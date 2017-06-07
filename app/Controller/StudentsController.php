<?php
App::uses('Folder','Utility');
App::uses('Files','Utility');
App::uses('AppController', 'Controller');
class StudentsController extends AppController {
    public $helpers = array(
	'Paginator',
	'Html', 
	'Form',
	'Js'
    
    );
    public $components = array('Paginator','Session');

    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Student' => array (
	    'paramType' => 'querystring',
	    'limit' => 10,
	    'order' => array(
	      'Student.id' => 'desc'
	    ),
	    'conditions' => array('Student.leavingreason =' => 'None'),
	    'fields' => array('Student.id','Student.registrationnumber','Student.surname','Student.othernames',
			      'Student.availabilitystatus','Student.studenthaspic','Student.sex',
			      'Student.currentclass','Student.currentclass','Student.currentstream',
	    ),
	    'recursive' => -1
	  ),
	  //'conditions' => array('Student.sex =' => 'M')
	);
	$this->set('students', $this->Paginator->paginate());
	$this->set('studentsnotpartofschool', 0);
	$this->set('extrasearchison', 0);
	
	$this->loadModel('Schoolstream');
	$streamsintheschool = $this->Schoolstream->find('list', array(
		'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	));
	
	$this->set('streamsintheschool',$streamsintheschool);
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
	$studentnotpartofschool = $this->request->data('studentnotpartofschool');
	return $this->redirect(array(
	  '?' => array(
	    'q' => $this->request->data('Student.searchQuery'),
	    'snpos' => $this->request->data('Student.studentnotpartofschool'),
	    'exson' => $this->request->data('Student.showextracriterea'),// extrasearchon
	    'clcsn' => $this->request->data('Student.currentclass'),//class chosen
	    'jndn' => ($this->request->data('Student.joiningdate')),//joining year
	    'lndn' => ($this->request->data('Student.leavingdate')),//leaving year
	    'strm' => ($this->request->data('Student.currentstream')),//stream
	    'sex' => ($this->request->data('Student.sex')),//sex
	    'availstate' => ($this->request->data('Student.availabilitystatus')),//availabilitystatus
	    'relgn' => ($this->request->data('Student.religion')),//religion
	  )
	));
      }
      
      $this->Student->recursive = -1;
      $searchQuery = $this->request->query('q');
      $studentnotpartofschool = $this->request->query('snpos');
      $extrasearchison = $this->request->query('exson');
      $currentclass = $this->request->query('clcsn');
      $joiningdate = $this->request->query('jndn');
      $leavingdate = $this->request->query('lndn');
      $currentstream = $this->request->query('strm');
      $sex = $this->request->query('sex');
      $availabilitystatus = $this->request->query('availstate');
      $religion = $this->request->query('relgn');
      
      if($studentnotpartofschool === "1"){
      
	  $studentnotpartofschool = "1";
      
      }else{
      
	  $studentnotpartofschool = "0";
      
      }
      $this->Paginator->settings = array(
	'Student' => array(
	  'findType' => 'search',
	  'limit' => 10,
	  'fields' => array('Student.id','Student.registrationnumber','Student.surname','Student.othernames',
			      'Student.availabilitystatus','Student.studenthaspic','Student.sex',
			      'Student.currentclass','Student.currentclass','Student.currentstream',
	   ),
	  'searchQuery' => $searchQuery,
	  'studentnotpartofschool' => $studentnotpartofschool,
	  'currentclass' => $currentclass,
	  'joiningdate' => $joiningdate,
	  'leavingdate' => $leavingdate,
	  'currentstream' => $currentstream,
	  'sex' => $sex,
	  'availabilitystatus' => $availabilitystatus,
	  'religion' => $religion,
	  'recursive' => -1
	)
      );
      
      if($studentnotpartofschool === "1"){
      
	 $this->set('studentsnotpartofschool', 1);
      
      }else{
      
	 $this->set('studentsnotpartofschool', 0);
      
      }
      
      if($extrasearchison == "1"){
      
	  $this->set('extrasearchison', 1);
      
      }else{
      
	  $this->set('extrasearchison', 0);
      
      }
      
      $this->loadModel('Schoolstream');
      $streamsintheschool = $this->Schoolstream->find('list', array(
		'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
      ));
	
      $this->set('streamsintheschool',$streamsintheschool);
      
      $this->set('students', $this->Paginator->paginate());
      $this->set('searchQuery', $searchQuery);
      $this->render('index');
      
    }
    
    public function searchedit() {
      $this->layout = 'default2';
      if ($this->request->is('put') || $this->request->is('post')) {
	// poor man's Post Redirect Get behavior
	$studentnotpartofschool = $this->request->data('studentnotpartofschool');
	return $this->redirect(array(
	  '?' => array(
	    'q' => $this->request->data('Student.searchQuery'),
	    'snpos' => $this->request->data('Student.studentnotpartofschool'),
	    'exson' => $this->request->data('Student.showextracriterea'),// extrasearchon
	    'clcsn' => $this->request->data('Student.currentclass'),//class chosen
	    'jndn' => ($this->request->data('Student.joiningdate')),//joining year
	    'lndn' => ($this->request->data('Student.leavingdate')),//leaving year
	    'strm' => ($this->request->data('Student.currentstream')),//stream
	    'sex' => ($this->request->data('Student.sex')),//sex
	    'availstate' => ($this->request->data('Student.availabilitystatus')),//availabilitystatus
	    'relgn' => ($this->request->data('Student.religion')),//religion
	  )
	));
      }
      
      $this->Student->recursive = 0;
      $searchQuery = $this->request->query('q');
      $studentnotpartofschool = $this->request->query('snpos');
      $extrasearchison = $this->request->query('exson');
      $currentclass = $this->request->query('clcsn');
      $joiningdate = $this->request->query('jndn');
      $leavingdate = $this->request->query('lndn');
      $currentstream = $this->request->query('strm');
      $sex = $this->request->query('sex');
      $availabilitystatus = $this->request->query('availstate');
      $religion = $this->request->query('relgn');
      
      if($studentnotpartofschool === "1"){
      
	  $studentnotpartofschool = "1";
      
      }else{
      
	  $studentnotpartofschool = "0";
      
      }
      $this->Paginator->settings = array(
	'Student' => array(
	  'findType' => 'search',
	  'limit' => 10,
	  'searchQuery' => $searchQuery,
	  'studentnotpartofschool' => $studentnotpartofschool,
	  'currentclass' => $currentclass,
	  'joiningdate' => $joiningdate,
	  'leavingdate' => $leavingdate,
	  'currentstream' => $currentstream,
	  'sex' => $sex,
	  'availabilitystatus' => $availabilitystatus,
	  'religion' => $religion,
	  'fields' => array('Student.id','Student.registrationnumber','Student.surname','Student.othernames',
			      'Student.availabilitystatus','Student.studenthaspic','Student.sex',
			      'Student.currentclass','Student.currentclass','Student.currentstream',
	  ),
	)
      );
      
      $this->Paginator->settings = array(
	  'Student' => array (
	    'paramType' => 'querystring',
	    'limit' => 10,
	    'order' => array(
	      'Student.id' => 'desc'
	    ),
	    'conditions' => array('Student.leavingreason =' => 'None'),
	    'fields' => array('Student.id','Student.registrationnumber','Student.surname','Student.othernames',
			      'Student.availabilitystatus','Student.studenthaspic','Student.sex',
			      'Student.currentclass','Student.currentclass','Student.currentstream',
	    ),
	  ),
	  //'conditions' => array('Student.sex =' => 'M')
	);
      
      if($studentnotpartofschool === "1"){
      
	 $this->set('studentsnotpartofschool', 1);
      
      }else{
      
	 $this->set('studentsnotpartofschool', 0);
      
      }
      
      if($extrasearchison == "1"){
      
	  $this->set('extrasearchison', 1);
      
      }else{
      
	  $this->set('extrasearchison', 0);
      
      }
      
      $this->loadModel('Schoolstream');
      $streamsintheschool = $this->Schoolstream->find('list', array(
		'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
      ));
	
      $this->set('streamsintheschool',$streamsintheschool);
      
      $this->set('students', $this->Paginator->paginate());
      $this->set('searchQuery', $searchQuery);
      return $this->edit(204,$this->Paginator->paginate());
      
    }
    
    
    public function checkifnumber(){
	/*$ajax1 = $this->request->data['Student']['picturenumber'];
	//$ajax = $ajax + 1;
	//$ajax1 = $ajax;
	if($ajax1 != null){
	      $this->set('ajax1', $ajax1);
	}else{
	      $this->set('ajax1', "here we are");
	}
	$this->layout = 'ajax';
	$this->render('checkifnumber');
	*/
    }

    public function add_olevel() {
	$this->layout = 'default2';
	//$this->autoRender = false;
	
	if($this->request->is('ajax')){
	
	if ($this->request->is('post')) {
	    $this->Student->create();
	    
	    if($this->request->data['Student']['picture'] != ""){
		$encoded_data = $this->request->data['Student']['picture'];
		$binary_data = base64_decode($encoded_data);

		// save to server (beware of permissions)
		//$result = file_put_contents( 'img/studentpics/'.$this->request->data['Student']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Student']['picture'] = "";
		$this->request->data['Student']['studenthaspic'] = "YES";
		$this->request->data['Student']['studentpicture'] = $binary_data;
	    }
	    
	    $this->request->data['Student']['fullnames'] = $this->request->data['Student']['surname']." ".$this->request->data['Student']['othernames'];
	    
	    if ($this->Student->saveAssociated($this->request->data)) {
		//$this->Session->setFlash(__('The student was sucessfully added to the database'));
		//return $this->redirect(array('action' => 'index'));
		$this->layout = false;
	    }else{
		//$this->Session->setFlash(__('Unable to add the student to the database'));
	    }
	}
	}else{
	if ($this->request->is('post')) {
	    $this->Student->create();
	    
	    if($this->request->data['Student']['picture'] != ""){
		$encoded_data = $this->request->data['Student']['picture'];
		$binary_data = base64_decode($encoded_data);

		// save to server (beware of permissions)
		//$result = file_put_contents( 'img/studentpics/'.$this->request->data['Student']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Student']['picture'] = "";
		$this->request->data['Student']['studenthaspic'] = "YES";
		$this->request->data['Student']['studentpicture'] = $binary_data;
	    }
	    
	    $this->request->data['Student']['fullnames'] = $this->request->data['Student']['surname']." ".$this->request->data['Student']['othernames'];
	    
	    if ($this->Student->saveAssociated($this->request->data)) {
		$this->Session->setFlash(__('The student was sucessfully added to the database'));
		return $this->redirect(array('action' => 'index'));
		//$this->layout = false;
	    }else{
		//$this->Session->setFlash(__('Unable to add the student to the database'));
	    }
	}

	
	}
	
	
	$this->loadModel('Number');
	$this->loadModel('Schoolstream');
	$currentnumber = $this->Number->findById(1);
	if($currentnumber['Number']['currentyear'] != date('Y')){
	    $newnumbertobeused = 1;
	    $newnumbertobeused = sprintf("%04d", $newnumbertobeused);
	    $data =  array('id' => 1, 'lastnumberused' => $newnumbertobeused, 'currentyear' => date('Y'));
	    $this->Number->save($data);
	    $this->set('lastnumberused', 1);
	    $this->set('currentyear', date('Y'));
	}else{
	    $newnumbertobeused = $currentnumber['Number']['lastnumberused'] + 1;
	    $newnumbertobeused = sprintf("%04d", $newnumbertobeused);
	    $data =  array('id' => 1, 'lastnumberused' => $newnumbertobeused);
	    $this->Number->save($data);
	    $this->set('lastnumberused', $newnumbertobeused);
	    $this->set('currentyear', date('Y'));
	}
	
	$streamsintheschool = $this->Schoolstream->find('list', array(
		'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	));
	
	$this->set('streamsintheschool',$streamsintheschool);
	
    }

    public function add_alevel() {
	
	//if($this->Auth->user('role') != 'admin'){
	//	$this->Session->setFlash(__('You do not have the permissions to do this, Please contact an administrator.'));
	//	return $this->redirect(array('action' => 'index'));
	//}else{
	$this->layout = 'default2';
	if ($this->request->is('post')) {
	    $this->Student->create();
	    
	    if($this->request->data['Student']['picture'] != ""){
		$encoded_data = $this->request->data['Student']['picture'];
		$binary_data = base64_decode($encoded_data);

		// save to server (beware of permissions)
		//$result = file_put_contents( 'img/studentpics/'.$this->request->data['Student']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Student']['picture'] = "";
		$this->request->data['Student']['studenthaspic'] = "YES";
		$this->request->data['Student']['studentpicture'] = $binary_data;
	    }
	    if ($this->Student->saveAssociated($this->request->data)) {
		$this->Session->setFlash(__('The student was sucessfully added to the database'));
		return $this->redirect(array('action' => 'index'));
	    }else{
		//$this->Session->setFlash(__('Unable to add the student to the database'));
	    }
	}
	
	$this->loadModel('Number');
	$currentnumber = $this->Number->findById(1);
	if($currentnumber['Number']['currentyear'] != date('Y')){
	    $newnumbertobeused = 1;
	    $newnumbertobeused = sprintf("%04d", $newnumbertobeused);
	    $data =  array('id' => 1, 'lastnumberused' => $newnumbertobeused, 'currentyear' => date('Y'));
	    $this->Number->save($data);
	    $this->set('lastnumberused', 1);
	    $this->set('currentyear', date('Y'));
	}else{
	    $newnumbertobeused = $currentnumber['Number']['lastnumberused'] + 1;
	    $newnumbertobeused = sprintf("%04d", $newnumbertobeused);
	    $data =  array('id' => 1, 'lastnumberused' => $newnumbertobeused);
	    $this->Number->save($data);
	    $this->set('lastnumberused', $newnumbertobeused);
	    $this->set('currentyear', date('Y'));
	}
	//}
	
	$this->loadModel('Schooldoneasubject');
	$alevel_subjects = $this->Schooldoneasubject->find('list', array(
		'fields' => array('Schooldoneasubject.id','Schooldoneasubject.shortsubjectname'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	));
	$this->set('alevel_subjects', $alevel_subjects);
    }

    public function edit($id = null, $index_ids = null) {
	$this->layout = 'default2';
	if (!$id){
	    throw new NotFoundException(__('Invalid Student'));
	}
	$students = $this->Student->findById($id);
	if (!$students){
	    throw new NotFoundException(__('Invalid Student'));
	}
	if ($this->request->is(array('post', 'put')) && ($index_ids == null)){
	    $this->Student->id = $id;

	    if($this->request->data['Student']['picture'] != ""){
		$encoded_data = $this->request->data['Student']['picture'];
		$binary_data = base64_decode($encoded_data);

		//first delete the file from the specified location if it exists
		//$path = "img/studentpics/".$this->request->data['Student']['picturenumber'].".jpg";
		//if(file_exists($path) == true){
		    //unlink($path);
		//}
		// save to server (beware of permissions)	
		//$result = file_put_contents( 'img/studentpics/'.$this->request->data['Student']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Student']['picture'] = "";
		$this->request->data['Student']['studenthaspic'] = "YES";
		$this->request->data['Student']['studentpicture'] = $binary_data;
		
	    }

	    $this->request->data['Student']['fullnames'] = $this->request->data['Student']['surname']." ".$this->request->data['Student']['othernames'];
	    
	    if ($this->Student->saveAssociated($this->request->data)){
		$this->Session->setFlash(__('Records for %s %s, Registration number: %s have been been updated.',
					    $this->request->data['Student']['surname'], 
					    $this->request->data['Student']['othernames'], 
					    $this->request->data['Student']['registrationnumber']));
		return $this->redirect(array('action' => 'index'));
	    }
	    $this->Session->setFlash(__('Unable to update Student Records.'));
	}

	if (!$this->request->data){
	    $this->request->data = $students;
	}

	/*
	if(file_exists("img/studentpics/".$students['Student']['picturenumber'].".jpg") == true){
	    $webcampic = $students['Student']['picturenumber'];
	    $this->set('webcampic', $students['Student']['picturenumber']);
	    $this->set('studentpicid', $students['Student']['id']);
	}else{
	    $webcampic = false;
	    $this->set('webcampic', $webcampic);
	    $this->set('studentpicid', $students['Student']['id']);
	}
	*/
	if ($students['Student']['studenthaspic'] == "YES") {
	
	    $webcampic = $students['Student']['studenthaspic'];
	    $this->set('webcampic', $webcampic);
	    $this->set('studentpicid', $students['Student']['id']);
	
	}else {
	
	    $webcampic = false;
	    $this->set('webcampic', $webcampic);
	    $this->set('studentpicid', $students['Student']['id']);
	
	}
	
	$this->loadModel('Schoolstream');
	
	$streamsintheschool = $this->Schoolstream->find('list', array(
		'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	));
	
	$this->set('streamsintheschool',$streamsintheschool);
	$this->loadModel('Schooldoneasubject');
	$alevel_subjects = $this->Schooldoneasubject->find('list', array(
		'fields' => array('Schooldoneasubject.id','Schooldoneasubject.shortsubjectname'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	));
	$this->set('alevel_subjects', $alevel_subjects);
    }
    
    public function searcheditsave($id = null, $index_ids = null) {
	$this->layout = 'default2';
	if (!$id){
	    throw new NotFoundException(__('Invalid Student'));
	}
	$students = $this->Student->findById($id);
	if (!$students){
	    throw new NotFoundException(__('Invalid Student'));
	}
	if ($this->request->is(array('post', 'put')) && ($index_ids == null)){
	    $this->Student->id = $id;

	    if($this->request->data['Student']['picture'] != ""){
		$encoded_data = $this->request->data['Student']['picture'];
		$binary_data = base64_decode($encoded_data);

		//first delete the file from the specified location if it exists
		//$path = "img/studentpics/".$this->request->data['Student']['picturenumber'].".jpg";
		//if(file_exists($path) == true){
		    //unlink($path);
		//}
		// save to server (beware of permissions)	
		//$result = file_put_contents( 'img/studentpics/'.$this->request->data['Student']['picturenumber'].'.jpg', $binary_data );
		$this->request->data['Student']['picture'] = "";
		$this->request->data['Student']['studenthaspic'] = "YES";
		$this->request->data['Student']['studentpicture'] = $binary_data;
		
	    }

	    if ($this->Student->saveAssociated($this->request->data)){
		$this->Session->setFlash(__('Records for %s %s, Registration number: %s have been been updated.',
					    $this->request->data['Student']['surname'], 
					    $this->request->data['Student']['othernames'], 
					    $this->request->data['Student']['registrationnumber']));
		return $this->redirect(array('action' => 'index'));
	    }
	    $this->Session->setFlash(__('Unable to update Student Records.'));
	}

	if (!$this->request->data){
	    $this->request->data = $students;
	}

	/*
	if(file_exists("img/studentpics/".$students['Student']['picturenumber'].".jpg") == true){
	    $webcampic = $students['Student']['picturenumber'];
	    $this->set('webcampic', $students['Student']['picturenumber']);
	    $this->set('studentpicid', $students['Student']['id']);
	}else{
	    $webcampic = false;
	    $this->set('webcampic', $webcampic);
	    $this->set('studentpicid', $students['Student']['id']);
	}
	*/
	if ($students['Student']['studenthaspic'] == "YES") {
	
	    $webcampic = $students['Student']['studenthaspic'];
	    $this->set('webcampic', $webcampic);
	    $this->set('studentpicid', $students['Student']['id']);
	
	}else {
	
	    $webcampic = false;
	    $this->set('webcampic', $webcampic);
	    $this->set('studentpicid', $students['Student']['id']);
	
	}
	
	$this->loadModel('Schoolstream');
	
	$streamsintheschool = $this->Schoolstream->find('list', array(
		'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	));
	
	$this->set('streamsintheschool',$streamsintheschool);
    }


    public function delete($id){
	$this->layout = 'default2';
	if ($this->request->is('get')){
	    throw new MethodNotAllowedException();
	}
	$students = $this->Student->findById($id);
	$path = "img/studentpics/".$students['Student']['picturenumber'].".jpg";
	if(file_exists($path) == true){
	    unlink($path);
	}
	
	$this->loadModel('Olevelmarksheetresult');
	$this->loadModel('Schooldonesubject');
	
	$olevelsubjects = $this->Schooldonesubject->find('all', array(
	    'fields' => array('Schooldonesubject.shortsubjectname')	    		      
	));
	
	$altleastonesubjectentered = null;
	
	foreach($olevelsubjects as $olevelsubject){
	
	    $olevelsubject['Schooldonesubject']['shortsubjectname'];
	    $results = $this->Olevelmarksheetresult->find('all',array(
		'fields' => array($olevelsubject['Schooldonesubject']['shortsubjectname']),
		'conditions' => array('student_id' => $id, $olevelsubject['Schooldonesubject']['shortsubjectname']." !=" => null)
	
	    ));
	    
	    if($results != false){
	    
		break;
	    
	    }
	
	}
	
	/*
	$results = $this->Olevelmarksheetresult->field('id',
	
	    array('student_id' => $id)
	
	);
	*/
	
	if($results == null){
	
		//$this->Session->setFlash(__('Managed to delete the records'));
		
		if ($this->Student->delete($id)) {
		    $this->Session->setFlash(__('Records for %s %s, Registration number: %s have been deleted.',
					    $students['Student']['surname'], 
					    $students['Student']['othernames'], 
					    $students['Student']['registrationnumber']));
		    return $this->redirect(array('action' => 'index'));
		} else {
		
		    $this->Session->setFlash(__('Had a slight problem trying to delete Student Records.'));
		    return $this->redirect(array('action' => 'index'));
	      
		}
	}else{
	
	     $this->Session->setFlash(__('Records for %s %s, Registration number: %s cannot be deleted because the student already has marks entered in a marksheet.',
					    $students['Student']['surname'], 
					    $students['Student']['othernames'], 
					    $students['Student']['registrationnumber']));
		    return $this->redirect(array('action' => 'index'));
	
	}
	

    }
    
    public function displayImage ( $id ) {
	$this->layout = 'default2';
	$this->autoRender = false;
	$file = $this->Student->field('studentpicture',
		    array('id =' => $id)
		);

	header('Content-type: image/jpg' );
	//header('Content-length: ' . strlen($file['Recipe']['thumb'])); // some people reported problems with this line (see the comments), commenting out this line helped in those cases
	//header('Content-Disposition: attachment; filename="'.$file['Recipe']['thumb'].'"');
	echo $file;

	//exit();
    
    }
    
    public function get_the_registrationnumber() {
    
	//$this->request->onlyAllow('ajax');
	
	$this->layout = 'ajax_response';
	
	//The requested class
	//$classrequested = intval($this->request->data['Student']['currentclass']);
	$classrequested = $this->request->data['currentclass'];
	
	//The year on the server
	$currentyear = date("Y");
	
	// get the year for that class
	$this->loadModel('Registrationnumber');
	$this->loadModel('Updatingflag');
	
	//the last number used
	$lastnumber = 0;
	
	//the flag to indicate the year of the class has changed
	$classyearchanged = 0;
	
	$theyearofthatclass = $this->Registrationnumber->field('yearused',
		      array('classused =' => $classrequested)
		  );
		  
	
	if(($currentyear -1) == $theyearofthatclass){
	
	    $theupdatestatusofclass = $this->Updatingflag->field('updatestatus',
		      array('updatingclass =' => $classrequested)
	    );
	    
	    $classyearchanged = 1;
	    
	    if($theupdatestatusofclass == "N"){
	      
		// Set update status to yes to indicate that updates to the year are being made
		$idofclassbeingupdated = $this->Updatingflag->field('id',
			array('updatingclass =' => $classrequested)
		);
		$data = array(
		      'Updatingflag' => array(
			  'id' => $idofclassbeingupdated,
			  'updatestatus' => "Y"
		      )
		);
		$this->Updatingflag->save($data);
		
		// increment the year by 1 and set the last number used to 0
		$idofclassandyear = $this->Registrationnumber->field('id',
			array('classused =' => $classrequested,'yearused =' => $theyearofthatclass)
		);
		$data = array(
		      'Registrationnumber' => array(
			  'id' => $idofclassandyear,
			  'yearused' => ($currentyear),
			  'classused' => $classrequested,
			  'lastnumberused' => 0
		      )
		);
		$this->Registrationnumber->save($data);
		
		// set the last number variable to 0
		$lastnumber = 0;
		
		
		// Set update status to No to indicate that updates to the year are not being made
		$idofclassbeingupdated = $this->Updatingflag->field('id',
			array('updatingclass =' => $classrequested)
		);
		$data = array(
		      'Updatingflag' => array(
			  'id' => $idofclassbeingupdated,
			  'updatestatus' => "N"
		      )
		);
		$this->Updatingflag->save($data);
		
		
	    
	    }else{
	    
		while($theupdatestatusofclass != "N"){
		    sleep(1);
		}
		
		if(($theupdatestatusofclass == "N") && ($currentyear == $theyearofthatclass)){
		
		    //get the last numberused
		    $lastnumberused = $this->Registrationnumber->field('lastnumberused',
			  array('classused =' => $classrequested,'yearused =' => $theyearofthatclass)
		    );
	      
		    //put that last number incremented by 1 into a variable 
		    $lastnumber = $lastnumberused + 1;
	      
		    //change the last number used for that class 
	      
		    $idofclassandyear = $this->Registrationnumber->field('id',
			  array('classused =' => $classrequested,'yearused =' => $theyearofthatclass)
		    );
		    $data = array(
			'Registrationnumber' => array(
			    'id' => $idofclassandyear,
			    'yearused' => $currentyear,
			    'classused' => $classrequested,
			    'lastnumberused' => $lastnumber
			)
		    );
		    $this->Registrationnumber->save($data);
		
		}
	    
	    }
	
	}else {
	
	  if($currentyear == $theyearofthatclass){
	  
	      //get the last numberused
	      $lastnumberused = $this->Registrationnumber->field('lastnumberused',
		      array('classused =' => $classrequested,'yearused =' => $theyearofthatclass)
	      );
	      
	      //put that last number incremented by 1 into a variable 
	      $lastnumber = $lastnumberused + 1;
	      
	      //change the last number used for that class 
	      
	      $idofclassandyear = $this->Registrationnumber->field('id',
		      array('classused =' => $classrequested,'yearused =' => $theyearofthatclass)
	      );
	      $data = array(
		    'Registrationnumber' => array(
			'id' => $idofclassandyear,
			'yearused' => $currentyear,
			'classused' => $classrequested,
			'lastnumberused' => $lastnumber
		    )
	      );
	      $this->Registrationnumber->save($data);
	      
	  
	  }
	
	}
	
	//$this->set('regnumber',$this->request->data['currentclass']);
	$lastnumberwithfourzeros = sprintf("%04d", $lastnumber);
	if($classyearchanged == 1){
	    $this->set('regnumber',$currentyear.$classrequested.$lastnumberwithfourzeros);
	}else{
	    $this->set('regnumber',$theyearofthatclass.$classrequested.$lastnumberwithfourzeros);
	}
	
    }
}
?>
