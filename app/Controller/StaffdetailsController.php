<?php
App::uses('Folder','Utility');
App::uses('Files','Utility');
App::uses('AppController', 'Controller');
/**
 * Staffdetails Controller
 *
 * @property Staffdetail $Staffdetail
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class StaffdetailsController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');

    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Staffdetail' => array (
	    'paramType' => 'querystring',
	    'limit' => 50,
	    'order' => array(
	      'Staffdetail.id' => 'desc'
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
	    'q' => $this->request->data('Staffdetail.searchQuery')
	  )
	));
      }
      $this->Staffdetail->recursive = 0;
      $searchQuery = $this->request->query('q');
      $this->Paginator->settings = array(
	'Staffdetail' => array(
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
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout = 'default2';
		/*if (!$this->Staffdetail->exists($id)) {
			throw new NotFoundException(__('Invalid staffdetail'));
		}
		$options = array('conditions' => array('Staffdetail.' . $this->Staffdetail->primaryKey => $id));
		$this->set('staffdetail', $this->Staffdetail->find('first', $options));
		*/

// This is the separator
		
	if (!$id){
	    throw new NotFoundException(__('Invalid Staff'));
	}
	
	$staff = $this->Staffdetail->findById($id);
	if (!$staff){
	    throw new NotFoundException(__('Invalid Staff'));
	}
	if ($this->request->is(array('post', 'put'))){
	    $this->Staffdetail->id = $id;
	    //$this->Staffdetail->Previousworkplace->staff_id = $id;

	    if($this->request->data['Staffdetail']['picture'] != ""){
		$encoded_data = $this->request->data['Staffdetail']['picture'];
		$binary_data = base64_decode($encoded_data);

		//first delete the file from the specified location if it exists
		$path = "img/staffpics/".$this->request->data['Staffdetail']['picturenumber'].".jpg";
		if(file_exists($path) == true){
		    unlink($path);
		}
		// save to server (beware of permissions)	
		$result = file_put_contents( 'img/staffpics/'.$this->request->data['Staffdetail']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Staffdetail']['picture'] = "";
		$this->request->data['Staffdetail']['studenthaspic'] = "YES";
	    }

	    if ($this->Staffdetail->saveAssociated($this->request->data)){ 
		//$this->Staffdetail->save($this->request->data['Previousworkplace']);
		//$this->Staffdetail->save($this->request->data['Dependantdetail']);
		$this->set('data',$this->request->data);
		$this->Session->setFlash(__('Records for %s, Registration number: %s have been been updated.',
					    $this->request->data['Staffdetail']['name'], 
					    $this->request->data['Staffdetail']['registrationnumber']));
		return $this->redirect(array('action' => 'index'));
	    }
	    $this->Session->setFlash(__('Unable to update Staff Records.'));
	}

	if (!$this->request->data){
	    $this->request->data = $staff;
	}

	if(file_exists("img/staffpics/".$staff['Staffdetail']['picturenumber'].".jpg") == true){
	    $webcampic = $staff['Staffdetail']['picturenumber'];
	    $this->set('webcampic', $staff['Staffdetail']['picturenumber']);
	}else{
	    $webcampic = false;
	    $this->set('webcampic', $webcampic);
	}
	
	$this->set('staffrecords',$staff);
	

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	/*
	    if (!empty($this->request->data)) {
		if ($this->request->is('post')) {
			$this->Staffdetail->create();
			unset($this->Staffdetail->Previousworkplace->validate['staffdetail_id']);
			if ($this->Staffdetail->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('The staffdetail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The staffdetail could not be saved. Please, try again.'));
			}
		}
	    }
	    
	*/  
	$this->layout = 'default2';
	if ($this->request->is('post')) {
	    $this->Staffdetail->create();
	    unset($this->Staffdetail->Previousworkplace->validate['staffdetail_id']);
	    unset($this->Staffdetail->Dependantdetail->validate['staffdetail_id']);
	    if($this->request->data['Staffdetail']['picture'] != ""){
		$encoded_data = $this->request->data['Staffdetail']['picture'];
		$binary_data = base64_decode($encoded_data);

		// save to server (beware of permissions)
		$result = file_put_contents( 'img/staffpics/'.$this->request->data['Staffdetail']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Staffdetail']['picture'] = "";
		$this->request->data['Staffdetail']['studenthaspic'] = "YES";
	    }
	    
	    //$this->request->data['Staffdetail']['fullnames'] = $this->request->data['Staffdetail']['surname']." ".$this->request->data['Staffdetail']['othernames'];
	    
	    
	    
	    if ($this->Staffdetail->saveAssociated($this->request->data)) {
		$this->Session->setFlash(__('Staff records were sucessfully added to the database'));
		return $this->redirect(array('action' => 'index'));
	    }else{
		$this->Session->setFlash(__('Unable to add the staff records to the database'));
	    }
	}
	
	
	$this->loadModel('Staffpicturenumber');
	$currentnumber = $this->Staffpicturenumber->findById(1);
	if($currentnumber['Staffpicturenumber']['currentyear'] != date('Y')){
	    $newnumbertobeused = 1;
	    $newnumbertobeused = sprintf("%04d", $newnumbertobeused);
	    $data =  array('id' => 1, 'lastnumberused' => $newnumbertobeused, 'currentyear' => date('Y'));
	    $this->Staffpicturenumber->save($data);
	    $this->set('lastnumberused', 1);
	    $this->set('currentyear', date('Y'));
	}else{
	    $newnumbertobeused = $currentnumber['Staffpicturenumber']['lastnumberused'] + 1;
	    $newnumbertobeused = sprintf("%04d", $newnumbertobeused);
	    $data =  array('id' => 1, 'lastnumberused' => $newnumbertobeused);
	    $this->Staffpicturenumber->save($data);
	    $this->set('lastnumberused', $newnumbertobeused);
	    $this->set('currentyear', date('Y'));
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
	    throw new NotFoundException(__('Invalid Staff'));
	}
	
	$staff = $this->Staffdetail->findById($id);
	if (!$staff){
	    throw new NotFoundException(__('Invalid Staff'));
	}
	if ($this->request->is(array('post', 'put'))){
	    $this->Staffdetail->id = $id;
	    //$this->Staffdetail->Previousworkplace->staff_id = $id;

	    if($this->request->data['Staffdetail']['picture'] != ""){
		$encoded_data = $this->request->data['Staffdetail']['picture'];
		$binary_data = base64_decode($encoded_data);

		//first delete the file from the specified location if it exists
		$path = "img/staffpics/".$this->request->data['Staffdetail']['picturenumber'].".jpg";
		if(file_exists($path) == true){
		    unlink($path);
		}
		// save to server (beware of permissions)	
		$result = file_put_contents( 'img/staffpics/'.$this->request->data['Staffdetail']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Staffdetail']['picture'] = "";
		$this->request->data['Staffdetail']['studenthaspic'] = "YES";
	    }

	    if ($this->Staffdetail->saveAssociated($this->request->data)){ 
		//$this->Staffdetail->save($this->request->data['Previousworkplace']);
		//$this->Staffdetail->save($this->request->data['Dependantdetail']);
		$this->set('data',$this->request->data);
		$this->Session->setFlash(__('Records for %s, Registration number: %s have been been updated.',
					    $this->request->data['Staffdetail']['name'], 
					    $this->request->data['Staffdetail']['registrationnumber']));
		return $this->redirect(array('action' => 'index'));
	    }
	    $this->Session->setFlash(__('Unable to update Staff Records.'));
	}

	if (!$this->request->data){
	    $this->request->data = $staff;
	}

	if(file_exists("img/staffpics/".$staff['Staffdetail']['picturenumber'].".jpg") == true){
	    $webcampic = $staff['Staffdetail']['picturenumber'];
	    $this->set('webcampic', $staff['Staffdetail']['picturenumber']);
	}else{
	    $webcampic = false;
	    $this->set('webcampic', $webcampic);
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
	public function delete($id = null) {
		$this->layout = 'default2';
		$this->Staffdetail->id = $id;
		if (!$this->Staffdetail->exists()) {
			throw new NotFoundException(__('Invalid staff member'));
		}
		
	$students = $this->Staffdetail->findById($id);
	$path = "img/staffpics/".$students['Staffdetail']['picturenumber'].".jpg";
	if(file_exists($path) == true){
	    unlink($path);
	}
		
		$this->request->allowMethod('post', 'delete');
		if ($this->Staffdetail->delete()) {
			$this->Session->setFlash(__('Staff details have been deleted.'));
		} else {
			$this->Session->setFlash(__('Staff details could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
