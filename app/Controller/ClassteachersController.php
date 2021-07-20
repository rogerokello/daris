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
class ClassteachersController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');

    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Classteacher' => array (
	    'paramType' => 'querystring',
	    'limit' => 10,
	    'order' => array(
	      'Classteacher.id' => 'desc'
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
	    'q' => $this->request->data('Classteacher.searchQuery')
	  )
	));
      }
      $this->Classteacher->recursive = 0;
      $searchQuery = $this->request->query('q');
      $this->Paginator->settings = array(
	'Classteacher' => array(
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
			
		$this->Classteacher->create();
			
		if ($this->Classteacher->save($this->request->data)) {
				
			$this->Session->setFlash(__('The Class teachers details have been saved.'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('The Class teachers details could not be saved. Please, try again.'));
		}
	    }
	}
	
	$this->loadModel("Schoolstream");
	
	$streams = $this->Schoolstream->find('list',array(
		  'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),	
	));
	
	$this->set('streams',$streams);
	
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id) {
	$this->layout = 'default2';	
	if (!$id){
	    throw new NotFoundException(__('Invalid Class teacher'));
	}
	
	
	$staff = $this->Classteacher->findById($id);
	
	if (!$staff){
	    throw new NotFoundException(__('Invalid Class teacher'));
	}

		
	if ($this->request->is(array('post', 'put'))){
	    $this->Classteacher->id = $id;
	    
		if ($this->Classteacher->save($this->request->data)){ 
		    
		    $this->Session->setFlash(__('Class teachers Details have been updated successfully'));
		    return $this->redirect(array('action' => 'index'));
		}
	    
	    $this->Session->setFlash(__('Unable to update Class teachers details.'));
	}

	$this->loadModel("Schoolstream");
	
	$streams = $this->Schoolstream->find('list',array(
		  'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),	
	));
	
	if (!$this->request->data){
	    $this->request->data = $staff;
	}
	
	$this->set('streams',$streams);
	
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
	$this->Classteacher->id = $id;
		
	if (!$this->Classteacher->exists()) {
		throw new NotFoundException(__('Invalid Class teacher'));
	}
		
	$this->request->allowMethod('post', 'delete');
		
	if ($this->Classteacher->delete()) {
			
		$this->Session->setFlash(__('Class teachers details have been deleted.'));
				
	} else {
			
		$this->Session->setFlash(__('Class teachers details could not be deleted. Please, try again.'));
			
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
