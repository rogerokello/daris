<?php
App::uses('Folder','Utility');
App::uses('Files','Utility');
App::uses('AppController', 'Controller');
/*
* Staffdetails Controller
*
* @property Staffdetail $Staffdetail
* @property PaginatorComponent $Paginator
* @property SessionComponent $Session
*/
class OlevelreportdetailsController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');

    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Olevelreportdetail' => array (
	    'paramType' => 'querystring',
	    'limit' => 10,
	    'order' => array(
	      'id' => 'desc'
	    )
	  )
	);
	$this->set('students', $this->Paginator->paginate());
	/*$students = $this->Student->find(
				      'all', 
				      array('order' => 'Student.id DESC', 'group' => 'Student.id')
					);
	$this->set('students', $students);
	*/
    }
    
    public function search() {
      $this->layout = 'default2';
      if ($this->request->is('put') || $this->request->is('post')) {
	// poor man's Post Redirect Get behavior
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
* Components
*
* @var array
*/
	//public $components = array('Paginator', 'Session');

/**
* index method
*
* @return void
*/

/*
	public function index() {
		$this->Staffdetail->recursive = 0;
		$this->set('staffdetails', $this->Paginator->paginate());
	}

	
*/

/**
* add method
*
* @return void
*/
    public function add() {
	    $this->layout = 'default2';
	    $this->loadModel('Schooldoneexam');
	    $this->loadModel('Schooldonesubject');
	    //$this->loadModel('Olevelreport');
	    //$this->loadModel('Schoolstream');
	    ///*
	    if (!empty($this->request->data)) {
		
		if ($this->request->is('post')) {
			
			$this->request->data['reportname'] = strtoupper(trim($this->request->data['reportname']));
			$reportname = $this->request->data['reportname'];
			$class = $this->request->data['class'];
			$term = $this->request->data['term'];
			$subjects = $this->request->data['subject']; // This is an array
			$examtoenter = $this->request->data['examtoenter']; // This is an array
			$year = $this->request->data['year'];
			
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

			    $students_in_that_class = $this->Student->find('all', array(
				  'fields' => array('Student.id','Student.currentstream'),
				  'conditions' => array(
							'Student.currentclass =' => $class,
							'Student.leavingreason' => "None"						    
							),
				  //'recursive' => 0
			    ));
			
			    $madereport = $this->Olevelreportdetail->find('list', array(
				  'fields' => array('Olevelreportdetail.id', 'Olevelreportdetail.reportname'),
				  'conditions' => array(
				      'Olevelreportdetail.reportname =' => $reportname,
				      'Olevelreportdetail.reportterm =' => $term,
				      'Olevelreportdetail.reportyear =' => $year,
				      'Olevelreportdetail.reportclass =' => $class,
				  )
			    ));
			
			    if ( ($madereport == null) && (count($students_in_that_class) > 0) ){
			
				$data = array(
				    'Olevelreportdetail' => array(
					'reportname' => $reportname,
					'reportterm' => $term,
					'reportyear' => $year,
					'reportclass' => $class,
				    )
				);
			    
				if ( $this->Olevelreportdetail->save($data) ) {
				    $reportdetail_id = $this->Olevelreportdetail->field('id',array(
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
				    
					foreach ( $subjects as $subject ) {
				    
					    $exams_considered_for_subject = $subject.'_examsconsidered';
					    $data['Olevelreport'][$exams_considered_for_subject] = $examsdone;
				    
					}
				    
				    
					$this->Olevelreport->save($data);
					$number_of_student_reports_created++;
					//Olevelmarksheetresult::save($data);				
			    
				    }
				
				//$this->set('data',$data);
				if($number_of_student_reports_created == $number_of_students_reports_to_create){
				
				    $this->Olevelreport->report_add_examsconsidered($reportdetail_id,null);
				    $this->Olevelreport->report_gradesubjects($reportdetail_id,null);
				    $this->Olevelreport->report_get_total_mark($reportdetail_id,null);
				    $this->Olevelreport->report_getaggregates($reportdetail_id);
				    $this->Olevelreport->report_getdivision($reportdetail_id);
				    $this->Session->setFlash(__('Successfully created '.$number_of_students_reports_to_create.' reports'));
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
    }

/**
* edit method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
    public function edit($id = null) {
	/*	
	if (!$id){
	    throw new NotFoundException(__('Invalid Report'));
	}
	
	
	$staff = $this->Olevelreportdetail->findById($id);
	
	if (!$staff){
	    throw new NotFoundException(__('Invalid Report'));
	}

	$shortsubjectnametobemodified = $staff['Schooldonesubject']['shortsubjectname'];
	
	if ($this->request->is(array('post', 'put'))){
	    $this->Schooldonesubject->id = $id;
	    //unset($this->Gradeprofile->Grading->validate['Gradeprofile_id']);
	    $modifiedshortsubjectname = $this->request->data['Schooldonesubject']['shortsubjectname'];
	    
	    if($shortsubjectnametobemodified != null && $modifiedshortsubjectname != null){
		if ($this->Schooldonesubject->save($this->request->data)){ 
		    $this->Schooldonesubject->alterColumninTable($shortsubjectnametobemodified,$modifiedshortsubjectname);
		    $this->Session->setFlash(__('Subject Details have been updated successfully'));
		    return $this->redirect(array('action' => 'index'));
		}
	    }
	    $this->Session->setFlash(__('Unable to update Subject details.'));
	}

	if (!$this->request->data){
	    $this->request->data = $staff;
	}
	

	$this->set('staffrecords',$staff);
	
	*/
	
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
		
		$this->request->allowMethod('post', 'delete');

		if ($this->Olevelreportdetail->delete()) {
		
			$this->Session->setFlash(__('All the details for the selected report have been deleted.'));
				
		} else {
		
			$this->Session->setFlash(__('Subject details could not be deleted. Please, try again.'));
			
		}
		
		return $this->redirect(array('action' => 'index'));
    }
    
    public function updateReports($report_id){
		$this->layout = 'default2';
		$this->Olevelreportdetail->id = $report_id;
		//$shortsubjectnametobedeleted = $shortsubjectname;
		if (!$this->Olevelreportdetail->exists()) {
			throw new NotFoundException(__('Invalid Report'));
		}
		
		$this->Olevelreportdetail->updateReport($report_id);
		
		$this->Session->setFlash(__('All the details for the selected report have been updated.'));
		return $this->redirect(array('action' => 'index'));
    
    }

    public function createcolumn($columnname){
    
	$this->layout = 'default2';
	// load the model with the data
	$new = ClassRegistry::init('Olevelmarksheetresult');

	// perform a query using the model you loaded
	$livequery = $new->query("DESCRIBE olevelmarksheetresults;");
    }
}
