<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function beforeFilter() {
	parent::beforeFilter();
	//allow users to register and logout
	//$this->Auth->allow('logout');
    }
    
    public function login() {
	
	$this->layout = 'loginandlogout';
	
	if ($this->request->is('post')) {
	    if ($this->Auth->login()) {
		return $this->redirect($this->Auth->redirect());
	    }
	    $this->Session->setFlash(__('Invalid username or password, try again'));
	}
    }
    
    public function logout() {
	$this->layout = 'loginandlogout';
	return $this->redirect($this->Auth->logout());
    }
    
    public function index() {
	//$this->layout = 'loginandlogout';
	$this->layout = 'default2';
	$this->User->recursive = 0;
	$this->set('users', $this->paginate());
    }
    
    public function view($id = null) {
	$this->layout = 'default2';
	$this->User->id = $id;
	if (!$this->User->exists()) {
	    throw new NotFoundException(__('Invalid user'));
	}
	$this->set('user', $this->User->read(null, $id));
    }
    
    public function add() {
	$this->layout = 'default2';
	if ($this->request->is('post')) {
	    $this->User->create();
	    if ($this->User->save($this->request->data)) {
		$this->Session->setFlash(__('The user has been saved'));
		return $this->redirect(array('action' => 'index'));
	    }
	    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
	}
    }
    
    public function edit($id = null) {
	$this->layout = 'default2';
	$this->User->id = $id;
	if (!$this->User->exists($id)) {
	    throw new NotFoundException(__('Invalid user'));
	}
	if ($this->request->is('post') || $this->request->is('put')) {
	    if(($this->Auth->user('id') != $this->User->id) && ($this->Auth->user('role') != 'admin')){
		$this->Session->setFlash(__('You can edit only your information, Please try again.'));
	    }else {
	    
		if ($this->User->save($this->request->data)) {
		    $this->Session->setFlash(__('The user has been saved'));
		    return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
	    }
	} else {
	    $this->request->data = $this->User->read(null, $id);
	    unset($this->request->data['User']['password']);
	}
    }
    
    public function delete($id = null) {
	$this->layout = 'default2';
	//$this->request->onlyAllow('post');
	
	if($this->Auth->user('role') === 'admin'){
	    $this->User->id = $id;
	    if (!$this->User->exists($id)) {
		throw new NotFoundException(__('Invalid user'));
	    }
	    if ($this->User->delete($id)) {
		$this->Session->setFlash(__('User deleted'));
		return $this->redirect(array('action' => 'index'));
	    }
	
	    $this->Session->setFlash(__('User was not deleted'));
	    return $this->redirect(array('action' => 'index'));
	}else{
	    $this->Session->setFlash(__('You do not have permission for this action, Please contact an Administrator'));
	    return $this->redirect(array('action' => 'index'));
	}
    }
}
?>
