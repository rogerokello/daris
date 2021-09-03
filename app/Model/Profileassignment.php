<?php
//App::uses('Student','Model');
class Profileassignment extends AppModel {

    public $primaryKey = 'id';

    public $belongsTo = array(
      'Gradeprofile' => array(
        'className' => 'Gradeprofile',
        'foreignKey' => 'gradeprofile_id',
        'conditions' => '',
        'fields' => '',
        'order' => ''
      )
    );
}
?>