<?php namespace App\Http\Controllers;

class meetingsController extends Controller {

	var $data = array();
	var $panelInit ;

	public function __construct(){
		if(app('request')->header('Authorization') != "" || \Input::has('token')){
			$this->middleware('jwt.auth');
		}else{
			$this->middleware('authApplication');
		}

		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = $this->panelInit->getAuthUser();
		if(!isset($this->data['users']->id)){
			return \Redirect::to('/');
		}
	}

	public function listAll()
	{

		if(!$this->panelInit->can( array("Meetings.list","Meetings.addMeeting","Meetings.editMeeting","Meetings.delMeet") )){
			exit;
		}

		$toReturn = array();

		$toReturn['meetings'] = array();
		$meetings = \meetings::select('id','conference_title','conference_desc','conference_status','conference_host','scheduled_date','conference_duration')->get()->toArray();
		foreach ($meetings as $key => $value) {
			$toReturn['meetings'][$key] = $value;
			if( $toReturn['meetings'][$key]['conference_host'] != "" ){
				$toReturn['meetings'][$key]['conference_host'] = json_decode($toReturn['meetings'][$key]['conference_host'],true);
			}
			$toReturn['meetings'][$key]['scheduled_date'] = $this->panelInit->unix_to_date( $meetings[$key]['scheduled_date'] ,  $this->panelInit->settingsArray['dateformat']." hr:mn A");			
		}

		//Get Classes & Sections
		$classes = \classes::select('id','className')->where('classAcademicYear',$this->panelInit->selectAcYear);

		if($this->data['users']->role == "teacher"){
			$classes = $classes->where('classTeacher','LIKE','%"'.$this->data['users']->id.'"%');
		}

		$toReturn['classes'] = $classes->orderby('id','desc')->get();

		return $toReturn;
	}

	public function delete($id){

		if(!$this->panelInit->can('Meetings.delMeet')){
			exit;
		}

		if ( $postDelete = \meetings::where('id',$id)->first() )
        {
            $postDelete->delete();
            return $this->panelInit->apiOutput(true,$this->panelInit->language['delMeet'],$this->panelInit->language['meetDeleted']);
        }else{
            return $this->panelInit->apiOutput(false,$this->panelInit->language['delMeet'],$this->panelInit->language['meetNotExist']);
        }
	}

	public function create(){

		if(!$this->panelInit->can('Meetings.addMeeting')){
			exit;
		}

		$meetings = new \meetings();
		$meetings->conference_title = \Input::get('conference_title');
		$meetings->conference_desc = \Input::get('conference_desc');
		if(\Input::has('conference_host')){
			$meetings->conference_host = json_encode( \Input::get('conference_host') );
		}
		$meetings->conference_target_type = \Input::get('conference_target_type');
		if($meetings->conference_target_type == "students" || $meetings->conference_target_type == "parents"){
			if(\Input::has('conference_target_details_ac')){
				$meetings->conference_target_details = json_encode(\Input::get('conference_target_details_ac'));
			}
		}
		if($meetings->conference_target_type == "users"){
			if(\Input::has('conference_target_details')){
				$meetings->conference_target_details = json_encode(\Input::get('conference_target_details'));
			}
		}
		$meetings->created_by = $this->data['users']->id;

		if(\input::get('scheduled_now') == "now"){
			$dateTime = new \DateTime();
			$dateTime->setTimezone( new \DateTimeZone($this->panelInit->settingsArray['timezone']) );
			$dateTime->setTime($dateTime->format('H'),floor($dateTime->format('i') / 5) * 5,0);
			$timestamp = $dateTime->getTimestamp();
			
			$meetings->scheduled_date = $timestamp;
			$meetings->scheduled_time_start_total = $timestamp;
			$meetings->scheduled_time_end_total = $timestamp + ( \Input::get('conference_duration') * 60 );
		}else{
			$start_of_meeting = \Input::get('scheduled_date')." ".\Input::get('scheduled_hour').":".\Input::get('scheduled_min')." ".\Input::get('scheduled_ampm');
			$meetings->scheduled_date = $this->panelInit->date_to_unix( $start_of_meeting , $this->panelInit->settingsArray['dateformat']." hr:mn A");
			$meetings->scheduled_time_start_total = $this->panelInit->date_to_unix( $start_of_meeting , $this->panelInit->settingsArray['dateformat']." hr:mn A");
			$meetings->scheduled_time_end_total = $this->panelInit->date_to_unix( $start_of_meeting , $this->panelInit->settingsArray['dateformat']." hr:mn A") + ( \Input::get('conference_duration') * 60 );
		}

		$meetings->conference_duration = \Input::get('conference_duration');

		$meetings->save();

		//Create Meeting on system
		if( \input::get('scheduled_now') == "now" ){

			$zoom = new \zoom_integration($this->panelInit->settingsArray['zoomApiKey'],$this->panelInit->settingsArray['zoomApiSecret']);

			$create_params = array(
                                        'topic' => $meetings->conference_title,
                                    );

            $create_params['type'] = 1;

            $response = $zoom->create_meeting($create_params);

            if( isset($response['start_url']) ){
				$meetings->conference_status = 1;
				$meetings->meeting_id = $response['id'];
				$meetings->meeting_metadata = json_encode($response);
            }else{
        		$meetings->conference_status = 0;
			}

			$meetings->save();

			//Send Push Notifications
			$tokens_list = array();
			
			if( $meetings->conference_target_type == "admins" ){
				$user_list = \User::where('role','admin');
			}
			if( $meetings->conference_target_type == "teachers" ){
				$user_list = \User::where('role','teacher');
			}

			if( $meetings->conference_target_type == "students" ){
				$conference_target_details = json_decode($meetings->conference_target_details,true);
				if(isset($conference_target_details['class'])){
					foreach ($conference_target_details['class'] as $key => $value) {
						$conference_target_details['class'][$key] = str_replace("c","",$conference_target_details['class'][$key]);
					}
				}
				if(isset($conference_target_details['section'])){
					foreach ($conference_target_details['section'] as $key => $value) {
						$conference_target_details['section'][$key] = str_replace("s","",$conference_target_details['section'][$key]);
					}
				}
				$user_list = \User::where('role','student')->whereIn('studentClass',$conference_target_details['class']);
				if(isset($conference_target_details['section'])){
					$user_list = $user_list->whereIn('studentSection',$conference_target_details['section']);
				}
			}

			if( $meetings->conference_target_type == "parents" ){
				
				$conference_target_details = json_decode($meetings->conference_target_details,true);
				if( is_array($conference_target_details) AND isset($conference_target_details['class']) AND isset($conference_target_details['section']) ){

					foreach ($conference_target_details['class'] as $key => $value) {
						$conference_target_details['class'][$key] = str_replace("c","",$conference_target_details['class'][$key]);
					}
					if(isset($conference_target_details['section'])){
						foreach ($conference_target_details['section'] as $key => $value) {
							$conference_target_details['section'][$key] = str_replace("s","",$conference_target_details['section'][$key]);
						}
					}
					$students = \User::where('role','student')->whereIn('studentClass',$conference_target_details['class']);
					if(isset($conference_target_details['section'])){
						$students = $students->whereIn('studentSection',$conference_target_details['section']);
					}
					$students = $students->select('id')->get();
					$ids = array();
					foreach ($students as $key => $value) {
						$ids[] = $value->id;
					}

					if(count($ids) > 0){
						$user_list = \User::where('role','parent')->where(function($query) use ($ids){
											foreach ($ids as $key_ => $value_) {
												$query->orWhere('parentOf','LIKE','%"'.$value_.'"%');
											}
										});
					}

				}

			}

			if( $meetings->conference_target_type == "users" ){
				$conference_target_details = json_decode($meetings->conference_target_details,true);

				$ids = array();
				foreach ($conference_target_details as $key => $value) {
					$ids[] = $value['id'];
				}
				if(count($ids)){
					$user_list = \User::whereIn('id',$ids);
				}
			}

			if(isset($user_list)){

				$user_list = $user_list->select('firebase_token')->get();
			
				foreach ($user_list as $value) {
					if($value['firebase_token'] != ""){
						$tokens_list[] = $value['firebase_token'];				
					}
				}

				if(count($tokens_list) > 0){
					$this->panelInit->send_push_notification($tokens_list,\Input::get('conference_title'),$this->panelInit->language['meetStartedJoin'],"meetings",$meetings->id);			
				}
				
			}
			

			$meetings->scheduled_date = "Now";
		}

		return $this->panelInit->apiOutput(true,$this->panelInit->language['addMeeting'],$this->panelInit->language['meetCreated'],$meetings->toArray());
	}

	function fetch($id){
		if(!$this->panelInit->can('Meetings.editMeeting')){
			exit;
		}

		$meetings = \meetings::where('id',$id)->select('id','conference_title','conference_desc','conference_host','conference_target_type','conference_target_details','scheduled_date','conference_duration')->first()->toArray();

		if($meetings['conference_host'] != ""){
			$meetings['conference_host'] = json_decode($meetings['conference_host'],true);
		}else{
			$meetings['conference_host'] = array();
		}


		if($meetings['conference_target_type'] == "students" || $meetings['conference_target_type'] == "parents"){
			if($meetings['conference_target_details'] != ""){
				$meetings['conference_target_details_ac'] = json_decode($meetings['conference_target_details'],true);
				$meetings['conference_target_details'] = json_decode($meetings['conference_target_details'],true);

				if(isset($meetings['conference_target_details_ac']['class'])){
					$DashboardController = new DashboardController();
					$meetings['sections_list'] = $DashboardController->sectionsSubjectsList( $meetings['conference_target_details_ac']['class'] );
				}

			}else{
				$meetings['conference_target_details_ac'] = array();
			}
		}
		if($meetings['conference_target_type'] == "users"){
			if($meetings['conference_target_details'] != ""){
				$meetings['conference_target_details'] = json_decode($meetings['conference_target_details'],true);
			}else{
				$meetings['conference_target_details'] = array();
			}
		}

		$original_date = $this->panelInit->unix_to_date( $meetings['scheduled_date'] , $this->panelInit->settingsArray['dateformat']." hr:mn A");
		$original_date = explode(" ", $original_date);

		$meetings['scheduled_date'] = $original_date[0];

		$original_date[1] = explode(":", $original_date[1]);
		$meetings['scheduled_hour'] = $original_date[1][0];
		$meetings['scheduled_min'] = $original_date[1][1];
		$meetings['scheduled_ampm'] = $original_date[2];

		$meetings['scheduled_now'] = "later";

		return $meetings;
	}

	function edit($id){
		if(!$this->panelInit->can('Meetings.editMeeting')){
			exit;
		}
		
		$start_of_meeting = \Input::get('scheduled_date')." ".\Input::get('scheduled_hour').":".\Input::get('scheduled_min')." ".\Input::get('scheduled_ampm');

		$meetings = \meetings::find($id);
		$meetings->conference_title = \Input::get('conference_title');
		$meetings->conference_desc = \Input::get('conference_desc');
		if(\Input::has('conference_host')){
			$meetings->conference_host = json_encode( \Input::get('conference_host') );
		}
		$meetings->conference_target_type = \Input::get('conference_target_type');
		if($meetings->conference_target_type == "students" || $meetings->conference_target_type == "parents"){
			if(\Input::has('conference_target_details_ac')){
				$meetings->conference_target_details = json_encode(\Input::get('conference_target_details_ac'));
			}
		}
		if($meetings->conference_target_type == "users"){
			if(\Input::has('conference_target_details')){
				$meetings->conference_target_details = json_encode(\Input::get('conference_target_details'));
			}
		}
		$meetings->created_by = $this->data['users']->id;

		if(\input::get('scheduled_now') == "now"){
			$dateTime = new \DateTime();
			$dateTime->setTimezone( new \DateTimeZone($this->panelInit->settingsArray['timezone']) );
			$dateTime->setTime($dateTime->format('H'),floor($dateTime->format('i') / 5) * 5,0);
			$timestamp = $dateTime->getTimestamp();
			
			$meetings->scheduled_date = $timestamp;
			$meetings->scheduled_time_start_total = $timestamp;
			$meetings->scheduled_time_end_total = $timestamp + ( \Input::get('conference_duration') * 60 );
		}else{
			$start_of_meeting = \Input::get('scheduled_date')." ".\Input::get('scheduled_hour').":".\Input::get('scheduled_min')." ".\Input::get('scheduled_ampm');
			$meetings->scheduled_date = $this->panelInit->date_to_unix( $start_of_meeting , $this->panelInit->settingsArray['dateformat']." hr:mn A");
			$meetings->scheduled_time_start_total = $this->panelInit->date_to_unix( $start_of_meeting , $this->panelInit->settingsArray['dateformat']." hr:mn A");
			$meetings->scheduled_time_end_total = $this->panelInit->date_to_unix( $start_of_meeting , $this->panelInit->settingsArray['dateformat']." hr:mn A") + ( \Input::get('conference_duration') * 60 );
		}

		$meetings->conference_duration = \Input::get('conference_duration');
		$meetings->save();

		$meetings->scheduled_date = $start_of_meeting;

		return $this->panelInit->apiOutput(true,$this->panelInit->language['editMeeting'],$this->panelInit->language['meetModified'],$meetings->toArray());
	}

	public function searchUsers($keyword){
		$users = \User::where('fullName','like','%'.$keyword.'%')->orWhere('username','like','%'.$keyword.'%')->orWhere('email','like','%'.$keyword.'%')->get();
		$retArray = array();
		foreach ($users as $user) {
			$retArray[$user->id] = array("id"=>$user->id,"name"=>$user->fullName,"email"=>$user->email);
		}
		return $retArray;
	}

	public function joinMeeting($id){

		$conferences = \meetings::where('id',$id)->where('conference_status','1');
		if($conferences->count() > 0){
			$conferences = $conferences->first();

			$is_moderator = false;
			$conferences['conference_host'] = json_decode($conferences['conference_host'],true);
			$conferences['meeting_metadata'] = json_decode($conferences['meeting_metadata'],true);
			if(is_array($conferences['conference_host']) AND $conferences['conference_host']['id'] == $this->data['users']->id){
				$meeting_join_url = $conferences['meeting_metadata']['start_url'];
			}else{

				if( $this->data['users']->role == "admin" && $conferences->conference_target_type == "admins" ){
					$meeting_join_url = $conferences['meeting_metadata']['join_url'];
				}

				if( $this->data['users']->role == "teacher" && $conferences->conference_target_type == "teachers" ){
					$meeting_join_url = $conferences['meeting_metadata']['join_url'];
				}

				if( $conferences->conference_target_type == "students" ){
					
					$conference_target_details = json_decode($conferences->conference_target_details,true);
					if(isset($conference_target_details['class'])){
						foreach ($conference_target_details['class'] as $key => $value) {
							$conference_target_details['class'][$key] = str_replace("c","",$conference_target_details['class'][$key]);
						}
					}
					if(isset($conference_target_details['section'])){
						foreach ($conference_target_details['section'] as $key => $value) {
							$conference_target_details['section'][$key] = str_replace("s","",$conference_target_details['section'][$key]);
						}
					}
					if( is_array($conference_target_details) AND isset($conference_target_details['class']) AND isset($conference_target_details['section']) AND in_array($this->data['users']->studentClass, $conference_target_details['class']) AND in_array($this->data['users']->studentSection, $conference_target_details['section']) ){
						$meeting_join_url = $conferences['meeting_metadata']['join_url'];
					}

				}

				if( $conferences->conference_target_type == "parents" ){
					
					$conference_target_details = json_decode($conferences->conference_target_details,true);
					if( is_array($conference_target_details) AND isset($conference_target_details['class']) AND isset($conference_target_details['section']) ){

						if($this->data['users']->parentOf != ""){
							$parentOf = json_decode($this->data['users']->parentOf,true);
							if(!is_array($parentOf)){
								$parentOf = array();
							}
							$ids = array();
							foreach ($parentOf as$value) {
								$ids[] = $value['id'];
							}

							if(count($ids) > 0){
								if(isset($conference_target_details['class'])){
									foreach ($conference_target_details['class'] as $key => $value) {
										$conference_target_details['class'][$key] = str_replace("c","",$conference_target_details['class'][$key]);
									}
								}
								if(isset($conference_target_details['section'])){
									foreach ($conference_target_details['section'] as $key => $value) {
										$conference_target_details['section'][$key] = str_replace("s","",$conference_target_details['section'][$key]);
									}
								}
								$studentArray = \User::where('role','student')->whereIn('studentClass',$conference_target_details['class'])->whereIn('studentSection',$conference_target_details['section'])->whereIn('id',$ids);
								if($studentArray->count() > 0){
									$meeting_join_url = $conferences['meeting_metadata']['join_url'];
								}

							}
							
						}

					}

				}

				if( $conferences->conference_target_type == "users" ){
					$conference_target_details = json_decode($conferences->conference_target_details,true);

					foreach ($conference_target_details as $key => $value) {
						if($value['id'] == $this->data['users']->id){
							$meeting_join_url = $conferences['meeting_metadata']['join_url'];
						}
					}

				}

			}

		}
		
		if(isset($meeting_join_url)){
	            return redirect()->away($meeting_join_url);
		}else{
			echo "<br/><br/><br/><br/><br/><center>You cannoot join this meeting, Meeting maybe ended / expired or you aren't authorized to join this meeting</center>";
		}

	}

}
