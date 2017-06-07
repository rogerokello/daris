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
class SchooldonesubjectsController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');

    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Schooldonesubject' => array (
	    'paramType' => 'querystring',
	    'limit' => 10,
	    'order' => array(
	      'Schooldonesubject.id' => 'desc'
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
	    'q' => $this->request->data('Schooldonesubject.searchQuery')
	  )
	));
      }
      $this->Schooldonesubject->recursive = 0;
      $searchQuery = $this->request->query('q');
      $this->Paginator->settings = array(
	'Schooldonesubject' => array(
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
	    if (!empty($this->request->data)) {
		if ($this->request->is('post')) {
			$newsubjectname = $this->request->data['Schooldonesubject']['shortsubjectname'];
			$this->Schooldonesubject->create();
			//unset($this->Staffdetail->Previousworkplace->validate['staffdetail_id']);
			if ($this->Schooldonesubject->save($this->request->data)) {
				$this->Schooldonesubject->addColumninTable($newsubjectname);
				$this->Session->setFlash(__('The Subject details have been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The Subject details could not be saved. Please, try again.'));
			}
		}
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
	
	
	$staff = $this->Schooldonesubject->findById($id);
	
	if (!$staff){
	    throw new NotFoundException(__('Invalid Subject'));
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
		$this->Schooldonesubject->id = $id;
		$shortsubjectnametobedeleted = $shortsubjectname;
		if (!$this->Schooldonesubject->exists()) {
			throw new NotFoundException(__('Invalid subject'));
		}
		
		$this->request->allowMethod('post', 'delete');
		$shortsubjectnamefound = $this->Schooldonesubject->findAllByShortsubjectname($shortsubjectnametobedeleted);
		
		$this->loadModel('Olevelmarksheetresult');
		
		$subjectsdoneintheschool = $this->Olevelmarksheetresult->find('first', array(
			      'fields' => array('Olevelmarksheetresult.'.$shortsubjectname),
			      'conditions' => array('Olevelmarksheetresult.'.$shortsubjectname.' >=' => 0),
			      //'recursive' => 0
		));
		
		if($subjectsdoneintheschool != null){
		    $this->Session->setFlash(__('Sorry, the subject cannot be deleted because some students have marks entered for it'));
		}else{
		
		    if($shortsubjectnamefound[0]['Schooldonesubject']['shortsubjectname'] != null){
			if ($this->Schooldonesubject->delete()) {
				$this->Schooldonesubject->deleteColumninTable($shortsubjectnametobedeleted);
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

    /*
    public function createcolumn($columnname){
	$this->layout = 'default2';
	// load the model with the data
	$new = ClassRegistry::init('Olevelmarksheetresult');

	// perform a query using the model you loaded
	$livequery = $new->query("DESCRIBE olevelmarksheetresults;");
    }*/
}
