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
class SchooldoneasubjectsController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');

    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Schooldoneasubject' => array (
	    'paramType' => 'querystring',
	    'limit' => 10,
	    'order' => array(
	      'Schooldoneasubject.id' => 'desc'
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
	    'q' => $this->request->data('Schooldoneasubject.searchQuery')
	  )
	));
      }
      $this->Schooldoneasubject->recursive = 0;
      $searchQuery = $this->request->query('q');
      $this->Paginator->settings = array(
	'Schooldoneasubject' => array(
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
	    
	    $no_of_subjects_already_entered = $this->Schooldoneasubject->find('count',array(
	    
		'conditions' => array('Schooldoneasubject.id !=' => null)
	    
	    ));
	    
	    if(($no_of_subjects_already_entered >= 42) ){
		$this->Session->setFlash(__('You can only create up to a maximum of 42 Advanced level subjects'));
		return $this->redirect(array('action' => 'index'));
	    
	    }else {
	    
	    $bothoptionschosen = null;
	    $subjectpapers = null;
	    $subsidiary_option_chosen = null;
	    if (!empty($this->request->data)) {
	    
		
	    
		if ($this->request->is(array('post','put'))) {
			if( (($this->request->data['Schooldoneasubject']['issubsidiary']) ||
			    ($this->request->data['Schooldoneasubject']['papersdone']))
			){
			
			
			    // if the subsidiary subject option is checked and some papers are chosen
			    if($this->request->data['Schooldoneasubject']['issubsidiary'] &&
				$this->request->data['Schooldoneasubject']['papersdone']
			    ){
		
				$this->Session->setFlash(__('You cannot choose both the Subsidiary Subject 
				    option and a set of subject papers'));
				
				if(is_array($this->request->data['Schooldoneasubject']['papersdone'])){
				    
				    $bothoptionschosen = 1;
				    $subjectpapers = $this->request->data['Schooldoneasubject']['papersdone'];
				    //$subjectpapers = explode("$",$this->request->data['Schooldoneasubject']['papersdone']);
				}
				//$this->render('add');
		
			    } else {
			
				$newsubjectname = $this->request->data['Schooldoneasubject']['shortsubjectname'];
				$this->Schooldoneasubject->create();
				//unset($this->Staffdetail->Previousworkplace->validate['staffdetail_id']);
				//unset($this->request->data['Schooldoneasubject']['papersdone']);
			
				$value2 = null;
				$subjectpapers = null;
			

			
				if($this->request->data['Schooldoneasubject']['issubsidiary'] == "1"){
			
				    unset($this->request->data['Schooldoneasubject']['papersdone']);
				    $subsidiary_option_chosen = 1;

				}else {
			
			    
			
				    if(is_array($this->request->data['Schooldoneasubject']['papersdone'])){
			    
					foreach($this->request->data['Schooldoneasubject']['papersdone'] as $key => $value){
			    
					    $value2 = $value2."$".$value; 
				    
					}
			    
				    }
			
				    if($value2 != null){
			
					$this->request->data['Schooldoneasubject']['papersdone'] = $value2;
					$subjectpapers = explode("$",$value2);
					unset($subjectpapers[0]);
				    }
				}
			
				if ($this->Schooldoneasubject->save($this->request->data)) {
			
					if($value2 != null){
				
					    $this->Schooldoneasubject->addColumninTable($newsubjectname,$subjectpapers,null);
				    
					}else{
					
					    $this->Schooldoneasubject->addColumninTable($newsubjectname,$subjectpapers,$subsidiary_option_chosen);
					
					}
				
					$this->Session->setFlash(__('The Subject details have been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The Subject details could not be saved. Please, try again.'));
				}
			    }
			    
			  } else {
	    
				  $this->Session->setFlash(__('Choose the Subsidiary Subject option or Choose atleast one subject
				    paper'));
				  $this->render('add');
	    
			  }
		}
		

	    }
	    if($bothoptionschosen == 1){
		
		    $this->set('selectedoptions',$subjectpapers);
		
	    }else{
		
		    $this->set('selectedoptions','none');
		
	    }//$this->set('selectedoptions','none');
	    
	    }
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
	$this->layout = 'default2';	
	if (!$id){
	    throw new NotFoundException(__('Invalid Subject'));
	}
	
	
	$staff = $this->Schooldoneasubject->findById($id);
	
	if (!$staff){
	    throw new NotFoundException(__('Invalid Subject'));
	}

	//The last saved information of the subject ie. shortsubjectname, issubsidiary, papersdone
	$shortsubjectnametobemodified = $staff['Schooldoneasubject']['shortsubjectname'];
	$subjectpaperissubsidiary = $staff['Schooldoneasubject']['issubsidiary'];
	$subjectpapers = $staff['Schooldoneasubject']['papersdone'];
	if($subjectpaperissubsidiary == 0){
	
	    $subjectpapers = explode("$",$subjectpapers);
	    unset($subjectpapers[0]);
	    
	}else {
	
	    $subjectpapers = array();
	
	}
	
	
	if ($this->request->is(array('post', 'put'))){
	
 
	    $this->Schooldoneasubject->id = $id;
	    //unset($this->Gradeprofile->Grading->validate['Gradeprofile_id']);
	    
	    $value2 = null;
	    $subjectpaperstobechanged = array();
	    $currentlydonesubjectpapers = null;
	    $subjectpaperstoremove = array();
	    $subjectpaperstoadd = array();
	    $subjectpaperstochange = array();
	    $subject_was_sub_before = null;
	    if( ($this->request->data['Schooldoneasubject']['issubsidiary']) ||
		($this->request->data['Schooldoneasubject']['papersdone'])
	    ){
	    
		// if the subsidiary subject option is checked and some papers are chosen
		if($this->request->data['Schooldoneasubject']['issubsidiary'] &&
		   $this->request->data['Schooldoneasubject']['papersdone']
		){
		
		    $this->Session->setFlash(__('Please choose the Subsidiary Subject 
			  option only or a set of subject papers only'));
		    $subjectpapers = $this->request->data['Schooldoneasubject']['papersdone'];
		    //$this->render('edit');
		
		} else {
		
	    
		    if($this->request->data['Schooldoneasubject']['issubsidiary'] == "1"){
			
			// converting from principal subject to subsidary subject
			//(the subject was not a subsidiary subject before)
			if(($subjectpaperissubsidiary == 0)
			){
			    
				// Check if results are in atleast one subjectpaper of the Alevelmarksheetresult and Alevelreport table
				if(($this->Schooldoneasubject
					->checkIfResultsAreInatleastaColumn($subjectpapers,
									$shortsubjectnametobemodified)) == true){
								    
					$this->Session->setFlash(__('Cannot convert subject into a subsidiary because
					some papers already have results'));
					return $this->redirect(array('action' => 'edit', $id));
				}else {
				    
				    // step 1: First delete the subjects that exist already
				    // step 2: Do a save of the information on the form
				    // step 3: Add the subjects that the user has selected to the marksheet and report table
				    
				    
				    // Step 1
				    $papers_currently_done = $staff['Schooldoneasubject']['papersdone'];
				    $papers_currently_done = explode("$",$papers_currently_done);
				    unset($papers_currently_done[0]);
				    $this->Schooldoneasubject->deleteColumninTable($shortsubjectnametobemodified,$papers_currently_done,0);
				    
				    
				    $newsubjectname = $this->request->data['Schooldoneasubject']['shortsubjectname'];
				    
				    if(is_array($this->request->data['Schooldoneasubject']['papersdone'])){
			    
					foreach($this->request->data['Schooldoneasubject']['papersdone'] as $key => $value){
			    
					    $value2 = $value2."$".$value; 
			    
					}
			    
				    }
			
				    if($value2 != null){
			
					$this->request->data['Schooldoneasubject']['papersdone'] = $value2;
					$subjectpaperstobechanged = explode("$",$value2);
					unset($subjectpaperstobechanged[0]);
				    }
				    
				    // Step 2
				    if ($this->Schooldoneasubject->save($this->request->data)){
				    
					//Step 3
					$this->Schooldoneasubject->addColumninTable($newsubjectname,$subjectpaperstobechanged,1);
		    
					$this->Session->setFlash(__('Subject Details have been updated successfully'));
					return $this->redirect(array('action' => 'index'));
		    
				    }else{
				    
					    $this->Session->setFlash(__('Subject Details could not be updated successfully'));
					    return $this->redirect(array('action' => 'index'));
				    
				    }
				    
				    
				}
			    
			}else{
			// converting 
			    
			
			}
			
			unset($this->request->data['Schooldoneasubject']['papersdone']);
			
		    }else {
		
			if(is_array($this->request->data['Schooldoneasubject']['papersdone'])){
			    
			    foreach($this->request->data['Schooldoneasubject']['papersdone'] as $key => $value){
			    
				$value2 = $value2."$".$value; 
			    
			    }
			    
			}
			
			if($value2 != null){
			
			    $this->request->data['Schooldoneasubject']['papersdone'] = $value2;
			    $subjectpaperstobechanged = explode("$",$value2);
			    unset($subjectpaperstobechanged[0]);
			}
		    }
		    
		    // if the paper was not a subsidary before and a set of subject papers has been chosen
		    // perform the if operation
		    if( ($subjectpaperissubsidiary == 0) &&
			($this->request->data['Schooldoneasubject']['issubsidiary'] != "1")
		      ) {
	      
			  //these are the subject papers to be removed from the existing
			  $subjectpaperstoremove = array_diff($subjectpapers,$subjectpaperstobechanged);
		    
			  //these are the subject papers to be added to the existing
			  $subjectpaperstoadd = array_diff($subjectpaperstobechanged,$subjectpapers);
		  
			  //these are the subject papers that existed before and the user has again
			  //selected them
			  $subjectpaperstochange = array_intersect($subjectpaperstobechanged,$subjectpapers);
		    }
	    
		    // Converting a subject which was subsidary before to one with papers now
		    if(
			($subjectpaperissubsidiary == 1) &&
			(($this->request->data['Schooldoneasubject']['issubsidiary'] != "1"))
		    ){
	    
			  if($this->Schooldoneasubject->checkIfResultsAreInColumn("",$shortsubjectnametobemodified) == true){
			  
			      $this->Session->setFlash(__('Cannot convert subsidiary paper to principal paper because
					results already exist for the subsidiary paper'));
					return $this->redirect(array('action' => 'edit', $id));
			  
			  }else{
			      //these are the subject papers to be removed from the existing
			      //$subjectpaperstoremove = array_diff($subjectpapers,$subjectpaperstobechanged);
		    
			      //these are the subject papers to be added to the existing
			      $subjectpaperstoadd = array_diff($subjectpaperstobechanged,$subjectpapers);
		  
			      //these are the subject papers that existed before and the user has again
			      //selected them
			      //$subjectpaperstochange = array_intersect($subjectpaperstobechanged,$subjectpapers);
			      $subject_was_sub_before = 1;
			  }
	    
		    }
	    
	    
		    $modifiedshortsubjectname = $this->request->data['Schooldoneasubject']['shortsubjectname'];
	    
		    if($shortsubjectnametobemodified != null && $modifiedshortsubjectname != null){
	    
			if ($this->Schooldoneasubject->save($this->request->data)){ 
		
			    if ($this->request->data['Schooldoneasubject']['issubsidiary'] != "1") {
		    
				if($subjectpaperissubsidiary == 0){
				    
				    $this->Schooldoneasubject
					->alterColumninTable($shortsubjectnametobemodified,
						    $modifiedshortsubjectname,
						    $subjectpaperstoremove,
						    $subjectpaperstoadd,
						    $subjectpaperstochange,$subject_was_sub_before
						  );
						  
				}else{
				
				    $this->Schooldoneasubject
					->alterColumninTable($shortsubjectnametobemodified,
						    $modifiedshortsubjectname,
						    $subjectpaperstoremove,
						    $subjectpaperstoadd,
						    $subjectpaperstochange,$subject_was_sub_before
						  );
				
				}
		    
			    } else {
		    
			    }
		    
			    $this->Session->setFlash(__('Subject Details have been updated successfully'));
			    return $this->redirect(array('action' => 'index'));
		    
			}
		
		
		    }
		    $this->Session->setFlash(__('Unable to update Subject details.'));
		 }
	    } else {
	    
		$this->Session->setFlash(__('Choose the Subsidiary Subject option only or Choose atleast one subject
				    paper'));
		$this->render('edit');
	    
	    }
	}

	if (!$this->request->data){
	    $this->request->data = $staff;
	}
	

	if($subjectpapers != null){
	
	    $this->set('selectedoptions',$subjectpapers);
	
	}else{
	
	    $this->set('selectedoptions','none');
	
	}
	
	$this->set('staffrecords',$staff);
	
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null, $shortsubjectname = null) {
		$this->layout = 'default2';
		$this->Schooldoneasubject->id = $id;
		$shortsubjectnametobedeleted = $shortsubjectname;
		if (!$this->Schooldoneasubject->exists()) {
			throw new NotFoundException(__('Invalid subject'));
		}
		
		$this->request->allowMethod('post', 'delete');
		$shortsubjectnamefound = $this->Schooldoneasubject->findAllByShortsubjectname($shortsubjectnametobedeleted);
		
		$this->loadModel('Alevelmarksheetresult');
		
		/*$papersdone = $this->Schooldoneasubject->find('all', array(
				      'fields' => array('Alevelmarksheetresult.papersdone'),
				      'conditions' => array('Alevelmarksheetresult.id =' => $id),
				      'recursive' => 0
				  ));
		*/
		$papersdone = $this->Schooldoneasubject->field('papersdone',
			    array('id =' => $id)
			);
		$is_subsidiary = $this->Schooldoneasubject->field('issubsidiary',
			    array('id =' => $id)
			);
		$is_subsidiary = intval($is_subsidiary);
		
		
		$subjectpaperstobechanged = explode("$",$papersdone);
		
		$subjectsdoneintheschool = $this->Alevelmarksheetresult->find('first', array(
			      'fields' => array('Alevelmarksheetresult.'.$shortsubjectname."_finalgrade"),
			      'conditions' => array('Alevelmarksheetresult.'.$shortsubjectname.'_finalgrade'.' >=' => 0),
			      //'recursive' => 0
		));
		
		if($subjectsdoneintheschool != null){
		    $this->Session->setFlash(__('Sorry, the subject cannot be deleted because some students have marks entered for it'));
		}else{
		
		    if($shortsubjectnamefound[0]['Schooldoneasubject']['shortsubjectname'] != null){
			if ($this->Schooldoneasubject->delete()) {
				$this->Schooldoneasubject->deleteColumninTable($shortsubjectnametobedeleted,$subjectpaperstobechanged,$is_subsidiary);
				$this->Session->setFlash(__('Subject details have been deleted.'));
			} else {
				$this->Session->setFlash(__('Subject details could not be deleted. Please, try again.'));
			}
		    }else{
			$this->Session->setFlash(__('Subject details could not be deleted because they do not exist. Please, try again.'));
		    }
		
		}
		return $this->redirect(array('action' => 'index'));
    }

    public function createcolumn($columnname){
	$this->layout = 'default2';
	// load the model with the data
	$new = ClassRegistry::init('Alevelmarksheetresult');

	// perform a query using the model you loaded
	$livequery = $new->query("DESCRIBE Alevelmarksheetresults;");
    }
}
