<?php
App::uses('AppModel', 'Model');
/*
 * Dependantdetail Model
 *
 * @property Staffdetail $Staffdetail
 */
class Advancedlevelpointsaward extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'staffdetail_id';

	//public $primaryKey = 'id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Gradeprofile' => array(
			'className' => 'Gradeprofile',
			'foreignKey' => 'gradeprofile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
    public $validate = array(
    
	'lowestvalue' => array(
	    'lowestvaluerule-1' => array(
		////,
		'rule'	=> array('range', -1, 10),
		'allowEmpty' => true,
		'message'	=> 'Please enter a number between 0 and 9'	    
	    ),
	
	),    
	'highestvalue' => array(
	    'highestvaluerule-1' => array(
		////,
		'rule'	=> array('range', -1, 10),
		'allowEmpty' => true,
		'message'	=> 'Please enter a number between 0 and 9'	    
	    ),
	
	),
	'award' => array(
	    'awardrule-1' => array(
		////,
		'rule'=> array('inList', array(' ','A', 'B','C', 'D','E', 'F','O')),
		'allowEmpty' => true,
		'message'	=> 'Please choose a correct award'	    
	    ),
	
	),
    
    );
}
