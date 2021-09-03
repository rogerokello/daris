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
class ReportsettingsController extends AppController {
    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session');

    /**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
  public function edit($unique_setting_name = null) {
    $this->layout = 'default2';

    if (!$unique_setting_name){
        throw new NotFoundException(__('Invalid Setting'));
    }

	  $setting = $this->Reportsetting->findByUniqueSettingName($unique_setting_name);
	
	  if (!$setting){
	    throw new NotFoundException(__('Invalid Setting'));
	  }

    if ($this->request->is(array('post', 'put'))) {

	    $this->Reportsetting->id = $setting["Reportsetting"]["id"];
      if ($this->Reportsetting->save($this->request->data)) {
        $this->Session->setFlash('Settings updated successfully');
      }else {
        $this->Session->setFlash('Something went wrong. Please check fields');
      }
    }

    if (!$this->request->data) {
	    $this->request->data = $setting;
	  }

    $this->set('settings',$setting);
  }
}

?>