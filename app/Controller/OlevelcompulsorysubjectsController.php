<?php
App::uses('AppController', 'Controller');
/**
 * Olevelcompulsorysubjects Controller
 *
 * @property Olevelcompulsorysubject $Olevelcompulsorysubject
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class OlevelcompulsorysubjectsController extends AppController {

/**
 * Components
 *
 * @var array
 */
 
	public $helpers = array('Paginator','Html', 'Form', 'Js');
	public $components = array('Paginator', 'Session');
	

	public function index() {
	    $this->layout = 'default2';
	    $this->Paginator->settings = array(
	      'Olevelcompulsorysubject' => array (
		'paramType' => 'querystring',
		'limit' => 10,
		'order' => array(
		  'Olevelcompulsorysubject.year' => 'desc'
		)
	      )
	    );
	    //$this->set('students', $this->Paginator->paginate());
	    $this->set('olevelcompulsorysubjects', $this->Paginator->paginate());
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
		'q' => $this->request->data('Olevelcompulsorysubject.searchQuery')
	      )
	    ));
	  }
	  $this->Olevelcompulsorysubject->recursive = 0;
	  $searchQuery = $this->request->query('q');
	  $this->Paginator->settings = array(
	    'Olevelcompulsorysubject' => array(
	    'findType' => 'search',
	    'searchQuery' => $searchQuery
	    )
	  );
	  //$this->set('students', $this->Paginator->paginate());
	  $this->set('olevelcompulsorysubjects', $this->Paginator->paginate());
	  $this->set('searchQuery', $searchQuery);
	  $this->render('index');
	}

	
	
/**
 * index method
 *
 * @return void
 */
	/*
	public function index() {
		$this->layout = 'default2';
		$this->Olevelcompulsorysubject->recursive = 0;
		$this->set('olevelcompulsorysubjects', $this->Paginator->paginate());
	}*/

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
	/*
	public function view($id = null) {
		if (!$this->Olevelcompulsorysubject->exists($id)) {
			throw new NotFoundException(__('Invalid olevelcompulsorysubject'));
		}
		$options = array('conditions' => array('Olevelcompulsorysubject.' . $this->Olevelcompulsorysubject->primaryKey => $id));
		$this->set('olevelcompulsorysubject', $this->Olevelcompulsorysubject->find('first', $options));
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
			if(($this->request->data['Olevelcompulsorysubject']['year'] != null) &&
			   ($this->request->data['Olevelcompulsorysubject']['class'] != null) &&
			   (is_array($this->request->data['Olevelcompulsorysubject']['compulsorysubjects']))
			){
			
			    $value2 = null;
			    
			    if(is_array($this->request->data['Olevelcompulsorysubject']['compulsorysubjects'])){
			    
					foreach($this->request->data['Olevelcompulsorysubject']['compulsorysubjects'] as $key => $value){
			    
					    $value2 = $value2."$".$value; 
				    
					}
			    
			    }
			
			    if($value2 != null){
			
					$this->request->data['Olevelcompulsorysubject']['compulsorysubjects'] = $value2;
			    }
			
			    $this->Olevelcompulsorysubject->create();
			    if ($this->Olevelcompulsorysubject->save($this->request->data)) {
				    $this->Session->setFlash(__('Compulsory subject details saved successfuly.'));
				    return $this->redirect(array('action' => 'index'));
			    } else {
				    $this->Session->setFlash(__('Compulsory subject details could not be saved successfuly. Please, try again.'));
			    }
			 }
			 
			 if(!(is_array($this->request->data['Olevelcompulsorysubject']['compulsorysubjects']))){
			    $this->Session->setFlash(__('Please choose atleast one subject'));
			 }
		    }
		}
		
		
		$this->loadModel('Schooldonesubject');
		$subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
		      'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),	    
		      'recursive' => 0
		));
		
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
	
		$this->layout = 'default2';
		
		if (!$this->Olevelcompulsorysubject->exists($id)) {
			throw new NotFoundException(__('Invalid Compulsory Subject'));
		}
		
		
		$this->loadModel('Schooldonesubject');
		$subjectsdoneintheschool1 = $this->Schooldonesubject->find('list', array(
		      'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),	    
		      'recursive' => 0
		));
		
		$subjectsdoneintheschool = array_values($subjectsdoneintheschool1);
		
		
		
		$staff = $this->Olevelcompulsorysubject->findById($id);
		
		$papers_currently_done1 = $staff['Olevelcompulsorysubject']['compulsorysubjects'];
		$papers_currently_done1 = explode("$",$papers_currently_done1);
		unset($papers_currently_done1[0]);
		
	
		
		if ($this->request->is(array('post', 'put'))) {
			if(($this->request->data['Olevelcompulsorysubject']['year'] != null) &&
			   ($this->request->data['Olevelcompulsorysubject']['class'] != null) &&
			   (is_array($this->request->data['Olevelcompulsorysubject']['compulsorysubjects']))
			){
			
			    $value2 = null;
			    
			    if(is_array($this->request->data['Olevelcompulsorysubject']['compulsorysubjects'])){
			    
					foreach($this->request->data['Olevelcompulsorysubject']['compulsorysubjects'] as $key => $value){
			    
					    $value2 = $value2."$".$value; 
				    
					}
			    
			    }
			
			    if($value2 != null){
			
					$this->request->data['Olevelcompulsorysubject']['compulsorysubjects'] = $value2;
			    }
			
			    //$this->Olevelcompulsorysubject->create();
			    $this->Olevelcompulsorysubject->id = $id;
			    if ($this->Olevelcompulsorysubject->save($this->request->data)) {
				    $this->Session->setFlash(__('Compulsory subject details saved successfuly.'));
				    return $this->redirect(array('action' => 'index'));
			    } else {
				    $this->Session->setFlash(__('Compulsory subject details could not be saved successfuly. Please, try again.'));
			    }
			 }
			 
			 if(!(is_array($this->request->data['Olevelcompulsorysubject']['compulsorysubjects']))){
			    $this->Session->setFlash(__('Please choose atleast one subject'));
			 }
		} else {
			$options = array('conditions' => array('Olevelcompulsorysubject.' . $this->Olevelcompulsorysubject->primaryKey => $id));
			$this->request->data = $this->Olevelcompulsorysubject->find('first', $options);
		}
		
		
		$this->set('selectedoptions',$papers_currently_done1);
		$this->set('subjectsdoneintheschool',$subjectsdoneintheschool1);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Olevelcompulsorysubject->id = $id;
		if (!$this->Olevelcompulsorysubject->exists()) {
			throw new NotFoundException(__('Invalid olevelcompulsorysubject'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Olevelcompulsorysubject->delete()) {
			$this->Session->setFlash(__('The O-level Compulsory Subject has been deleted.'));
		} else {
			$this->Session->setFlash(__('The O-level Compulsory Subject could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
