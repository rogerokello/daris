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
class AlevelreportdetailsController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session','PhpExcel.PhpExcel');
   

    public function index() {
	    $this->layout = 'default2';

      $this->Paginator->settings = array(
        'Alevelreportdetail' => array (
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
	      return $this->redirect(
          array(
	          '?' => array(
	            'q' => $this->request->data('Alevelreportdetail.searchQuery')
	          )
	        )
        );
      }

      $this->Alevelreportdetail->recursive = 0;
      $searchQuery = $this->request->query('q');
      $this->Paginator->settings = array(
	      'Alevelreportdetail' => array(
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
      $this->loadModel('Schooldoneasubject');

	    if (!empty($this->request->data)) {
		
		    if ($this->request->is('post')) {
			
			    $this->request->data['reportname'] = strtoupper(trim($this->request->data['reportname']));
			    $reportname = $this->request->data['reportname'];
			    $class = $this->request->data['class'];
			    $term = $this->request->data['term'];
			    // $subjects = $this->request->data['subject']; // This is an array
			    $examtoenter = $this->request->data['examtoenter']; // This is an array
			    $year = $this->request->data['year'];
			
          $test = (
              ($class != null) 
              && 
              ($term != null)
              // &&
              // (is_array($subjects))
              &&
              (is_array($examtoenter))
          );
			
			    if  ($test) {
			
			      $this->loadModel('Student');
			      $this->loadModel('Alevelmarksheetresult');
			      $this->loadModel('Alevelreport');

			      $students_in_that_class = $this->Student->find(
              'all',
              array(
				        'fields' => array(
                  'Student.id','Student.currentstream'
                ),
				        'conditions' => array(
							    'Student.currentclass =' => $class,
							    'Student.leavingreason' => "None"						    
							  ),
				        'order' => array('Student.currentstream' => 'asc')
				        //'recursive' => 0
			        )
            );
			
			      $madereport = $this->Alevelreportdetail->find(
              'list', array(
				        'fields' => array('Alevelreportdetail.id', 'Alevelreportdetail.reportname'),
				        'conditions' => array(
				          'Alevelreportdetail.reportname =' => $reportname,
				          'Alevelreportdetail.reportterm =' => $term,
				          'Alevelreportdetail.reportyear =' => $year,
				          'Alevelreportdetail.reportclass =' => $class,
				        )
			        )
            );
			
			      if ( ($madereport == null) && (count($students_in_that_class) > 0) ) {
			
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
				
              $data = array(
                'Alevelreportdetail' => array(
                  'reportname' => $reportname,
                  'reportterm' => $term,
                  'reportyear' => $year,
                  'reportclass' => $class,
                  'default_exams_considered' => $examsdone,
                )
              );
			    
				      $examsdone = null;
				      $number_of_exams_selected = null;
				
				      $subjectsdone = null;
				      $number_of_subjects_selected = null;
				
				      if ( $this->Alevelreportdetail->save($data) ) {
                $SchoolDoneASubject = $this->Schooldoneasubject->find(
                  'all',
                  array(
                    'fields' => array(
                      'Schooldoneasubject.shortsubjectname',
                      'Schooldoneasubject.papersdone',
                      'Schooldoneasubject.issubsidiary'
                    ),
                    'conditions' => array(
                      "NOT" => array('Schooldoneasubject.shortsubjectname' => null)
                    ),
                  //'recursive' => 0
                  )
                );
                $reportdetail_id = $this->Alevelreportdetail->id;
			    
				        $data = null;
				        $number_of_students_reports_to_create = count($students_in_that_class );
				        $number_of_student_reports_created = 0;
                $dataMulti = array();

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

				        foreach ( $students_in_that_class as $student_in_class ) {
					        $data = array (
					          'Alevelreport' => array (
						          'student_id' => $student_in_class['Student']['id'],
						          'classthen' => $class,
						          'streamthen' => $student_in_class['Student']['currentstream'],
						          'alevelreportdetail_id' => $reportdetail_id,
					          )
					        );

                  foreach ($SchoolDoneASubject as $subject) {
                    $subject_papers = array();

                    if ($subject['Schooldoneasubject']['issubsidiary'] == False) {
                      $subject_papers
                        = 
                      array_slice(
                        explode("$",$subject['Schooldoneasubject']['papersdone']),
                        1
                      );
                    } else {
                      $subject_papers = [""];
                    }

                    foreach ( $subject_papers as $paper ) {
                      $subject_exams_considered 
                        = 
                      $subject['Schooldoneasubject']['shortsubjectname'].($paper)."_examsconsidered";
                      $data["Alevelreport"][$subject_exams_considered] = $examsdone;
                    }

                  }
                  
					        $number_of_student_reports_created++;
                  array_push($dataMulti, $data);			
				        }

                //Do the actual creation
                $this->Alevelreport->saveMany($dataMulti);


				        if ($number_of_student_reports_created == $number_of_students_reports_to_create)  {
				
				          $this->Alevelreport->report_add_examsconsidered($reportdetail_id, null);
                  $this->Alevelreport->report_grade_subjects($reportdetail_id,null); // Grade individual subjects ie D1 yadi yada
                  $this->Alevelreport->report_get_final_subject_grades($reportdetail_id,null); // Grade all papers done ie A B C or D 
                  $this->Alevelreport->report_get_points($reportdetail_id, $class, null); // Get the total points for each student
                  $this->Session->setFlash(__('Successfully created '.$number_of_students_reports_to_create.' reports'));
                  return $this->redirect(array('action' => 'index'));
				
				        } else {
				
				          $this->Session->setFlash(
                    __(
                      'The number of reports created by the system is less than 
								      the number supposed to be created. Please delete the reports
								      just created and repeat the process'
                    )
                  );
				          return $this->redirect(array('action' => 'index'));
				
				        }

			        } else {
				        $this->Session->setFlash(__('Did not successfully save Advanced Level report detail'));
			        }

			      } else {
			
			        if( count($students_in_that_class) == 0 ) {
			    
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
			
			        } else  {
				          if (!is_array($examtoenter)) {

					          $this->Session->setFlash(__('Please select atleast one Examination'));
			
				          } else  {
					          if ($year == null) {

					            $this->Session->setFlash(__('Please select a year'));

					          }
				          }
			        }
			      }
			    }
		    }
	    }
	    //*/
	    
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
		    'fields' => array(
          'Schooldonesubject.shortsubjectname',
          'Schooldonesubject.fullsubjectname'),
		      'recursive' => 0
	      )
      );

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
	$this->loadModel('Alevelreport');
	
	$reports = $this->Alevelreportdetail->findById($id);
	$reports_results = $this->Alevelreport->find('all', array(
	    'conditions' => array('Alevelreport.alevelreportdetail_id' => $id),
	    'fields' => array('Alevelreport.id')
	));
	
	$exams_considered = explode("<::>",$reports['Alevelreportdetail']['default_exams_considered']);
	$subjects_considered = explode("<::>",$reports['Alevelreportdetail']['default_subjects_considered']);
	$report_name = $reports['Alevelreportdetail']['reportname'];
	$report_year = $reports['Alevelreportdetail']['reportyear'];
	$reportclass = $reports['Alevelreportdetail']['reportclass'];
	$reportterm = $reports['Alevelreportdetail']['reportterm'];
	
	if (!$reports){
	    throw new NotFoundException(__('Invalid Report'));
	}

	    set_time_limit(0);
	    
	    $this->layout = 'default2';
	    $this->loadModel('Schooldoneexam');
	    $this->loadModel('Schooldonesubject');
	    $this->loadModel('Student');
	    //$this->loadModel('Alevelreport');
	    //$this->loadModel('Schoolstream');
	    ///*
	    if (!empty($this->request->data)) {
		
		if ($this->request->is('post')) {
			$this->Alevelreportdetail->id = $id;
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
			
			if(($this->request->data['enterspecificstudents'] == "1") && ($this->request->data['registrationnumbers'] != null)){
			
			    $registrationnumbers = explode(",",$registration_numbers_text_box);
			    
			    //Extract the student IDS before checking if they exist in the report
			    foreach($registrationnumbers as $registrationnumber){
			    
				$student_idr = $this->Student->field('id',
				
				    array(
					'registrationnumber' => $registrationnumber
				    )
				
				);
				
				if($student_idr != false){
				
				    //Check if student ID exists in the report
				    $student_id_of_report = $this->Alevelreport->field('id',
				    
					array(
					
					    'student_id' => $student_idr,
					    'olevelreportdetail_id' => $id
					
					)
				    
				    );
				    
				    if($student_id_of_report == false){
				    
					array_push($nonexistent_in_report_registration_numbers,$registrationnumber);
				    
				    }else{
				    
					array_push($report_ids_to_be_edited,$student_id_of_report);
				    
				    }
				
				}else{
				
				    array_push($nonexistent_in_system_registration_numbers,$registrationnumber);
				
				}
			    
			    }
			    
			    if((count($nonexistent_in_system_registration_numbers) > 0) ||
			       (count($nonexistent_in_report_registration_numbers) > 0)
			    ){
			    
					//$this->autoRender = false;
					//implode(",",$nonexistent_in_system_registration_numbers);
					
					$noneexistent = " ";
					foreach($nonexistent_in_system_registration_numbers as $nonexistent1){
					
					    $noneexistent = $noneexistent.$nonexistent1."<br/>";
					
					}
					
					$noneexistent2 = " ";
					foreach($nonexistent_in_report_registration_numbers as $nonexistent1){
					
					    $noneexistent2 = $noneexistent2.$nonexistent1."<br/>";
					
					}
					
					$this->Session->setFlash(__('The following registration numbers where not found in the database:<br/>'.$noneexistent.
								    'The following registration numbers where not found in the report:<br/>'.$noneexistent2
					));
									
										
					$examsdoneintheschool = $this->Schooldoneexam->find('list', array(
					    'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
					    //’conditions’ => array(’Article.status !=’ => ’pending’),
					    'recursive' => 0
					));
    
					$subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
					    'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
					    //’conditions’ => array(’Article.status !=’ => ’pending’),
					    'recursive' => 0
					));
					
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
			    $this->loadModel('Alevelmarksheetresult');
			    $this->loadModel('Alevelreport');

			    $students_in_that_class = $this->Student->find('all', array(
				  'fields' => array('Student.id','Student.currentstream'),
				  'conditions' => array(
							'Student.currentclass =' => $class,
							'Student.leavingreason' => "None"						    
							),
				  'order' => array('Student.currentstream' => 'asc')
				  //'recursive' => 0
			    ));
			
			    $madereport = $this->Alevelreportdetail->find('list', array(
				  'fields' => array('Alevelreportdetail.id', 'Alevelreportdetail.reportname'),
				  'conditions' => array(
				      'Alevelreportdetail.reportname =' => $reportname,
				      'Alevelreportdetail.reportterm =' => $term,
				      'Alevelreportdetail.reportyear =' => $year,
				      'Alevelreportdetail.reportclass =' => $class,
				  )
			    ));
			
			    if ( (count($madereport) == 1) && (count($students_in_that_class) > 0) ){
			
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
				
				
				if(($this->request->data['enterspecificstudents'] == "1") &&
				   ($this->request->data['registrationnumbers'] != null)
				){
				    $data = array(
					'Alevelreportdetail' => array(
					    'reportname' => $reportname,
					    //'reportterm' => $term,
					    //'reportyear' => $year,
					    //'reportclass' => $class,
					    //'default_exams_considered' => $examsdone,
					    //'default_subjects_considered' => $subjectsdone,
					)
				    );
				}else{
				
				    $data = array(
					'Alevelreportdetail' => array(
					    'reportname' => $reportname,
					    'reportterm' => $term,
					    //reportyear' => $year,
					    //'reportclass' => $class,
					    'default_exams_considered' => $examsdone,
					    'default_subjects_considered' => $subjectsdone,
					)
				    );
				
				
				}
			    
				$examsdone = null;
				$number_of_exams_selected = null;
				
				$subjectsdone = null;
				$number_of_subjects_selected = null;
				
				if ( $this->Alevelreportdetail->save($data) ) {
				    $reportdetail_id = $this->Alevelreportdetail->field('id',array(
								  'reportname =' => $reportname,
								  'reportterm' => $term,
								  'reportyear' => $year,
								  'reportclass' => $class,
							  )
						    );
			    
				    $data = null;
				    $number_of_students_reports_to_create = count($students_in_that_class );
				    $number_of_student_reports_created = 0;
				    
				    // Update the reports
				    foreach ( $reports_results as $report_result ) {
				
					//$this->Alevelreport->create();
					
					if(($this->request->data['enterspecificstudents'] == "1") &&
					   (
					    (count($nonexistent_in_system_registration_numbers) == 0) &&
					    (count($nonexistent_in_report_registration_numbers) == 0)
					   )
					   &&
					   ($this->request->data['registrationnumbers'] != null)
					){
					
					    if(in_array($report_result['Alevelreport']['id'],$report_ids_to_be_edited) != null){
					    
						$this->Alevelreport->id = $report_result['Alevelreport']['id'];
						$number_of_student_reports_created++;
						$found_value = 1;
					   
					    }else{
					    
						continue;
					    
					    }
					
					}else{
					
					    $this->Alevelreport->id = $report_result['Alevelreport']['id'];
					    $number_of_student_reports_created++;
					
					}
					
					
					$data = array(
					    'Alevelreport' => array(
						
					    )
					);
				    
					// put all exams meant to be done in a string and separate by <::>
					$examsdone = ""; //The exams chosen for each student
					$number_of_exams_selected = count($examtoenter);
				    
					foreach($examtoenter as $oneexam) {
					    /*$the_exam_id  = $this->Schooldoneexam->field(
						'id',
						array('alias =' => $oneexam)
					    
					    );*/
					    
					    /*if($the_exam_id != false){
					    
						$oneexam = $the_exam_id;
					    
					    }*/
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
					    $data['Alevelreport'][$exams_considered_for_subject] = $examsdone;
					    $date_and_time_report_created = $subject.'_datecreated';
					    
					    $data['Alevelreport'][$date_and_time_report_created] = $date->format('Y-m-d H:i:s');
					}
				    
				    
					$this->Alevelreport->save($data);
					
					//Alevelmarksheetresult::save($data);				
			    
				    }
				
				//$this->set('data',$data);
				if(($number_of_student_reports_created == $number_of_students_reports_to_create)
								||				
				   (($this->request->data['enterspecificstudents'] == "1") &&
					   (
					    (count($nonexistent_in_system_registration_numbers) == 0) &&
					    (count($nonexistent_in_report_registration_numbers) == 0)
					   )
					   &&
					   ($this->request->data['registrationnumbers'] != null)
				  )
				){
				
				    
				    $this->Alevelreport->report_add_examsconsidered($reportdetail_id,null);
				    $this->Alevelreport->report_gradesubjects($reportdetail_id,null);
				    $this->Alevelreport->report_get_total_mark($reportdetail_id,null);
				    $this->Alevelreport->report_getaggregates($reportdetail_id);
				    $this->Alevelreport->report_getdivision($reportdetail_id);
				    $this->Alevelreport->report_get_position($reportdetail_id, null);
				    
				    $report_name = $reports['Alevelreportdetail']['reportname'];
				    $report_year = $reports['Alevelreportdetail']['reportyear'];
				    $reportclass = $reports['Alevelreportdetail']['reportclass'];
				    $reportterm = $reports['Alevelreportdetail']['reportterm'];
				    
				    $this->Session->setFlash(__('Successfully updated '.$number_of_student_reports_created.' report(s) for '.
								  "Senior ".$reportclass." , ".$report_name." ".$reportterm." , ".$report_year
				    
				    
				    ));
				    //$this->set('report_ids_to_be_edited',$found_value);
				    //return $this->render('index');
				    return $this->redirect(array('action' => 'index'));
				
				} else {
				
				    $this->Session->setFlash(__('The number of reports created by the system is less than 
								the number supposed to be created. Please delete the reports
								just created and repeat the process'));
				    return $this->redirect(array('action' => 'index'));
				
				}
			
			    
			    } else {
			    
				$this->Session->setFlash(__('Did not successfully save Olevel report detail'));
			    
			    }
			    

			} else {
			
			    if( count($students_in_that_class) == 0 ) {
			    
				$this->Session->setFlash(__('There are no students in the class chosen. System not creating report(s)' ));
			    
			    }else {
			    
				if ( $madereport != null ) {
			    
				    $this->Session->setFlash(__('This report name already exists, please try another report name'));
			    
				}
			    }
			}
			} else {
		
			if ($class == null) {
			
			    $this->Session->setFlash(__('Please select a class'
							)
						    );
			
			} else {
			
			    if ($term == null) {
			
				$this->Session->setFlash(__('Please select a term'
							)
						    );
			
			    }else{
			
				if (!is_array($subjects)) {
			
				    $this->Session->setFlash(__('Please select atleast one subject'
							)
						    );
			
				}else {
			
				    if (!is_array($examtoenter)) {
			
					  $this->Session->setFlash(__('Please select atleast one Examination'
							)
						    );
			
				    }else{

					if ($year == null) {
			
					    $this->Session->setFlash(__('Please select a year'
							)
						    );
			
					}
				    }
				}
			    }
			
			}
			
			
			}
			
		}
		
	    }
	    //*/
	    
	    $examsdoneintheschool = $this->Schooldoneexam->find('list', array(
		'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	    ));
    
	    $subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
		'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	    ));
	    
	    //$this->set('streamsintheschool',$streamsintheschool);
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

	      if(!$reportdetail_id){
	          throw new NotFoundException(__('Invalid Report'));
	      }
	
	      if(!$mode){
	          throw new NotFoundException(__('Invalid mode'));
	      }
        
	      $reports = $this->Alevelreportdetail->find(
          "first",
          array(
            'conditions' => array('Alevelreportdetail.id' => $reportdetail_id),
          )
        );
	
	      if (!$reports)  {
	          throw new NotFoundException(__('Invalid Report - report not found'));
	      }
        
	      // Mode to download the reports
	      if  ($mode == 3)  {
	
	          $objPhpExcel  = $this->PhpExcel->createWorksheet()
					      ->setDefaultFont('Calibri', 11);

	          $table = array(
			          array(
                  'label' => __(
                      "S".$reports['Alevelreportdetail']['reportclass']. " " .
						          $reports['Alevelreportdetail']['reportname']. " " .
						          $reports['Alevelreportdetail']['reportterm']. " - " .
						          $reports['Alevelreportdetail']['reportyear']. " - ".
						          "Examination Marksheet"
			              )
                )
			      );
			  
	          $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

	          $this->PhpExcel->addTableFooter();
	    
	          $objPhpExcel->removeSheetByIndex(0);
	    
	          $report_exams_considered = explode("<::>",$reports['Alevelreportdetail']['default_exams_considered']);
	    
	          $report_exams_considered = array_reverse($report_exams_considered);
	    

	          //Start adding next sheets
	          $i=0;
	          $this->loadModel('Student');
	          $this->loadModel('Schoolstream');
	          $this->loadModel('Schooldonesubject');
            $this->loadModel('Schooldoneasubject');
	          $this->loadModel('Alevelmarksheetresult');
	          $this->loadModel('Classteacher');
            $this->loadModel('Alevelsubjectcombination');
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
            $header_a_level_report = null; // a_level_report_header
            $space_top_a_level = null; // a_level_top_space
            $space_left_a_level = null; // a_level_left_space
            $header_a_level_shown = null; // a_level_show_inbuilt_header
            $school_motto = null; // school_motto

            if ($settings_report) {
              $school_name = $settings_report["Reportsetting"]["school_name"];
              $school_address = $settings_report["Reportsetting"]["school_address"];
              $school_telephone_number = $settings_report["Reportsetting"]["school_telephone_number"];
              $headteacher_name = $settings_report["Reportsetting"]["headteacher_name"];
              $dorm_master_name = $settings_report["Reportsetting"]["dorm_master_name"];
              $dorm_mistress_name = $settings_report["Reportsetting"]["dorm_mistress_name"];
              $header_a_level_report = $settings_report["Reportsetting"]["a_level_report_header"];
              $space_top_a_level = $settings_report["Reportsetting"]["a_level_top_space"];
              $space_left_a_level = $settings_report["Reportsetting"]["a_level_left_space"];
              $header_a_level_shown = $settings_report["Reportsetting"]["a_level_show_inbuilt_header"];
              $school_motto = $settings_report["Reportsetting"]["school_motto"];
            }


	          //$this->Schooldoneexam->find($reportdetail_id);
	          $report_exams = $this->Schooldoneexam->find(
              'list',
              array(
		            'fields' => array('Schooldoneexam.alias'),
		            'order'  => array('Schooldoneexam.reportorder' => 'asc')
	            )
            );
	    
	          $number_of_students_inclass = count($reports['Alevelreport']);
	    
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
	    
            $student_ids = array();
            // Also get the student_ids
	          // Get the number of students in each stream
	          foreach ($reports['Alevelreport'] as $report) {

                array_push($student_ids, $report["student_id"]);

		            if  (array_key_exists($report['streamthen'], $real_school_streams)) {
		                $real_school_streams[$report['streamthen']]
                      =
                    $real_school_streams[$report['streamthen']] + 1;
		            }
	    
	          }

            $students_combinations = $this->Alevelsubjectcombination->find(
              'all',
              array(
				        'conditions' => array(
							    'Alevelsubjectcombination.student_id' => $student_ids					    
                ),
                'recursive' => -1
			        )
            );

            // Store the key as the student_id and the array of subjects done
            // Cache values for quick look up later on.
            $students_and_combinations = array();
            foreach( $students_combinations as $student_combination ){
              $students_and_combinations[
                $student_combination["Alevelsubjectcombination"]["student_id"]
              ] = $student_combination["Alevelsubjectcombination"];
            }

            $subjects_a_level = $this->Schooldoneasubject->find(
              'all',
              array(
                'recursive' => -1
              )
            );

            // Cache subjects with their ids. Use id as a key and array of
            // details as values
            $subject_details_cache = array();
            foreach($subjects_a_level as $subject) {
              $subject_details_cache[
                $subject["Schooldoneasubject"]["id"]
              ] = $subject["Schooldoneasubject"];
            }

            $row_height_default = 14.25;

	          foreach($reports['Alevelreport'] as $report) {

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
		
		          /*
		          if  ($student_sex == "F") {
		            continue;
		          }
		          */
		
		          // Get the title of the class teacher
		          $classteachertitle = $this->Classteacher->field(
                'title',
		            array(
                  'class' => $report['classthen'],
			            'stream' => $report['streamthen'],
			            'year' => $reports['Alevelreportdetail']['reportyear'],
                )
		          );
		
		          // Get the name of class teacher
		          $classteachername = $this->Classteacher->field(
                'names',
		            array(
                  'class' => $report['classthen'],
			            'stream' => $report['streamthen'],
			            'year' => $reports['Alevelreportdetail']['reportyear'],
		            )
		          );
              
              // Add new sheet
              $objWorkSheet = $objPhpExcel->createSheet($i); //Setting index when creating

              $objPhpExcel->setActiveSheetIndex($i);
      
              $objPhpExcel->getActiveSheet()->setTitle($surname." ".$othernames);
              $objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.71);
              $objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14.14);
              $objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6.29);

              $objPhpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(37.5);
              $objPhpExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(35.25);

              if (true) {
                if ($header_a_level_shown) {
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
                  //$objDrawing->setHeight(50);
                  $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());

                  // School name
                  $objPhpExcel->getActiveSheet()->mergeCells('C1:O1');
                  $objPhpExcel->getActiveSheet()->setCellValue('C1', (string)$school_name);
                  $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setSize(25);
                  $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
                  $objPhpExcel->getActiveSheet()->getStyle('C1')
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $objPhpExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
                  $objPhpExcel->getActiveSheet()->mergeCells('C2:O2');

                  // School Box address and telephone number
                  $school_address_and_phone = (string)$school_address."      TEL:".(string)$school_telephone_number;
                  $objPhpExcel->getActiveSheet()->setCellValue('C2',$school_address_and_phone);
                  $objPhpExcel->getActiveSheet()->getStyle('C2')
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  
                }

                // Report name
                $objPhpExcel->getActiveSheet()->mergeCells('C4:O4');
                $objPhpExcel->getActiveSheet()->setCellValue('C4',(string)$header_a_level_report);
                $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setBold(true);
                $objPhpExcel->getActiveSheet()->getStyle('C4')
                              ->getAlignment()
                              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	  
                $objPhpExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(19);
                $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setSize(16);
                
                // Set the top space and bottom space if shown
                $objPhpExcel->getActiveSheet()
                      ->getPageMargins()
                          ->setTop(is_null($space_top_a_level)?0.75:$space_top_a_level)
                          ->setRight(0.05)
                          ->setLeft(is_null($space_left_a_level)?0.05:$space_left_a_level)
                          ->setBottom(0.75);

                // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
                $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN,
                      'color' => array(
                        'argb' => '000000'
                      ),
                    ),
                    
                  ),
                );
                
                // The Exam name block
                $objPhpExcel->getActiveSheet()->mergeCells('C6:O6');
                $objPhpExcel->getActiveSheet()->setCellValue('C6',
                      $reports['Alevelreportdetail']['reportname']." ".
                      $reports['Alevelreportdetail']['reportterm']." ".
                      "EXAMINATIONS"." - ".
                      $reports['Alevelreportdetail']['reportyear']
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
                
                // The student details section; ie StdN, Name: , Class:, Sex:
                // Merge the Name
                $objPhpExcel->getActiveSheet()->mergeCells('C8:O8');
                // Merge the StdN cells
                $objPhpExcel->getActiveSheet()->mergeCells('C9:E9');

                // Set the Student Number Label and the Font Size
                $objPhpExcel->getActiveSheet()->setCellValue('B9','STUDENT NO:');
                $objPhpExcel->getActiveSheet()->getStyle("B9")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("B9")
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPhpExcel->getActiveSheet()->getStyle("B9")->getFont()->setBold(true);
                $objPhpExcel->getActiveSheet()->getStyle("C9")->getFont()->setSize(12);

                //Set the registrationnumber of the student
                $objPhpExcel->getActiveSheet()->setCellValue('C9',$regnumber);		
                // Align content of the registration number to the left
                $objPhpExcel->getActiveSheet()->getStyle("C9")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                // Align label of the registration number to the Right
                $objPhpExcel->getActiveSheet()->getStyle("B9")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // Report ID
                // Merge the Report ID label cells 
                $objPhpExcel->getActiveSheet()->mergeCells('G9:H9');
                $objPhpExcel->getActiveSheet()->setCellValue('G9','REPORT ID:');
                $objPhpExcel->getActiveSheet()->mergeCells('I9:O9');
                $objPhpExcel->getActiveSheet()->setCellValue('I9',($report['id']));
                $objPhpExcel->getActiveSheet()->getStyle("G9")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("G9")->getFont()->setBold(true);
                $objPhpExcel->getActiveSheet()->getStyle("I9")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("I9")->getFont()->setBold(true);
                // Align report id label to the right
                $objPhpExcel->getActiveSheet()->getStyle("G9")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                // Align report id value to the left
                $objPhpExcel->getActiveSheet()->getStyle("I9")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        
                // Give a label to the name 
                $objPhpExcel->getActiveSheet()->setCellValue('B8','NAME:');
                // Align label of the Name to the Right
                $objPhpExcel->getActiveSheet()->getStyle("B8")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPhpExcel->getActiveSheet()->getStyle("B8")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("C8")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("B8")->getFont()->setBold(true);

                //Set the Name of the student
                $objPhpExcel->getActiveSheet()->setCellValue('C8',$surname." ".$othernames);		
                // Align to the left
                $objPhpExcel->getActiveSheet()->getStyle("C8")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
                $objPhpExcel->getActiveSheet()->setCellValue('B10','CLASS:');
                $objPhpExcel->getActiveSheet()->getStyle("B10")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("B10")->getFont()->setBold(true);
                // Align to the left
                $objPhpExcel->getActiveSheet()->getStyle("B10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // Merge the Cells that will contain the student class
                $objPhpExcel->getActiveSheet()->mergeCells('C10:D10');
                //Set the Class the student was in at the time of the student
                $objPhpExcel->getActiveSheet()->setCellValue('C10',"Senior ".$report['classthen']);		
                // Align to the left
                $objPhpExcel->getActiveSheet()->getStyle("C10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        
                // Merge the Cells that will contain the Stream label
                $objPhpExcel->getActiveSheet()->mergeCells('E10:F10');
                $objPhpExcel->getActiveSheet()->setCellValue('E10','STREAM:');
                $objPhpExcel->getActiveSheet()->getStyle("E10")->getFont()->setBold(true);
                $objPhpExcel->getActiveSheet()->getStyle("E10")->getFont()->setSize(12);
                // Align its contents to the right
                $objPhpExcel->getActiveSheet()->getStyle("E10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // Merge the Cells that will contain the Stream DETAILS
                $objPhpExcel->getActiveSheet()->mergeCells('G10:H10');
                $objPhpExcel->getActiveSheet()->getStyle("G10")->getFont()->setSize(12);
                //Set the Stream the student was in at the time of report creation.
                $objPhpExcel->getActiveSheet()->setCellValue('G10',$student_stream);		
                // Align to the left
                $objPhpExcel->getActiveSheet()->getStyle("G10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
                // Process student gender/sex
                $objPhpExcel->getActiveSheet()->setCellValue('I10','SEX:');
                $objPhpExcel->getActiveSheet()->getStyle("I10")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("I10")->getFont()->setBold(true);
                // Align to the right
                $objPhpExcel->getActiveSheet()->getStyle("I10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPhpExcel->getActiveSheet()->getStyle("J10")->getFont()->setSize(12);
                
                $objPhpExcel->getActiveSheet()->setCellValue('J10',$student_sex);		
                // Align to the left
                $objPhpExcel->getActiveSheet()->getStyle("J10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                // Process student combination
                // Merge the Cells that will contain the Combination
                $objPhpExcel->getActiveSheet()->mergeCells('K10:O10');
                // Get the student combination as a string
                $objPhpExcel->getActiveSheet()->getStyle("K10")->getFont()->setSize(12);
                $objPhpExcel->getActiveSheet()->getStyle("K10")->getFont()->setBold(true);

                // Align to the left
                $objPhpExcel->getActiveSheet()->getStyle("K10")
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

              }
              
              $table = array("", "CODE/SUBJECT", "PAPER");
              
              $number_of_exams_counter = 0;
              
              // add the exams considered to the table array that will be used to add 
              // to the report
              foreach($report_exams as $anexamination){
              
                  array_push($table,$anexamination);
                  $number_of_exams_counter++;
              
              }
              
              //add AVG MK, grade, remarks and initials to the report 
              $AGRI = array("AVERAGE","GRADE","AWARD","REMARKS");
              
              foreach($AGRI as $agri){
              
                  array_push($table,$agri);
              
              }
              
              // Add column headers
              $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'A12');
		
		
              // counter tells one where to start adding the inividual subjects for the student together
              // with the marks and average
              $insert_counter = 13;
		
              // if the number of subjects initially considered is more than 1, go ahead and 
              // create the subjects and their marks
              $report_number_of_subjects = 0;
              if  (true)  {
                // Get the students Combination
                $combination = $students_and_combinations[$report["student_id"]];
                $combination_string = "";

                foreach (["1", "2", "3", "4", "5"] as $suffix) {
                  $subject_id = $combination["subject".$suffix];
                  // Get the subject details using the id
                  $subject = $subject_details_cache[$subject_id];
                  $subject_short_name = $subject["shortsubjectname"];
                  $subject_code = $subject["subjectcode"];
                  $subject_full_name = $subject["fullsubjectname"];
                  $subject_papers_done = $subject["papersdone"];
                  $subject_is_subsidiary = $subject["issubsidiary"];

                  if ($subject_is_subsidiary != true && is_string($subject_papers_done)) {
                    $subject_papers_done = array_slice(
                      explode("$", $subject_papers_done),
                      1
                    );
                    $combination_string = $combination_string.$subject_short_name[0];
                  }

                  $final_subject_grade = $report[$subject_short_name."_finalgrade"];
                  if ($subject_is_subsidiary == true) {
                    $subject_papers_done = array("");
                    $combination_string = $combination_string."/".$subject_short_name;
                  }
                  
                  foreach($subject_papers_done as $paper) {
                    $report_number_of_subjects++;
                    $table = array();
                    array_push(
                      $table,
                      "",
                      $subject_code." ".$subject_full_name,
                      (string)($paper)
                    );

                    foreach ($report_exams as $anexamination) {
                      $amark = $this->Alevelmarksheetresult->field(
                        $subject_short_name.((string)($paper))."_mark",
                        array(
                          'exam_name' => $anexamination,
                          'year' => $reports['Alevelreportdetail']['reportyear'],
                          'student_id' => $report['student_id']
                        )
                      );

                      // Means we encountered a missing mark
                      // So award an x
                      if ($amark == 1111) {
                        $amark = "X";
                      }
                      array_push($table, $amark);
                    }

                    $grade_to_be_put = "";
                
                    switch  ($report[$subject_short_name.((string)($paper))."_finalaveragemarkgrade"]) {
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

                    $final_average_mark = $report[$subject_short_name.((string)($paper))."_finalaveragemark"];
                    array_push(
                      $table,
                      $final_average_mark,
                      $grade_to_be_put,
                      $final_subject_grade,
                      $Gradeprofile->gradeprofile_returnsubjectremark(
                        $reports['Alevelreportdetail']['reportclass'],
                        $final_average_mark
                      ),
                      ""
                    );
                    
                    // Insert values from that part.
                    $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'A'.$insert_counter);
                    $insert_counter++;
                  }

                  // Merge the Cells that will contain the subject name and
                  // only merge when the number of papers is more than 1
                  $number_of_papers = count($subject_papers_done);
                  $row_number = ($insert_counter - $number_of_papers);
                  $row_nums = $this->Alevelreportdetail->getRowcount($subject_code." ".$subject_full_name);

                  $final_height = $row_height_default * $row_nums;

                  $row_number = ($insert_counter - $number_of_papers);

                  if ($number_of_papers > 1) {
                    // Increase the height uniformly over a number of rows
                    $final_height_split = $final_height / $number_of_papers;

                    for ($paper_counter=0; $paper_counter < $number_of_papers; $paper_counter++) {

                      $row_height = $objPhpExcel->getActiveSheet()
                                      ->getRowDimension($row_number + $paper_counter)
                                      ->getRowHeight();

                      // Means row height is set to auto so we first initialize
                      // to default row height
                      if ($row_height == -1) {
                        $row_height = $row_height_default;
                      }

                      $row_height = $row_height + $final_height_split;

                      $objPhpExcel->getActiveSheet()
                        ->getRowDimension($row_number + $paper_counter)
                        ->setRowHeight($row_height);
                    }
                  }

                  if ($number_of_papers == 1) {
                    $row_height = $objPhpExcel->getActiveSheet()
                                    ->getRowDimension($row_number)
                                    ->getRowHeight();

                    if ($row_height == -1)  {
                      $row_height = $row_height_default;
                    }

                    $row_height = $final_height;

                    $objPhpExcel->getActiveSheet()
                                    ->getRowDimension($row_number)
                                    ->setRowHeight($row_height);
                  }

                  // Merge the cells with the subject name
                  $objPhpExcel->getActiveSheet()->mergeCells("B".$row_number.":"."B".($insert_counter - 1));
                
                  // Wrap text in the cells with the subject name 
                  $objPhpExcel->getActiveSheet()->getStyle("B".($insert_counter - $number_of_papers))
                      ->getAlignment()->setWrapText(true);

                  // Merge the cells with the Final grade, increase font size(if not subsidiary),
                  // Center align all Contents
                  $column_final_grade = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 3);
                  $cell_range = $column_final_grade.$row_number.":".$column_final_grade.($insert_counter - 1);
                  
                  $objPhpExcel->getActiveSheet()->mergeCells($cell_range);
                  $objPhpExcel->getActiveSheet()->getStyle($cell_range)
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $objPhpExcel->getActiveSheet()->getStyle($cell_range)
                      ->getAlignment()
                      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                  $objPhpExcel->getActiveSheet()->getStyle($column_final_grade.$row_number)->getFont()->setSize(24);

                }
                // Write Processed student combination
                $objPhpExcel->getActiveSheet()->setCellValue(
                  'K10',"COMBINATION: ".$combination_string
                );
                
              }
		
              // Put boarders around the report data
              $objPhpExcel->getActiveSheet()->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).$insert_counter)
                  ->applyFromArray($styleArray);
                  
              //Make the heading where the code, subject and exam names are bold
              $objPhpExcel->getActiveSheet()
                  ->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 1)."12")
                  ->getFont()->setBold(true);

              // Merge Cells containing the Grade Column and make width of Award column 30 pts
              $column_name_start = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 4);
              $column_name_end = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 3);
              // $objPhpExcel->getActiveSheet()
              //           ->getColumnDimension($column_name_end)
              //           ->setWidth(40);
              $objPhpExcel->getActiveSheet()->getColumnDimensionByColumn(($number_of_exams_counter+8) - 3)->setAutoSize(true);
              // $objPhpExcel->getActiveSheet()->getColumnDimensionByColumn(($number_of_exams_counter+8) - 3)->setWidth(40);
              // $objPhpExcel->getActiveSheet()
              //           ->mergeCells(
              //             $column_name_start."11".":".$column_name_end."11"
              //           );
              
              // Set label of cell containing total points
              $objPhpExcel->getActiveSheet()->setCellValue($column_name_start.$insert_counter,"TOTAL POINTS:");
              // Align contents to the right 
              $objPhpExcel->getActiveSheet()->getStyle($column_name_start.$insert_counter)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
              
              //set the total points
              $column_name_start = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 5);
              $column_name_end = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 4);
              $column_name_total_points = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 3);
              
              // Merge Cells containing the total points label
              $objPhpExcel->getActiveSheet()->mergeCells(
                $column_name_start.$insert_counter.":".$column_name_end.$insert_counter
              );
              
              // Set label of cell containing total points
              $objPhpExcel->getActiveSheet()->setCellValue($column_name_start.$insert_counter,"TOTAL POINTS:");
              // Align contents to the right 
              $objPhpExcel->getActiveSheet()->getStyle($column_name_start.$insert_counter)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
              $objPhpExcel->getActiveSheet()->setCellValue($column_name_total_points.$insert_counter,(string)$report['totalpoints']);
              $objPhpExcel->getActiveSheet()->getStyle($column_name_total_points.$insert_counter)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              // Set the formating to include 0 before it
              $objPhpExcel->getActiveSheet()->getStyle($column_name_total_points.$insert_counter)->getNumberFormat()->setFormatCode("00");
              
              // set the total points label and contents to bold
              $objPhpExcel->getActiveSheet()
                  ->getStyle($column_name_start.$insert_counter.":".$column_name_total_points.$insert_counter)
                  ->getFont()->setBold(true);
                                
              //Wrap the text for the subjects codes, names and paper and center values in cells
              // $objPhpExcel->getActiveSheet()->getStyle('B12'.':'.'C'.($insert_counter-1))
              //         ->getAlignment()->setWrapText(true);
              $objPhpExcel->getActiveSheet()->getStyle('B13'.':'.'C'.($insert_counter-1))
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $objPhpExcel->getActiveSheet()->getStyle('B13'.':'.'C'.($insert_counter-1))
                      ->getAlignment()
                      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

              // Modify width of remarks column
              $column_name = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 2);
              $objPhpExcel->getActiveSheet()
                            ->getColumnDimension($column_name)
                            ->setAutoSize(true);
              
              // Create a row to separate Subjects and their performance from the rest
              $insert_counter++;

              // Set the grading scheme
              $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+1),"Grading scheme:");
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+1))->getFont()->setUnderline(true);
              
              //Award the grading schemes
              $report_class = (int)$reports['Alevelreportdetail']['reportclass'];
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
              $objPhpExcel->getActiveSheet()->setCellValue(
                'B'.($insert_counter+7),
                is_null($headteacher_name)?"":$headteacher_name
              );
              //Align the Name to the center
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
                      ->getAlignment()
                      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
              //Wrap the cell text
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
                      ->getAlignment()
                      ->setWrapText(True);
              //Set the comment font size to 12
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))->getFont()->setSize(12);				
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
              //Name of the class teacher
              $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+10),$classteachertitle." ".$classteachername);
              //Align the Name to the center
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
                      ->getAlignment()
                      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
              //Wrap the cell text
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
                      ->getAlignment()
                      ->setWrapText(True);
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
              //Name of the House master / House mistress		
              if($student_sex == "F"){
                  $objPhpExcel->getActiveSheet()->setCellValue(
                    'B'.($insert_counter+13),
                    is_null($dorm_mistress_name)? "": $dorm_mistress_name
                  );
              }
              if($student_sex == "M"){
                  $objPhpExcel->getActiveSheet()->setCellValue(
                    'B'.($insert_counter+13),
                    is_null($dorm_master_name)? "": $dorm_master_name
                  );
              }

              //Align the Name to the center
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
                      ->getAlignment()
                      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
              //Wrap the cell text
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
                      ->getAlignment()
                      ->setWrapText(True);
              //Set the comment font size to 12
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))->getFont()->setSize(12);
              //The House mistress/House master comment section
              if($student_sex == "F"){
                  $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+12),"House Mistress's comment");
              }
              if ($student_sex == "M"){
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
              
              //Add the school logo to the end of the report and center align it
              $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+15).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+15));
              $objPhpExcel->getActiveSheet()->setCellValue(
                'B'.($insert_counter+15),
                is_null($school_motto)? "": $school_motto
              );
              $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+15))
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              
              
              //Auto resize the remarks section to fit certain remarks
              $objPhpExcel->getActiveSheet()
                    ->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 2))->setAutoSize(true);
              
              // Change the font size of each of the subject names to ten
              $subject_name_number = 0;
              
              while ($subject_name_number <= $report_number_of_subjects)  {
              
                  $objPhpExcel->getActiveSheet()->getStyle("C13:"."C".$insert_counter)->getFont()->setSize(10);
                  $subject_name_number++;
              }
              
              // Set the document to fit strictly on one page 
              $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
              $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
              $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
              
              /*
              // Start protecting the worksheet
              //unprotect the head teacher section
              $objPhpExcel->getActiveSheet()->getStyle('D'.($insert_counter+7))
                      ->getProtection()
                      ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
              
              // Protect the sheet
              $objPhpExcel->getActiveSheet()->getProtection()->setSheet(true);
              
              $objPhpExcel->getActiveSheet()->getProtection()->setInsertRows(true);
              $objPhpExcel->getActiveSheet()->getProtection()->setInsertColumns(true);
              
              */


              
              
              //Write cells
              /*$objWorkSheet->setCellValue('A1', 'Hello'.$i)
                    ->setCellValue('B2', 'world!')
                    ->setCellValue('C1', 'Hello')
                    ->setCellValue('D2', 'world!');
              */
              // Rename sheet
              //$objWorkSheet->setTitle("$i");

              $i++;
            }

            // $this->Session->setFlash(__(print_r($subject_details_cache)));
            // $objPhpExcel->getActiveSheet()->getProtection()->setPassword('PHPExcel');
            
            $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']. " " .
                        $reports['Alevelreportdetail']['reportname']. " " .
                        $reports['Alevelreportdetail']['reportterm']. " - " .
                        $reports['Alevelreportdetail']['reportyear']. " - ".
                        'Report'.'.xlsx','Excel2007');
	    
	
	      }
	
        // Mode for creating marksheet with all the results	
        if($mode == 1){      
            $this->loadModel('Schooldoneasubject');
            $this->loadModel('Student');
            $subjectsdoneinolevel = $this->Schooldoneasubject->find(
              'all',
              array(
                'fields' => array('Schooldoneasubject.fullsubjectname','Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.subjectcode', 'Schooldoneasubject.papersdone', 'Schooldoneasubject.issubsidiary'),
                'order' => array('Schooldoneasubject.shortsubjectname' => 'asc')
              )
            );

            //$reports['Alevelreportdetail'][''];
            $objPhpExcel  = $this->PhpExcel->createWorksheet()
                      ->setDefaultFont('Calibri', 11);
            
            $table = array(
              array('label' => __("S".$reports['Alevelreportdetail']['reportclass']. " " .
                    $reports['Alevelreportdetail']['reportname']. " " .
                    $reports['Alevelreportdetail']['reportterm']. " - " .
                    $reports['Alevelreportdetail']['reportyear']. " - ".
                    "Examination Marksheet"
              ))
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

            // Subject list to use
            $subject_list = [];

            // Generate Subject headers
            foreach($subjectsdoneinolevel as $olevel_subject){
              if ($olevel_subject['Schooldoneasubject']['issubsidiary'] == 0) {
                $subject_papers = [];
                $subject_papers = explode("$",substr($olevel_subject['Schooldoneasubject']['papersdone'], 1));
                if (count($subject_papers) > 0){
                  foreach($subject_papers as $paper){
                    array_push(
                      $table,
                      array(
                        'label' => __(
                          $olevel_subject['Schooldoneasubject']['shortsubjectname']."_".(string)$paper
                        )
                      )
                    );
                    array_push($table,array('label' => __('G')));
                    array_push(
                      $subject_list,
                      $olevel_subject['Schooldoneasubject']['shortsubjectname'].(string)$paper."_finalaveragemark",
                      $olevel_subject['Schooldoneasubject']['shortsubjectname'].(string)$paper."_finalaveragemarkgrade",
                    );
                  }
                }
                array_push($table,array('label' => __($olevel_subject['Schooldoneasubject']['shortsubjectname']."_G")));
                array_push(
                  $subject_list,
                  $olevel_subject['Schooldoneasubject']['shortsubjectname']."_finalgrade"
                );
              }

              if ($olevel_subject['Schooldoneasubject']['issubsidiary'] == 1) {
                array_push(
                  $table,
                  array(
                    'label' => __(
                      $olevel_subject['Schooldoneasubject']['shortsubjectname']
                    )
                  )
                );
                array_push($table,array('label' => __($olevel_subject['Schooldoneasubject']['shortsubjectname']."_G")));
                array_push(
                  $subject_list,
                  $olevel_subject['Schooldoneasubject']['shortsubjectname']."_finalaveragemark",
                  $olevel_subject['Schooldoneasubject']['shortsubjectname']."_finalaveragemarkgrade",
                );
              }
            }

            // Total points label
            array_push($table,array('label' => __("Total Points")));

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
            $column_name_total_points = PHPExcel_Cell::stringFromColumnIndex((count($table) - 1));      
            //row counter
            $row_counter = 3;

            $row_picture_counter = 3;
            foreach($reports['Alevelreport'] as $report){
          
              // increase row height for the row currently in
              $objPhpExcel->getActiveSheet()->getRowDimension($row_picture_counter++)
                              ->setRowHeight(32);

              $studentregistrationnumber = $this->Student->field(
                'registrationnumber',
                array('id' => $report['student_id'])
              );
          
              $file = $this->Student->field('studentpicture',
                  array('id =' => $report['student_id'])
              );

              if($file != null){
              
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
          
              foreach($subject_list as $item){
                array_push($row_to_add,$report[$item]);
              }

              // Total points
              array_push($row_to_add, $report['totalpoints']);
              
              $this->PhpExcel->addTableRow($row_to_add);
              // Set the formating of the total points to include 0 before it
              $objPhpExcel
                ->getActiveSheet()
                ->getStyle($column_name_total_points.$row_counter)
                ->getNumberFormat()->setFormatCode("00");

              $row_counter++;
            }
            
            // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
            $styleArray = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
              ),
            );


            $this->PhpExcel->addTableFooter();
            $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']." - ".
                  $reports['Alevelreportdetail']['reportname']. " " .
                  $reports['Alevelreportdetail']['reportterm']. " - " .
                  $reports['Alevelreportdetail']['reportyear']. " - ".
                  "Examination Marksheet".
                  '.xlsx','Excel2007');
        
        }
	
	// Mode for creating the summary of results
	if($mode == 2){
	
	    $this->loadModel('Schooldonesubject');
	    $this->loadModel('Student');
	    $subjectsdoneinolevel = $this->Schooldonesubject->find('all',
		array(
		  'fields' => array('Schooldonesubject.fullsubjectname','Schooldonesubject.shortsubjectname'),
		  'order' => array('Schooldonesubject.shortsubjectname' => 'asc')
		)
	    
	    );
	    //$reports['Alevelreportdetail'][''];
	    $objPhpExcel  = $this->PhpExcel->createWorksheet()
					      ->setDefaultFont('Calibri', 11);
	    
	    $table = array(
			      array('label' => __("S".$reports['Alevelreportdetail']['reportclass']. " " .
						      $reports['Alevelreportdetail']['reportname']. " " .
						      $reports['Alevelreportdetail']['reportterm']. " - " .
						      $reports['Alevelreportdetail']['reportyear']. " - ".
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
	    
	    foreach($subjectsdoneinolevel as $olevel_subject){
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
	    
		foreach($reports['Alevelreport'] as $report){
		    
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
		$row_to_add = array($olevel_subject['Schooldonesubject']['fullsubjectname'],
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
		//$this->PhpExcel->addTableRow();
	}
	$table = null;
	$table = array(
			      array('label' => __("S".$reports['Alevelreportdetail']['reportclass']. " " .
						      $reports['Alevelreportdetail']['reportname']. " " .
						      $reports['Alevelreportdetail']['reportterm']. " - " .
						      $reports['Alevelreportdetail']['reportyear']. " - ".
						      "Results Summary (By Percentages)"
			      ))
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
	    foreach($subjectsdoneinolevel as $olevel_subject){
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
	    
		foreach($reports['Alevelreport'] as $report){
		    
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
		
		foreach($percentages_to_be_created as $percentage){
		
		    if(count($percentage) != 0){
		    
			$apercentage = (count($percentage)/$total_number_of_students)*100;
			array_push($row_to_add,sprintf("%01.1f",$apercentage));
			
		    }else{
		    
			array_push($row_to_add,0);
		    
		    }
		
		}
		
		/*$row_to_add = array($olevel_subject['Schooldonesubject']['fullsubjectname'],
			  ((count($d1s)/$total_number_of_students)*100),
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
		*/
		$this->PhpExcel->addTableRow($row_to_add);
	}	

	$table = null;
	$table = array(
			      array('label' => __("S".$reports['Alevelreportdetail']['reportclass']. " " .
						      $reports['Alevelreportdetail']['reportname']. " " .
						      $reports['Alevelreportdetail']['reportterm']. " - " .
						      $reports['Alevelreportdetail']['reportyear']. " - ".
						      "Results Summary (By Division)"
			      ))
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
	    
	    foreach($reports['Alevelreport'] as $report){
	    
		$grade = $report["division"];
	    
		switch($grade){
		
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
	    array_push($row_to_add,"Number of Students",
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
				    //'color' => array('argb' => 'FFFF0000'),
				 ),
			    ),
	    );	
	    
	    //$objPhpExcel->getActiveSheet()->getCellByColumnAndRow(4,4)->getStyle()->applyFromArray($styleArray);
	    $this->PhpExcel->addTableFooter();
	    $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']." - ".
				     $reports['Alevelreportdetail']['reportname']. " " .
				     $reports['Alevelreportdetail']['reportterm']. " - " .
				     $reports['Alevelreportdetail']['reportyear']. " - ".
				     "Result summaries".
				     '.xlsx','Excel2007');
	    
	    
	
	}
    
    }


    
  public function comment($reportdetail_id = null, $mode = null){
    
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
	
	  $reports = $this->Alevelreportdetail->findById($reportdetail_id);
	
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
      $header_a_level_report = null; // a_level_report_header
      $space_top_a_level = null; // a_level_top_space
      $space_left_a_level = null; // a_level_left_space
      $header_a_level_shown = null; // a_level_show_inbuilt_header
      $school_motto = null; // school_motto

      if ($settings_report) {
        $school_name = $settings_report["Reportsetting"]["school_name"];
        $school_address = $settings_report["Reportsetting"]["school_address"];
        $school_telephone_number = $settings_report["Reportsetting"]["school_telephone_number"];
        $headteacher_name = $settings_report["Reportsetting"]["headteacher_name"];
        $dorm_master_name = $settings_report["Reportsetting"]["dorm_master_name"];
        $dorm_mistress_name = $settings_report["Reportsetting"]["dorm_mistress_name"];
        $header_a_level_report = $settings_report["Reportsetting"]["a_level_report_header"];
        $space_top_a_level = $settings_report["Reportsetting"]["a_level_top_space"];
        $space_left_a_level = $settings_report["Reportsetting"]["a_level_left_space"];
        $header_a_level_shown = $settings_report["Reportsetting"]["a_level_show_inbuilt_header"];
        $school_motto = $settings_report["Reportsetting"]["school_motto"];
      }
        
      $objPhpExcel  = $this->PhpExcel->createWorksheet()
                ->setDefaultFont('Calibri', 11);

      $table = array(
        array('label' => __("S".$reports['Alevelreportdetail']['reportclass']. " " .
              $reports['Alevelreportdetail']['reportname']. " " .
              $reports['Alevelreportdetail']['reportterm']. " - " .
              $reports['Alevelreportdetail']['reportyear']. " - ".
              "Examination Marksheet"
        ))
      );
          
      $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
      
      $this->PhpExcel->addTableFooter();
      
      $objPhpExcel->removeSheetByIndex(0);
      
      $report_exams_considered = explode("<::>",$reports['Alevelreportdetail']['default_exams_considered']);
      
      $report_exams_considered = array_reverse($report_exams_considered);
      
      $report_subjects_considered = explode("<::>",$reports['Alevelreportdetail']['default_subjects_considered']);
      
      sort($report_subjects_considered);
            
        
      //Start adding next sheets
      $i=0;
      $this->loadModel('Student');
      //$this->loadModel('Schoolstream');
      $this->loadModel('Schooldonesubject');
      $this->loadModel('Alevelmarksheetresult');
      $Gradeprofile = ClassRegistry::init('Gradeprofile');
      $this->loadModel('Schooldoneexam');
      $this->loadModel('Schoolstream');
      $this->loadModel('Schooldoneasubject');
      $this->loadModel('Classteacher');
      $this->loadModel('Alevelsubjectcombination');
      //$this->Schooldoneexam->find($reportdetail_id);
      $report_exams = $this->Schooldoneexam->find(
        'list',
        array(
          'fields' => array('Schooldoneexam.alias'),
          'order'  => array('Schooldoneexam.reportorder' => 'asc')
        )
      );
      
      $school_streams  = $this->Schoolstream->find('all',array(
        'fields' => array('shortstreamname')
      ));
      
      $real_school_streams = array();
        
      //get an array with keys as stream names
      foreach($school_streams as $astream){
        $real_school_streams[$astream['Schoolstream']['shortstreamname']] = 0;
      }

      $student_ids = array();
      // Also get the student_ids
      // Get the number of students in each stream
      foreach ($reports['Alevelreport'] as $report) {

          array_push($student_ids, $report["student_id"]);

          if  (array_key_exists($report['streamthen'], $real_school_streams)) {
              $real_school_streams[$report['streamthen']]
                =
              $real_school_streams[$report['streamthen']] + 1;
          }

      }

      $students_combinations = $this->Alevelsubjectcombination->find(
        'all',
        array(
          'conditions' => array(
            'Alevelsubjectcombination.student_id' => $student_ids					    
          ),
          'recursive' => -1
        )
      );

      // Store the key as the student_id and the array of subjects done
      // Cache values for quick look up later on.
      $students_and_combinations = array();
      foreach( $students_combinations as $student_combination ){
        $students_and_combinations[
          $student_combination["Alevelsubjectcombination"]["student_id"]
        ] = $student_combination["Alevelsubjectcombination"];
      }

      $subjects_a_level = $this->Schooldoneasubject->find(
        'all',
        array(
          'recursive' => -1
        )
      );

      // Cache subjects with their ids. Use id as a key and array of
      // details as values
      $subject_details_cache = array();
      foreach($subjects_a_level as $subject) {
        $subject_details_cache[
          $subject["Schooldoneasubject"]["id"]
        ] = $subject["Schooldoneasubject"];
      }

      $row_height_default = 14.25;
        
      // Get the number of students in each stream
      foreach($reports['Alevelreport'] as $report){

        if(array_key_exists($report['streamthen'], $real_school_streams)){
          $real_school_streams[$report['streamthen']] = $real_school_streams[$report['streamthen']] + 1;
        }
        
      }
        
      foreach($reports['Alevelreport'] as $report) {

        $surname  = $this->Student->field('surname',
        
            array('id' => $report['student_id'])
        
        );
        
        $othernames  = $this->Student->field('othernames',
        
            array('id' => $report['student_id'])
        
        );
        
        $student_sex  = $this->Student->field('sex',
        
            array('id' => $report['student_id'])
        
        );
        
        $regnumber  = $this->Student->field('registrationnumber',
        
            array('id' => $report['student_id'])
        
        );
        
        $student_stream  = $this->Schoolstream->field('stream',
        
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
        $classteachertitle = $this->Classteacher->field('title',
            array('class' => $report['classthen'],
            'stream' => $report['streamthen'],
            'year' => $reports['Alevelreportdetail']['reportyear'],
            )
        );
        
        // Get the name of class teacher
        $classteachername = $this->Classteacher->field('names',
            array('class' => $report['classthen'],
            'stream' => $report['streamthen'],
            'year' => $reports['Alevelreportdetail']['reportyear'],
            )
        );
      
        // Add new sheet
        $objWorkSheet = $objPhpExcel->createSheet($i); //Setting index when creating
        
        $objPhpExcel->setActiveSheetIndex($i);
        
        $objPhpExcel->getActiveSheet()->setTitle($surname." ".$othernames);
        $objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.71);
        $objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14.14);
        $objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6.29);

        $objPhpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(37.5);
        $objPhpExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(35.25);

        if (true) {
          if ($header_a_level_shown) {
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
            //$objDrawing->setHeight(50);
            $objDrawing->setWorksheet($objPhpExcel->getActiveSheet());

            // School name
            $objPhpExcel->getActiveSheet()->mergeCells('C1:O1');
            $objPhpExcel->getActiveSheet()->setCellValue('C1', (string)$school_name);
            $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setSize(25);
            $objPhpExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
            $objPhpExcel->getActiveSheet()->getStyle('C1')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPhpExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
            $objPhpExcel->getActiveSheet()->mergeCells('C2:O2');

            // School Box address and telephone number
            $school_address_and_phone = (string)$school_address."      TEL:".(string)$school_telephone_number;
            $objPhpExcel->getActiveSheet()->setCellValue('C2',$school_address_and_phone);
            $objPhpExcel->getActiveSheet()->getStyle('C2')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
          }

          // Report name
          $objPhpExcel->getActiveSheet()->mergeCells('C4:O4');
          $objPhpExcel->getActiveSheet()->setCellValue('C4',(string)$header_a_level_report);
          $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle('C4')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	  
          $objPhpExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(19);
          $objPhpExcel->getActiveSheet()->getStyle("C4")->getFont()->setSize(16);
          
          // Set the top space and bottom space if shown
          $objPhpExcel->getActiveSheet()
                ->getPageMargins()
                    ->setTop(is_null($space_top_a_level)?0.75:$space_top_a_level)
                    ->setRight(0.05)
                    ->setLeft(is_null($space_left_a_level)?0.05:$space_left_a_level)
                    ->setBottom(0.75);

          // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
          $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                  'argb' => '000000'
                ),
              ),
              
            ),
          );
          
          // The Exam name block
          $objPhpExcel->getActiveSheet()->mergeCells('C6:O6');
          $objPhpExcel->getActiveSheet()->setCellValue('C6',
                $reports['Alevelreportdetail']['reportname']." ".
                $reports['Alevelreportdetail']['reportterm']." ".
                "EXAMINATIONS"." - ".
                $reports['Alevelreportdetail']['reportyear']
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
          
          // The student details section; ie StdN, Name: , Class:, Sex:
          // Merge the Name
          $objPhpExcel->getActiveSheet()->mergeCells('C8:O8');
          // Merge the StdN cells
          $objPhpExcel->getActiveSheet()->mergeCells('C9:E9');

          // Set the Student Number Label and the Font Size
          $objPhpExcel->getActiveSheet()->setCellValue('B9','STUDENT NO:');
          $objPhpExcel->getActiveSheet()->getStyle("B9")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("B9")
                  ->getAlignment()
                  ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $objPhpExcel->getActiveSheet()->getStyle("B9")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle("C9")->getFont()->setSize(12);

          //Set the registrationnumber of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C9',$regnumber);		
          // Align content of the registration number to the left
          $objPhpExcel->getActiveSheet()->getStyle("C9")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          // Align label of the registration number to the Right
          $objPhpExcel->getActiveSheet()->getStyle("B9")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

          // Report ID
          // Merge the Report ID label cells 
          $objPhpExcel->getActiveSheet()->mergeCells('G9:H9');
          $objPhpExcel->getActiveSheet()->setCellValue('G9','REPORT ID:');
          $objPhpExcel->getActiveSheet()->mergeCells('I9:O9');
          $objPhpExcel->getActiveSheet()->setCellValue('I9',($report['id']));
          $objPhpExcel->getActiveSheet()->getStyle("G9")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("G9")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle("I9")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("I9")->getFont()->setBold(true);
          // Align report id label to the right
          $objPhpExcel->getActiveSheet()->getStyle("G9")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          // Align report id value to the left
          $objPhpExcel->getActiveSheet()->getStyle("I9")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                  
          // Give a label to the name 
          $objPhpExcel->getActiveSheet()->setCellValue('B8','NAME:');
          // Align label of the Name to the Right
          $objPhpExcel->getActiveSheet()->getStyle("B8")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $objPhpExcel->getActiveSheet()->getStyle("B8")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("C8")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("B8")->getFont()->setBold(true);

          //Set the Name of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C8',$surname." ".$othernames);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("C8")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          
          $objPhpExcel->getActiveSheet()->setCellValue('B10','CLASS:');
          $objPhpExcel->getActiveSheet()->getStyle("B10")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("B10")->getFont()->setBold(true);
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("B10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

          // Merge the Cells that will contain the student class
          $objPhpExcel->getActiveSheet()->mergeCells('C10:D10');
          //Set the Class the student was in at the time of the student
          $objPhpExcel->getActiveSheet()->setCellValue('C10',"Senior ".$report['classthen']);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("C10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                  
          // Merge the Cells that will contain the Stream label
          $objPhpExcel->getActiveSheet()->mergeCells('E10:F10');
          $objPhpExcel->getActiveSheet()->setCellValue('E10','STREAM:');
          $objPhpExcel->getActiveSheet()->getStyle("E10")->getFont()->setBold(true);
          $objPhpExcel->getActiveSheet()->getStyle("E10")->getFont()->setSize(12);
          // Align its contents to the right
          $objPhpExcel->getActiveSheet()->getStyle("E10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

          // Merge the Cells that will contain the Stream DETAILS
          $objPhpExcel->getActiveSheet()->mergeCells('G10:H10');
          $objPhpExcel->getActiveSheet()->getStyle("G10")->getFont()->setSize(12);
          //Set the Stream the student was in at the time of report creation.
          $objPhpExcel->getActiveSheet()->setCellValue('G10',$student_stream);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("G10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
          
          // Process student gender/sex
          $objPhpExcel->getActiveSheet()->setCellValue('I10','SEX:');
          $objPhpExcel->getActiveSheet()->getStyle("I10")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("I10")->getFont()->setBold(true);
          // Align to the right
          $objPhpExcel->getActiveSheet()->getStyle("I10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          $objPhpExcel->getActiveSheet()->getStyle("J10")->getFont()->setSize(12);
          
          $objPhpExcel->getActiveSheet()->setCellValue('J10',$student_sex);		
          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("J10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

          // Process student combination
          // Merge the Cells that will contain the Combination
          $objPhpExcel->getActiveSheet()->mergeCells('K10:O10');
          // Get the student combination as a string
          $objPhpExcel->getActiveSheet()->getStyle("K10")->getFont()->setSize(12);
          $objPhpExcel->getActiveSheet()->getStyle("K10")->getFont()->setBold(true);

          // Align to the left
          $objPhpExcel->getActiveSheet()->getStyle("K10")
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        }
        
        $table = array("", "CODE/SUBJECT", "PAPER");
        
        $number_of_exams_counter = 0;
        
        // add the exams considered to the table array that will be used to add 
        // to the report
        foreach($report_exams as $anexamination){
        
            array_push($table,$anexamination);
            $number_of_exams_counter++;
        
        }
        
        //add AVG MK, grade, remarks and initials to the report 
        $AGRI = array("AVERAGE","GRADE","AWARD","REMARKS");
        
        foreach($AGRI as $agri){
        
            array_push($table,$agri);
        
        }
        
        // Add column headers
        $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'A12');


        // counter tells one where to start adding the inividual subjects for the student together
        // with the marks and average
        $insert_counter = 13;

        // if the number of subjects initially considered is more than 1, go ahead and 
        // create the subjects and their marks
        $report_number_of_subjects = 0;

        if  (true)  {
          // Get the students Combination
          $combination = $students_and_combinations[$report["student_id"]];
          $combination_string = "";

          foreach (["1", "2", "3", "4", "5"] as $suffix) {
            $subject_id = $combination["subject".$suffix];
            // Get the subject details using the id
            $subject = $subject_details_cache[$subject_id];
            $subject_short_name = $subject["shortsubjectname"];
            $subject_code = $subject["subjectcode"];
            $subject_full_name = $subject["fullsubjectname"];
            $subject_papers_done = $subject["papersdone"];
            $subject_is_subsidiary = $subject["issubsidiary"];

            if ($subject_is_subsidiary != true && is_string($subject_papers_done)) {
              $subject_papers_done = array_slice(
                explode("$", $subject_papers_done),
                1
              );
              $combination_string = $combination_string.$subject_short_name[0];
            }

            $final_subject_grade = $report[$subject_short_name."_finalgrade"];
            if ($subject_is_subsidiary == true) {
              $subject_papers_done = array("");
              $combination_string = $combination_string."/".$subject_short_name;
            }
            
            foreach($subject_papers_done as $paper) {
              $report_number_of_subjects++;
              $table = array();
              array_push(
                $table,
                "",
                $subject_code." ".$subject_full_name,
                (string)($paper)
              );

              foreach ($report_exams as $anexamination) {
                $amark = $this->Alevelmarksheetresult->field(
                  $subject_short_name.((string)($paper))."_mark",
                  array(
                    'exam_name' => $anexamination,
                    'year' => $reports['Alevelreportdetail']['reportyear'],
                    'student_id' => $report['student_id']
                  )
                );

                // Means we encountered a missing mark
                // So award an x
                if ($amark == 1111) {
                  $amark = "X";
                }
                array_push($table, $amark);
              }

              $grade_to_be_put = "";
          
              switch  ($report[$subject_short_name.((string)($paper))."_finalaveragemarkgrade"]) {
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

              $final_average_mark = $report[$subject_short_name.((string)($paper))."_finalaveragemark"];
              array_push(
                $table,
                $final_average_mark,
                $grade_to_be_put,
                $final_subject_grade,
                $Gradeprofile->gradeprofile_returnsubjectremark(
                  $reports['Alevelreportdetail']['reportclass'],
                  $final_average_mark
                ),
                ""
              );
              
              // Insert values from that part.
              $objPhpExcel->getActiveSheet()->fromArray($table, NULL, 'A'.$insert_counter);
              $insert_counter++;
            }

            // Merge the Cells that will contain the subject name and
            // only merge when the number of papers is more than 1
            $number_of_papers = count($subject_papers_done);
            $row_number = ($insert_counter - $number_of_papers);
            $row_nums = $this->Alevelreportdetail->getRowcount($subject_code." ".$subject_full_name);

            $final_height = $row_height_default * $row_nums;

            $row_number = ($insert_counter - $number_of_papers);

            if ($number_of_papers > 1) {
              // Increase the height uniformly over a number of rows
              $final_height_split = $final_height / $number_of_papers;

              for ($paper_counter=0; $paper_counter < $number_of_papers; $paper_counter++) {

                $row_height = $objPhpExcel->getActiveSheet()
                                ->getRowDimension($row_number + $paper_counter)
                                ->getRowHeight();

                // Means row height is set to auto so we first initialize
                // to default row height
                if ($row_height == -1) {
                  $row_height = $row_height_default;
                }

                $row_height = $row_height + $final_height_split;

                $objPhpExcel->getActiveSheet()
                  ->getRowDimension($row_number + $paper_counter)
                  ->setRowHeight($row_height);
              }
            }

            if ($number_of_papers == 1) {
              $row_height = $objPhpExcel->getActiveSheet()
                              ->getRowDimension($row_number)
                              ->getRowHeight();

              if ($row_height == -1)  {
                $row_height = $row_height_default;
              }

              $row_height = $final_height;

              $objPhpExcel->getActiveSheet()
                              ->getRowDimension($row_number)
                              ->setRowHeight($row_height);
            }

            // Merge the cells with the subject name
            $objPhpExcel->getActiveSheet()->mergeCells("B".$row_number.":"."B".($insert_counter - 1));
          
            // Wrap text in the cells with the subject name 
            $objPhpExcel->getActiveSheet()->getStyle("B".($insert_counter - $number_of_papers))
                ->getAlignment()->setWrapText(true);

            // Merge the cells with the Final grade, increase font size(if not subsidiary),
            // Center align all Contents
            $column_final_grade = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 3);
            $cell_range = $column_final_grade.$row_number.":".$column_final_grade.($insert_counter - 1);
            
            $objPhpExcel->getActiveSheet()->mergeCells($cell_range);
            $objPhpExcel->getActiveSheet()->getStyle($cell_range)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPhpExcel->getActiveSheet()->getStyle($cell_range)
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPhpExcel->getActiveSheet()->getStyle($column_final_grade.$row_number)->getFont()->setSize(24);

          }
          // Write Processed student combination
          $objPhpExcel->getActiveSheet()->setCellValue(
            'K10',"COMBINATION: ".$combination_string
          );
          
        }

        // Put boarders around the report data
        $objPhpExcel->getActiveSheet()->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).$insert_counter)
            ->applyFromArray($styleArray);
            
        //Make the heading where the code, subject and exam names are bold
        $objPhpExcel->getActiveSheet()
            ->getStyle('B12:'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 1)."12")
            ->getFont()->setBold(true);

        // Merge Cells containing the Grade Column and make width of Award column 30 pts
        $column_name_start = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 4);
        $column_name_end = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 3);
        // $objPhpExcel->getActiveSheet()
        //           ->getColumnDimension($column_name_end)
        //           ->setWidth(40);
        $objPhpExcel->getActiveSheet()->getColumnDimensionByColumn(($number_of_exams_counter+8) - 3)->setAutoSize(true);
        // $objPhpExcel->getActiveSheet()->getColumnDimensionByColumn(($number_of_exams_counter+8) - 3)->setWidth(40);
        // $objPhpExcel->getActiveSheet()
        //           ->mergeCells(
        //             $column_name_start."11".":".$column_name_end."11"
        //           );
        
        // Set label of cell containing total points
        $objPhpExcel->getActiveSheet()->setCellValue($column_name_start.$insert_counter,"TOTAL POINTS:");
        // Align contents to the right 
        $objPhpExcel->getActiveSheet()->getStyle($column_name_start.$insert_counter)
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        //set the total points
        $column_name_start = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 5);
        $column_name_end = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 4);
        $column_name_total_points = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 3);
        
        // Merge Cells containing the total points label
        $objPhpExcel->getActiveSheet()->mergeCells(
          $column_name_start.$insert_counter.":".$column_name_end.$insert_counter
        );
        
        // Set label of cell containing total points
        $objPhpExcel->getActiveSheet()->setCellValue($column_name_start.$insert_counter,"TOTAL POINTS:");
        // Align contents to the right 
        $objPhpExcel->getActiveSheet()->getStyle($column_name_start.$insert_counter)
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPhpExcel->getActiveSheet()->setCellValue($column_name_total_points.$insert_counter,(string)$report['totalpoints']);
        $objPhpExcel->getActiveSheet()->getStyle($column_name_total_points.$insert_counter)
                  ->getAlignment()
                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set the formating to include 0 before it
        $objPhpExcel->getActiveSheet()->getStyle($column_name_total_points.$insert_counter)->getNumberFormat()->setFormatCode("00");
        
        // set the total points label and contents to bold
        $objPhpExcel->getActiveSheet()
            ->getStyle($column_name_start.$insert_counter.":".$column_name_total_points.$insert_counter)
            ->getFont()->setBold(true);
                          
        //Wrap the text for the subjects codes, names and paper and center values in cells
        // $objPhpExcel->getActiveSheet()->getStyle('B12'.':'.'C'.($insert_counter-1))
        //         ->getAlignment()->setWrapText(true);
        $objPhpExcel->getActiveSheet()->getStyle('B13'.':'.'C'.($insert_counter-1))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPhpExcel->getActiveSheet()->getStyle('B13'.':'.'C'.($insert_counter-1))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Modify width of remarks column
        $column_name = PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+8) - 2);
        $objPhpExcel->getActiveSheet()
                      ->getColumnDimension($column_name)
                      ->setAutoSize(true);
        
        // Create a row to separate Subjects and their performance from the rest
        $insert_counter++;

        // Set the grading scheme
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+1),"Grading scheme:");
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+1))->getFont()->setUnderline(true);
        
        //Award the grading schemes
        $report_class = (int)$reports['Alevelreportdetail']['reportclass'];
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
        $objPhpExcel->getActiveSheet()->setCellValue(
          'B'.($insert_counter+7),
          is_null($headteacher_name)?"":$headteacher_name
        );
        //Align the Name to the center
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Wrap the cell text
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))
                ->getAlignment()
                ->setWrapText(True);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+7))->getFont()->setSize(12);				
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
        //Name of the class teacher
        $objPhpExcel->getActiveSheet()->setCellValue('B'.($insert_counter+10),$classteachertitle." ".$classteachername);
        //Align the Name to the center
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Wrap the cell text
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+10))
                ->getAlignment()
                ->setWrapText(True);
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
        //Name of the House master / House mistress		
        if($student_sex == "F"){
            $objPhpExcel->getActiveSheet()->setCellValue(
              'B'.($insert_counter+13),
              is_null($dorm_mistress_name)? "": $dorm_mistress_name
            );
        }
        if($student_sex == "M"){
            $objPhpExcel->getActiveSheet()->setCellValue(
              'B'.($insert_counter+13),
              is_null($dorm_master_name)? "": $dorm_master_name
            );
        }

        //Align the Name to the center
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Wrap the cell text
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))
                ->getAlignment()
                ->setWrapText(True);
        //Set the comment font size to 12
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+13))->getFont()->setSize(12);
        //The House mistress/House master comment section
        if($student_sex == "F"){
            $objPhpExcel->getActiveSheet()->setCellValue('D'.($insert_counter+12),"House Mistress's comment");
        }
        if ($student_sex == "M"){
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
        
        //Add the school logo to the end of the report and center align it
        $objPhpExcel->getActiveSheet()->mergeCells('B'.($insert_counter+15).':'.PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 1).($insert_counter+15));
        $objPhpExcel->getActiveSheet()->setCellValue(
          'B'.($insert_counter+15),
          is_null($school_motto)? "": $school_motto
        );
        $objPhpExcel->getActiveSheet()->getStyle('B'.($insert_counter+15))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        
        //Auto resize the remarks section to fit certain remarks
        $objPhpExcel->getActiveSheet()
              ->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(($number_of_exams_counter+7) - 2))->setAutoSize(true);
        
        // Change the font size of each of the subject names to ten
        $subject_name_number = 0;
        
        while ($subject_name_number <= $report_number_of_subjects)  {
        
            $objPhpExcel->getActiveSheet()->getStyle("C13:"."C".$insert_counter)->getFont()->setSize(10);
            $subject_name_number++;
        }
        
        // Set the document to fit strictly on one page 
        $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPhpExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
      
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
            $objPhpExcel->getActiveSheet()->getCell('I9')->getValue()
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
        $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']. " " .
                      $reports['Alevelreportdetail']['reportname']. " " .
                      $reports['Alevelreportdetail']['reportterm']. " - " .
                      $reports['Alevelreportdetail']['reportyear']. " - ".
                      'Report'." - " .'Head Teacher Comment file'.'.xlsx','Excel2007');
      }
        
      if($mode == "2"){
        $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']." ".$streamchosenbyclassteacher. " - " .
                      $reports['Alevelreportdetail']['reportname']. " " .
                      $reports['Alevelreportdetail']['reportterm']. " - " .
                      $reports['Alevelreportdetail']['reportyear']. " - ".
                      'Report'." - " .'Class Teacher Comment file'.'.xlsx','Excel2007');    
      }
        
      if($mode == "3"){
        $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']. " " .
                      $reports['Alevelreportdetail']['reportname']. " " .
                      $reports['Alevelreportdetail']['reportterm']. " - " .
                      $reports['Alevelreportdetail']['reportyear']. " - ".
                      'Report'." - " .'Warden Comment file'.'.xlsx','Excel2007');    
      }
        
      if($mode == "4"){
        $objPhpExcel->output("S".$reports['Alevelreportdetail']['reportclass']. " " .
                      $reports['Alevelreportdetail']['reportname']. " " .
                      $reports['Alevelreportdetail']['reportterm']. " - " .
                      $reports['Alevelreportdetail']['reportyear']. " - ".
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
	
    $commentfile = $reports['Alevelreportdetail']['reportclass']. " " .
                    $reports['Alevelreportdetail']['reportname']. " " .
                    $reports['Alevelreportdetail']['reportterm']. " - " .
                    $reports['Alevelreportdetail']['reportyear'];

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
		$this->Alevelreportdetail->id = $id;
		//$shortsubjectnametobedeleted = $shortsubjectname;
		if (!$this->Alevelreportdetail->exists()) {
			throw new NotFoundException(__('Invalid Report'));
		}
		
		$this->loadModel("Alevelreport");
		$numberofcomments = $this->Alevelreport->find(
      'count',
      array(
		    //'fields' => array(''),
		    'conditions' => array(
          'alevelreportdetail_id' => $id,
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
		
		if($numberofcomments>0){
		
		    $this->Session->setFlash(__('This report cannot be deleted because it contains some comments'));
		
		}else{
		
		    if ($this->Alevelreportdetail->delete()) {
		
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
		$this->Alevelreportdetail->id = $report_id;
		//$shortsubjectnametobedeleted = $shortsubjectname;
		if (!$this->Alevelreportdetail->exists()) {
			throw new NotFoundException(__('Invalid Report'));
		}
		
		if($update_flag == "1"){
		
		    $this->Alevelreportdetail->updateReport($report_id,1);
		    
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

    $errors = [];

	  if ($this->request->is('Post')){
      if ($this->request->data['uploadData'] != "alevelstudentreports"){
        
      }

      // Validate sent files
      if (is_array($this->request->data['uploadedfiles'])){
        foreach($this->request->data['uploadedfiles'] as $key => $value) {
          if ($value['error'] != 0) {
            if (array_key_exists($value["name"], $errors)){
              $errors[$value["name"]]["upload_error"] = "Something went wrong during upload";
            }else{
              $errors[$value["name"]] = array("upload_error" => "Something went wrong during upload");
            }
          }
          if (strcmp($value['type'], "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") != 0) {
            if (array_key_exists($value["name"], $errors)){
              $errors[$value["name"]]["type_error"] = "Wrong file type, must be an xlxs file";
            }else{
              $errors[$value["name"]] = array("type_error" => "Wrong file type, must be an xlxs file");
            }
          }

          $file = $value['tmp_name'];
	    
          //load the worksheet from a file
          //Read spreadsheeet workbook
          try {
            $objPhpExcel = $this->PhpExcel->loadWorksheet($file);
          } catch(Exception $e) {
            die($e->getMessage());
            if (array_key_exists($value["name"], $errors)){
              $errors[$value["name"]]["loading_error"] = "Unable to load file";
            }else{
              $errors[$value["name"]] = array("loading_error" => "Unable to load file");
            }
          }
		
          $avaluethathasbeenhacked = null;
          $thehack;
      
          Security::setHash('blowfish');

          //Check if all the cells have been hashed according to how you wanted initially
          foreach ($objPhpExcel->getWorksheetIterator() as $worksheetNbr => $worksheet) {

            $cellsthatwerehashed = $worksheet->getCell('B11')->getValue().
                $worksheet->getCell('C11')->getValue().
                $worksheet->getCell('I9')->getValue();
          
            $hashedmatch = (Security::hash($cellsthatwerehashed,'blowfish',$worksheet->getCell('D11')->getValue()) === $worksheet->getCell('D11')->getValue());

            if($hashedmatch != true) {
              $avaluethathasbeenhacked = 2;
              break;
            }

          }
		
          if($avaluethathasbeenhacked == 2){
          
            if (array_key_exists($value["name"], $errors)){
              $errors[$value["name"]]["sheet_error"] = "Sheet has been tampered with, Invalid cell values on sheet";
            }else{
              $errors[$value["name"]] = array("sheet_error" => "Sheet has been tampered with, Invalid cell values on sheet");
            }
          
          }

          if($value['size'] == 0){
            if (array_key_exists($value["name"], $errors)){
              $errors[$value["name"]]["size_error"] = "File cannot be empty";
            }else{
              $errors[$value["name"]] = array("size_error" => "File cannot be empty");
            }
          }
        }
      }

      if(count($errors) == 0){
        foreach($this->request->data['uploadedfiles'] as $key => $value) {

          $file = $value['tmp_name'];
      
          //load the worksheet from a file
          //Read spreadsheeet workbook
          try {
            $objPhpExcel = $this->PhpExcel->loadWorksheet($file);
          } catch(Exception $e) {
            die($e->getMessage());
            $this->Session->setFlash(__("An error occurred during file loading"));
          }

          $final_data = [];
          // reports
          foreach ($objPhpExcel->getWorksheetIterator() as $worksheetNbr => $worksheet) {

            $who_is_commenting = $worksheet->getCell('B11')->getValue();
            $were_2_extract_cmmnt_from = $worksheet->getCell('C11')->getValue();
            $the_rptid_2_pt_de_cmmnt_on = $worksheet->getCell('I9')->getValue();
            $the_sex_of_student = $worksheet->getCell('E10')->getValue();
            $thecomment = $worksheet->getCell($were_2_extract_cmmnt_from)->getValue();
      
            if($who_is_commenting == "H"){
            
              array_push($final_data, array(
                  'Alevelreport' => array(
                'id' => $the_rptid_2_pt_de_cmmnt_on,
                'headteacherscomment' => $thecomment				    
                  )
                )
              );

            }
      
            if($who_is_commenting == "C"){
            
              array_push($final_data, array(
                  'Alevelreport' => array(
                'id' => $the_rptid_2_pt_de_cmmnt_on,
                'classteacherscomment' => $thecomment				    
                  )
                )
              );
            
            }
      
            if($who_is_commenting == "W"){
            
              array_push($final_data, array(
                  'Alevelreport' => array(
                'id' => $the_rptid_2_pt_de_cmmnt_on,
                'dormmasterscomment' => $thecomment				    
                  )
                )
              );
            
            }
      
            if($who_is_commenting == "M"){
            
              array_push($final_data, array(
                  'Alevelreport' => array(
                'id' => $the_rptid_2_pt_de_cmmnt_on,
                'dormmistresscomment' => $thecomment				    
                  )
                )
              );

            }

          }
          $this->Alevelreport->saveMany($final_data);
        }
        $this->Session->setFlash(__("Commenting Successfull"));
      }else{
        $this->Session->setFlash(__("Errors occured while validating files. Please reupload the correct files.<br/>"));
        foreach($errors as $key => $value) {
          $error_string = "Errors occured while processing file: `".$key."`<br/>Errors: <br/>";
          $error_counter=1;
          foreach($value as $key2 => $value2){
            $error_string=$error_string.($error_counter++).". ". $value2."<br/>";
          }
          $this->Session->setFlash(__($error_string));
        }
      }
	  }
	  $this->render('up_load_data');
  }

    public function createcolumn($columnname){
    
	$this->layout = 'default2';
	// load the model with the data
	$new = ClassRegistry::init('Alevelmarksheetresult');

	// perform a query using the model you loaded
	$livequery = $new->query("DESCRIBE olevelmarksheetresults;");
    }
}
