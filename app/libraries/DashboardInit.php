<?php
class DashboardInit {

	public $panelItems;
	public $settingsArray = array();
	public $language;
	
	public $version = "7.0";
	public $nversion = "700";
	
	public $lowAndVersion = "4.0";
	public $nLowAndVersion = "400";
	
	public $lowiOsVersion = "2.0";
	public $nLowiOsVersion = "200";

	public $teacherClasses = array();
	public $isRTL;
	public $languageUniversal;
	public $selectAcYear;
	public $defTheme;
	public $baseURL;
	public $customPermissionsDecoded;
	public $calendarsLocale = array("ethiopic"=>"am","gregorian"=>"en_US","islamic"=>"en_US","persian"=>"fa");
	public $perms = array();

	public function __construct(){
		$this->panelItems = array(
									"dashboard"=>array("title"=>"dashboard","icon"=>"mdi mdi-gauge","url"=> URL::to('portal#/') ),

									"wel_office"=>array("title"=>"wel_office","icon"=>"mdi mdi-book-multiple",
													"children"=>array(
															"visitors"=>array("title"=>"visitors","url"=>URL::to("portal#/visitors"),"role_perm"=>array("visitors.list","visitors.View","visitors.add_vis","visitors.edit_vis","visitors.del_vis","visitors.Download","visitors.Export"),"activated"=>"visitorsAct" ),
															"phone_calls"=>array("title"=>"phn_calls","url"=>URL::to("portal#/phone_calls"),"role_perm"=>array("phn_calls.list","phn_calls.View","phn_calls.add_call","phn_calls.edit_call","phn_calls.del_call","phn_calls.Export"),"activated"=>"phoneCallsAct" ),
															"postal"=>array("title"=>"postal","url"=>URL::to("portal#/postal"),"role_perm"=>array("postal.list","postal.add_postal","postal.edit_postal","postal.del_postal","postal.Download","postal.Export"),"activated"=>"postalAct" ),
															"con_mess"=>array("title"=>"con_mess","url"=>URL::to("portal#/con_mess"),"role_perm"=>array("con_mess.list","con_mess.View","con_mess.del_mess","con_mess.Export"),"activated"=>"conMessAct" ),
															"enquiries"=>array("title"=>"enquiries","url"=>URL::to("portal#/enquiries"),"role_perm"=>array("enquiries.list","enquiries.View","enquiries.add_enq","enquiries.edit_enq","enquiries.del_enq","enquiries.Download","enquiries.Export"),"activated"=>"enquiriesAct" ),
															"complaints"=>array("title"=>"complaints","url"=>URL::to("portal#/complaints"),"role_perm"=>array("complaints.list","complaints.View","complaints.add_complaint","complaints.edit_complaint","complaints.del_complaint","complaints.Download","complaints.Export"),"activated"=>"complainAct" ),
															"wel_office_cat"=>array("title"=>"wel_office_cat","url"=>URL::to("portal#/wel_office_cat"),"role_perm"=>array("wel_office_cat.list","wel_office_cat.add_cat","wel_office_cat.edit_cat","wel_office_cat.del_cat") ),
													)
									),


									"staticContent"=>array("title"=>"staticPages","icon"=>"mdi mdi-book-multiple","activated"=>"staticpagesAct",
													"children"=>array(
															"controlStatic"=>array("title"=>"controlPages","url"=>URL::to('portal#/static'),"role_perm"=>array("staticPages.list","staticPages.delPage","staticPages.editPage","staticPages.addPage") )
														)
									),

									"onlineMeetings"=>array("title"=>"onlineMeetings","url"=>URL::to('portal#/online_meetings'),"icon"=>"mdi mdi-video","activated"=>"onlineMeetingsAct","role_perm"=>array("Meetings.list") ),
									"messages"=>array("title"=>"Messages","url"=>URL::to('portal#/messages'),"icon"=>"mdi mdi-message-text-outline","activated"=>"messagesAct","role_perm"=>array("Messages.list") ),

									"mailsms"=>array("title"=>"mailsms","url"=>URL::to('portal#/mailsms'),"role_perm"=>array('mailsms.mailSMSSend'),"icon"=>"mdi mdi-cellphone-iphone","activated"=>"mailSmsAct" ),
									"mobNotif"=>array("title"=>"mobileNotifications","url"=>URL::to('portal#/mobileNotif'),"role_perm"=>array("mobileNotifications.sendNewNotification"),"icon"=>"mdi mdi-telegram","activated"=>"sendNotifAct" ),

									"calender"=>array("title"=>"Calender","url"=>URL::to('portal#/calender'),"icon"=>"mdi mdi-calendar-text","activated"=>"calendarAct" ),
									"classSchedule"=>array("title"=>"classSch","url"=>URL::to('portal#/classschedule'),"role_perm"=>array("classSch.list","classSch.addSch","classSch.editSch","classSch.delSch"),"icon"=>"mdi mdi-timelapse","activated"=>"classSchAct"),

									"attendance"=>array("title"=>"Attendance","icon"=>"mdi mdi-check-all","activated"=>"attendanceAct",
														"children"=>array(
															"takeAttendance"=>array("title"=>"takeAttendance","role_perm"=>array("Attendance.takeAttendance"),"url"=>URL::to('portal#/attendance') ),
															"attReport"=>array("title"=>"attReport","role_perm"=>array("Attendance.attReport"),"url"=>URL::to('portal#/attendance_report') ),
														)
									),
									
									"staffAttendance"=>array("title"=>"staffAttendance","icon"=>"mdi mdi-check","activated"=>"staffAttendanceAct",
														"children"=>array(
															"takeAttendance"=>array("title"=>"takeAttendance","role_perm"=>array("staffAttendance.takeAttendance"),"url"=>URL::to('portal#/staffAttendance') ),
															"attReport"=>array("title"=>"attReport","role_perm"=>array("staffAttendance.attReport"),"url"=>URL::to('portal#/staffAttendance_report') ),
														)
									),


									"vacation"=>array("title"=>"Vacation","icon"=>"mdi mdi-airplane","activated"=>"vacationAct",
														"children"=>array(
															"reqVacation"=>array("title"=>"reqVacation","url"=>URL::to('portal#/vacation'),"role_perm"=>array("Vacation.reqVacation") ),
															"appVacation"=>array("title"=>"appVacation","url"=>URL::to('portal#/vacation/approve'),"role_perm"=>array("Vacation.appVacation") ),
															"myVacation"=>array("title"=>"myVacation","url"=>URL::to('portal#/vacation/mine'),"role_perm"=>array("Vacation.myVacation") ),
														)
									),
									

									"myAttendance"=>array("title"=>"myAttendance","url"=>URL::to('portal#/attendanceStats'),"role_perm"=>array("myAttendance.myAttendance"),"icon"=>"mdi mdi-check","activated"=>"attendanceAct" ),
									

									"library"=>array("title"=>"Library","icon"=>"mdi mdi-library","activated"=>"bookslibraryAct",
														"children"=>array(
															"library_issues"=>array("title"=>"issue_book","url"=>URL::to("portal#/library_issues"),"role_perm"=>array("issue_book.list","issue_book.add_issue","issue_book.edit_issue","issue_book.del_issue","issue_book.Export") ),
															"book_return"=>array("title"=>"book_return","url"=>URL::to("portal#/library_return"),"role_perm"=>array("issue_book.book_return") ),

															"listBooks"=>array("title"=>"listBooks","url"=>URL::to('portal#/library'),"role_perm"=> array("Library.list","Library.addBook","Library.editBook","Library.delLibrary","Library.Download")),
															"subscription"=>array("title"=>"mngSub","url"=>URL::to('portal#/lib_subscription'),"role_perm"=> array("Library.mngSub") ),

														)
									),
									

									"media"=>array("title"=>"mediaCenter","url"=>URL::to('portal#/media'),"role_perm"=>array("mediaCenter.View","mediaCenter.addAlbum","mediaCenter.editAlbum","mediaCenter.delAlbum","mediaCenter.addMedia","mediaCenter.editMedia","mediaCenter.delMedia"),"icon"=>"mdi mdi-folder-multiple-image","activated"=>"mediaAct" ),

									"employees"=>array("title"=>"employees","icon"=>"mdi mdi-briefcase","activated"=>"employeesAct",
														"children"=>array(
															"employees"=>array("title"=>"employees","url"=>URL::to('portal#/employees'),"role_perm"=> array("employees.list","employees.addEmployee","employees.editEmployee","employees.editEmployee") ),
															"teachers"=>array("title"=>"teachers","url"=>URL::to('portal#/teachers'),"role_perm"=>array("teachers.list","teachers.addTeacher","teachers.EditTeacher","teachers.delTeacher","teachers.Approve","teachers.teacLeaderBoard","teachers.Import","teachers.Export") ),
															"departments"=>array("title"=>"depart","url"=>URL::to("portal#/departments"),"role_perm"=>array("depart.list","depart.add_depart","depart.edit_depart","depart.del_depart") ),
															"designations"=>array("title"=>"desig","url"=>URL::to("portal#/designations"),"role_perm"=>array("desig.list","desig.add_desig","desig.edit_desig","desig.del_desig") ),

														)
									),

									"students"=>array("title"=>"students","icon"=>"mdi mdi-account-multiple-outline" ,
														"children"=>array(
															"students"=>array("title"=>"students","url"=>URL::to("portal#/students"),"role_perm"=>array("students.list","students.editStudent","students.delStudent","students.listGradStd","students.Approve","students.stdLeaderBoard","students.Import","students.Export","students.Attendance","students.Marksheet","students.medHistory") ),
															"admission"=>array("title"=>"admission","url"=>URL::to("portal#/students/admission"),"role_perm"=>array("students.admission") ),
															"student_categories"=>array("title"=>"std_cat","url"=>URL::to("portal#/student/categories"),"role_perm"=>array("students.std_cat") ),
														)
									),

									"parents"=>array("title"=>"parents","url"=>URL::to('portal#/parents'),"role_perm"=>array("parents.list","parents.AddParent","parents.editParent","parents.delParent","parents.Approve","parents.Import","parents.Export"),"icon"=>"mdi mdi-account-multiple" ),

									"studentsMarksheet"=>array("title"=>"Marksheet","url"=>URL::to('portal#/students/marksheet'),"role_perm"=>array("Marksheet.Marksheet"),"icon"=>"mdi mdi-grid" ),

									"gradelevels"=>array("title"=>"gradeLevels","url"=>URL::to('portal#/gradeLevels'),"role_perm"=>array("gradeLevels.list","gradeLevels.addLevel","gradeLevels.editGrade","gradeLevels.delGradeLevel"),"icon"=>"mdi mdi-arrange-send-backward"),
									"materials"=>array("title"=>"studyMaterial","url"=>URL::to('portal#/materials'),"role_perm"=>array("studyMaterial.list","studyMaterial.addMaterial","studyMaterial.editMaterial","studyMaterial.delMaterial","studyMaterial.Download"),"icon"=>"mdi mdi-cloud-download","activated"=>"materialsAct" ),
									"homework"=>array("title"=>"Homework","url"=>URL::to('portal#/homework'),"role_perm"=>array("Homework.list","Homework.View","Homework.addHomework","Homework.editHomework","Homework.delHomework","Homework.Download"),"icon"=>"mdi mdi-book","activated"=>"homeworkAct" ),
									"assignments"=>array("title"=>"Assignments","url"=>URL::to('portal#/assignments'),"role_perm"=>array("Assignments.list","Assignments.Download","Assignments.AddAssignments","Assignments.editAssignment","Assignments.delAssignment","Assignments.viewAnswers","Assignments.applyAssAnswer"),"icon"=>"mdi mdi-file-pdf","activated"=>"assignmentsAct" ),
									"examslist"=>array("title"=>"examsList","url"=>URL::to('portal#/examsList'),"role_perm"=>array("examsList.list","examsList.addExam","examsList.editExam","examsList.delExam","examsList.examDetailsNot","examsList.showMarks","examsList.controlMarksExam"),"icon"=>"mdi mdi-playlist-check" ),
									"onlineexams"=>array("title"=>"onlineExams","url"=>URL::to('portal#/onlineExams'),"icon"=>"mdi mdi-account-network","role_perm"=>array("onlineExams.list","onlineExams.addExam","onlineExams.editExam","onlineExams.delExam","onlineExams.takeExam","onlineExams.showMarks","onlineExams.QuestionsArch"),"activated"=>"onlineexamsAct" ),

									"newsboard"=>array("title"=>"newsboard","url"=>URL::to('portal#/newsboard'),"role_perm"=>array("newsboard.list","newsboard.View","newsboard.addNews","newsboard.editNews","newsboard.delNews"),"icon"=>"mdi mdi-bullhorn","activated"=>"newsboardAct" ),
									"events"=>array("title"=>"events","url"=>URL::to('portal#/events'),"role_perm"=>array("events.list","events.View","events.addEvent","events.editEvent","events.delEvent"),"icon"=>"mdi mdi-calendar-clock","activated"=>"eventsAct" ),

									"mypayroll"=>array("title"=>"MyPayroll","icon"=>"mdi mdi-bank","url"=>URL::to('portal#/payroll/mine'),"role_perm"=>array("Payroll.MyPayroll"),"activated"=>"payrollAct" ),
									"payroll"=>array("title"=>"Payroll","icon"=>"mdi mdi-bank","activated"=>"payrollAct",
														"children"=>array(
															"makePay"=>array("title"=>"makePayment","url"=>URL::to('portal#/payroll/dopayment'),"role_perm"=>array('Payroll.makeUsrPayment') ),
															"usersSalary"=>array("title"=>"userSalary","url"=>URL::to('portal#/payroll/users_salary'),"role_perm"=>array('Payroll.userSalary') ),
															"salaryBase"=>array("title"=>"salaryBase","url"=>URL::to('portal#/payroll/salary_base'),"role_perm"=>array('Payroll.salaryBase') ),
															"hourlyBase"=>array("title"=>"hourSalary","url"=>URL::to('portal#/payroll/hourly_base'),"role_perm"=>array('Payroll.hourSalary') ),
														)
									),

									"accounting"=>array("title"=>"accounting","icon"=>"mdi mdi-currency-usd","activated"=>"paymentsAct",
														"children"=>array(
															"Invoices"=>array("title"=>"Invoices","url"=>URL::to('portal#/invoices'),"role_perm"=>array("Invoices.list","Invoices.View","Invoices.addPayment","Invoices.editPayment","Invoices.delPayment","Invoices.collInvoice","Invoices.payRevert","Invoices.Export") ),
															"DueInvoices"=>array("title"=>"dueInvoices","url"=>URL::to('portal#/invoices/due'),"role_perm"=>array("Invoices.dueInvoices") ),
															"controlFeeGroups"=>array("title"=>"FeeGroups","url"=>URL::to('portal#/feeGroup'),"role_perm"=>array("FeeGroups.list","FeeGroups.addFeeGroup","FeeGroups.editFeeGroup","FeeGroups.delFeeGroup") ),
															"controlFeeTypes"=>array("title"=>"FeeTypes","url"=>URL::to('portal#/feeType'),"role_perm"=>array("FeeTypes.list","FeeTypes.addFeeType","FeeTypes.editFeeType","FeeTypes.delFeeType") ),
															"controlFeeAllocation"=>array("title"=>"FeeAllocation","url"=>URL::to('portal#/feeAllocation'),"role_perm"=>array("FeeAllocation.list","FeeAllocation.addFeeAllocation","FeeAllocation.editFeeAllocation","FeeAllocation.delFeeAllocation") ),
															"feeDiscount"=>array("title"=>"FeeDiscount","url"=>URL::to('portal#/feeDiscount'),"role_perm"=>array("FeeDiscount.list","FeeDiscount.addFeeDiscount","FeeDiscount.editFeeDiscount","FeeDiscount.delFeeDiscount","FeeDiscount.assignUser") ),
														)
									),

									"expensesList"=>array("title"=>"Expenses","icon"=>"mdi mdi-currency-usd","activated"=>"expensesAct",
														"children"=>array(
															"expenses"=>array("title"=>"Expenses","url"=>URL::to('portal#/expenses'),"role_perm"=>array("Expenses.list","Expenses.addExpense","Expenses.editExpense","Expenses.delExpense")),
															"expensesCat"=>array("title"=>"expCategory","url"=>URL::to('portal#/expensesCat'),"role_perm"=>array("Expenses.expCategory") ),
														)
									),

									"incomeList"=>array("title"=>"Incomes","icon"=>"fa fa-money","activated"=>"incomeAct",
														"children"=>array(
															"income"=>array("title"=>"Incomes","url"=>URL::to('portal#/incomes'),"role_perm"=>array("Incomes.list","Incomes.addIncome","Incomes.editIncome","Incomes.delIncome") ),
															"incomeCat"=>array("title"=>"incomeCategory","url"=>URL::to('portal#/incomesCat'),"role_perm"=>array("Incomes.incomeCategory") ),
														)
									),


									"inventory"=>array("title"=>"inventory","icon"=>"mdi mdi-sitemap","activated"=>"inventoryAct",
														"children"=>array(

															"inv_issue"=>array("title"=>"iss_ret","url"=>URL::to("portal#/inv_issue"),"role_perm"=>array("iss_ret.list","iss_ret.issue_item","iss_ret.edit_item","iss_ret.del_item","iss_ret.Download","iss_ret.Export")),
															"items_stock"=>array("title"=>"items_stock","url"=>URL::to("portal#/items_stock"),"role_perm"=>array("items_stock.list","items_stock.add_item","items_stock.edit_item","items_stock.del_item","items_stock.Download","items_stock.Export")),															
															"inv_cat"=>array("title"=>"inv_cat","url"=>URL::to("portal#/inv_cat"),"role_perm"=>array("inv_cat.list","inv_cat.add_cat","inv_cat.edit_cat","inv_cat.del_cat") ),
															"suppliers"=>array("title"=>"suppliers","url"=>URL::to("portal#/suppliers"),"role_perm"=>array("suppliers.list","suppliers.add_supp","suppliers.edit_supp","suppliers.del_supp") ),
															"stores"=>array("title"=>"stores","url"=>URL::to("portal#/stores"),"role_perm"=>array("stores.list","stores.add_store","stores.edit_store","stores.del_store") ),
															"items_code"=>array("title"=>"items_code","url"=>URL::to("portal#/items_code"),"role_perm"=>array("items_code.list","items_code.add_item","items_code.edit_item","items_code.del_item","items_code.Export") ),

														)
									),



									"classes"=>array("title"=>"classes","icon"=>"mdi mdi-sitemap",
														"children"=>array(
															"classes"=>array("title"=>"classes","url"=>URL::to('portal#/classes'),"role_perm"=>array("classes.list","classes.addClass","classes.editClass","classes.delClass") ),
															"sections"=>array("title"=>"sections","url"=>URL::to('portal#/sections'),"role_perm"=>array("sections.list","sections.addSection","sections.editSection","sections.delSection")),
														)
									),

									"subjects"=>array("title"=>"Subjects","url"=>URL::to('portal#/subjects'),"icon"=>"mdi mdi-book-open-page-variant","role_perm"=>array("Subjects.list","Subjects.addSubject","Subjects.editSubject","Subjects.delSubject") ),
									
									"hostel"=>array("title"=>"HostelManage","icon"=>"mdi mdi-home-map-marker","activated"=>"hostelAct",
														"children"=>array(
															"controlHostel"=>array("title"=>"Hostel","url"=>URL::to('portal#/hostel'),"role_perm"=>array("Hostel.list","Hostel.AddHostel","Hostel.EditHostel","Hostel.delHostel","Hostel.listSubs")),
															"hostelCat"=>array("title"=>"HostelCat","url"=>URL::to('portal#/hostelCat'),"role_perm"=>array("Hostel.HostelCat")),
														)
									),
									
									"Transportation"=>array("title"=>"Transportation","icon"=>"mdi mdi-bus","activated"=>"transportAct",
														"children"=>array(
															"transportations"=>array("title"=>"Transportation","url"=>URL::to('portal#/transports'),"role_perm"=>array("Transportation.list","Transportation.addTransport","Transportation.editTransport","Transportation.delTrans")),
															"transport_vehicles"=>array("title"=>"trans_vehicles","url"=>URL::to("portal#/transport_vehicles"),"role_perm"=>array("trans_vehicles.list","trans_vehicles.add_vehicle","trans_vehicles.edit_vehicle","trans_vehicles.del_vehicle")),
															"members"=>array("title"=>"members","url"=>URL::to("portal#/transport_members"),"role_perm"=>array("Transportation.members") ),
														)
									),
									"certificates"=>array("title"=>"Certificates","url"=>URL::to("portal#/certificates"),"icon"=>"mdi mdi-certificate","role_perm"=>array("Certificates.list","Certificates.add_cert","Certificates.edit_cert","Certificates.del_cert","Certificates.Download"),"activated"=>"certAct" ),
									"id_cards"=>array("title"=>"id_cards","url"=>URL::to("portal#/id_cards"),"icon"=>"mdi mdi-certificate","role_perm"=>array("id_cards.list","id_cards.add_card","id_cards.edit_card","id_cards.del_card"),"activated"=>"cardAct" ),

									"reports"=>array("title"=>"Reports","url"=>URL::to('portal#/reports'),"role_perm"=>array("Reports.Reports"),"icon"=>"mdi mdi-chart-areaspline","activated"=>"reportsAct"),

									"frontEnd"=>array("title"=>"frontendCMS","icon"=>"mdi mdi-book-multiple",
																				"children"=>array(
																						"pages"=>array("title"=>"ctrlPages","url"=>URL::to('portal#/frontend/pages'),"role_perm"=>array("frontendCMSpages.list","frontendCMSpages.addPage","frontendCMSpages.editPage","frontendCMSpages.delPage")),
																						"settings"=>array("title"=>"CMSSettings","url"=>URL::to('portal#/frontend/settings'),"role_perm"=>array("adminTasks.frontendCMS")),
																					)
																				),
									
									"adminTasks"=>array("title"=>"adminTasks","icon"=>"mdi mdi-settings",
																				"children"=>array(
																						"academicyear"=>array("title"=>"academicyears","url"=>URL::to('portal#/academicYear'),"role_perm"=>array("academicyears.list","academicyears.addAcademicyear","academicyears.editAcademicYears","academicyears.delAcademicYears")),
																						"promotion"=>array("title"=>"Promotion","url"=>URL::to('portal#/promotion'),"role_perm"=>array("Promotion.promoteStudents") ),
																						"mailsmsTemplates"=>array("title"=>"mailsmsTemplates","url"=>URL::to('portal#/mailsmsTemplates'),"role_perm"=>array('mailsms.mailsmsTemplates') ),
																						"polls"=>array("title"=>"Polls","url"=>URL::to('portal#/polls'),"role_perm"=>array("Polls.list","Polls.addPoll","Polls.editPoll","Polls.delPoll"),"activated"=>"pollsAct"),
																						"dormitories"=>array("title"=>"Dormitories","url"=>URL::to('portal#/dormitories'),"role_perm"=>array("Dormitories.list","Dormitories.addDormitories","Dormitories.editDorm","Dormitories.delDorm")),
																						"siteSettings" => array("title"=>"generalSettings","url"=>URL::to('portal#/settings'),"role_perm"=>array("adminTasks.globalSettings","adminTasks.activatedModules","adminTasks.paymentsSettings","adminTasks.mailSmsSettings","adminTasks.vacationSettings","adminTasks.mobileSettings","adminTasks.frontendCMS","adminTasks.bioItegration","adminTasks.lookFeel") ),
																						"languages" => array("title"=>"Languages","url"=>URL::to('portal#/languages'),"role_perm"=>array("Languages.list","Languages.addLanguage","Languages.editLanguage","Languages.delLanguage")),
																						"admins"=>array("title"=>"Administrators","url"=>URL::to('portal#/admins'),"role_perm"=> array("Administrators.list","Administrators.addAdministrator","Administrators.editAdministrator","Administrators.delAdministrator")),
																						"roles"=>array("title"=>"roles","url"=>URL::to('portal#/roles'),"role_perm"=>array("roles.list","roles.add_role","roles.modify_role","roles.delete_role")),
																						"terms"=>array("title"=>"schoolTerms","url"=>URL::to('portal#/terms'),"role_perm"=>array("adminTasks.globalSettings")),
																						"exportimport"=>array("title"=>"dbExport","url"=>URL::to('portal#/dbexports'),"role_perm"=>array("dbExport.dbExport")),
																					)
																				)
					);
		
		global $settingsLC;
		$check = \Schema::hasTable('settings');
		if(!$check){
			$this->redirect('install');
		}
		$settings = settings::get();
		$this->settingsArray = call_user_func($settingsLC[0], $settings,$this->version);

		if($this->settingsArray['thisVersion'] != $this->version){
			$this->redirect('upgrade');
		}
		
		if($this->settingsArray['https_enabled'] == "1"){
			\URL::forceSchema('https');
		}

		$staticPages = static_pages::where('pageActive','1')->get();
		foreach ($staticPages as $pages) {
			$this->panelItems['staticContent']['children'][md5(uniqid())] = array("title"=>$pages->pageTitle,"url"=>URL::to('portal#/static')."/".$pages->id,"icon"=>"fa fa-file-text");
		}

		if($this->settingsArray['allowTeachersMailSMS'] == "none" AND !Auth::guest() AND \Auth::user()->role == "teacher"){
			unset($this->panelItems['mailsms']);
		}

		$this->authUser = $this->getAuthUser();

		//Languages
		$defLang = $defLang_ = $this->settingsArray['languageDef'];
		if(isset($this->settingsArray['languageAllow']) AND $this->settingsArray['languageAllow'] == "1" AND isset($this->authUser->defLang) AND $this->authUser->defLang != 0){
			$defLang = $this->authUser->defLang;
		}

		//Theme
		$this->defTheme = $this->settingsArray['layoutColor'];
		if(isset($this->settingsArray['layoutColorUserChange']) AND $this->settingsArray['layoutColorUserChange'] == "1" AND isset($this->authUser->defTheme) AND $this->authUser->defTheme != ""){
			$this->defTheme = $this->authUser->defTheme;
		}

		//Permissions
		if( isset($this->authUser->role_perm) AND $this->authUser->role_perm != "" AND $this->authUser->role_perm != 0 ){
			$roles = \roles::where('id',$this->authUser->role_perm)->orWhere('def_for',$this->authUser->role)->select('role_permissions');
			if($roles->count() == 0){
				$this->perms = array();
			}
			$roles = $roles->first();
			$this->perms = json_decode($roles->role_permissions,true);
		}

		$language = languages::whereIn('id',array($defLang,1))->get();
		if(count($language) == 0){
			$language = languages::whereIn('id',array($defLang_,1))->get();
		}
		
		foreach ($language as $value) {
			if($value->id == 1){
				$this->language = json_decode($value->languagePhrases,true);
				$this->languageUniversal = "en";
			}else{
				$this->languageUniversal = $value->languageUniversal;
				$this->isRTL = $value->isRTL;
				$phrases = json_decode($value->languagePhrases,true);
				foreach ($phrases as $key => $value){
					$this->language[$key] = $value;
				}
			}
		}

		$this->weekdays = array("ethiopic"=>array(1=>'እሑድ',2=>'ሰኞ',3=>'ማክሰኞ',4=>'ረቡዕ',5=>'ሓሙስ',6=>'ዓርብ',7=>'ቅዳሜ'),
								"gregorian"=>array(1=>$this->language['Sunday'],2=>$this->language['Monday'],3=>$this->language['Tuesday'],4=>$this->language['Wednesday'],5=>$this->language['Thurusday'],6=>$this->language['Friday'],7=>$this->language['Saturday']),
								"islamic"=>array(1=>'Yawm as-sabt',2=>'Yawm al-ahad',3=>'Yawm al-ithnayn',4=>"Yawm ath-thulaathaa'",5=>"Yawm al-arbi'aa'",6=>"Yawm al-khamīs",7=>"Yawm al-jum'a"),
								"persian"=>array(1=>'Shambe',2=>'Yekshambe',3=>'Doshambe',4=>'Seshambe',5=>'Chæharshambe',6=>'Panjshambe',7=>"Jom'e"),
							);

		//Selected academicYear
		if (Session::has('selectAcYear')){
			$this->selectAcYear = Session::get('selectAcYear');
		}else{
			$currentAcademicYear = academic_year::where('isDefault','1')->first();
			$this->selectAcYear = $currentAcademicYear->id;
			Session::put('selectAcYear', $this->selectAcYear);
		}

		//Process Scheduled Payments
		$this->collectFees();
		$this->dueInvoicesNotif();
		$this->create_meetings();
	
		$this->baseURL = URL::to('/');
		if (strpos($this->baseURL, 'index.php') == false) {
			$this->baseURL .= "/";
		}
	}

	public function create_meetings(){

		if(!isset($this->settingsArray['zoomApiKey']) || !isset($this->settingsArray['zoomApiSecret'])){
			return;
		}

		//check cached last time
		$meeting_last_create = Cache::get('meeting_last_create');
        if( $meeting_last_create != null &&	$meeting_last_create + 60 > time() ){
			return;
		}

		Cache::forever('meeting_last_create',time());
		
		$conferences_list = \meetings::where(function($query){
                                                    $query->where('meetings.conference_status','0')
                                                            ->where('meetings.scheduled_time_start_total','<=',time() + ( 15*60 ) )
                                                            ->where('meetings.scheduled_time_end_total','>',time());
                                            })->orWhere(function($query){
                                                    $query->where('meetings.conference_status','1')
                                                            ->where('meetings.scheduled_time_end_total','<',time() - ( 0*60 ) );
											})->select('meetings.*')->get();
											
        foreach ($conferences_list as $conference) {

            $meeting_metadata = "";
            if($conference->meeting_metadata != ""){
                $meeting_metadata = json_decode($conference->meeting_metadata,true);
            }
            if(!is_array($meeting_metadata)){
                $meeting_metadata = array();
            }

            if( $conference->conference_status == '1'){

				$conference->conference_status = 2;
                $conference->save();

            }else{

				$zoom = new \zoom_integration($this->settingsArray['zoomApiKey'],$this->settingsArray['zoomApiSecret']);

				$create_params = array(
											'topic' => $conference->conference_title,
										);

				$create_params['type'] = 1;

				$response = $zoom->create_meeting($create_params);

				if( isset($response['start_url']) ){
					$conference->conference_status = 1;
					$conference->meeting_id = $response['id'];
					$conference->meeting_metadata = json_encode($response);
				}else{
					$conference->conference_status = 0;
				}

				$conference->save();

				//Send Push Notifications
				$tokens_list = array();

				if( isset($response['start_url']) ){
				
					if( $conference->conference_target_type == "admins" ){
						$user_list = \User::where('role','admin');
					}
					if( $conference->conference_target_type == "teachers" ){
						$user_list = \User::where('role','teacher');
					}

					if( $conference->conference_target_type == "students" ){
						$conference_target_details = json_decode($conference->conference_target_details,true);
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
						$user_list = \User::where('role','student')->whereIn('studentClass',$conference_target_details['class'])->whereIn('studentSection',$conference_target_details['section']);
					}

					if( $conference->conference_target_type == "parents" ){
						
						$conference_target_details = json_decode($conference->conference_target_details,true);
						if( is_array($conference_target_details) AND isset($conference_target_details['class']) AND isset($conference_target_details['section']) ){

							foreach ($conference_target_details['class'] as $key => $value) {
								$conference_target_details['class'][$key] = str_replace("c","",$conference_target_details['class'][$key]);
							}
							foreach ($conference_target_details['section'] as $key => $value) {
								$conference_target_details['section'][$key] = str_replace("s","",$conference_target_details['section'][$key]);
							}
							$students = \User::where('role','student')->whereIn('studentClass',$conference_target_details['class'])->whereIn('studentSection',$conference_target_details['section'])->select('id')->get();
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

					if( $conference->conference_target_type == "users" ){
						$conference_target_details = json_decode($conference->conference_target_details,true);

						$ids = array();
						foreach ($conference_target_details as $key => $value) {
							$ids[] = $value['id'];
						}
						if(count($ids)){
							$user_list = \User::whereIn('id',$ids);
						}
					}

					$user_list = $user_list->select('firebase_token')->get();
					
					foreach ($user_list as $value) {
						if($value['firebase_token'] != ""){
							$tokens_list[] = $value['firebase_token'];				
						}
					}

					if(count($tokens_list) > 0){
						$this->send_push_notification($tokens_list,$conference->conference_title,$this->language['meetStartedJoin'],"meetings",$conference->id);			
					}

				}

            }
            
		}
		
	}

	public function can($perm){
		if(is_array($perm)){
			foreach ($perm as $key => $value) {
				if (in_array($value, $this->perms)) {
					return true;
				}
			}
		}else{
			if (in_array($perm, $this->perms)) {
				return true;
			}
		}
		return false;
	}

	public function collectFees($id = ""){
		$feeTypeList = array();
		$updateAllocationArray = array();
		$updateGroupArray = array();
		$invoice_ids = array();

		if($id == ""){
			$fee_allocation = \fee_allocation::where('feeTypeNextTS','<',time())->where('feeTypeNextTS','!=',0);
		}else{
			$fee_allocation = \fee_allocation::where('id',$id);
		}
		if( $fee_allocation->count() > 0 ){
			$fee_allocation = $fee_allocation->limit(1)->get()->toArray();

			foreach ($fee_allocation as $value){
				$updateAllocationArray[$value['id']] = array();

				if(!isset($feeTypeList[$value['feeType']])){
					$feeType = \fee_type::leftJoin('fee_group','fee_group.id','=','fee_type.feeGroup')->where('fee_type.id',$value['feeType']);
					if($feeType->count() > 0){
						$feeTypeList[$value['feeType']] = $feeType->select('fee_type.id','fee_type.feeTitle','fee_type.feeCode','fee_type.feeDescription','fee_type.feeGroup','fee_type.feeAmount','fee_type.feeSchDetails','fee_group.invoice_prefix as invoice_prefix','fee_group.invoice_count as invoice_count')->first()->toArray();
						$feeTypeList[$value['feeType']]['feeSchDetails'] = json_decode($feeTypeList[$value['feeType']]['feeSchDetails'],true);

						$updateGroupArray[$feeTypeList[$value['feeType']]['id']] = array();
						$updateGroupArray[$feeTypeList[$value['feeType']]['id']]['group'] = $feeTypeList[$value['feeType']]['feeGroup'];
						$updateGroupArray[$feeTypeList[$value['feeType']]['id']]['count'] = $feeTypeList[$value['feeType']]['invoice_count'];
					}
				}

				if( !isset(	$feeTypeList[$value['feeType']] ) ){
					$updateAllocationArray[$value['id']]['feeTypeNextTS'] = 0;
				}else{
					$paymentUsers = $this->getPaymentUsers($value['feeFor'],$value['feeForInfo']);

					$paymentDate = time();
					$compareTimes = array();

					reset($feeTypeList[$value['feeType']]['feeSchDetails']);

					foreach ($feeTypeList[$value['feeType']]['feeSchDetails'] as $key_ => $value_){

						if($id != ""){

							if( !isset($dueDate) ){
	
								$paymentDate = time();
								$dueDate = time();

							}else{

								if($value_['date'] > time() AND $value_['date'] != "" AND $value_['date'] != 0){
									$compareTimes[] = $value_['date'];
								}
							}

						}else{
							
							if($value_['date'] >= time() AND $value_['date'] != "" AND $value_['date'] != 0){
								$compareTimes[] = $value_['date'];
							}

							if($value['feeTypeNextTS'] == $value_['date']){
								$paymentDate = $value_['date'];
								$dueDate = $value_['due'];
							}
						}
						
					}

					if(count($compareTimes) > 0){
						$updateAllocationArray[$value['id']]['feeTypeNextTS'] = min($compareTimes);
					}else{
						$updateAllocationArray[$value['id']]['feeTypeNextTS'] = 0;
					}

					$paymentRows = array();
					$paymentRows[] = array("title"=>$feeTypeList[$value['feeType']]['feeTitle'],"amount"=>$feeTypeList[$value['feeType']]['feeAmount']);

					foreach ($paymentUsers as $value_){

						$updateGroupArray[$value['feeType']]['count'] ++ ;

						$payments = new \payments();
						$payments->paymentTitle = $feeTypeList[$value['feeType']]['invoice_prefix'].$updateGroupArray[$value['feeType']]['count'];
						$payments->paymentDescription = $feeTypeList[$value['feeType']]['feeTitle'];
						$payments->paymentStudent = $value_['id'];
						$payments->paymentRows = json_encode($paymentRows);
						$payments->paymentAmount = $feeTypeList[$value['feeType']]['feeAmount'];
						$payments->paymentDiscounted = $feeTypeList[$value['feeType']]['feeAmount'];
						$payments->paymentStatus = "0";
						$payments->paymentDate = $paymentDate;
						$payments->dueDate = $dueDate;
						$payments->paymentUniqid = uniqid();
						$payments->save();

						$invoice_ids[] = $payments->id;
					}

				}
			}

		}

		if(count($updateAllocationArray) > 0){
			foreach ($updateAllocationArray as $key => $value){
				\fee_allocation::where('id',$key)->update($value);
			}
		}

		if(count($updateGroupArray) > 0){
			foreach ($updateGroupArray as $key => $value){
				\fee_group::where('id',$value['group'])->update( array( 'invoice_count' => $value['count']) );
			}
		}

		if(count($invoice_ids) > 0){
			$this->calculate_discounts($invoice_ids);
		}

	}

	function collectFeesRegister($user){
		$invoice_ids = array();
		$fee_type = \fee_type::where('feeSchType','register');
		if($fee_type->count() > 0){
			$fee_type = $fee_type->get();

			foreach ($fee_type as $key => $value) {

				$class_id = $user->studentClass;
				$section_id = $user->studentSection;

				$fee_allocation = \fee_allocation::where('feeType',$value->id)->whereIn('feeFor', array('all','class') );
				if($fee_allocation->count() > 0){

					$fee_allocation = $fee_allocation->first();
					$fee_allocation_for = json_decode($fee_allocation->feeForInfo,true);

					$generate_invoice = false;
					if($fee_allocation->feeFor == "all"){
						$generate_invoice = true;
					}

					if($fee_allocation->feeFor == "class" AND is_array($fee_allocation_for) AND isset($fee_allocation_for['class']) AND $fee_allocation_for['class'] == $class_id ){

						if ( $section_id != "" AND $section_id != 0 AND $section_id != null AND isset($fee_allocation_for['section']) AND is_array($fee_allocation_for['section']) AND in_array($section_id,$fee_allocation_for['section']) ){
							$generate_invoice = true;
						}
						if( !isset($fee_allocation_for['section']) OR ( isset($fee_allocation_for['section']) AND is_array($fee_allocation_for['section']) AND count($fee_allocation_for['section']) == 0 ) ){
							$generate_invoice = true;
						}

					}

					if($generate_invoice == true){

						$fee_group = \fee_group::where('id',$fee_allocation->feeGroup);
						if($fee_group->count() > 0){
							$fee_group = $fee_group->first();

							$paymentRows = array();
							$paymentRows[] = array("title"=>$value->feeTitle,"amount"=>$value->feeAmount);

							$invoice_count = $fee_group->invoice_count + 1;

							$payments = new \payments();
							$payments->paymentTitle = $fee_group->invoice_prefix.$invoice_count;
							$payments->paymentDescription = $value->feeTitle;
							$payments->paymentStudent = $user->id;
							$payments->paymentRows = json_encode($paymentRows);
							$payments->paymentAmount = $value->feeAmount;
							$payments->paymentDiscounted = $value->feeAmount;
							$payments->paymentStatus = "0";
							$payments->paymentDate = time();
							$payments->dueDate = time() + ( 7 * 24 * 60 * 60 );
							$payments->paymentUniqid = uniqid();
							$payments->save();

							\fee_group::where('id',$fee_group->id)->update( array( 'invoice_count' => $invoice_count) );
							$invoice_ids[] = $payments->id;

						}
					}
					
				}

			}
			
		}
		
		if(count($invoice_ids) > 0){
			$this->calculate_discounts($invoice_ids);
		}
	}

	function calculate_discounts($invoices_list){
		$available_discount = \fee_discount::where('discount_status','1')->get();
		$section_enabeld = $this->settingsArray['enableSections'];
		$userIds = array();
		
		$invoices = new \payments();
		if(is_array($invoices_list)){
			$invoices = $invoices->whereIn('id',$invoices_list);
		}else{
			$invoices = $invoices->where('id',$invoices_list);
		}
		$invoices = $invoices->get();
		foreach ($invoices as $key => $invoice) {
			$userIds[] = $invoice->paymentStudent;
		}

		//get users list
		$users = array();
		$users_list = \User::whereIn('id',$userIds)->select('studentClass','studentSection','id')->get()->toArray();
		foreach ($users_list as $key => $value) {
			$users[ $value['id'] ] = $value;
		}

		reset($invoices);
		foreach ($invoices as $key => $invoice) {
			reset($available_discount);

			$can_use_list = array();

			foreach ($available_discount as $key => $discount) {
				if($section_enabeld == true && isset($users[ $invoice->paymentStudent ]) ){
					if (strpos($discount->discount_assignment, 'cl-'.$users[ $invoice->paymentStudent ]['studentClass']."-".$users[ $invoice->paymentStudent ]['studentSection']) !== false) {
						$can_use_list[ $discount->id ] = $discount;
					}
				}
				if($section_enabeld == false && isset($users[ $invoice->paymentStudent ])){
					if (strpos($discount->discount_assignment, 'cl-'.$users[ $invoice->paymentStudent ]['studentClass']) !== false) {
						$can_use_list[ $discount->id ] = $discount;
					}
				}
				
				if (strpos($discount->discount_assignment, 'inv-'.$invoice->id) !== false) {
					$can_use_list[ $discount->id ] = $discount;
				}

				if (strpos($discount->discount_assignment, 'std-'.$invoice->paymentStudent) !== false) {
					$can_use_list[ $discount->id ] = $discount;
				}
			}

			$apply_discount = array();

			//Get max one
			if(count($can_use_list) >= 1){
				$fee_discount = array();

				foreach ($can_use_list as $key => $can_use_one) {
					$tmp_discount_calculation = $this->calculate_discount_value($can_use_one, $invoice->paymentAmount);
					if(count($fee_discount) == 0){
						$fee_discount = $tmp_discount_calculation;
					}else{
						if($tmp_discount_calculation['discount_value'] > $fee_discount['discount_value']){
							$fee_discount = $tmp_discount_calculation;
						}
					}
				}
				
			}

			if(count($can_use_list) == 0){
				\payments::where('id',$invoice->id)->update( array('paymentDiscount'=>0,'paymentDiscounted'=>$invoice->paymentAmount,'discount_id'=>0) );
			}else{
				if($fee_discount['discount_value'] > $invoice->paymentDiscount){

					$paymentDiscounted = $invoice->paymentAmount - $fee_discount['discount_value'];
					$update_invoice = array('paymentDiscount'=>$fee_discount['discount_value'],'paymentDiscounted'=>$paymentDiscounted,'discount_id'=>$fee_discount['discount_id']);
					if($paymentDiscounted == 0){
						$update_invoice['paymentStatus'] = 1;
					}

					\payments::where('id',$invoice->id)->update( $update_invoice );
				}
			}
			
		}
	}

	function calculate_discount_value($fee_discount,$original){
		$to_return = array();

		if($fee_discount['discount_type'] == "percentage"){
			$to_return['discount_id'] = $fee_discount['id'];
			$to_return['discount_value'] = ($original * $fee_discount['discount_value']) / 100;
			$to_return['after_discount'] = $original - ($original * $fee_discount['discount_value']) / 100;
		}
		
		if($fee_discount['discount_type'] == "fixed"){
			$to_return['discount_value'] = 0;
			if($fee_discount['discount_value'] >= $original){
				$to_return['discount_value'] = $original;
			}else{
				$to_return['discount_value'] = $fee_discount['discount_value'];
			}
			$to_return['after_discount'] = $original - $to_return['discount_value'];
			$to_return['discount_id'] = $fee_discount['id'];

		}

		return $to_return;
	}

	public function dueInvoicesNotif(){
		$dueInvoices = \payments::where('dueDate','<', time() )->where('dueNotified','0')->where('paymentStatus','!=','1');
		if($dueInvoices->count() > 0){

			if($this->settingsArray['dueInvoicesNotif'] == "mail" || $this->settingsArray['dueInvoicesNotif'] == "mailsms"){
				$mail = true;
			}
			if($this->settingsArray['dueInvoicesNotif'] == "sms" || $this->settingsArray['dueInvoicesNotif'] == "mailsms"){
				$sms = true;
			}

			if($this->settingsArray['dueInvoicesNotifTo'] == "student" || $this->settingsArray['dueInvoicesNotifTo'] == "both"){
				$students = true;
			}
			if($this->settingsArray['dueInvoicesNotifTo'] == "parent" || $this->settingsArray['dueInvoicesNotifTo'] == "both"){
				$parents = true;
			}

			if(isset($mail) || isset($sms)){
				$mailsms_template = \mailsms_templates::where('templateTitle','Due Invoice');

				$usersIds = array();
				$usersIdsFlat = array();
				$studentsArray = array();
				$parentsArray = array();
				$updateInvoices = array();

				//Get Due Invoices
				$dueInvoices = $dueInvoices->limit(5)->get()->toArray();
				foreach ($dueInvoices as $value){
					$usersIds[ $value['id'] ] = $value['paymentStudent'];
					$usersIdsFlat[] = $value['paymentStudent'];
					$updateInvoices[] = $value['id'];
				}

				if( $mailsms_template->count() > 0 ){
					$mailsms_template = $mailsms_template->first()->toArray();
					
					//Get users information
					$usersList = \User::whereIn('id',$usersIdsFlat);

					if(isset($parents)){
						$usersList = $usersList->orWhere(function ($query) use ($usersIdsFlat) {
									foreach ($usersIdsFlat as $value){
										$query = $query->orWhere('parentOf', 'like', '%"'.$value.'"%');
									}
								});
					}

					$usersList = $usersList->select('id','role','fullName','email','mobileNo','comVia','parentOf')->get()->toArray();
					foreach ($usersList as $value){

						if($value['role'] == "parent"){
							
							$value['parentOf'] = json_decode($value['parentOf'],true);
							if(is_array($value['parentOf'])){

								foreach ($value['parentOf'] as $value2){
									if(!isset($parentsArray[ $value2['id'] ])){
										$parentsArray[ $value2['id'] ] = array();
									}
									$parentsArray[ $value2['id'] ][] = array("id"=>$value['id'],"role"=>$value['role'],"email"=>$value['email'],"mobileNo"=>$value['mobileNo'],"comVia"=>$value['comVia'],"fullName"=>$value['fullName']);
								}

							}
								
						}else{
							$studentsArray[ $value['id'] ] = $value;
						}

					}

					//Start the sending operation
					reset($dueInvoices);
					$MailSmsHandler = new \MailSmsHandler();

					foreach ($dueInvoices as $value){

						if(!isset($studentsArray[$value['paymentStudent']])){
							continue;
						}

						if(isset($students)){

							if(isset($mail) AND strpos($studentsArray[$value['paymentStudent']]['comVia'], 'mail') !== false){
								$temp_mailsms_template = $mailsms_template;
								$searchArray = array("{name}","{invoice_id}","{invoice_details}","{invoice_amount}","{invoice_date}");
								$replaceArray = array($studentsArray[$value['paymentStudent']]['fullName'],$value['paymentTitle'],$value['paymentDescription'],$this->settingsArray['currency_symbol'].$value['paymentAmount'], $this->unix_to_date($value['paymentDate']) );
								$sendTemplate = str_replace($searchArray, $replaceArray, $temp_mailsms_template['templateMail']);
								$MailSmsHandler->mail($studentsArray[$value['paymentStudent']]['email'],$this->language['Invoices'],$sendTemplate,"",$this->settingsArray);
							}

							if(isset($sms) AND strpos($studentsArray[$value['paymentStudent']]['comVia'], 'sms') !== false AND strlen($studentsArray[$value['paymentStudent']]['mobileNo']) > 5){
								$temp_mailsms_template = $mailsms_template;
								$searchArray = array("{name}","{invoice_id}","{invoice_details}","{invoice_amount}","{invoice_date}");
								$replaceArray = array($studentsArray[$value['paymentStudent']]['fullName'],$value['paymentTitle'],$value['paymentDescription'],$this->settingsArray['currency_symbol'].$value['paymentAmount'], $this->unix_to_date($value['paymentDate']) );
								$sendTemplate = str_replace($searchArray, $replaceArray, $temp_mailsms_template['templateSMS']);
								$MailSmsHandler->sms($studentsArray[$value['paymentStudent']]['mobileNo'],$sendTemplate,$this->settingsArray);
							}

						}
						if(isset($parents) AND isset($parentsArray[$value['paymentStudent']]) ){
							
							foreach ($parentsArray[$value['paymentStudent']] as $parent){
								if(isset($mail) AND strpos($parent['comVia'], 'mail') !== false){
									$temp_mailsms_template = $mailsms_template;
									$searchArray = array("{name}","{invoice_id}","{invoice_details}","{invoice_amount}","{invoice_date}");
									$replaceArray = array($parent['fullName'],$value['paymentTitle'],$value['paymentDescription'],$this->settingsArray['currency_symbol'].$value['paymentAmount'], $this->unix_to_date($value['paymentDate']) );
									$sendTemplate = str_replace($searchArray, $replaceArray, $temp_mailsms_template['templateMail']);
									$MailSmsHandler->mail($parent['email'],$this->language['Invoices'],$sendTemplate,"",$this->settingsArray);
								}

								if(isset($sms) AND strpos($parent['comVia'], 'sms') !== false AND strlen($parent['mobileNo']) > 5){
									$temp_mailsms_template = $mailsms_template;
									$searchArray = array("{name}","{invoice_id}","{invoice_details}","{invoice_amount}","{invoice_date}");
									$replaceArray = array($parent['fullName'],$value['paymentTitle'],$value['paymentDescription'],$this->settingsArray['currency_symbol'].$value['paymentAmount'], $this->unix_to_date($value['paymentDate']) );
									$sendTemplate = str_replace($searchArray, $replaceArray, $temp_mailsms_template['templateSMS']);
									$MailSmsHandler->sms($parent['mobileNo'],$sendTemplate,$this->settingsArray);
								}
							}

						}
					}
				}
				if(count($updateInvoices) > 0){
					\payments::whereIn('id', $updateInvoices )->update( array('dueNotified'=>'1') );
				}
			}
		}
		
	}

	public function real_notifications($data){

		//Send to firebase
		$Firebase = new \Firebase();

		if(isset($this->settingsArray['firebase_apikey']) AND $this->settingsArray['firebase_apikey'] != ""){
			$Firebase->api_key($this->settingsArray['firebase_apikey']);
		}else{
			return;
		}

		$Firebase->title = $data['data_title'] ;
		$Firebase->body = strip_tags($data['data_message']);

		$addData = array();
		if(isset($data['payload_where'])){
			$addData['where'] = $data['payload_where'];
		}
		if(isset($data['payload_id'])){
			$addData['id'] = $data['payload_id'];
		}
		$addData['sound'] = 'default';
		if(count($addData) > 0){
			$Firebase->data = $addData;
		}
		
		$info = $Firebase->send($data['firebase_token']);
		\Log::info($info);
	}

	public function validate_upload($file){
		$allowed_mime_type = array("text/plain", "text/html", "text/css", "text/javascript", "text/markdown","text/pdf","text/richtext","text/calendar",
									"image/gif", "image/png", "image/jpeg", "image/bmp", "image/webp", "image/vnd.microsoft.icon","image/svg+xml","image/psd","image/pjpeg","image/x-icon",
									"audio/midi", "audio/mpeg", "audio/webm", "audio/ogg", "audio/wav","audio/mpeg3", "audio/x-mpeg-3", "audio/m4a","audio/x-wav","audio/3gpp","audio/3gpp2","audio/x-realaudio",
									"video/webm", "video/ogg","video/mpeg", "video/x-mpeg","video/mp4","video/x-m4v","video/quicktime","video/x-ms-asf","video/x-ms-wmv","application/x-troff-msvideo", "video/avi", "video/msvideo", "video/x-msvideo","video/3gpp","video/3gpp2","video/x-flv","video/divx","video/x-matroska",
									"application/pkcs12", "application/vnd.mspowerpoint","application/msword", "application/xhtml+xml", "application/xml", "application/pdf","application/x-pdf","application/vnd.openxmlformats-officedocument.wordprocessingml.document",'application/rtf',"application/mspowerpoint", "application/powerpoint", "application/vnd.ms-powerpoint", "application/x-mspowerpoint","application/vnd.openxmlformats-officedocument.presentationml.presentation","application/mspowerpoint","application/vnd.ms-powerpoint","application/vnd.openxmlformats-officedocument.presentationml.slideshow","application/vnd.oasis.opendocument.text","application/excel","application/vnd.ms-excel","application/x-excel","application/x-msexcel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.ms-write","application/vnd.ms-access","application/vnd.ms-project",
									"application/x-rar-compressed","application/zip", "application/x-zip-compressed", "multipart/x-zip","application/x-7z-compressed","application/rar","application/x-7z-compressed",
								);
		$banned_extensions = array("php","php3","php4","php5","cgi","sh","bash","bin","pl","htaccess","htpasswd","ksh");

		$uploaded_mime_type = $file->getMimeType();
		$uploaded_extension = $file->getClientOriginalExtension();
		
		if( in_array( $uploaded_extension , $banned_extensions)  ){
			return false;
		}

		if( in_array( $uploaded_mime_type , $allowed_mime_type)  ){
			return true;
		}

		return false;
	}

	public function redirect($to){
		if($to == "install"){
			$toTitle = "Installation";
		}
		if($to == "upgrade"){
			$toTitle = "Upgrade";
		}
		echo "<html><head>
			<title>$toTitle</title>
			<meta http-equiv='refresh' content='2; URL=".\URL::to('/'.$to)."'>
			<meta name='keywords' content='automatic redirection'>
		</head>
		<body> If your browser doesn't automatically go to the $toTitle within a few seconds,
		you may want to go to <a href='".\URL::to('/'.$to)."'>the destination</a> manually.
		</body></html>";
		die();
	}

	public function getPaymentUsers($feeFor,$feeForInfo){
		$students = array();

		if($feeFor == "all" AND isset($this->selectAcYear)){
			$classesList = array();
			$classes = classes::where('classAcademicYear',$this->selectAcYear)->get()->toArray();
			foreach ($classes as $value){
				$classesList[] = $value['id'];
			}

			$students = array();
			if(count($classesList) > 0){
				$students = User::where('role','student')->whereIn('studentClass',$classesList)->where('activated','1')->select('id')->get()->toArray();
			}
		}

		if($feeFor == "class"){
			$feeForInfo = json_decode($feeForInfo,true);

			if(is_array($feeForInfo) AND isset($feeForInfo['class'])){
				$students = User::where('role','student')->where('activated','1')->where('studentClass',$feeForInfo['class']);
				if( isset($feeForInfo['section']) AND is_array($feeForInfo['section']) ){
					$students = $students->whereIn('studentSection',$feeForInfo['section']);
				}
				$students = $students->select('id')->get()->toArray();

			}
		}

		if($feeFor == "student"){
			$feeForInfo = json_decode($feeForInfo,true);

			if(is_array($feeForInfo) && count($feeForInfo) > 0){
				$ids = array();
				foreach ($feeForInfo as $value){
					if(isset($value['id'])){
						$ids[] = $value['id'];
					}
				}

				if(count($ids) > 0){
					$students = User::where('role','student')->where('activated','1')->whereIn('id',$ids)->select('id')->get()->toArray();					
				}

			}
		}

		return $students;
	}

	public function hasThePerm($perm){
		if(\Auth::user() AND \Auth::user()->role == "admin" AND \Auth::user()->customPermissionsType == "custom" AND is_array(\Auth::user()->customPermissionsAsJson()) AND !in_array($perm,\Auth::user()->customPermissionsAsJson())){
			return false;
		}else{
			return true;
		}
	}

	public function getAuthUser(){
		if(app('request')->header('Authorization') != "" || \Input::has('token')){
			try{
				return \JWTAuth::parseToken()->authenticate();				
			}catch(exception $e){
				
			}
		}else{
			return \Auth::guard('web')->user();
		}
	}

	public function isLoggedInUser(){

	}

	public function customPermissionsType(){
		if($this->customPermissionsDecoded == ""){
			$this->customPermissionsDecoded = json_decode($this->customPermissions);
		}
		return $this->customPermissionsDecoded;
	}

	public function mobNotifyUser($userType,$userIds,$notifData){
		$mobNotifications = new \mob_notifications();

		if($userType == "users"){
			$mobNotifications->notifTo = "users";
			if(!is_array($userIds)){
				$userIds = array($userIds);
			}
			$userIdsList = array();
			foreach ($userIds as $value){
				$userIdsList[] = array('id'=>$value);
			}
			$mobNotifications->notifToIds = json_encode($userIdsList);
		}elseif($userType == "class"){
			$mobNotifications->notifTo = "students";
			$mobNotifications->notifToIds = $userIds;
		}elseif($userType == "role"){
			$mobNotifications->notifTo = $userIds;
			$mobNotifications->notifToIds = "";
		}

		$mobNotifications->notifData = htmlspecialchars($notifData,ENT_QUOTES);
		$mobNotifications->notifDate = time();
		$mobNotifications->notifSender = "Automated";
		$mobNotifications->save();

		//Get users List
		$token_list = array();
		if($userType == "users"){
			if(!is_array($userIds)){
				$userIds = array($userIds);
			}
			$userIdsList = array();
			foreach ($userIds as $value){
				$userIdsList[] = array('id'=>$value);
			}

			$token_list = \User::whereIn('id',$userIdsList)->select('firebase_token')->get();
		}elseif($userType == "class"){
			$token_list = \User::whereIn('role','student')->select('firebase_token')->get();
		}elseif($userType == "role"){
			$token_list = \User::whereIn('role',$userIds)->select('firebase_token')->get();
		}

		$notif_data = array('data_title'=>'','data_message'=>'','notifUrl'=>'','payload_where'=>'','payload_id'=>'','firebase_token'=>array());
		foreach ($token_list as $value) {
			$notif_data['firebase_token'][] = $value['firebase_token'];
		}
		$this->send_push_notification($notif_data);

	}

	public function send_push_notification($target_tokens,$message,$title="",$payload_location = "",$payload_id = ""){
		//Send to firebase
		$Firebase = new \Firebase();

		if(isset($this->settingsArray['firebase_apikey']) AND $this->settingsArray['firebase_apikey'] != ""){
			$Firebase->api_key($this->settingsArray['firebase_apikey']);
		}else{
			return;
		}

		if($title != ""){
			$Firebase->title = $title ;
		}else{
			$Firebase->title = $this->settingsArray['siteTitle'] ;
		}
		$Firebase->body = strip_tags($message);

		$payload_data = array();
		if($payload_location != ""){
			$payload_data['where'] = $payload_location;
		}
		if($payload_id != ""){
			$payload_data['id'] = $payload_id;
		}
		$payload_data['sound'] = 'default';
		if(count($payload_data) > 0){
			$Firebase->data = $payload_data;
		}

		$inflated_tokens = array();
		if(is_array($target_tokens)){
			foreach ($target_tokens as $key => $value) {
				$value = json_decode($value);
				if(is_array($value)){
					foreach ($value as $key_ => $value_) {
						$inflated_tokens[] = $value_;
					}
				}
			}
		}else{
			$target_tokens = json_decode($target_tokens);
			if(is_array($target_tokens)){
				foreach ($target_tokens as $key_ => $value_) {
					$inflated_tokens[] = $value_;
				}
			}
		}
		
		$info = $Firebase->send($inflated_tokens);
		\Log::info($info);
	}

	public static function globalXssClean()
	{
	  $sanitized = static::arrayStripTags(Input::get());
	  Input::merge($sanitized);
	}

	public static function arrayStripTags($array)
	{
	    $result = array();

	    foreach ($array as $key => $value) {
	        // Don't allow tags on key either, maybe useful for dynamic forms.
	        $key = strip_tags($key);

	        // If the value is an array, we will just recurse back into the
	        // function to keep stripping the tags out of the array,
	        // otherwise we will set the stripped value.
	        if (is_array($value)) {
	            $result[$key] = static::arrayStripTags($value);
	        } else {
	            // I am using strip_tags(), you may use htmlentities(),
	            // also I am doing trim() here, you may remove it, if you wish.
	            $result[$key] = trim(strip_tags($value));
	        }
	    }

	    return $result;
	}

	public function viewop($layout,$view,&$data,$div=""){
		$data['content'] = View::make($view, $data);
		return view($layout, $data);
	}

	function sanitize_output($buffer) {
		$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s','/\s\s+/');
		$replace = array('>','<',' ',' ');
		$buffer = preg_replace($search, $replace, $buffer);

		return $buffer;
	}

	public static function breadcrumb($breadcrumb){
		echo "<ol class='breadcrumb'>
					<li><a class='aj' href='".URL::to('/dashboard')."'><i class='fa fa-dashboard'></i> Home</a></li>";
		$i = 0;
		foreach ($breadcrumb as $key => $value){
			$i++;
			if($i == count($breadcrumb)){
				echo "<li class='active'>".$key."</li>";
			}else{
				echo "<li class='bcItem'><a class='aj' href='$value' title='$key'>$key</a></li>";
			}
		}
		echo "</ol>";
	}

	public function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = false) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen ( preg_replace ( '/<.*?>/', '', $text ) ) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all ( '/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER );
			$total_length = strlen ( $ending );
			$open_tags = array ( );
			$truncate = '';
			foreach ( $lines as $line_matchings ) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (! empty ( $line_matchings [1] )) {
					// if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
					if (preg_match ( '/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings [1] )) {
						// do nothing
					// if tag is a closing tag (f.e. </b>)
					} else if (preg_match ( '/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings [1], $tag_matchings )) {
						// delete tag from $open_tags list
						$pos = array_search ( $tag_matchings [1], $open_tags );
						if ($pos !== false) {
							unset ( $open_tags [$pos] );
						}
						// if tag is an opening tag (f.e. <b>)
					} else if (preg_match ( '/^<\s*([^\s>!]+).*?>$/s', $line_matchings [1], $tag_matchings )) {
						// add tag to the beginning of $open_tags list
						array_unshift ( $open_tags, strtolower ( $tag_matchings [1] ) );
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings [1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen ( preg_replace ( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings [2] ) );
				if ($total_length + $content_length > $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all ( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings [2], $entities, PREG_OFFSET_CAPTURE )) {
						// calculate the real length of all entities in the legal range
						foreach ( $entities [0] as $entity ) {
							if ($entity [1] + 1 - $entities_length <= $left) {
								$left --;
								$entities_length += strlen ( $entity [0] );
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr ( $line_matchings [2], 0, $left + $entities_length );
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings [2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if ($total_length >= $length) {
					break;
				}
			}
		} else {
			if (strlen ( $text ) <= $length) {
				return $text;
			} else {
				$truncate = substr ( $text, 0, $length - strlen ( $ending ) );
			}
		}
		// if the words shouldn't be cut in the middle...
		if (! $exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos ( $truncate, ' ' );
			if (isset ( $spacepos )) {
				// ...and cut the text in this position
				$truncate = substr ( $truncate, 0, $spacepos );
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if ($considerHtml) {
			// close all unclosed html-tags
			foreach ( $open_tags as $tag ) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}

	public function apiOutput($success,$title=null,$messages = null,$data=null){
		$returnArray = array("status"=>"");

		if($title != null){
			$returnArray['title'] = $title;
		}

		if($messages != null){
			$returnArray['message'] = $messages;
		}

		if($data != null){
			$returnArray['data'] = $data;
		}

		if($success){
			$returnArray['status'] = 'success';
			return $returnArray;
		}else{
			$returnArray['status'] = 'failed';
			return $returnArray;
		}
	}

	public function get_default_perm($role){
		$roles = \roles::where('def_for',$role)->select('id');
		if($roles->count() == 0){
			return 0;
		}
		$roles = $roles->first();
		return $roles->id;
	}

	public function date_to_unix($time,$format=""){
		if(!isset($this->settingsArray['timezone'])){
			$this->settingsArray['timezone'] = "Europe/London";
		}
		if($format == ""){
			$format = $this->settingsArray['dateformat'];
		}
		if(!isset($this->settingsArray['gcalendar']) || ( isset($this->settingsArray['gcalendar']) AND ( $this->settingsArray['gcalendar'] == "gregorian" || $this->settingsArray['gcalendar'] == "" ) ) ){
			//Regular Date manipulation
			$format = str_replace("hr","h",$format);
			$format = str_replace("mn","i",$format);
			return $this->greg_to_unix($time,$format);
		}else{
			//Intl Date manipulation
			$format = str_replace("hr","h",$format);
			$format = str_replace("mn","m",$format);
			return $this->intlToTimestamp($time,$format);
		}
	}

	public function unix_to_date($timestamp,$format=""){
		if($format == ""){
			$format = $this->settingsArray['dateformat'];
		}
		if(!isset($this->settingsArray['timezone'])){
			$this->settingsArray['timezone'] = "Europe/London";
		}

		//Adjust date offset
		if(isset($this->settingsArray['calendarOffset']) AND $this->settingsArray['calendarOffset'] != "" AND $this->settingsArray['calendarOffset'] != "0" ){
			$timestamp += ( intval($this->settingsArray['calendarOffset']) * 86400 );
		}

		if(!isset($this->settingsArray['gcalendar']) || ( isset($this->settingsArray['gcalendar']) AND ( $this->settingsArray['gcalendar'] == "gregorian" || $this->settingsArray['gcalendar'] == "" ) ) ){
			//Regular Date manipulation
			$format = str_replace("hr","h",$format);
			$format = str_replace("mn","i",$format);
			return $this->unix_to_greg($timestamp,$format);
		}else{
			//Intl Date manipulation
			$format = str_replace("hr","h",$format);
			$format = str_replace("mn","m",$format);
			return $this->timestampToIntl($timestamp,$format);
		}
	}

	public function date_ranges($start,$end=""){
		if(!isset($this->settingsArray['timezone'])){
			$this->settingsArray['timezone'] = "Europe/London";
		}

		//Adjust date offset
		if(isset($this->settingsArray['calendarOffset']) AND $this->settingsArray['calendarOffset'] != "" AND $this->settingsArray['calendarOffset'] != "0" ){
			$start += ( intval($this->settingsArray['calendarOffset']) * 86400 );
			$end += ( intval($this->settingsArray['calendarOffset']) * 86400 );
		}

		if(!isset($this->settingsArray['gcalendar']) || ( isset($this->settingsArray['gcalendar']) AND ( $this->settingsArray['gcalendar'] == "gregorian" || $this->settingsArray['gcalendar'] == "" ) ) ){
			return $this->gregTsDow($start,$end);
		}else{
			return $this->intlTsDow($start,$end);
		}
	}

	function todayDow(){
		$time = time();

		//Adjust date offset
		if(isset($this->settingsArray['calendarOffset']) AND $this->settingsArray['calendarOffset'] != "" AND $this->settingsArray['calendarOffset'] != "0" ){
			$time += ( intval($this->settingsArray['calendarOffset']) * 86400 );
		}

		if(!isset($this->settingsArray['gcalendar']) || ( isset($this->settingsArray['gcalendar']) AND ( $this->settingsArray['gcalendar'] == "gregorian" || $this->settingsArray['gcalendar'] == "" ) ) ){
			return $this->unix_to_date($time,'w') + 1;
		}else{
			return $this->unix_to_date($time,'e') + 1 ;
		}
	}

	//Work with Date & Time
	public function greg_to_unix($time,$format) {
		$dd = DateTime::createFromFormat($format, $time, new DateTimeZone($this->settingsArray['timezone']));
		if (strpos($format, 'h:i') == false) {
			$dd->setTime(0,0,0);
		}
		return $dd->getTimestamp();
	}

	public function unix_to_greg($timestamp, $format){
		if($timestamp == ""){
			$timestamp = time();
		}
		$date = new DateTime("@".$timestamp);
		$date->setTimezone(new DateTimeZone($this->settingsArray['timezone']));
		return $date->format($format);
	}

	//Work with Date & Time
	public function intlToTimestamp($date,$format=""){
		if($format == ""){
			$format = $this->settingsArray['dateformat'];
		}

		$format = str_replace('m','MM',$format);
		$format = str_replace('d','dd',$format);
		$format = str_replace('Y','yyyy',$format);

		if($this->settingsArray['gcalendar'] == "gregorian"){
			$intl_locale = 'en_Us';
			$intl_calendar = \IntlDateFormatter::GREGORIAN;
		}else{
			$intl_locale = 'en_Us@calendar='.$this->settingsArray['gcalendar'];
			$intl_calendar = \IntlDateFormatter::TRADITIONAL;
		}

		$intlDateFormatter = new \IntlDateFormatter(
			$intl_locale,
			\IntlDateFormatter::FULL,
			\IntlDateFormatter::FULL,
			$this->settingsArray['timezone'],
			$intl_calendar,
			$format
		);
		$intlDateFormatter->setLenient(false);

		return $intlDateFormatter->parse($date);
	}

	public function timestampToIntl($timestamp,$format=""){

		if($format == ""){
			$format = $this->settingsArray['dateformat'];
		}

		$format = str_replace('m','MM',$format);
		$format = str_replace('d','dd',$format);
		$format = str_replace('Y','yyyy',$format);

		if($this->settingsArray['gcalendar'] == "gregorian"){
			$intl_locale = 'en_Us';
			$intl_calendar = \IntlDateFormatter::GREGORIAN;
		}else{
			$intl_locale = 'en_Us@calendar='.$this->settingsArray['gcalendar'];
			$intl_calendar = \IntlDateFormatter::TRADITIONAL;
		}

		$DateTime = new \DateTime("@".$timestamp);
		$IntlDateFormatter = new \IntlDateFormatter(
			$intl_locale,
			\IntlDateFormatter::FULL,
			\IntlDateFormatter::FULL,
			$this->settingsArray['timezone'],
			$intl_calendar,
			$format
		);
		return $IntlDateFormatter->format($timestamp);
	}

	public function gregTsDow($start,$end=""){
		$return = array();

		$format = $this->settingsArray['dateformat'];

		if(!isset($this->settingsArray['timezone'])){
			$this->settingsArray['timezone'] = "Europe/London";
		}

		if($end == ""){
			$dd = DateTime::createFromFormat($format, $start, new DateTimeZone($this->settingsArray['timezone']));
			$return[] = array("dow"=>$dd->format('N'),"date"=>$start,"timestamp"=>$dd->getTimestamp() );
		}else{

			$tmpDate = DateTime::createFromFormat($format, $start, new DateTimeZone($this->settingsArray['timezone']));
			$tmpDate->setTime(0,0,0);

			$tmpEndDate = DateTime::createFromFormat($format, $end, new DateTimeZone($this->settingsArray['timezone']));
			$tmpEndDate->setTime(0,0,0);

			$outArray = array();
			do {
				$return[] = array("dow"=>$tmpDate->format('N'),"date"=>$tmpDate->format($format),"timestamp"=>$tmpDate->getTimestamp() );
			} while ($tmpDate->modify('+1 day') <= $tmpEndDate);

		}

		return $return;
	}

	public function intlTsDow($start,$end=""){
		$return = array();

		$format = $this->settingsArray['dateformat'];

		$format = str_replace('m','MM',$format);
		$format = str_replace('d','dd',$format);
		$format = str_replace('Y','yyyy',$format);

		if(!isset($this->settingsArray['timezone'])){
			$this->settingsArray['timezone'] = "Europe/London";
		}

		$intl_locale = 'en_Us@calendar='.$this->settingsArray['gcalendar'];
		$intl_calendar = \IntlDateFormatter::TRADITIONAL;

		$intlDateFormatter = new \IntlDateFormatter(
						$intl_locale,
						\IntlDateFormatter::FULL,
						\IntlDateFormatter::FULL,
						$this->settingsArray['timezone'],
						$intl_calendar,
						$format
					);
		$intlDateFormatter->setLenient(false);
		$timestamp = $intlDateFormatter->parse($start);
		$firstTime = true;

		if($end == ""){
			$DateTime = new \DateTime("@".$timestamp);
			$IntlDateFormatter = new \IntlDateFormatter(
				$intl_locale,
				\IntlDateFormatter::FULL,
				\IntlDateFormatter::FULL,
				$this->settingsArray['timezone'],
				$intl_calendar,
				"e"
			);
			$return[] = array("dow"=>$IntlDateFormatter->format($DateTime),"date"=>$start,"timestamp"=>$timestamp);
		}else{
			do{
				if(!isset($firstTime)){
					$start = $this->timestampToIntl($timestamp);
				}else{
					$end = $this->intlToTimestamp($end);
				}

				unset($firstTime);
				$DateTime = new \DateTime("@".$timestamp);
				$IntlDateFormatter = new \IntlDateFormatter(
					$intl_locale,
					\IntlDateFormatter::FULL,
					\IntlDateFormatter::FULL,
					$this->settingsArray['timezone'],
					$intl_calendar,
					"e"
				);
				$return[] = array("dow"=>$IntlDateFormatter->format($DateTime),"date"=>$start,"timestamp"=>$timestamp);

				//Next timestamp
				$timestamp = $timestamp + 86400;
			}while($timestamp <= $end);
		}

		return $return;
	}

}
