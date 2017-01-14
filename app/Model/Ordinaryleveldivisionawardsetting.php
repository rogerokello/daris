<?php
App::uses('AppModel', 'Model');
/*
 * Dependantdetail Model
 *
 * @property Staffdetail $Staffdetail
 */
class Ordinaryleveldivisionawardsetting extends AppModel {

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
}
