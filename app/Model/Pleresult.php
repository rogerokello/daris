<?php
//App::uses('Student','Model');
class Pleresult extends AppModel {

    public $primaryKey = 'student_id';
    public $belongsTo = array(
	'Student' => array(
	    'className' => 'Student',
	    'foreignKey' => 'student_id'
	 )
    );
}
?>