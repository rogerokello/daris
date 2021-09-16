<?php
App::uses('Folder','Utility');
App::uses('Files','Utility');
App::uses('AppController', 'Controller');
App::uses('StudentsController', 'Controller');
/*
* Staffdetails Controller
*
* @property Staffdetail $Staffdetail
* @property PaginatorComponent $Paginator
* @property SessionComponent $Session
*/
class OlevelreportdetailsController extends AppController {

  public $helpers = array('Paginator','Html', 'Form', 'Js');
  public $components = array('Paginator','Session','PhpExcel.PhpExcel');
   

  public function index() {
    $this->layout = 'default2';
    $this->Paginator->settings = array(
      'Olevelreportdetail' => array (
        'paramType' => 'querystring',
        'limit' => 10,
        'order' => array(
          'id' => 'desc'
        ),
        'recursive' => 0
      )
    );
    $this->set('students', $this->Paginator->paginate());
  }
 

  public function search() {
    $this->layout = 'default2';
    if ($this->request->is('put') || $this->request->is('post')) {
      return $this->redirect(array(
        '?' => array(
          'q' => $this->request->data('Olevelreportdetail.searchQuery')
        )
      ));
    }
    $this->Olevelreportdetail->recursive = 0;
    $searchQuery = $this->request->query('q');
    $this->Paginator->settings = array(
      'Olevelreportdetail' => array(
        'findType' => 'search',
        'searchQuery' => $searchQuery
      )
    );
    $this->set('students', $this->Paginator->paginate());
    $this->set('searchQuery', $searchQuery);
    $this->render('index');
  }


/**
* add method
*
* @return void
*/
  public function add() {
    
	      set_time_limit(0);
	    
	      $this->layout = 'default2';
	      $this->loadModel('Schooldoneexam');
	      $this->loadModel('Schooldonesubject');

	      if (!empty($this->request->data)) {
          if ($this->request->is('post')) {

            $this->request->data['reportname'] = strtoupper(trim($this->request->data['reportname']));
            $reportname = $this->request->data['reportname'];
            $class = $this->request->data['class'];
            $term = $this->request->data['term'];
            $subjects = $this->request->data['subject']; // This is an array
            $examtoenter = $this->request->data['examtoenter']; // This is an array
            $year = $this->request->data['year'];
  
            $test = (
              ($class != null) 
                && 
              ($term != null)
                &&
              (is_array($subjects))
                &&
              (is_array($examtoenter))
            );
    
            if ($test) {
              $this->loadModel('Student');
              $this->loadModel('Olevelmarksheetresult');
              $this->loadModel('Olevelreport');

              $students_in_that_class = $this->Student->find('all', array(
                  'fields' => array('Student.id','Student.currentstream'),
                  'conditions' => array(
                      'Student.currentclass =' => $class,
                      'Student.leavingreason' => "None"						    
                  ),
                  'order' => array('Student.currentstream' => 'asc')
                  //'recursive' => 0
                )
              );

              $madereport = $this->Olevelreportdetail->find('list', array(
                  'fields' => array('Olevelreportdetail.id', 'Olevelreportdetail.reportname'),
                  'conditions' => array(
                      'Olevelreportdetail.reportname =' => $reportname,
                      'Olevelreportdetail.reportterm =' => $term,
                      'Olevelreportdetail.reportyear =' => $year,
                      'Olevelreportdetail.reportclass =' => $class,
                  )
                )
              );
  
              if ( ($madereport == null) && (count($students_in_that_class) > 0) ) {
				        // put all exams meant to be done in a string and separate by <::>
				        $examsdone = ""; //The exams chosen for each student
				        $number_of_exams_selected = count($examtoenter);

				        if(is_array($examtoenter)){ 
				          foreach($examtoenter as $oneexam) {			    
					          if ( $number_of_exams_selected == 1 ) {
					            $examsdone = $oneexam;
					            break;
					          } else {
					            $examsdone = $oneexam."<::>".$examsdone;   
					          }
				          }
				        }

				        $examsdone = rtrim($examsdone, "<::>");

				        //put all subject to be done separated by the <::>
				        $subjectsdone = "";
				        $number_of_subjects_selected = count($subjects);

				        if(is_array($subjects)){ 
				          foreach($subjects as $oneexam) {
					          if ( $number_of_subjects_selected == 1 ) {
					            $subjectsdone = $oneexam;
					            break;
					          } else {
					            $subjectsdone = $oneexam."<::>".$subjectsdone;  
					          }
				          } 
				        }
				
				        $subjectsdone = rtrim($subjectsdone, "<::>");
				
                $data = array(
                  'Olevelreportdetail' => array(
                    'reportname' => $reportname,
                    'reportterm' => $term,
                    'reportyear' => $year,
                    'reportclass' => $class,
                    'default_exams_considered' => $examsdone,
                    'default_subjects_considered' => $subjectsdone,
                  )
                );
			    
				        $examsdone = null;
			        	$number_of_exams_selected = null;
				
				        $subjectsdone = null;
				        $number_of_subjects_selected = null;
				
				        if ( $this->Olevelreportdetail->save($data) ) {
				          $reportdetail_id = $this->Olevelreportdetail->field(
                    'id',
                    array(
								      'reportname =' => $reportname,
								      'reportterm' => $term,
								      'reportyear' => $year,
								      'reportclass' => $class,
							      )
						      );
			    
				          $data = null;
				          $number_of_students_reports_to_create = count($students_in_that_class );
				          $number_of_student_reports_created = 0;

				          foreach ( $students_in_that_class as $student_in_class ) {
					          $this->Olevelreport->create();
					          $data = array(
					            'Olevelreport' => array(
						            'student_id' => $student_in_class['Student']['id'],
						            'classthen' => $class,
						            'streamthen' => $student_in_class['Student']['currentstream'],
						            'olevelreportdetail_id' => $reportdetail_id,
					            )
					          );
				    
					          // put all exams meant to be done in a string and separate by <::>
					          $examsdone = ""; //The exams chosen for each student
					          $number_of_exams_selected = count($examtoenter);
				    
					          foreach($examtoenter as $oneexam) {
					            if ( $number_of_exams_selected == 1 ) {
						            $examsdone = $oneexam;
						            break;
					            } else {
						            $examsdone = $oneexam."<::>".$examsdone;   
					            }
					          }
				    
					          $date = new DateTime();
					
					          foreach ( $subjects as $subject ) {
					            $exams_considered_for_subject = $subject.'_examsconsidered';
					            $data['Olevelreport'][$exams_considered_for_subject] = $examsdone;
					            $date_and_time_report_created = $subject.'_datecreated';
					    
					            $data['Olevelreport'][$date_and_time_report_created] = $date->format('Y-m-d H:i:s');
					          }

					          $this->Olevelreport->save($data);
					          $number_of_student_reports_created++;
				          }

				          if($number_of_student_reports_created == $number_of_students_reports_to_create){

				            $this->Olevelreport->report_add_examsconsidered($reportdetail_id,null);
				            $this->Olevelreport->report_gradesubjects($reportdetail_id,null);
				            $this->Olevelreport->report_get_total_mark($reportdetail_id,null);
				            $this->Olevelreport->report_getaggregates($reportdetail_id);
				            $this->Olevelreport->report_getdivision($reportdetail_id);
				            $this->Olevelreport->report_get_position($reportdetail_id, null);
				            $this->Session->setFlash(__('Successfully created '.$number_of_students_reports_to_create.' reports'));

				            return $this->redirect(array('action' => 'index'));
				          } else {

				            $this->Session->setFlash(__('The number of reports created by the system is less than 
								      the number supposed to be created. Please delete the reports
								      just created and repeat the process')
                    );

				            return $this->redirect(array('action' => 'index'));
				          }
			          } else {
			    
				          $this->Session->setFlash(__('Did not successfully save Olevel report detail'));
			    
			          }
			        } else {
			
			          if ( count($students_in_that_class) == 0 ) {
			    
				          $this->Session->setFlash(__('There are no students in the class chosen. System not creating report(s)' ));
			    
			          } else {
			    
				          if ( $madereport != null ) {
			    
				            $this->Session->setFlash(__('This report name already exists, please try another report name'));
			    
				          }
			          }
			        }
			      } else {
		
			        if ($class == null) {
			          $this->Session->setFlash(__('Please select a class'));
			        } else {
			          if ($term == null) {
				          $this->Session->setFlash(__('Please select a term'));
			          } else {
				          if (!is_array($subjects)) {
				            $this->Session->setFlash(__('Please select atleast one subject'));
				          } else {
				            if (!is_array($examtoenter)) {
					            $this->Session->setFlash(__('Please select atleast one Examination'));
				            } else {
					            if ($year == null) {
					              $this->Session->setFlash(__('Please select a year'));
					            }
				            }
				          }
			          }
			        }
			      }
		      }
	      }
	    
	      $examsdoneintheschool = $this->Schooldoneexam->find(
          'list',
          array(
		        'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
		        'recursive' => 0
	        )
        );
    
	      $subjectsdoneintheschool = $this->Schooldonesubject->find(
          'list',
          array(
		        'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
		        'recursive' => 0
	        )
        );
	    
	      //$this->set('streamsintheschool',$streamsintheschool);
	      $this->set('examsdoneintheschool',$examsdoneintheschool);
	      $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
  }


/**
* edit method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
  public function edit($id = null,$edit_mode = null) {
		
	  if ((!$id) || (!$edit_mode)){
	    throw new NotFoundException(__('Invalid Report'));
	  }
	  $this->loadModel('Olevelreport');
	
	  $reports = $this->Olevelreportdetail->findById($id);
	  $reports_results = $this->Olevelreport->find('all', array(
	    'conditions' => array('Olevelreport.olevelreportdetail_id' => $id),
	    'fields' => array('Olevelreport.id')
	  ));
	
	  $exams_considered = explode("<::>",$reports['Olevelreportdetail']['default_exams_considered']);
	  $subjects_considered = explode("<::>",$reports['Olevelreportdetail']['default_subjects_considered']);
	  $report_name = $reports['Olevelreportdetail']['reportname'];
	  $report_year = $reports['Olevelreportdetail']['reportyear'];
	  $reportclass = $reports['Olevelreportdetail']['reportclass'];
	  $reportterm = $reports['Olevelreportdetail']['reportterm'];
	
	  if (!$reports){
	    throw new NotFoundException(__('Invalid Report'));
	  }

	  set_time_limit(0);
	    
	  $this->layout = 'default2';
	  $this->loadModel('Schooldoneexam');
	  $this->loadModel('Schooldonesubject');
	  $this->loadModel('Student');

	  if (!empty($this->request->data)) {
		
		  if ($this->request->is('post')) {
        $this->Olevelreportdetail->id = $id;
        $this->request->data['reportname'] = strtoupper(trim($this->request->data['reportname']));
        $reportname = $this->request->data['reportname'];
        $class = $reportclass;
        $term = $this->request->data['term'];
        $subjects = $this->request->data['subject']; // This is an array
        $examtoenter = $this->request->data['examtoenter']; // This is an array
        $year = $report_year;
        $report_ids_to_be_edited = array();
        $wrongregistration_number = null;
        $nonexistent_in_system_registration_numbers = array();
        $nonexistent_in_report_registration_numbers = array();
        $registration_numbers_text_box = $this->request->data['registrationnumbers'];
			
			  if (($this->request->data['enterspecificstudents'] == "1") && ($this->request->data['registrationnumbers'] != null)) {
			
			    $registrationnumbers = explode(",",$registration_numbers_text_box);
			    
			    //Extract the student IDS before checking if they exist in the report
			    foreach ($registrationnumbers as $registrationnumber) {
			    
				    $student_idr = $this->Student->field(
              'id',
				      array(
                'registrationnumber' => $registrationnumber
              )
				    );
				
				    if ($student_idr != false) {
				      //Check if student ID exists in the report
				      $student_id_of_report = $this->Olevelreport->field(
                'id',
                array(
                  'student_id' => $student_idr,
                  'olevelreportdetail_id' => $id
                )
				      );
				    
				      if ($student_id_of_report == false) {   
					      array_push($nonexistent_in_report_registration_numbers,$registrationnumber);
				      } else {
					      array_push($report_ids_to_be_edited,$student_id_of_report);
				      }
				    } else {
				      array_push($nonexistent_in_system_registration_numbers,$registrationnumber);
				    }
			    }
			    
			    if ((count($nonexistent_in_system_registration_numbers) > 0) ||
			       (count($nonexistent_in_report_registration_numbers) > 0)
			    ) {
					  $noneexistent = " ";

					  foreach ($nonexistent_in_system_registration_numbers as $nonexistent1) {
					    $noneexistent = $noneexistent.$nonexistent1."<br/>";
					  }

					  $noneexistent2 = " ";

					  foreach ($nonexistent_in_report_registration_numbers as $nonexistent1) {
					    $noneexistent2 = $noneexistent2.$nonexistent1."<br/>";
					  }
					
					  $this->Session->setFlash(__('The following registration numbers where not found in the database:<br/>'.$noneexistent.
								    'The following registration numbers where not found in the report:<br/>'.$noneexistent2
					  ));
		
					  $examsdoneintheschool = $this->Schooldoneexam->find(
              'list',
              array(
					      'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
					      'recursive' => 0
					    )
            );
    
					  $subjectsdoneintheschool = $this->Schooldonesubject->find(
              'list',
              array(
					      'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
					      'recursive' => 0
					    )
            );
					
            $this->set('examsdoneintheschool',$examsdoneintheschool);
            $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
            $this->set('exams_considered',$examtoenter);
            $this->set('subjects_considered',$subjects);
            $this->set('reportclass',$reportclass);
            $this->set('report_name',$report_name);
            $this->set('report_year',$year);
            $this->set('reportterm',$term);
            $this->set('idsselectedbystudent',$this->request->data['registrationnumbers']);
            $this->set('registrationnumbers1',$registrationnumbers);

            return $this->render('edit');
			    }
			  }
			
			  $test = (($class != null) 
					&& 
				  ($term != null)
					&&
				  (is_array($subjects))
					&&
				  (is_array($examtoenter))
				);
			
			  if($test){
			
			    $this->loadModel('Student');
			    $this->loadModel('Olevelmarksheetresult');
			    $this->loadModel('Olevelreport');

			    $students_in_that_class = $this->Student->find(
            'all',
            array(
				      'fields' => array('Student.id','Student.currentstream'),
				      'conditions' => array(
							  'Student.currentclass =' => $class,
							  'Student.leavingreason' => "None"						    
						  ),
				      'order' => array('Student.currentstream' => 'asc')
			      )
          );
			
			    $madereport = $this->Olevelreportdetail->find(
            'list',
            array(
              'fields' => array('Olevelreportdetail.id', 'Olevelreportdetail.reportname'),
              'conditions' => array(
                'Olevelreportdetail.reportname =' => $reportname,
                'Olevelreportdetail.reportterm =' => $term,
                'Olevelreportdetail.reportyear =' => $year,
                'Olevelreportdetail.reportclass =' => $class,
              )
			      )
          );
			
			    if ( (count($madereport) == 1) && (count($students_in_that_class) > 0) ){
			
            // put all exams meant to be done in a string and separate by <::>
            $examsdone = ""; //The exams chosen for each student
            $number_of_exams_selected = count($examtoenter);
            if (is_array($examtoenter)) {
            
                foreach($examtoenter as $oneexam) {
                  if ( $number_of_exams_selected == 1 ) {
                    $examsdone = $oneexam;
                    break;
                  } else {
                    $examsdone = $oneexam."<::>".$examsdone;
                  }
                }

            }
				    $examsdone = rtrim($examsdone, "<::>");
				
				    //put all subject to be done separated by the <::>
				    $subjectsdone = "";
				    $number_of_subjects_selected = count($subjects);

				    if (is_array($subjects)) {
				      foreach ($subjects as $oneexam) {
					      if ( $number_of_subjects_selected == 1 ) {
					        $subjectsdone = $oneexam;
					        break;
					      } else {
					        $subjectsdone = $oneexam."<::>".$subjectsdone; 
					      }
				      }
				    }
	
				    $subjectsdone = rtrim($subjectsdone, "<::>");
				
            if (($this->request->data['enterspecificstudents'] == "1") &&
              ($this->request->data['registrationnumbers'] != null)
            ) {
                $data = array(
                  'Olevelreportdetail' => array(
                    'reportname' => $reportname,
                  )
                );
            } else {
                $data = array(
                  'Olevelreportdetail' => array(
                    'reportname' => $reportname,
                    'reportterm' => $term,
                    'default_exams_considered' => $examsdone,
                    'default_subjects_considered' => $subjectsdone,
                  )
                );
            }
			    
            $examsdone = null;
            $number_of_exams_selected = null;
            
            $subjectsdone = null;
            $number_of_subjects_selected = null;
            
				    if ( $this->Olevelreportdetail->save($data) ) {
				      $reportdetail_id = $this->Olevelreportdetail->field(
                'id',
                array(
								  'reportname =' => $reportname,
								  'reportterm' => $term,
								  'reportyear' => $year,
								  'reportclass' => $class,
							  )
						  );
			    
              $data = null;
              $number_of_students_reports_to_create = count($students_in_that_class);
              $number_of_student_reports_created = 0;
				    
				      // Update the reports
				      foreach ( $reports_results as $report_result ) {
					      if (
                  ($this->request->data['enterspecificstudents'] == "1")
                   &&
					        (
					          (count($nonexistent_in_system_registration_numbers) == 0)
                     &&
					          (count($nonexistent_in_report_registration_numbers) == 0)
					        )
					          &&
					        ($this->request->data['registrationnumbers'] != null)
					      ) {

					        if (in_array($report_result['Olevelreport']['id'],$report_ids_to_be_edited) != null) {   
						        $this->Olevelreport->id = $report_result['Olevelreport']['id'];
						        $number_of_student_reports_created++;
						        $found_value = 1;
					        } else {
						        continue;
					        }
					      } else {
					        $this->Olevelreport->id = $report_result['Olevelreport']['id'];
					        $number_of_student_reports_created++;
					      }
					
                $data = array('Olevelreport' => array());

                // put all exams meant to be done in a string and separate by <::>
                $examsdone = ""; //The exams chosen for each student
                $number_of_exams_selected = count($examtoenter);
				    
					      foreach ($examtoenter as $oneexam) {
					        if ( $number_of_exams_selected == 1 ) {
						        $examsdone = $oneexam;
						        break;
					        } else {
						        $examsdone = $oneexam."<::>".$examsdone;
					        }
					      }
				    
					      $date = new DateTime();
					
					      foreach ( $subjects as $subject ) {
					        $exams_considered_for_subject = $subject.'_examsconsidered';
					        $data['Olevelreport'][$exams_considered_for_subject] = $examsdone;
					        $date_and_time_report_created = $subject.'_datecreated';
					        $data['Olevelreport'][$date_and_time_report_created] = $date->format('Y-m-d H:i:s');
					      }
				    
					      $this->Olevelreport->save($data);				
			    
				      }
				
				      if (
                ($number_of_student_reports_created == $number_of_students_reports_to_create)
                  ||				
                (
                  ($this->request->data['enterspecificstudents'] == "1")
                    &&
                  (
                    (count($nonexistent_in_system_registration_numbers) == 0)
                    &&
                    (count($nonexistent_in_report_registration_numbers) == 0)
                  )
                    &&
                  ($this->request->data['registrationnumbers'] != null)
                )
				      ) {
				    
                $this->Olevelreport->report_add_examsconsidered($reportdetail_id,null);
                $this->Olevelreport->report_gradesubjects($reportdetail_id,null);
                $this->Olevelreport->report_get_total_mark($reportdetail_id,null);
                $this->Olevelreport->report_getaggregates($reportdetail_id);
                $this->Olevelreport->report_getdivision($reportdetail_id);
                $this->Olevelreport->report_get_position($reportdetail_id, null);
                
                $report_name = $reports['Olevelreportdetail']['reportname'];
                $report_year = $reports['Olevelreportdetail']['reportyear'];
                $reportclass = $reports['Olevelreportdetail']['reportclass'];
                $reportterm = $reports['Olevelreportdetail']['reportterm'];
                
                $this->Session->setFlash(__(
                    'Successfully updated '.$number_of_student_reports_created.' report(s) for '.
                    "Senior ".$reportclass." , ".$report_name." ".$reportterm." , ".$report_year
                  )
                );

                return $this->redirect(array('action' => 'index'));
				      } else {
				
				        $this->Session->setFlash(__('The number of reports created by the system is less than 
								    the number supposed to be created. Please delete the reports
								    just created and repeat the process'
                  )
                );

				        return $this->redirect(array('action' => 'index'));
				      }    
			      } else {
				      $this->Session->setFlash(__('Did not successfully save Olevel report detail'));
			      }
			    } else {
			      if ( count($students_in_that_class) == 0 ) {
				      $this->Session->setFlash(
                __(
                  'There are no students in the class chosen. System not creating report(s)' 
                )
              );
			      } else {
				      if ( $madereport != null ) {
				        $this->Session->setFlash(
                  __(
                    'This report name already exists, please try another report name'
                  )
                );
				      }
			      }
			    }
			  } else {
		
          if ($class == null) {
            $this->Session->setFlash(
              __('Please select a class')
            );
          } else {
            if ($term == null) {

              $this->Session->setFlash(
                __('Please select a term')
              );

            } else {
              if (!is_array($subjects)) {
                $this->Session->setFlash(
                  __('Please select atleast one subject')
                );
              } else {
                if (!is_array($examtoenter)) {
                  $this->Session->setFlash(
                    __('Please select atleast one Examination')
                  );
                } else {
                  if ($year == null) {
                    $this->Session->setFlash(
                      __('Please select a year')
                    );
                  }
                }
              }
            }
          }
			  }
		  }
	  }
	    
	  $examsdoneintheschool = $this->Schooldoneexam->find(
      'list',
      array(
		    'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
		    'recursive' => 0
	    )
    );
    
	  $subjectsdoneintheschool = $this->Schooldonesubject->find(
      'list',
      array(
		    'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
		    'recursive' => 0
	    )
    );
	    
    $this->set('examsdoneintheschool',$examsdoneintheschool);
    $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
    $this->set('exams_considered',$exams_considered);
    $this->set('subjects_considered',$subjects_considered);
    $this->set('reportclass',$reportclass);
    $this->set('report_name',$report_name);
    $this->set('report_year',$report_year);
    $this->set('reportterm',$reportterm);

  }


  public function downloadReports($reportdetail_id = null, $mode = null){
    
	  set_time_limit(0);

	  if (!$reportdetail_id) {
	    throw new NotFoundException(__('Invalid Report'));
	  }
	
	  if (!$mode) {
	    throw new NotFoundException(__('Invalid mode'));
	  }
	
	  $reports = $this->Olevelreportdetail->findById($reportdetail_id);
	
	  if (!$reports) {
	    throw new NotFoundException(__('Invalid Report - report not found'));
	  }

	  // Mode to download the reports
    if ($mode == 3) {
    
      $objPhpExcel  = $this->PhpExcel->createWorksheet()
                  ->setDefaultFont('Calibri', 11);
      $table = array(
        array (
          'label' => __("S".$reports['Olevelreportdetail']['reportclass']. " " .
                    $reports['Olevelreportdetail']['reportname']. " " .
                    $reports['Olevelreportdetail']['reportterm']. " - " .
                    $reports['Olevelreportdetail']['reportyear']. " - ".
                    "Examination Marksheet"
          )
        )
      );
          
      $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

      $this->PhpExcel->addTableFooter();
        
      $objPhpExcel->removeSheetByIndex(0);
        
      $report_exams_considered = explode("<::>",$reports['Olevelreportdetail']['default_exams_considered']);
        
      $report_exams_considered = array_reverse($report_exams_considered);
        
      $report_subjects_considered = explode("<::>",$reports['Olevelreportdetail']['default_subjects_considered']);
        
      sort($report_subjects_considered);
            
      //Start adding next sheets
      $i=0;
      $this->loadModel('Student');
      $this->loadModel('Schoolstream');
      $this->loadModel('Schooldonesubject');
      $this->loadModel('Olevelmarksheetresult');
      $this->loadModel('Classteacher');
      $Gradeprofile = ClassRegistry::init('Gradeprofile');
      $this->loadModel('Schooldoneexam');

      $this->loadModel('Reportsetting');

      // Get all school details
      $settings_report = $this->Reportsetting->findByUniqueSettingName("unique");
      $school_name = null;
      $school_address = null;
      $school_telephone_number = null;
      $headteacher_name = null;
      $dorm_master_name = null;
      $dorm_mistress_name = null;
      $header_o_level_report = null; // o_level_report_header
      $space_top_o_level = null; // o_level_top_space
      $space_left_o_level = null; // o_level_left_space
      $header_o_level_shown = null; // o_level_show_inbuilt_header
      $school_motto = null; // school_motto

      if ($settings_report) {
        $school_name = $settings_report["Reportsetting"]["school_name"];
        $school_address = $settings_report["Reportsetting"]["school_address"];
        $school_telephone_number = $settings_report["Reportsetting"]["school_telephone_number"];
        $headteacher_name = $settings_report["Reportsetting"]["headteacher_name"];
        $dorm_master_name = $settings_report["Reportsetting"]["dorm_master_name"];
        $dorm_mistress_name = $settings_report["Reportsetting"]["dorm_mistress_name"];
        $header_o_level_report = $settings_report["Reportsetting"]["o_level_report_header"];
        $space_top_o_level = $settings_report["Reportsetting"]["o_level_top_space"];
        $space_left_o_level = $settings_report["Reportsetting"]["o_level_left_space"];
        $header_o_level_shown = $settings_report["Reportsetting"]["o_level_show_inbuilt_header"];
        $school_motto = $settings_report["Reportsetting"]["school_motto"];
      }

      $report_exams = $this->Schooldoneexam->find(
        'list',
        array(
          'fields' => array('Schooldoneexam.alias'),
          'order'  => array('Schooldoneexam.reportorder' => 'asc')
        )
      );
        
      $number_of_students_inclass = count($reports['Olevelreport']);
        
      $school_streams  = $this->Schoolstream->find(
        'all',
        array(
          'fields' => array('shortstreamname')
        )
      );
        
      $real_school_streams = array();
        
      //get an array with keys as stream names
      foreach ($school_streams as $astream) {
        $real_school_streams[$astream['Schoolstream']['shortstreamname']] = 0;
      }
        
      //count the number of streams
      $number_of_streams = count($real_school_streams);
        
      // Get the number of students in each stream
      foreach($reports['Olevelreport'] as $report){
        
        if (array_key_exists($report['streamthen'], $real_school_streams)) {
          $real_school_streams[$report['streamthen']] = $real_school_streams[$report['streamthen']] + 1;
        }
        
      }
        
      foreach($reports['Olevelreport'] as $report) {
        $surname  = $this->Student->field(
          'surname',
          array(
            'id' => $report['student_id']
          )
        );
      
        $othernames  = $this->Student->field(
          'othernames',
          array('id' => $report['student_id'])
        );
      
        $student_sex  = $this->Student->field(
          'sex',
          array('id' => $report['student_id'])
        );
      
        $regnumber  = $this->Student->field(
          'registrationnumber',
          array('id' => $report['student_id'])
        );
      
        $student_stream  = $this->Schoolstream->field(
          'stream',
          array('shortstreamname' => $report['streamthen'])
        );
      
        // Get the title of the class teacher
        $classteachertitle = $this->Classteacher->field(
          'title',
          array(
            'class' => $report['classthen'],
            'stream' => $report['streamthen'],
            'year' => $reports['Olevelreportdetail']['reportyear'],
          )
        );
      
        // Get the name of class teacher
        $classteachername = $this->Classteacher->field(
          'names',
          array(
            'class' => $report['classthen'],
            'stream' => $report['streamthen'],
            'year' => $reports['Olevelreportdetail']['reportyear'],
          )
        );
      
        // Add new sheet
        $objWorkSheet = $objPhpExcel->createSheet($i); //Setting index when creating

        $objPhpExcel->setActiveSheetIndex($i);
      
        $objPhpExcel->getActiveSheet()->setTitle($surname." ".$othernames);
        //$objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);
        $objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.25);
        //$objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
        $objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7.0);
        //$objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
        $objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17.00);

        $objPhpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(29);
        $objPhpExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(39.75);

        if ($header_o_level_shown) {
          // School Badge
          $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
          //$objDrawing->setName('Student Image');        //set name to image
          $objDrawing->setDescription('School logo/badge'); //set description to image
          //$signature = $file;    //Path to signature .jpg file
          //$objDrawing->setPath(WWW_ROOT.'/img/studentpics/'.'person.png');
          $objDrawing->setPath(WWW_ROOT.'/img/studentpics/'.'logo2.png');
          //$objDrawing->setImageResource($file);
          $objDrawing->setOffsetX(1);                       //setOffsetX works properly
          $objDrawing->setOffsetY(2);                       //setOffsetY works properly
          $objDrawing->setCoordinates('B1');        //set image to cell
          $objDrawing->setWidth(100);                 //set width, height
          $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());

          // School name
          $objPhpExcel->getActiveSheet()->mergeCells('C1:N1');
          $objPhpExcel->getActiveSheet()->setCellValue(
            'C1',
            (string)$school_name
          );
          $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setSize(25);
          $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle('C1')
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objPhpExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
          $objPhpExcel->getActiveSheet()->mergeCells('C2:N2');
          // School Box address and telephone number
          $school_address_and_phone = (string)$school_address."      TEL:".(string)$school_telephone_number;
          $objPhpExcel->getActiveSheet()->setCellValue(
            'C2',
            $school_address_and_phone
          );
          $objPhpExcel->getActiveSheet()->getStyle('C2')
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $path = WWW_ROOT."img/studentpics/".(string)$report['student_id'].".jpg";
        // attach student picture if it exists
	      if(file_exists($path) == true){
	        $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
          //$objDrawing->setName('Student Image');        //set name to image
          $objDrawing->setDescription('Student Image'); //set description to image
          
          $objDrawing->setPath($path);
          $objDrawing->setOffsetX(1);                       //setOffsetX works properly
          $objDrawing->setOffsetY(20.23);                       //setOffsetY works properly
          $objDrawing->setCoordinates('O1');        //set image to cell
          $objDrawing->setWidth(120);                 //set width, height
          $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());
	      }

        $objPhpExcel->getActiveSheet()->mergeCells('C4:N4');
        // Set the report header
        $objPhpExcel->getActiveSheet()->setCellValue('C4',(string)$header_o_level_report);
        $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setBold(true);
        $objPhpExcel->getActiveSheet()->getStyle('C4')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THICK,
                'color' => array('argb' => 'FFFF0000'),
            ),
          ),
        );			  
          
        //$objPhpExcel->getActiveSheet()->getStyle('D4:M4')->applyFromArray($styleArray);
        $objPhpExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(19);
        $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setSize(16);
      
        // Set the top space and bottom space if shown
        $objPhpExcel->getActiveSheet()
            ->getPageMargins()
            ->setTop(is_null($space_top_o_level)?0.75:$space_top_o_level)
            ->setRight(0.05)
            ->setLeft(is_null($space_left_o_level)?0.05:$space_left_o_level)
            ->setBottom(0.75);
      
        // The Exam name block
        $objPhpExcel->getActiveSheet()->mergeCells('C6:N6');
        $objPhpExcel->getActiveSheet()->setCellValue(
          'C6',
          $reports['Olevelreportdetail']['reportname']." ".
          $reports['Olevelreportdetail']['reportterm']." ".
          "EXAMINATIONS"." - ".
          $reports['Olevelreportdetail']['reportyear']
        );
        $objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
        $objPhpExcel->getActiveSheet()->getStyle("C6")->getFont()->setSize(12);
        $objPhpExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true);
        $objPhpExcel->getActiveSheet()->getStyle('C6')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
        $objPhpExcel->getActiveSheet()->getStyle("C6")
              ->getAlignment()
              ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
        // Set a cell value and wrap the text
        $objPhpExcel->getActiveSheet()->setCellValue('D12',$report_exams_considered[0]." 100%");
        $objPhpExcel->getActiveSheet()->getStyle('D12')
              ->getAlignment()->setWrapText(true); 
      
        $styleArray1 = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );	
      
        // The student details section; ie StdN, Name: , Class:, Sex:
        // Merge the StdN cells
        $objPhpExcel->getActiveSheet()->mergeCells('C7:E7');
        // Merge the Name
        $objPhpExcel->getActiveSheet()->getStyle('C7:E7')->applyFromArray($styleArray1);
        $objPhpExcel->getActiveSheet()->mergeCells('C8:E8');
        // Merge the Sex sex
        //$objPhpExcel->getActiveSheet()->mergeCells('C10:E10');
        $objPhpExcel->getActiveSheet()->setCellValue('B7','RegNo:');
        $objPhpExcel->getActiveSheet()->getStyle("B7")->getFont()->setSize(10);
        $objPhpExcel->getActiveSheet()->getStyle("C7")->getFont()->setSize(10);
        //Set the registrationnumber of the student
        $objPhpExcel->getActiveSheet()->setCellValue('C7',$regnumber);		
        // Align to the left
        $objPhpExcel->getActiveSheet()->getStyle("C7")
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      
        $objPhpExcel->getActiveSheet()->setCellValue('B8','Name:');
        $objPhpExcel->getActiveSheet()->getStyle("B8")->getFont()->setSize(10);
        $objPhpExcel->getActiveSheet()->getStyle("C8")->getFont()->setSize(10);
        //Set the Name of the student
        $objPhpExcel->getActiveSheet()->setCellValue('C8',$surname." ".$othernames);		
        // Align to the left
        $objPhpExcel->getActiveSheet()->getStyle("C8")
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      
        $objPhpExcel->getActiveSheet()->setCellValue('B9','Class:');
        $objPhpExcel->getActiveSheet()->getStyle("B9")->getFont()->setSize(10);
        //$objPhpExcel->getActiveSheet()->getStyle("C9")->getFont()->setSize(10);
        //Set the Class the student was in at the time of the student
        $objPhpExcel->getActiveSheet()->setCellValue('C9',"Senior ".$report['classthen']);		
        // Align to the left
        $objPhpExcel->getActiveSheet()->getStyle("C9")
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
              
        $objPhpExcel->getActiveSheet()->setCellValue('D9','Stream:');
        $objPhpExcel->getActiveSheet()->getStyle("D9")->getFont()->setSize(10);
        $objPhpExcel->getActiveSheet()->getStyle("E9")->getFont()->setSize(10);
        //Set the Stream the student was in at the time of the student
        $objPhpExcel->getActiveSheet()->setCellValue('E9',$student_stream);		
        // Align to the left
        $objPhpExcel->getActiveSheet()->getStyle("E9")
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      
        $objPhpExcel->getActiveSheet()->setCellValue('B10','RptID:');
        $objPhpExcel->getActiveSheet()->getStyle("B10")->getFont()->setSize(10);
        $objPhpExcel->getActiveSheet()->getStyle("C10")->getFont()->setSize(10);
        //Set the Stream the student was in at the time of the student
        $objPhpExcel->getActiveSheet()->setCellValue('C10',$report['id']);
      
        $objPhpExcel->getActiveSheet()->setCellValue('D10','Sex:');
        $objPhpExcel->getActiveSheet()->getStyle("D10")->getFont()->setSize(10);
        $objPhpExcel->getActiveSheet()->getStyle("E10")->getFont()->setSize(10);
        //Set the Stream the student was in at the time of the student
        $objPhpExcel->getActiveSheet()->setCellValue('E10',$student_sex);		
        // Align to the left
        $objPhpExcel->getActiveSheet()->getStyle("C10")
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );			  
          
        $objPhpExcel->getActiveSheet()->getStyle('B7:C10')->applyFromArray($styleArray);
        $objPhpExcel->getActiveSheet()->getStyle('C8:E8')->applyFromArray($styleArray);
        $objPhpExcel->getActiveSheet()->getStyle('C9')->applyFromArray($styleArray);
        $objPhpExcel->getActiveSheet()->getStyle('D9')->applyFromArray($styleArray);
        $objPhpExcel->getActiveSheet()->getStyle('E9')->applyFromArray($styleArray);
        $objPhpExcel->getActiveSheet()->getStyle('C10:E10')->applyFromArray($styleArray);
      
        //$objPhpExcel->getActiveSheet()->getStyle('B12:O26')->applyFromArray($styleArray);
      
        //get either the class position or Aggregates and division
        if (($reports['Olevelreportdetail']['reportclass'] == 1)
            ||
          ($reports['Olevelreportdetail']['reportclass'] == 2)
        ) {
      
          $objPhpExcel->getActiveSheet()->setCellValue('K10','Class position is '.$report['classposition'].' out of '.$number_of_students_inclass);
          $objPhpExcel->getActiveSheet()->setCellValue('K8','Aggregate is '.$report['besteightaggregates'].' and Division is '.$report['division']);
          $objPhpExcel->getActiveSheet()->setCellValue('K9','Stream Position is '.$report['streamposition'].' out of '.$real_school_streams[$report['streamthen']]);
          
        } else {
      
          $objPhpExcel->getActiveSheet()->setCellValue('K8','Aggregate is '.$report['besteightaggregates'].' and Division is '.$report['division']);
      
        }
      
        // define table cells
        // create an array that will be used to push "", CODE , and subject to
        // the report
        $table = array(
              "",
              'CODE',
              'SUBJECT'
        );
      
        $number_of_exams_counter = 0;
      
        // add the exams considered to the table array that will be used to add 
        // to the report
        foreach($report_exams as $anexamination){
          array_push($table,$anexamination);
          $number_of_exams_counter++;
        }
      
        //add AVG MK, grade, remarks and initials to the report 
        $AGRI = array("AVG MK","GRADE","REMARKS","INITIALS");
      
        foreach ($AGRI as $agri) {
          array_push($table,$agri);
        }
      
        // portion of code below may not be so vital
        $objPhpExcel->getActiveSheet()->getStyle('A'.(3+$number_of_exams_counter).':'.'A'.(7+$number_of_exams_counter))
              ->getAlignment()->setWrapText(true);
        //portion of code above may not be so vital
        $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'A12');
      
        // counter tells one where to start adding the inividual subjects for the student together
        // with the marks and average
        $insert_counter = 13;
      
        // if the number of subjects initially considered is more than 1, go ahead and 
        // create the subjects and their marks
        $report_number_of_subjects = 0;
        if (count($report_subjects_considered) > 1) {

          foreach ($report_subjects_considered as $asubject) {
            $report_number_of_subjects++;

            $full_subject_name  = $this->Schooldonesubject->field(
              'fullsubjectname',
              array('shortsubjectname' => $asubject)
            );
          
            $subject_code = $this->Schooldonesubject->field(
              'subjectcode',
              array('shortsubjectname' => $asubject)
            );
          
            $table = array();
          
            array_push($table,$subject_code,$full_subject_name);
          
            foreach ($report_exams as $anexamination) {
          
              $amark = $this->Olevelmarksheetresult->field(
                $asubject,
                array(
                  'exam_name' => $anexamination,
                  'year' => $reports['Olevelreportdetail']['reportyear'],
                  'student_id' => $report['student_id']
                )
              );

              array_push($table,$amark);

            }
          
            $grade_to_be_put = "";
          
            switch ($report[$asubject."_grade"]) {
              
              case 1:
                $grade_to_be_put = "D1";
                break;
              case 2:
                $grade_to_be_put = "D2";
                break;
              case 3:
                $grade_to_be_put = "C3";
                break;
              case 4:
                $grade_to_be_put = "C4";
                break;
              case 5:
                $grade_to_be_put = "C5";
                break;
              case 6:
                $grade_to_be_put = "C6";
                break;
              case 7:
                $grade_to_be_put = "P7";
                break;
              case 8:
                $grade_to_be_put = "P8";
                break;
              case 9:
                $grade_to_be_put = "F9";
                break;
              case 10:
                $grade_to_be_put = "X";
                break;		    

            }
          
            array_push(
              $table,$report[$asubject],
              $grade_to_be_put,
              $Gradeprofile->gradeprofile_returnsubjectremark(
                $reports['Olevelreportdetail']['reportclass'],
                $report[$asubject]
              )
            );
            //$objPhpExcel->getActiveSheet()->getRowDimension(13)->setRowHeight(-1);
            $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'B'.$insert_counter++);
      
          }
        }
      
        // Put boarders around the report data
        $objPhpExcel->getActiveSheet()->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).$insert_counter)
          ->applyFromArray($styleArray);
          
        //Make the heading where the code, subject and exam names are bold
        $objPhpExcel->getActiveSheet()
          ->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1)."12")
          ->getFont()->setBold(true);
      
        //set the total mark 
        $objPhpExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter,"Total:");
        $objPhpExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)+1).$insert_counter,$report['totalmark']);

        // set the total mark contents to bold
        $objPhpExcel->getActiveSheet()
            ->getStyle(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter.":".PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)+1).$insert_counter)
            ->getFont()->setBold(true);
            
        // set the total mark cell alignment to Right
        $objPhpExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      
        //Wrap the text for the subjects names
        $objPhpExcel->getActiveSheet()->getStyle('C13'.':'.'C'.($insert_counter-1))
              ->getAlignment()->setWrapText(true);
      
        // Set the grading scheme
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+1),"Grading scheme:");
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+1))->getFont()->setUnderline(true);
      
        //Award the grading schemes
        $report_class = (int)$reports['Olevelreportdetail']['reportclass'];
        $grading_scheme = $Gradeprofile->get_grading_scheme($report_class);
        // $this->Session->setFlash(__(print_r($grading_scheme)));
        for ($counter_grading_scheme=0; $counter_grading_scheme < count($grading_scheme); $counter_grading_scheme++) {
            $objPhpExcel->getActiveSheet()
                ->setCellValue(
                  'B'.($insert_counter+2+$counter_grading_scheme),
                  $grading_scheme[$counter_grading_scheme]
                );
        }

        //Apply boarders to the grading section
      
        $style_outside_boarder = array(
          'borders' => array(
            'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+1).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+4))
          ->applyFromArray($style_outside_boarder);
      
        // Generate the Head teacher section
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+6),"Head Teacher:");
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+6))->getFont()->setUnderline(true);
        //Merge the cells containing the name
        $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+7).':'.'C'.($insert_counter+7));
        //Name of the Head teacher
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+7), $headteacher_name);
        //Align the Name to the center
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
              ->getAlignment()
              ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))->getFont()->setSize(12);
        //Wrap the contents of the cell
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
          ->getAlignment()->setWrapText(true);				
        //The Head teacher comment section
        $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+6),"Head Teacher's comment");
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+6))->getFont()->setUnderline(true);
      
        // merge the cells where the Head teacher's comments are meant to be
        $objPhpExcel->getActiveSheet()->mergeCells('D'.($insert_counter+7).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+7));
      
        // Get the comment for the Head teacher and put on the report
        $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+7),$report['headteacherscomment']);

      
        // Set the row hieght of the Head teachers name and the Head teachers comment to auto fit
        $objPhpExcel->getActiveSheet()->getRowDimension(($insert_counter+7))->setRowHeight(80);
        // set the alignment for the cell with the comment to top left
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))
              ->getAlignment()
              ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))->getFont()->setSize(12);
        //Wrap the contents of the cell with comment
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))
              ->getAlignment()->setWrapText(true); 
      
        // put boarders around the Head teacher area

        //one half
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+6).':'."C".($insert_counter+7))
          ->applyFromArray($style_outside_boarder);
      
        //One half
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+6).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+7))
          ->applyFromArray($style_outside_boarder);		
      
        // Generate the Class teacher section
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+9),"Class Teacher:");
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+9))->getFont()->setUnderline(true);
        //Merge the cells containing the name
        $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+10).':'.'C'.($insert_counter+10));
        //Wrap the contents of the cell
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
          ->getAlignment()->setWrapText(true);
        //Name of the class teacher
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+10),$classteachertitle." ".$classteachername);
        //Align the Name to the center
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
              ->getAlignment()
              ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))->getFont()->setSize(12);
        //The class teacher comment section
        $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+9),"Class Teacher's comment");
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+9))->getFont()->setUnderline(true);
      
        // merge the cells where the class teacher's comments are meant to be
        $objPhpExcel->getActiveSheet()->mergeCells('D'.($insert_counter+10).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+10));
      
        // Get the comment for the class teacher and put on the report
        $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+10),$report['classteacherscomment']);
      
        // Set the row hieght of the Class teachers name and the Class teachers comment to auto fit
        $objPhpExcel->getActiveSheet()->getRowDimension(($insert_counter+10))->setRowHeight(80);
        // set the alignment for the cell with the comment to top left
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))
              ->getAlignment()
              ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))->getFont()->setSize(12);
        //Wrap the contents of the cell with comment
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))
              ->getAlignment()->setWrapText(true); 
      
        // put boarders around the class teacher area
      
        //one half
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+9).':'."C".($insert_counter+10))
          ->applyFromArray($style_outside_boarder);
      
        //One half
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+9).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+10))
          ->applyFromArray($style_outside_boarder);
      
        // Generate the House master/mistresses section
        if($student_sex == "F"){
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+12),"House Mistress:");
        }else{
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+12),"House Master:");
        }
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+12))->getFont()->setUnderline(true);
        //Merge the cells containing the name
        $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+13).':'.'C'.($insert_counter+13));

        //Wrap the contents of the cell
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
          ->getAlignment()->setWrapText(true);

        //Name of the House master / House mistress		
        if ($student_sex == "F") {
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+13), $dorm_mistress_name);
        } else  {
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+13), $dorm_master_name);
        }
        //Align the Name to the center
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))->getFont()->setSize(12);
        //The House mistress/House master comment section
        if ($student_sex == "F") {

            $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+12),"House Mistress's comment");
        
        } else {

            $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+12),"House Master's comment");
        
        }
      
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+12))->getFont()->setUnderline(true);
        
        // merge the cells where the Wardens comments are meant to be
        $objPhpExcel->getActiveSheet()->mergeCells('D'.($insert_counter+13).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+13));
        
        // Get the comment for the Warden and put on the report
        if ($student_sex == "M") {
        
            $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+13),$report['dormmasterscomment']);
        
        } else {
        
            $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+13),$report['dormmistresscomment']);
        
        }
        // Set the row hieght of the Wardens comment and name to auto fit
        $objPhpExcel->getActiveSheet()->getRowDimension(($insert_counter+13))->setRowHeight(80);
        // set the alignment for the cell with the comment to top left
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))->getFont()->setSize(12);
        //Wrap the contents of the cell with comment
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))
                ->getAlignment()->setWrapText(true); 
        // put boarders around the Wardens area
        
        //one half
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+12).':'."C".($insert_counter+13))
            ->applyFromArray($style_outside_boarder);
        
        //One half
        $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+12).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+13))
            ->applyFromArray($style_outside_boarder);
        
        //Add the school logo to the end of the report and center align it
        $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+15).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+15));
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+15),$school_motto);
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+15))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
        //Auto resize the remarks section to fit certain remarks
        $objPhpExcel->getActiveSheet()
              ->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 2))->setAutoSize(true);
        
        // Change the font size of each of the subject names to ten
        $subject_name_number = 0;
      
        while ($subject_name_number <= $report_number_of_subjects) {
        
            $objPhpExcel->getActiveSheet()->getStyle("C13:"."C".$insert_counter)->getFont()->setSize(10);
            $subject_name_number++;
        }
      
        // Set the document to fit strictly on one page 
        $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);

        $i++;
      }
        
      $objPhpExcel->output(
        "S".$reports['Olevelreportdetail']['reportclass']. " " .
        $reports['Olevelreportdetail']['reportname']. " " .
        $reports['Olevelreportdetail']['reportterm']. " - " .
        $reports['Olevelreportdetail']['reportyear']. " - ".
        'Report'.'.xlsx','Excel2007'
      );
    }
	
    // Mode for creating marksheet with all the results	
    if($mode == 1){

      $this->loadModel('Schooldonesubject');
      $this->loadModel('Student');
      $subjectsdoneinolevel = $this->Schooldonesubject->find(
        'all',
        array(
          'fields' => array('Schooldonesubject.fullsubjectname','Schooldonesubject.shortsubjectname'),
          'order' => array('Schooldonesubject.shortsubjectname' => 'asc')
        )
      );

      $objPhpExcel  = $this->PhpExcel->createWorksheet()
                ->setDefaultFont('Calibri', 11);
      
      $table = array(
          array(
            'label' => __(
              "S".$reports['Olevelreportdetail']['reportclass']. " " .
              $reports['Olevelreportdetail']['reportname']. " " .
              $reports['Olevelreportdetail']['reportterm']. " - " .
              $reports['Olevelreportdetail']['reportyear']. " - ".
              "Examination Marksheet"
            )
          )
      );
        
      $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

      // merge particular cells
      $objPhpExcel->getActiveSheet()->mergeCells('A1:E1');

      // change the cell alignment
      $objPhpExcel->getActiveSheet()->getStyle('A1:E1')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      // change the text wrapping to false
      $objPhpExcel->getActiveSheet()->getStyle('A1:E1')
            ->getAlignment()
            ->setWrapText(true);

      // increase row height for the first row 
      $objPhpExcel->getActiveSheet()->getRowDimension(1)
            ->setRowHeight(30);
            
            
      // define table cells
      $table = array(
          array('label' => __('No.'), 'filter' => false),
          array('label' => __('Picture.')),
          array('label' => __('Registration Number'), 'filter' => false,),
          array('label' => __('Student Name'), 'filter' => false),
          array('label' => __('Stream'))
      );
      
      foreach($subjectsdoneinolevel as $olevel_subject){
      
        array_push($table,array('label' => __($olevel_subject['Schooldonesubject']['shortsubjectname'])));
        array_push($table,array('label' => __('G')));
    
      }
      
      if (
          ($reports['Olevelreportdetail']['reportclass'] == 1)
            || 
          ($reports['Olevelreportdetail']['reportclass'] == 2)
      ) {

        array_push($table, array('label' => __('Total')));
        array_push($table, array('label' => __('Strm Posn')));
        array_push($table, array('label' => __('Class Posn')));
    
      } else {

        array_push($table, array('label' => __('Agg')));
        array_push($table, array('label' => __('Div')));
      
      }

      // add heading with different font and bold text
      $this->PhpExcel
        ->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

      // The number of students to be used as a counter
      $numberofstudent = 1;
      
      $this->loadModel('Student');
      $file1 = $this->Student->field(
        'studentpicture',
        array('id =' => 651)
      );

            
      //row counter
      $row_counter = 3;
      
      $row_picture_counter = 3;
      foreach ($reports['Olevelreport'] as $report) {

        // increase row height for the row currently in
        $objPhpExcel->getActiveSheet()->getRowDimension($row_picture_counter++)
                    ->setRowHeight(32);
        $studentregistrationnumber  = $this->Student->field(
          'registrationnumber',
          array('id' => $report['student_id'])
        );
    
        $file = $this->Student->field(
          'studentpicture',
          array('id =' => $report['student_id'])
        );
        if ($file != null) {
          // Create file in the studentpics folder with a 0777 attribute
          $file1 = new File(WWW_ROOT.'img/studentpics/'.$report['student_id'].'.jpg', true, 0777);
          // Write a given number of bytes to the file.
          // The bytes will be got from the database
          $file1->write($file,'w',false);
          $file1->close();
          $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
          $objDrawing->setName('Student Image');        //set name to image
          $objDrawing->setDescription('Customer Signature'); //set description to image
          //$signature = $file;    //Path to signature .jpg file
          $objDrawing->setPath(WWW_ROOT.'img/studentpics/'.$report['student_id'].'.jpg');
          //$objDrawing->setImageResource($file);
          $objDrawing->setOffsetX(1);                       //setOffsetX works properly
          $objDrawing->setOffsetY(2);                       //setOffsetY works properly
          $objDrawing->setCoordinates('B'.($row_counter));        //set image to cell
          //$objDrawing->setWidth(33);                 //set width, height
          $objDrawing->setHeight(37);
          $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());
        }
    
        $row_counter++;
    
        $studentfullnames  = $this->Student->field(
          'fullnames',
          array('id' => $report['student_id'])
        );
    
        $row_to_add = array(
          $numberofstudent++,
          "",
          $studentregistrationnumber,		
          $studentfullnames,
          $report['streamthen']
        );
    
        foreach($subjectsdoneinolevel as $olevel_subject){

          array_push($row_to_add,$report[$olevel_subject['Schooldonesubject']['shortsubjectname']]);
          $grade = $report[$olevel_subject['Schooldonesubject']['shortsubjectname']."_grade"];

          if  ($grade == 10) {
            array_push($row_to_add,"X");
          } else {
            array_push($row_to_add,$report[$olevel_subject['Schooldonesubject']['shortsubjectname']."_grade"]);
          }    
        }
    
        if(($reports['Olevelreportdetail']['reportclass'] == 1) || 
            ($reports['Olevelreportdetail']['reportclass'] == 2)
        ){
        
            array_push($row_to_add, $report['totalmark']); // total
            array_push($row_to_add, $report['streamposition']);  // stream position
            array_push($row_to_add, $report['classposition']); // class position
        
        } else {
          
            array_push($row_to_add, $report['besteightaggregates']); // aggregates
            array_push($row_to_add, $report['division']); // division
          
        }
    
        $this->PhpExcel->addTableRow($row_to_add);
      }
      
      // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
      $styleArray = array(
          'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            //'color' => array('argb' => 'FFFF0000'),
          ),
          ),
      );	
      
      //$objPhpExcel->getActiveSheet()->getCellByColumnAndRow(4,4)->getStyle()->applyFromArray($styleArray);
      $this->PhpExcel->addTableFooter();
      $objPhpExcel->output("S".$reports['Olevelreportdetail']['reportclass']." - ".
              $reports['Olevelreportdetail']['reportname']. " " .
              $reports['Olevelreportdetail']['reportterm']. " - " .
              $reports['Olevelreportdetail']['reportyear']. " - ".
              "Examination Marksheet".
              '.xlsx','Excel2007');

    }
	
	  // Mode for creating the summary of results
    if($mode == 2){
    
      $this->loadModel('Schooldonesubject');
      $this->loadModel('Student');
      $subjectsdoneinolevel = $this->Schooldonesubject->find(
        'all',
        array(
          'fields' => array('Schooldonesubject.fullsubjectname','Schooldonesubject.shortsubjectname'),
          'order' => array('Schooldonesubject.shortsubjectname' => 'asc')
        )
      );

      $objPhpExcel  = $this->PhpExcel->createWorksheet()
                ->setDefaultFont('Calibri', 11);
      
      $table = array(
        array('label' => __("S".$reports['Olevelreportdetail']['reportclass']. " " .
              $reports['Olevelreportdetail']['reportname']. " " .
              $reports['Olevelreportdetail']['reportterm']. " - " .
              $reports['Olevelreportdetail']['reportyear']. " - ".
              "Results Summary (By numbers)"
        ))
      );
          
      $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

      // merge particular cells
      $objPhpExcel->getActiveSheet()->mergeCells('A1:L1');

      // change the cell alignment
      $objPhpExcel->getActiveSheet()->getStyle('A1:L1')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      // change the text wrapping to false
      $objPhpExcel->getActiveSheet()->getStyle('A1:L1')
            ->getAlignment()
            ->setWrapText(true);

      // increase row height for the first row 
      $objPhpExcel->getActiveSheet()->getRowDimension(1)
            ->setRowHeight(30);
                    
      // define table cells
      $table = array(
            array('label' => __('Subject Name'), 'filter' => false),
            array('label' => __('D1'), 'filter' => false,),
            array('label' => __('D2'), 'filter' => false),
            array('label' => __('C3')),
            array('label' => __('C4')),
            array('label' => __('C5')),
            array('label' => __('C6')),
            array('label' => __('P7')),
            array('label' => __('P8')),
            array('label' => __('F9')),
            array('label' => __('X')),
            array('label' => __('Total')),
      );
        
      // add heading with different font and bold text
      $this->PhpExcel
      ->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

      // The number of students to be used as a counter
      $numberofstudent = 1;
      
      $number_of_subjects = 2;
        
      foreach ($subjectsdoneinolevel as $olevel_subject) {
        $number_of_subjects++;
        $d1s = null;
        $d1s = array();
        
        $d2s = null;
        $d2s = array();
        
        $c3s = null;
        $c3s = array();
        
        $c4s = null;
        $c4s = array();
        
        $c5s = null;
        $c5s = array();
        
        $c6s = null;
        $c6s = array();
        
        $p7s = null;
        $p7s = array();
        
        $p8s = null;
        $p8s = array();
        
        $f9s = null;
        $f9s = array();
        
        $notdone = null;
        $notdone = array();
        
        foreach($reports['Olevelreport'] as $report){
          
          $grade = intval(($report[$olevel_subject['Schooldonesubject']['shortsubjectname']."_grade"]));
          
          switch ($grade){
            case 1:
              array_push($d1s,1);
              break;
            case 2:
              array_push($d2s,2);
              break;
            case 3:
              array_push($c3s,3);
              break;
            case 4:
              array_push($c4s,4);
              break;
            case 5:
              array_push($c5s,5);
              break;
            case 6:
              array_push($c6s,6);
              break;
            case 7:
              array_push($p7s,7);
              break;
            case 8:
              array_push($p8s,8);
              break;
            case 9:
              array_push($f9s,9);
              break;
            case 10:
              array_push($notdone,10);
              break;
          }
      
        }
      
        $row_to_add = null;
        $row_to_add = array(
            $olevel_subject['Schooldonesubject']['fullsubjectname'],
            count($d1s),
            count($d2s),
            count($c3s),
            count($c4s),
            count($c5s),
            count($c6s),
            count($p7s),
            count($p8s),
            count($f9s),
            count($notdone),
            (count($d1s)+count($d2s)+count($c3s)+count($c4s)+
            count($c5s)+count($c6s)+count($p7s)+count($p8s)+
            count($f9s)+count($notdone))
        );
      
        $this->PhpExcel->addTableRow($row_to_add);
      }

      $table = null;
      $table = array(
        array(
          'label' => __(
            "S".$reports['Olevelreportdetail']['reportclass']. " " .
            $reports['Olevelreportdetail']['reportname']. " " .
            $reports['Olevelreportdetail']['reportterm']. " - " .
            $reports['Olevelreportdetail']['reportyear']. " - ".
            "Results Summary (By Percentages)"
          )
        )
      );
            
      $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

      // merge particular cells
      $objPhpExcel->getActiveSheet()->mergeCells('A'.($number_of_subjects + 1).':L'.($number_of_subjects + 1));

      // change the cell alignment
      $objPhpExcel->getActiveSheet()->getStyle('A'.($number_of_subjects + 1).':L'.($number_of_subjects + 1))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      // change the text wrapping to false
      $objPhpExcel->getActiveSheet()->getStyle('A'.($number_of_subjects + 1).':L'.($number_of_subjects + 1))
            ->getAlignment()
            ->setWrapText(true);

      // increase row height for the first row 
      $objPhpExcel->getActiveSheet()->getRowDimension(1)
            ->setRowHeight(30);
              
              
      // define table cells
      $table = array(
        array('label' => __('Subject Name'), 'filter' => false),
        array('label' => __('D1'), 'filter' => false,),
        array('label' => __('D2'), 'filter' => false),
        array('label' => __('C3')),
        array('label' => __('C4')),
        array('label' => __('C5')),
        array('label' => __('C6')),
        array('label' => __('P7')),
        array('label' => __('P8')),
        array('label' => __('F9')),
        array('label' => __('X')),
      );

      // add heading with different font and bold text
      $this->PhpExcel
        ->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
    
      // The number of students to be used as a counter
      $numberofstudent = 1;
      $number_of_subjects = $number_of_subjects + 2;
      foreach ($subjectsdoneinolevel as $olevel_subject) {
        $number_of_subjects++;
        $d1s = null;
        $d1s = array();
        
        $d2s = null;
        $d2s = array();
        
        $c3s = null;
        $c3s = array();
        
        $c4s = null;
        $c4s = array();
        
        $c5s = null;
        $c5s = array();
        
        $c6s = null;
        $c6s = array();
        
        $p7s = null;
        $p7s = array();
        
        $p8s = null;
        $p8s = array();
        
        $f9s = null;
        $f9s = array();
        
        $notdone = null;
        $notdone = array();
        
        foreach ($reports['Olevelreport'] as $report) {
            
          $grade = intval(($report[$olevel_subject['Schooldonesubject']['shortsubjectname']."_grade"]));
            
          switch ($grade){
            case 1:
              array_push($d1s,1);
              break;
            case 2:
              array_push($d2s,2);
              break;
            case 3:
              array_push($c3s,3);
              break;
            case 4:
              array_push($c4s,4);
              break;
            case 5:
              array_push($c5s,5);
              break;
            case 6:
              array_push($c6s,6);
              break;
            case 7:
              array_push($p7s,7);
              break;
            case 8:
              array_push($p8s,8);
              break;
            case 9:
              array_push($f9s,9);
              break;
            case 10:
              array_push($notdone,10);
              break;
          }
        }
      
        $row_to_add = null;
        $total_number_of_students = (count($d1s)+count($d2s)+count($c3s)+count($c4s)+
            count($c5s)+count($c6s)+count($p7s)+count($p8s)+
            count($f9s)+count($notdone));
        
        $percentages_to_be_created = array();
        
        array_push($percentages_to_be_created,$d1s,$d2s,$c3s,$c4s,$c5s,$c6s,$p7s,$p8s,$f9s,$notdone);
        
        $row_to_add = array($olevel_subject['Schooldonesubject']['fullsubjectname']);
        
        foreach ($percentages_to_be_created as $percentage) {
        
          if (count($percentage) != 0) {
            $apercentage = (count($percentage)/$total_number_of_students)*100;
            array_push($row_to_add,sprintf("%01.1f",$apercentage));
          } else {   
            array_push($row_to_add,0);
          }
        }
      
        $this->PhpExcel->addTableRow($row_to_add);
      }	

      $table = null;
      $table = array(
        array(
          'label' => __(
            "S".$reports['Olevelreportdetail']['reportclass']. " " .
            $reports['Olevelreportdetail']['reportname']. " " .
            $reports['Olevelreportdetail']['reportterm']. " - " .
            $reports['Olevelreportdetail']['reportyear']. " - ".
            "Results Summary (By Division)"
            )
        )
      );
          
      $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
    
      // merge particular cells
      $objPhpExcel->getActiveSheet()->mergeCells('A'.($number_of_subjects + 1).':L'.($number_of_subjects + 1));

      // change the cell alignment
      $objPhpExcel->getActiveSheet()->getStyle('A'.($number_of_subjects + 1).':L'.($number_of_subjects + 1))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      // change the text wrapping to false
      $objPhpExcel->getActiveSheet()->getStyle('A'.($number_of_subjects + 1).':L'.($number_of_subjects + 1))
            ->getAlignment()
            ->setWrapText(true);

      // increase row height for the first row 
      $objPhpExcel->getActiveSheet()->getRowDimension(1)
            ->setRowHeight(30);
              
              
      // define table cells
      $table = array(
            array('label' => __('Division'), 'filter' => false),
            array('label' => __('I'), 'filter' => false,),
            array('label' => __('II'), 'filter' => false),
            array('label' => __('III')),
            array('label' => __('IV')),
            array('label' => __('VII')),
            array('label' => __('U')),
            array('label' => __('X')),
            array('label' => __('Total')),
      );
        
      $div1 = 0;
      $div2 = 0;
      $div3 = 0;
      $div4 = 0;
      $div7 = 0;
      $divU = 0;
      $divX = 0;
      $total_number_of_students_for_division = 0;
        
      foreach ($reports['Olevelreport'] as $report) {
        
        $grade = $report["division"];
        
        switch ($grade) {
          case "I":
            $div1 = $div1 + 1;
            $total_number_of_students_for_division++;
            break;
          case "II":
            $div2 = $div2 + 1;
            $total_number_of_students_for_division++;
            break;
          case "III":
            $div3 = $div3 + 1;
            $total_number_of_students_for_division++;
            break;
          case "IV":
            $div4 = $div4 + 1;
            $total_number_of_students_for_division++;
            break;
          case "VII":
            $div7 = $div7 + 1;
            $total_number_of_students_for_division++;
            break;
          case "U":
            $divU = $divU + 1;
            $total_number_of_students_for_division++;
            break;
          case "X":
            $divX = $divX + 1;
            $total_number_of_students_for_division++;
            break;		
        }
        
      }
        
      // add heading with different font and bold text
      $this->PhpExcel
        ->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
    
      // The number of students to be used as a counter
      $numberofstudent = 1;
    
      $row_to_add = null;
      $row_to_add = array();
      array_push(
        $row_to_add,
        "Number of Students",
        $div1,
        $div2,
        $div3,
        $div4,
        $div7,
        $divU,
        $divX,
        $total_number_of_students_for_division
      );
        
      $this->PhpExcel->addTableRow($row_to_add);

      $styleArray = array(
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
          ),
        ),
      );	
        
      $this->PhpExcel->addTableFooter();
      $objPhpExcel->output("S".$reports['Olevelreportdetail']['reportclass']." - ".
              $reports['Olevelreportdetail']['reportname']. " " .
              $reports['Olevelreportdetail']['reportterm']. " - " .
              $reports['Olevelreportdetail']['reportyear']. " - ".
              "Result summaries".
              '.xlsx','Excel2007');
    }
  }


    
    public function comment($reportdetail_id = null, $mode = null)  {
    
    	set_time_limit(0);
    	
    	$this->loadModel('Schoolstream');
    	$this->loadModel('Classteacher');
    	
    	$this->layout = 'default2';
    	
	    if(!$reportdetail_id){
	
	      throw new NotFoundException(__('Invalid Report'));
	
	    }
	
	    if(!$mode){
	
	      throw new NotFoundException(__('Invalid mode'));
	
	    }
	
	    $reports = $this->Olevelreportdetail->findById($reportdetail_id);
	
	    if (!$reports){
	      throw new NotFoundException(__('Invalid Report - report not found'));
	    }
	
	    $classteachermode = null;
	    $stream = null;
	
	    if(($mode == 1) || (!empty($this->request->data)) || ($mode == 3) || ($mode == 4)){
	
        if(!empty($this->request->data) && (($mode == 2))){
    
            if($this->request->is('post')){
                $streamchosenbyclassteacher = $this->request->data['term'];
                $classteachermode = 1;
            }
    
        }

        $this->loadModel('Reportsetting');

        // Get all school details
        $settings_report = $this->Reportsetting->findByUniqueSettingName("unique");
        $school_name = null;
        $school_address = null;
        $school_telephone_number = null;
        $headteacher_name = null;
        $dorm_master_name = null;
        $dorm_mistress_name = null;
        $header_o_level_report = null; // o_level_report_header
        $space_top_o_level = null; // o_level_top_space
        $space_left_o_level = null; // o_level_left_space
        $header_o_level_shown = null; // o_level_show_inbuilt_header
        $school_motto = null; // school_motto
  
        if ($settings_report) {
          $school_name = $settings_report["Reportsetting"]["school_name"];
          $school_address = $settings_report["Reportsetting"]["school_address"];
          $school_telephone_number = $settings_report["Reportsetting"]["school_telephone_number"];
          $headteacher_name = $settings_report["Reportsetting"]["headteacher_name"];
          $dorm_master_name = $settings_report["Reportsetting"]["dorm_master_name"];
          $dorm_mistress_name = $settings_report["Reportsetting"]["dorm_mistress_name"];
          $header_o_level_report = $settings_report["Reportsetting"]["o_level_report_header"];
          $space_top_o_level = $settings_report["Reportsetting"]["o_level_top_space"];
          $space_left_o_level = $settings_report["Reportsetting"]["o_level_left_space"];
          $header_o_level_shown = $settings_report["Reportsetting"]["o_level_show_inbuilt_header"];
          $school_motto = $settings_report["Reportsetting"]["school_motto"];
        }
    
        $objPhpExcel  = $this->PhpExcel->createWorksheet()
            ->setDefaultFont('Calibri', 11);
        $table = array(
            array('label' => __("S".$reports['Olevelreportdetail']['reportclass']. " " .
              $reports['Olevelreportdetail']['reportname']. " " .
              $reports['Olevelreportdetail']['reportterm']. " - " .
              $reports['Olevelreportdetail']['reportyear']. " - ".
              "Examination Marksheet"
            ))
        );
      
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

        $this->PhpExcel->addTableFooter();
        
        $objPhpExcel->removeSheetByIndex(0);
        
        $report_exams_considered = explode("<::>",$reports['Olevelreportdetail']['default_exams_considered']);
        
        $report_exams_considered = array_reverse($report_exams_considered);
        
        $report_subjects_considered = explode("<::>",$reports['Olevelreportdetail']['default_subjects_considered']);
        
        sort($report_subjects_considered);

        //Start adding next sheets
        $i=0;
        $this->loadModel('Student');
        //$this->loadModel('Schoolstream');
        $this->loadModel('Schooldonesubject');
        $this->loadModel('Olevelmarksheetresult');
        $Gradeprofile = ClassRegistry::init('Gradeprofile');
        $this->loadModel('Schooldoneexam');
        //$this->Schooldoneexam->find($reportdetail_id);

        $report_exams = $this->Schooldoneexam->find(
          'list', array(
            'fields' => array('Schooldoneexam.alias'),
            'order'  => array('Schooldoneexam.reportorder' => 'asc')
          )
        );
	    
	      $number_of_students_inclass = count($reports['Olevelreport']);
	    
        $school_streams  = $this->Schoolstream->find('all',array(
          'fields' => array('shortstreamname')
        ));
	    
  	    $real_school_streams = array();
	    
        //get an array with keys as stream names
        foreach($school_streams as $astream){
          $real_school_streams[$astream['Schoolstream']['shortstreamname']] = 0; 
        }
	    
        //count the number of streams
        $number_of_streams = count($real_school_streams);
	    
	    
        // Get the number of students in each stream
        foreach($reports['Olevelreport'] as $report){
        
          if(array_key_exists($report['streamthen'], $real_school_streams)){
          
            $real_school_streams[$report['streamthen']] = $real_school_streams[$report['streamthen']] + 1;
          
          }
        
        }
	    
        foreach($reports['Olevelreport'] as $report) {

          $surname  = $this->Student->field(
            'surname',
            array('id' => $report['student_id'])
          );
          
          $othernames  = $this->Student->field(
            'othernames',
            array('id' => $report['student_id'])
          );
          
          $student_sex  = $this->Student->field(
            'sex',
            array('id' => $report['student_id'])
          );
          
          $regnumber  = $this->Student->field(
            'registrationnumber',
            array('id' => $report['student_id'])
          );
          
          $student_stream  = $this->Schoolstream->field(
            'stream',
            array('shortstreamname' => $report['streamthen'])
          );
      
          if(($mode == 3) || ($mode == 4)){
      
            // Choose the males only
            if(($mode == 3) && ($student_sex == "F")){
              continue;
            }
          
            // Choose the females only
            if(($mode == 4) && ($student_sex == "M")){
              continue;
            }
          }
      
          //Extract only that class teacher's students 
          if($classteachermode == 1){
            if($student_stream != $streamchosenbyclassteacher){
              continue;
            }
          }
      
          // Get the title of the class teacher
          $classteachertitle = $this->Classteacher->field(
            'title',
            array(
              'class' => $report['classthen'],
              'stream' => $report['streamthen'],
              'year' => $reports['Olevelreportdetail']['reportyear'],
            )
          );
      
          // Get the name of class teacher
          $classteachername = $this->Classteacher->field(
            'names',
            array(
              'class' => $report['classthen'],
              'stream' => $report['streamthen'],
              'year' => $reports['Olevelreportdetail']['reportyear'],
            )
          );
      
          // Add new sheet
          $objWorkSheet = $objPhpExcel->createSheet($i); //Setting index when creating
      
          // // School Badge
          // $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
          // //$objDrawing->setName('Student Image');        //set name to image
          // $objDrawing->setDescription('School logo/badge'); //set description to image
          // //$signature = $file;    //Path to signature .jpg file
          // //$objDrawing->setPath(WWW_ROOT.'/img/studentpics/'.'person.png');
          // $objDrawing->setPath(WWW_ROOT.'/img/studentpics/'.'logo2.png');
          // //$objDrawing->setImageResource($file);
          // $objDrawing->setOffsetX(1);                       //setOffsetX works properly
          // $objDrawing->setOffsetY(2);                       //setOffsetY works properly
          // $objDrawing->setCoordinates('B1');        //set image to cell
          // $objDrawing->setWidth(100);                 //set width, height
          //$objDrawing->setHeight(50);
      
      
          $objPhpExcel->setActiveSheetIndex($i);
          
          $objPhpExcel->getActiveSheet()->setTitle($surname." ".$othernames);
          //$objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);
          $objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.25);
          //$objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
          $objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7.0);
          //$objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
          $objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17.00);

          $objPhpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(29);
          $objPhpExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(39.75);

          if ($header_o_level_shown) {
            // School Badge
            $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            //$objDrawing->setName('Student Image');        //set name to image
            $objDrawing->setDescription('School logo/badge'); //set description to image
            //$signature = $file;    //Path to signature .jpg file
            //$objDrawing->setPath(WWW_ROOT.'/img/studentpics/'.'person.png');
            $objDrawing->setPath(WWW_ROOT.'/img/studentpics/'.'logo2.png');
            //$objDrawing->setImageResource($file);
            $objDrawing->setOffsetX(1);                       //setOffsetX works properly
            $objDrawing->setOffsetY(2);                       //setOffsetY works properly
            $objDrawing->setCoordinates('B1');        //set image to cell
            $objDrawing->setWidth(100);                 //set width, height
            $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());
  
            // School name
            $objPhpExcel->getActiveSheet()->mergeCells('C1:N1');
            $objPhpExcel->getActiveSheet()->setCellValue(
              'C1',
              (string)$school_name
            );
            $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setSize(25);
            $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
            $objPhpExcel->getActiveSheet()->getStyle('C1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPhpExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
            $objPhpExcel->getActiveSheet()->mergeCells('C2:N2');
            // School Box address and telephone number
            $school_address_and_phone = (string)$school_address."      TEL:".(string)$school_telephone_number;
            $objPhpExcel->getActiveSheet()->setCellValue(
              'C2',
              $school_address_and_phone
            );
            $objPhpExcel->getActiveSheet()->getStyle('C2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          }
  
          $path = WWW_ROOT."img/studentpics/".(string)$report['student_id'].".jpg";
          // attach student picture if it exists
          if(file_exists($path) == true){
            $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            //$objDrawing->setName('Student Image');        //set name to image
            $objDrawing->setDescription('Student Image'); //set description to image
            
            $objDrawing->setPath($path);
            $objDrawing->setOffsetX(1);                       //setOffsetX works properly
            $objDrawing->setOffsetY(20.23);                       //setOffsetY works properly
            $objDrawing->setCoordinates('O1');        //set image to cell
            $objDrawing->setWidth(120);                 //set width, height
            $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());
          }
  
          $objPhpExcel->getActiveSheet()->mergeCells('C4:N4');
          // Set the report header
          $objPhpExcel->getActiveSheet()->setCellValue('C4',(string)$header_o_level_report);
          $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle('C4')
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
          $styleArray = array(
            'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THICK,
                  'color' => array('argb' => 'FFFF0000'),
              ),
            ),
          );			  
            
          //$objPhpExcel->getActiveSheet()->getStyle('D4:M4')->applyFromArray($styleArray);
          $objPhpExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(19);
          $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setSize(16);
        
          // Set the top space and bottom space if shown
          $objPhpExcel->getActiveSheet()
              ->getPageMargins()
              ->setTop(is_null($space_top_o_level)?0.75:$space_top_o_level)
              ->setRight(0.05)
              ->setLeft(is_null($space_left_o_level)?0.05:$space_left_o_level)
              ->setBottom(0.75);
          
          // The Exam name block
          $objPhpExcel->getActiveSheet()->mergeCells('C6:N6');
          $objPhpExcel->getActiveSheet()->setCellValue('C6',
                $reports['Olevelreportdetail']['reportname']." ".
                $reports['Olevelreportdetail']['reportterm']." ".
                "EXAMINATIONS"." - ".
                $reports['Olevelreportdetail']['reportyear']
                );
          $objPhpExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
          $objPhpExcel->getActiveSheet()->getStyle("C6")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle('C6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          
          $objPhpExcel->getActiveSheet()->getStyle("C6")
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          
          // Set a cell value and wrap the text
          $objPhpExcel->getActiveSheet()->setCellValue('D12',$report_exams_considered[0]." 100%");
          $objPhpExcel->getActiveSheet()->getStyle('D12')
                  ->getAlignment()->setWrapText(true); 
          
          $styleArray1 = array(
                  'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    //'color' => array('argb' => 'FFFF0000'),
                ),
                  ),
          );	
          
          // The student details section; ie StdN, Name: , Class:, Sex:
          // Merge the StdN cells
          $objPhpExcel->getActiveSheet()->mergeCells('C7:E7');
          // Merge the Name
          $objPhpExcel->getActiveSheet()->getStyle('C7:E7')->applyFromArray($styleArray1);
          $objPhpExcel->getActiveSheet()->mergeCells('C8:E8');
          // Merge the Sex sex
          //$objPhpExcel->getActiveSheet()->mergeCells('C10:E10');
          $objPhpExcel->getActiveSheet()->setCellValue('B7','RegNo:');
          $objPhpExcel->getActiveSheet()->getStyle("B7")->getFont()->setSize(10);
          $objPhpExcel->getActiveSheet()->getStyle("C7")->getFont()->setSize(10);
          //Set the registrationnumber of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C7',$regnumber);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("C7")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          
          
          $objPhpExcel->getActiveSheet()->setCellValue('B8','Name:');
          $objPhpExcel->getActiveSheet()->getStyle("B8")->getFont()->setSize(10);
          $objPhpExcel->getActiveSheet()->getStyle("C8")->getFont()->setSize(10);
          //Set the Name of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C8',$surname." ".$othernames);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("C8")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          
          $objPhpExcel->getActiveSheet()->setCellValue('B9','Class:');
          $objPhpExcel->getActiveSheet()->getStyle("B9")->getFont()->setSize(10);
          //$objPhpExcel->getActiveSheet()->getStyle("C9")->getFont()->setSize(10);
          //Set the Class the student was in at the time of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C9',"Senior ".$report['classthen']);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("C9")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                  
          $objPhpExcel->getActiveSheet()->setCellValue('D9','Stream:');
          $objPhpExcel->getActiveSheet()->getStyle("D9")->getFont()->setSize(10);
          $objPhpExcel->getActiveSheet()->getStyle("E9")->getFont()->setSize(10);
          //Set the Stream the student was in at the time of the student
          $objPhpExcel->getActiveSheet()->setCellValue('E9',$student_stream);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("E9")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          
          
          $objPhpExcel->getActiveSheet()->setCellValue('B10','RptID:');
          $objPhpExcel->getActiveSheet()->getStyle("B10")->getFont()->setSize(10);
          $objPhpExcel->getActiveSheet()->getStyle("C10")->getFont()->setSize(10);
          //Set the Stream the student was in at the time of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C10',$report['id']);
          
          $objPhpExcel->getActiveSheet()->setCellValue('D10','Sex:');
          $objPhpExcel->getActiveSheet()->getStyle("D10")->getFont()->setSize(10);
          $objPhpExcel->getActiveSheet()->getStyle("E10")->getFont()->setSize(10);
          //Set the Stream the student was in at the time of the student
          $objPhpExcel->getActiveSheet()->setCellValue('E10',$student_sex);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("C10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          
          $styleArray = array(
                  'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    //'color' => array('argb' => 'FFFF0000'),
                ),
                  ),
          );			  
              
          $objPhpExcel->getActiveSheet()->getStyle('B7:C10')->applyFromArray($styleArray);
          $objPhpExcel->getActiveSheet()->getStyle('C8:E8')->applyFromArray($styleArray);
          $objPhpExcel->getActiveSheet()->getStyle('C9')->applyFromArray($styleArray);
          $objPhpExcel->getActiveSheet()->getStyle('D9')->applyFromArray($styleArray);
          $objPhpExcel->getActiveSheet()->getStyle('E9')->applyFromArray($styleArray);
          $objPhpExcel->getActiveSheet()->getStyle('C10:E10')->applyFromArray($styleArray);
      
          //get either the class position or Aggregates and division
          if(($reports['Olevelreportdetail']['reportclass'] == 1)
                ||
            ($reports['Olevelreportdetail']['reportclass'] == 2)
          ){
          
              $objPhpExcel->getActiveSheet()->setCellValue('K10','Class position is '.$report['classposition'].' out of '.$number_of_students_inclass);
              $objPhpExcel->getActiveSheet()->setCellValue('K8','Aggregate is '.$report['besteightaggregates'].' and Division is '.$report['division']);
              $objPhpExcel->getActiveSheet()->setCellValue('K9','Stream Position is '.$report['streamposition'].' out of '.$real_school_streams[$report['streamthen']]);
              
          }else{
          
              $objPhpExcel->getActiveSheet()->setCellValue('K8','Aggregate is '.$report['besteightaggregates'].' and Division is '.$report['division']);
          
          }
          
          // define table cells
          // create an array that will be used to push "", CODE , and subject to
          // the report
          $table = array(
                  "",
                  'CODE',
                  'SUBJECT'
          );
          
          $number_of_exams_counter = 0;
      
          // add the exams considered to the table array that will be used to add 
          // to the report
          foreach($report_exams as $anexamination){
          
              array_push($table,$anexamination);
              $number_of_exams_counter++;
          
          }
      
          //add AVG MK, grade, remarks and initials to the report 
          $AGRI = array("AVG MK","GRADE","REMARKS","INITIALS");
          
          foreach($AGRI as $agri){
          
              array_push($table,$agri);
          
          }
          
          // portion of code below may not be so vital
          $objPhpExcel->getActiveSheet()->getStyle('A'.(3+$number_of_exams_counter).':'.'A'.(7+$number_of_exams_counter))
                  ->getAlignment()->setWrapText(true);
          //portion of code above may not be so vital
          $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'A12');
          
          
          // counter tells one where to start adding the inividual subjects for the student together
          // with the marks and average
          $insert_counter = 13;
          
          // if the number of subjects initially considered is more than 1, go ahead and 
          // create the subjects and their marks
          $report_number_of_subjects = 0;
          if (count($report_subjects_considered) > 1) {
          
            foreach ($report_subjects_considered as $asubject) {
            
              $report_number_of_subjects++;
            
              $full_subject_name  = $this->Schooldonesubject->field(
                'fullsubjectname',
                array('shortsubjectname' => $asubject)
              );
              
              $subject_code = $this->Schooldonesubject->field(
                'subjectcode',
                array('shortsubjectname' => $asubject)
              );
              
              $table = array();
              
              array_push($table,$subject_code,$full_subject_name);
              
              foreach ($report_exams as $anexamination) {
              
                $amark = $this->Olevelmarksheetresult->field(
                  $asubject,
                  array(
                    'exam_name' => $anexamination,
                    'year' => $reports['Olevelreportdetail']['reportyear'],
                    'student_id' => $report['student_id']
                  )
                );
            
                array_push($table,$amark);
              
              }
              
              $grade_to_be_put = "";
              
              switch($report[$asubject."_grade"]){
                
                case 1:
                  $grade_to_be_put = "D1";
                  break;
                case 2:
                  $grade_to_be_put = "D2";
                  break;
                case 3:
                  $grade_to_be_put = "C3";
                  break;
                case 4:
                  $grade_to_be_put = "C4";
                  break;
                case 5:
                  $grade_to_be_put = "C5";
                  break;
                case 6:
                  $grade_to_be_put = "C6";
                  break;
                case 7:
                  $grade_to_be_put = "P7";
                  break;
                case 8:
                  $grade_to_be_put = "P8";
                  break;
                case 9:
                  $grade_to_be_put = "F9";
                  break;
                case 10:
                  $grade_to_be_put = "X";
                  break;		    

              }
              
              array_push(
                $table,
                $report[$asubject],
                $grade_to_be_put,
                $Gradeprofile->gradeprofile_returnsubjectremark(
                  $reports['Olevelreportdetail']['reportclass'],
                  $report[$asubject]
                )
              );

              $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'B'.$insert_counter++);
          
            }
          }
      
          // Put boarders around the report data
          $objPhpExcel->getActiveSheet()->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).$insert_counter)
              ->applyFromArray($styleArray);
              
          //Make the heading where the code, subject and exam names are bold
          $objPhpExcel->getActiveSheet()
              ->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1)."12")
              ->getFont()->setBold(true);
          
          //set the total mark 
          $objPhpExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter,"Total:");
          $objPhpExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)+1).$insert_counter,$report['totalmark']);
          
          // set the total mark contents to bold
          $objPhpExcel->getActiveSheet()
              ->getStyle(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter.":".PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)+1).$insert_counter)
              ->getFont()->setBold(true);
              
          // set the total mark cell alignment to Right
          $objPhpExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter)
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

          //Wrap the text for the total mark cell
          $objPhpExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+2)).$insert_counter)
            ->getAlignment()->setWrapText(true);
          
          // Set the grading scheme
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+1),"Grading scheme:");
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+1))->getFont()->setUnderline(true);
        
          //Award the grading schemes
          $report_class = (int)$reports['Olevelreportdetail']['reportclass'];
          $grading_scheme = $Gradeprofile->get_grading_scheme($report_class);
          // $this->Session->setFlash(__(print_r($grading_scheme)));
          for ($counter_grading_scheme=0; $counter_grading_scheme < count($grading_scheme); $counter_grading_scheme++) {
              $objPhpExcel->getActiveSheet()
                  ->setCellValue(
                    'B'.($insert_counter+2+$counter_grading_scheme),
                    $grading_scheme[$counter_grading_scheme]
                  );
          }

          //Apply boarders to the grading section
        
          $style_outside_boarder = array(
            'borders' => array(
              'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+1).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+4))
            ->applyFromArray($style_outside_boarder);
          
          // Generate the Head teacher section
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+6),"Head Teacher:");
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+6))->getFont()->setUnderline(true);
          //Merge the cells containing the name
          $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+7).':'.'C'.($insert_counter+7));
          //Name of the Head teacher
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+7), $headteacher_name);
          //Align the Name to the center
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          //Set the comment font size to 12
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))->getFont()->setSize(12);
          //Wrap the contents of the cell
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
            ->getAlignment()->setWrapText(true);				
          //The Head teacher comment section
          $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+6),"Head Teacher's comment");
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+6))->getFont()->setUnderline(true);
          
          // merge the cells where the Head teacher's comments are meant to be
          $objPhpExcel->getActiveSheet()->mergeCells('D'.($insert_counter+7).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+7));
          
          // The headteacher's actual comment
          $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+7),$report['headteacherscomment']);
          
          // Set the row hieght of the Head teachers name and the Head teachers comment to auto fit
          $objPhpExcel->getActiveSheet()->getRowDimension(($insert_counter+7))->setRowHeight(80);
          // set the alignment for the cell with the comment to top left
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
          //Set the comment font size to 12
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))->getFont()->setSize(12);
          //Wrap the contents of the cell with comment
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))
                  ->getAlignment()->setWrapText(true); 
          
          // put boarders around the Head teacher area
          
          //one half
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+6).':'."C".($insert_counter+7))
              ->applyFromArray($style_outside_boarder);
          
          //One half
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+6).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+7))
              ->applyFromArray($style_outside_boarder);		
          
          // Generate the Class teacher section
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+9),"Class Teacher:");
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+9))->getFont()->setUnderline(true);
          //Merge the cells containing the name
          $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+10).':'.'C'.($insert_counter+10));
          //Name of the class teacher
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+10),$classteachertitle." ".$classteachername);
          //Align the Name to the center
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          //Wrap the contents of the cell
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
            ->getAlignment()->setWrapText(true);
          //Set the comment font size to 12
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))->getFont()->setSize(12);
          //The class teacher comment section
          $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+9),"Class Teacher's comment");
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+9))->getFont()->setUnderline(true);
          
          // merge the cells where the class teacher's comments are meant to be
          $objPhpExcel->getActiveSheet()->mergeCells('D'.($insert_counter+10).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+10));
          
          // The class teacher's actual comment
          $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+10),$report['classteacherscomment']);

          
          // Set the row hieght of the Class teachers name and the Class teachers comment to auto fit
          $objPhpExcel->getActiveSheet()->getRowDimension(($insert_counter+10))->setRowHeight(80);
          // set the alignment for the cell with the comment to top left
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
          //Set the comment font size to 12
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))->getFont()->setSize(12);
          //Wrap the contents of the cell with comment
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))
                  ->getAlignment()->setWrapText(true); 
          
          // put boarders around the class teacher area
          
          //one half
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+9).':'."C".($insert_counter+10))
              ->applyFromArray($style_outside_boarder);
          
          //One half
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+9).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+10))
              ->applyFromArray($style_outside_boarder);
      
          // Generate the House master/mistresses section
          if($student_sex == "F"){
              $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+12),"House Mistress:");
          }else{
              $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+12),"House Master:");
          }

          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+12))->getFont()->setUnderline(true);
          //Merge the cells containing the name
          $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+13).':'.'C'.($insert_counter+13));
          //Name of the House master / House mistress		
          if ($student_sex == "F") {
            $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+13), $dorm_mistress_name);
          } else  {
            $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+13), $dorm_master_name);
          }
          //Wrap the contents of the cell
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
            ->getAlignment()->setWrapText(true);
          //Align the Name to the center
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          //Set the comment font size to 12
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))->getFont()->setSize(12);
          //The House mistress/House master comment section
          if($student_sex == "F"){
              $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+12),"House Mistress's comment");
          }else{
              $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+12),"House Master's comment");
          }
      
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+12))->getFont()->setUnderline(true);
          
          // merge the cells where the Wardens comments are meant to be
          $objPhpExcel->getActiveSheet()->mergeCells('D'.($insert_counter+13).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+13));
          
          // Get the comment for the Warden and put on the report
          if($student_sex == "M"){
          
              $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+13),$report['dormmasterscomment']);
          
          }else{
          
              $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+13),$report['dormmistresscomment']);
          
          }
      
          // Set the row hieght of the Wardens comment and name to auto fit
          $objPhpExcel->getActiveSheet()->getRowDimension(($insert_counter+13))->setRowHeight(80);
          // set the alignment for the cell with the comment to top left
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
          //Set the comment font size to 12
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))->getFont()->setSize(12);
          //Wrap the contents of the cell with comment
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))
                  ->getAlignment()->setWrapText(true); 
      
          // put boarders around the Wardens area
          
          //one half
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+12).':'."C".($insert_counter+13))
              ->applyFromArray($style_outside_boarder);
          
          //One half
          $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+12).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+13))
              ->applyFromArray($style_outside_boarder);
      
          //Add the school Moto to the end of the report and center align it
          $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+15).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+15));
          $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+15),$school_motto);
          $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+15))
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      
          //Auto resize the remarks section to fit certain remarks
          $objPhpExcel->getActiveSheet()
                ->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 2))->setAutoSize(true);
          
          // Change the font size of each of the subject names to ten
          $subject_name_number = 0;
          
          while($subject_name_number <= $report_number_of_subjects){
          
              $objPhpExcel->getActiveSheet()->getStyle("C13:"."C".$insert_counter)->getFont()->setSize(10);
              $subject_name_number++;
          }
      
          // Set the document to fit strictly on one page 
          $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
          $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
          $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
          
          // $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());
          
          //get the Head teacher section and in cell B11, change the mode to H
          if($mode == "1"){
          
              $objPhpExcel->getActiveSheet()->setCellValue("B11","H");
              $objPhpExcel->getActiveSheet()->setCellValue("C11",'D'.($insert_counter+7));
          
          }
      
          //get the Class teacher section and in cell B11, change the mode to C
          if($classteachermode == 1){
          
              $objPhpExcel->getActiveSheet()->setCellValue("B11","C");
              $objPhpExcel->getActiveSheet()->setCellValue("C11",'D'.($insert_counter+10));
          
          }
      
          //get the warden section and in cell B11, change the mode to W
          if($mode == "3"){
          
              $objPhpExcel->getActiveSheet()->setCellValue("B11","W");
              $objPhpExcel->getActiveSheet()->setCellValue("C11",'D'.($insert_counter+13));
          
          }
      
          //get the matron section and in cell B11, change the mode to M
          if($mode == "4"){
          
              $objPhpExcel->getActiveSheet()->setCellValue("B11","M");
              $objPhpExcel->getActiveSheet()->setCellValue("C11",'D'.($insert_counter+13));
          
          }
      
          // Start protecting the worksheet
          //unprotect the head teacher section if mode is 1
          if($mode == "1"){
          
              $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))
                ->getProtection()
                ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                
          }
      
          //unprotect the class teacher section if class teacher mode is 1
          if($classteachermode == "1"){
          
              $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+10))
                ->getProtection()
                ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                
          }

          //Unprotect the Warden or matron section if mode is 3 or 4
          if(($mode == "3") || ($mode == "4")){
          
              $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+13))
                ->getProtection()
                ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                
          }
      
          // Hash the combination of Report ID, cell B11 and cell C11
          // Put the Hash in cell D11
          
          Security::setHash('blowfish');
          
          $objPhpExcel->getActiveSheet()->setCellValue('D11',Security::hash(
              $objPhpExcel->getActiveSheet()->getCell('B11')->getValue().
              $objPhpExcel->getActiveSheet()->getCell('C11')->getValue().
              $objPhpExcel->getActiveSheet()->getCell('C10')->getValue().
              $objPhpExcel->getActiveSheet()->getCell('E10')->getValue()
          ));

          $WhitecorstyleArray = array(
                'font'  => array(
              //'bold' => true,
              //'color' => array('rgb' => 'FF0000'),
              'color' => array('rgb' => 'FFFFFF'),
              //'size'  => 15,
              // 'name' => 'Verdana'
                )
          );
      
          // Change the color of the contents of the Cell B11 to white
          $objPhpExcel->getActiveSheet()->getStyle('B11')->applyFromArray($WhitecorstyleArray);
          
          // Change the color of the contents of the Cell C11 to white
          $objPhpExcel->getActiveSheet()->getStyle('C11')->applyFromArray($WhitecorstyleArray);
          
          // Change the color of the contents of the Cell D11 to white
          $objPhpExcel->getActiveSheet()->getStyle('D11')->applyFromArray($WhitecorstyleArray);

      
          if(($mode == "3") || ($mode == "4")){
                $objPhpExcel->getActiveSheet()
                  ->setSelectedCell(
                'D'.($insert_counter+13)
              );
          }
      
          if(($mode == "1")){
          
              $objPhpExcel->getActiveSheet()
                  ->setSelectedCell(
                'D'.($insert_counter+7)
              );
          
          }
          // Protect the sheet
          $objPhpExcel->getActiveSheet()->getProtection()->setSheet(true);
          
          $objPhpExcel->getActiveSheet()->getProtection()->setInsertRows(true);
          $objPhpExcel->getActiveSheet()->getProtection()->setInsertColumns(true);

          $i++;

        }
	    
        if($mode == "1"){
          $objPhpExcel->output("S".$reports['Olevelreportdetail']['reportclass']. " " .
                    $reports['Olevelreportdetail']['reportname']. " " .
                    $reports['Olevelreportdetail']['reportterm']. " - " .
                    $reports['Olevelreportdetail']['reportyear']. " - ".
                    'Report'." - " .'Head Teacher Comment file'.'.xlsx','Excel2007');
        }
	    
	    
        if($mode == "2"){
          $objPhpExcel->output("S".$reports['Olevelreportdetail']['reportclass']." ".$streamchosenbyclassteacher. " - " .
                    $reports['Olevelreportdetail']['reportname']. " " .
                    $reports['Olevelreportdetail']['reportterm']. " - " .
                    $reports['Olevelreportdetail']['reportyear']. " - ".
                    'Report'." - " .'Class Teacher Comment file'.'.xlsx','Excel2007');    
        }
	    
        if($mode == "3"){
          $objPhpExcel->output("S".$reports['Olevelreportdetail']['reportclass']. " " .
                    $reports['Olevelreportdetail']['reportname']. " " .
                    $reports['Olevelreportdetail']['reportterm']. " - " .
                    $reports['Olevelreportdetail']['reportyear']. " - ".
                    'Report'." - " .'Warden Comment file'.'.xlsx','Excel2007');    
        }
	    
        if($mode == "4"){
          $objPhpExcel->output("S".$reports['Olevelreportdetail']['reportclass']. " " .
                    $reports['Olevelreportdetail']['reportname']. " " .
                    $reports['Olevelreportdetail']['reportterm']. " - " .
                    $reports['Olevelreportdetail']['reportyear']. " - ".
                    'Report'." - " .'Matron Comment file'.'.xlsx','Excel2007');    
        }
	    }

      $student_streams  = $this->Schoolstream->find(
        'list',
        array(
          'fields' => array('stream','stream'),
          'conditions' => array('Schoolstream.stream !=' => null)
        )
      );
	
	    $this->set('student_streams',$student_streams);
	
	    $commentfile = $reports['Olevelreportdetail']['reportclass']. " " .
						      $reports['Olevelreportdetail']['reportname']. " " .
						      $reports['Olevelreportdetail']['reportterm']. " - " .
						      $reports['Olevelreportdetail']['reportyear'];
	    $this->set('commentfile',$commentfile);
    
    }

    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function delete($id = null) {
      $this->layout = 'default2';
      $this->Olevelreportdetail->id = $id;
      //$shortsubjectnametobedeleted = $shortsubjectname;
      if (!$this->Olevelreportdetail->exists()) {
        throw new NotFoundException(__('Invalid Report'));
      }
		
      $this->loadModel("Olevelreport");

      $numberofcomments = $this->Olevelreport->find(
        'count', array(
		    //'fields' => array(''),
          'conditions' => array(
            'olevelreportdetail_id' => $id,
            "OR" => array(
                "headteacherscomment !=" => null,
                "classteacherscomment !=" => null,
                "dormmasterscomment !=" => null,
                "dormmistresscomment !=" => null,
                "headteacherscomment !=" => "",
                "classteacherscomment !=" => "",
                "dormmasterscomment !=" => "",
                "dormmistresscomment !=" => "",
            )
          ),
		    )
      );
		
	    if  ($numberofcomments>0) {
		    $this->Session->setFlash(__('This report cannot be deleted because it contains some comments'));
		  } else {
		    if ($this->Olevelreportdetail->delete()) {
			    $this->Session->setFlash(__('All the details for the selected report have been deleted.'));
		    } else {
			    $this->Session->setFlash(__('The report details could not be deleted. Please, try again.'));
		    }
		  }
		
		  return $this->redirect(array('action' => 'index'));
    }
    
    public function updateReports($report_id,$update_flag = null){
		set_time_limit(0);
		$this->layout = 'default2';
		$this->Olevelreportdetail->id = $report_id;
		//$shortsubjectnametobedeleted = $shortsubjectname;
		if (!$this->Olevelreportdetail->exists()) {
			throw new NotFoundException(__('Invalid Report'));
		}
		
		if($update_flag == "1"){
		
		    $this->Olevelreportdetail->updateReport($report_id,1);
		    
		}
		
		if($update_flag == "2"){
		
		    
		
		}
		
		$this->Session->setFlash(__('All the details for the selected report have been updated.'));
		return $this->redirect(array('action' => 'index'));
    
    }
    
    public function upLoadData(){
        
      set_time_limit(0);
  
      $this->layout = 'default2';
      Controller::disableCache();

      if ($this->request->is('Post')) {
        $condition1 = ($this->request->data['uploadedfile']['error'] == 0);
        $condition2 = ($this->request->data['uploadedfile']['type'] == 
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        );
        $condition4 = ($this->request->data['uploadData'] == "olevelstudentreports");
  
        if($condition1 != true){
          $this->Session->setFlash(__("There was an error during the upload, Please try again"));
        }
  
        if  ($condition2 != true){
          $this->Session->setFlash(__("Please select an Excel 2007 file"));
        }
  
        if  ($this->request->data['uploadedfile']['size'] == 0) {
          $this->Session->setFlash(__("Please choose an Excel 2007 file to upload"));
        }

	      if  ($condition1 && $condition2 && $condition4) {
	    
		      $file = $this->request->data['uploadedfile']['tmp_name'];
	    
		      //load the worksheet from a file
		      //Read spreadsheeet workbook
		      try {
		        $objPhpExcel = $this->PhpExcel->loadWorksheet($file);
		      } catch(Exception $e) {
		        die($e->getMessage());
		        $this->Session->setFlash(__("An error occurred during file loading"));
		      }
		
		      $avaluethathasbeenhacked = null;
		
		      Security::setHash('blowfish');

		      $this->loadModel("Olevelreport");
		      //Check if all the cells have been hashed according to how you wanted initially
		      foreach ($objPhpExcel->getWorksheetIterator() as $worksheetNbr => $worksheet) {
		        //echo 'Worksheet number - ', $worksheetNbr, PHP_EOL;

		        //$division = $worksheet->getCell('C3');
            $cellsthatwerehashed = $worksheet->getCell('B11')->getValue().
                $worksheet->getCell('C11')->getValue().
                $worksheet->getCell('C10')->getValue().
                $worksheet->getCell('E10')->getValue();
		    
            $hashedmatch = (
              Security::hash(
                $cellsthatwerehashed,
                'blowfish',
                $worksheet->getCell('D11')->getValue()
              ) === $worksheet->getCell('D11')->getValue());

            if  ($hashedmatch != true)  {
			        $avaluethathasbeenhacked = 2;
			        break;
		        }
		      }
		
          if  ($avaluethathasbeenhacked == 2) {
              $this->Session->setFlash(__("Invalid file supplied. Please upload correctfile"));
          } else {
            // Start the processing of the file and putting the comments into the individual 
            // reports
            foreach ($objPhpExcel->getWorksheetIterator() as $worksheetNbr => $worksheet) {
              //echo 'Worksheet number - ', $worksheetNbr, PHP_EOL;
			        //$division = $worksheet->getCell('C3');
              $who_is_commenting = $worksheet->getCell('B11')->getValue();
              $were_2_extract_cmmnt_from = $worksheet->getCell('C11')->getValue();
              $the_rptid_2_pt_de_cmmnt_on = $worksheet->getCell('C10')->getValue();
              $the_sex_of_student = $worksheet->getCell('E10')->getValue();
              $thecomment = $worksheet->getCell($were_2_extract_cmmnt_from)->getValue();
              
			        if($who_is_commenting == "H"){
			
                $data = array(
                  'Olevelreport' => array(
                    'id' => $the_rptid_2_pt_de_cmmnt_on,
                    'headteacherscomment' => $thecomment				    
                  )
                );
			    
			          $this->Olevelreport->save($data);
			
			        }
			
			        if  ($who_is_commenting == "C") {
			
                $data = array(
                  'Olevelreport' => array(
                    'id' => $the_rptid_2_pt_de_cmmnt_on,
                    'classteacherscomment' => $thecomment				    
                  )
                );
			    
			          $this->Olevelreport->save($data);
			
			        }
			
			        if  ($who_is_commenting == "W") {
                $data = array(
                  'Olevelreport' => array(
                    'id' => $the_rptid_2_pt_de_cmmnt_on,
                    'dormmasterscomment' => $thecomment				    
                  )
                );
			    
			          $this->Olevelreport->save($data);	
			        }
			
			        if  ($who_is_commenting == "M") {
			
                $data = array(
                  'Olevelreport' => array(
                    'id' => $the_rptid_2_pt_de_cmmnt_on,
                    'dormmistresscomment' => $thecomment				    
                  )
                );
			    
			          $this->Olevelreport->save($data);
			        }

		        }
		    
		        $this->Session->setFlash(__("Commenting Successfull"));

		      }
	      }
	    }
	
	    $this->render('up_load_data');
    }

    public function createcolumn($columnname){
    
      $this->layout = 'default2';
      // load the model with the data
      $new = ClassRegistry::init('Olevelmarksheetresult');

      // perform a query using the model you loaded
      $livequery = $new->query("DESCRIBE olevelmarksheetresults;");
    }
}
