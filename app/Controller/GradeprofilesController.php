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
class GradeprofilesController extends AppController {

    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');
    
    
    public function beforeFilter() {
	parent::beforeFilter();
 
	// Change layout for Ajax requests
	if ($this->request->is('ajax')) {
	    $this->layout = 'ajax';
	}
    }


    public function index() {
	$this->layout = 'default2';
	$this->Paginator->settings = array(
	  'Gradeprofile' => array (
	    'paramType' => 'querystring',
	    'limit' => 50,
	    'order' => array(
	      'Gradeprofile.id' => 'desc'
	    ),
	    'fields' => array('DISTINCT Gradeprofile.profilename','Gradeprofile.*'),
	    'recursive' => -1
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
	    'q' => $this->request->data('Gradeprofile.searchQuery')
	  )
	));
      }
      $this->Gradeprofile->recursive = 0;
      $searchQuery = $this->request->query('q');
      $this->Paginator->settings = array(
	'Gradeprofile' => array(
	'findType' => 'search',
	'searchQuery' => $searchQuery,
	'recursive' => -1
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
	    if (!$id){
		throw new NotFoundException(__('Invalid Profile'));
	    }
	
	    $profile = $this->Gradeprofile->findById($id);
	    if (!$profile){
		throw new NotFoundException(__('Invalid profile'));
	    }

	    if (!$this->request->data){
		$this->request->data = $profile;
	    }
	
	    $this->set('staffrecords',$profile);
	

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	$this->layout = 'default2';    
	    if ($this->request->is('post')) {
		/*
		$this->Gradeprofile->create();
		//unset($this->Gradeprofile->Grading->validate['Gradeprofile_id']);
	    
		if ($this->Gradeprofile->saveAssociated($this->request->data)) {
		    $this->Session->setFlash(__('Profile records were sucessfully added to the database'));
		    return $this->redirect(array('action' => 'index'));
		}else{
		    $this->Session->setFlash(__('Unable to add the profile records to the database'));
		}
		*/
	    }
	    
	    /*
	    $this->loadModel('Schooldonesubject');
	    $subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
		'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
		//’conditions’ => array(’Article.status !=’ => ’pending’),
		'recursive' => 0
	    ));
	    $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
	    */
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
	    throw new NotFoundException(__('Invalid Profile'));
	}
	
	$staff = $this->Gradeprofile->findById($id);
	if (!$staff){
	    throw new NotFoundException(__('Invalid Profile'));
	}
	if ($this->request->is(array('post', 'put'))){
	    //$this->Gradeprofile->id = $id;
	    /*$this->Gradeprofile->Grading->gradeprofile_id = $id;
	    $this->Gradeprofile->Ordinaryleveldivisionaward->gradeprofile_id = $id;
	    $this->Gradeprofile->Advancedlevelpointsaward->gradeprofile_id = $id;
	    $this->Gradeprofile->Ordinaryleveldivisionawardsetting->gradeprofile_id = $id;
	    $this->Gradeprofile->Advancedlevelpointsawardsetting->gradeprofile_id = $id;
	    $this->Gradeprofile->Gradeprofileusesetting->gradeprofile_id = $id;
	    */
	    //unset($this->Gradeprofile->Grading->validate['Gradeprofile_id']);
	    //unset($this->Company->Account->validate[’company_id’]);
	    
	    $this->request->data['Gradeprofile']['id'] = $id;
	    //$this->request->data['Ordinaryleveldivisionawardsetting']['gradeprofile_id'] = $id;
	    //$this->Gradeprofile->Grading->gradeprofile_id = $id;
	    /*
	    $this->request->data['Grading']['gradeprofile_id'] = $id;
	    $this->request->data['Ordinaryleveldivisionaward']['gradeprofile_id'] = $id;
	    $this->request->data['Advancedlevelpointsaward']['gradeprofile_id'] = $id;
	    $this->request->data['Ordinaryleveldivisionawardsetting']['gradeprofile_id'] = $id;
	    $this->request->data['Advancedlevelpointsawardsetting']['gradeprofile_id'] = $id;
	    $this->request->data['Gradeprofileusesetting']['gradeprofile_id'] = $id;	    
	    */
	    ///*
	    if ($this->Gradeprofile->saveAssociated($this->request->data,array('deep' => true))){ 
		//$this->set('data',$this->request->data);
		$this->Session->setFlash(__('Profile records were sucessfully updated from the database'));
		return $this->redirect(array('action' => 'index'));
	    }else{
		$this->Session->setFlash(__('Unable to update Profile Records.'));
	    }
	   //*/
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
	public function delete($id = null) {
	$this->layout = 'default2';
		$this->Gradeprofile->id = $id;
		if (!$this->Gradeprofile->exists()) {
			throw new NotFoundException(__('Invalid Grade profile'));
		}
		
		$students = $this->Gradeprofile->findById($id);
		
		$this->request->allowMethod('post', 'delete');
		if ($this->Gradeprofile->delete()) {
			$this->Session->setFlash(__('Profile details have been deleted.'));
		} else {
			$this->Session->setFlash(__('Profile details could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function getprofiles(){
	$this->layout = 'default2';
	   $this->request->onlyAllow('ajax'); // No direct access via browser URL
	
	    $gradeprofilesintheschool = $this->Gradeprofile->find('list', 
		array(
 		    'fields' => array('id','profilename'),
		    'recursive' => 0
		)
	    );
	    
	    //set current profile as content to show in view
	    //$this->set(compact('content')); 
	    
	    $this->set('gradeprofilesintheschool',$gradeprofilesintheschool);
	    
	    $this->layout = 'ajax_response';
	    
	    //render spacial view for ajax
	    //$this->render('ajax_response', 'ajax');  
	
	}
	
	public function assign() {
	$this->layout = 'default2';
	    $this->loadModel('Profileassignment');
	    
	    if ($this->request->is(array('post', 'put'))){
		//$this->Gradeprofile->id = $id;
		/* $this->request->data['Gradeprofile']['id'] = $id;

		if ($this->Gradeprofile->saveAssociated($this->request->data) $this->Gradeprofile->save($this->request->data)){ 
		    //$this->set('data',$this->request->data);
		    $this->Session->setFlash(__('Profile records were sucessfully updated from the database'));
		    return $this->redirect(array('action' => 'index'));
		}else{
		    $this->Session->setFlash(__('Unable to update Profile Records.'));
		}
		*/
		
		//$this->request->data['Profileassignment']['id'] = 13;
		// Update Senior 1 profile		
		if($this->request->data['profile1'] != ""){
		    $profile_id = $this->request->data['profile1'];
		}else{
		    $profile_id = null;
		}
		
		$data = array(
			'Profileassignment' => array(
			    'id' => 13,
			    'gradeprofile_id' => $profile_id,
			)
		);
		$this->Profileassignment->save($data);
		//End update of profile

		// Update Senior 2 profile		
		if($this->request->data['profile2'] != ""){
		    $profile_id = $this->request->data['profile2'];
		}else{
		    $profile_id = null;
		}
		
		$data = array(
			'Profileassignment' => array(
			    'id' => 14,
			    'gradeprofile_id' => $profile_id,
			)
		);
		$this->Profileassignment->save($data);
		//End update of profile
		
		// Update Senior 3 profile		
		if($this->request->data['profile3'] != ""){
		    $profile_id = $this->request->data['profile3'];
		}else{
		    $profile_id = null;
		}
		
		$data = array(
			'Profileassignment' => array(
			    'id' => 15,
			    'gradeprofile_id' => $profile_id,
			)
		);
		$this->Profileassignment->save($data);
		//End update of profile
		
		// Update Senior 4 profile		
		if($this->request->data['profile4'] != ""){
		    $profile_id = $this->request->data['profile4'];
		}else{
		    $profile_id = null;
		}
		
		$data = array(
			'Profileassignment' => array(
			    'id' => 16,
			    'gradeprofile_id' => $profile_id,
			)
		);
		$this->Profileassignment->save($data);
		//End update of profile
		
		// Update Senior 5 profile		
		if($this->request->data['profile5'] != ""){
		    $profile_id = $this->request->data['profile5'];
		}else{
		    $profile_id = null;
		}
		
		$data = array(
			'Profileassignment' => array(
			    'id' => 17,
			    'gradeprofile_id' => $profile_id,
			)
		);
		$this->Profileassignment->save($data);
		//End update of profile
		
		// Update Senior 6 profile		
		if($this->request->data['profile6'] != ""){
		    $profile_id = $this->request->data['profile6'];
		}else{
		    $profile_id = null;
		}
		
		$data = array(
			'Profileassignment' => array(
			    'id' => 18,
			    'gradeprofile_id' => $profile_id,
			)
		);
		$this->Profileassignment->save($data);
		//End update of profile
		
		$this->Session->setFlash(__('Successfully assigned the profile(s) to the class(es).'));
		
	    }
	    
	    
	    
	    $profileassignments = $this->Profileassignment->find('list', 
		array(
 		    'fields' => array('class','gradeprofile_id'),
 		    //'conditions' => array('Student.currentclass =' => 1,'Student.availabilitystatus =' => "Present"),
		    'order' => array( 'Profileassignment.class' => 'asc'),
		    'recursive' => 0
		)
	    );	
	    
	    $gradeprofilesintheschool = $this->Gradeprofile->find('list', 
		array(
 		    'fields' => array('id','profilename'),
		    'recursive' => 0
		)
	    );
	    
	     
	    
	    $this->set('gradeprofilesintheschool',$gradeprofilesintheschool);
	    
	    $this->set('profileassignments',$profileassignments);
	
	}
}
