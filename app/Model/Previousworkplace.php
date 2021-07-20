<?php
App::uses('AppModel', 'Model');
/**
 * Previousworkplace Model
 *
 * @property Staffdetail $Staffdetail
 */
class Previousworkplace extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'staffdetail_id';
	
	//public $primaryKey = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Staffdetail' => array(
			'className' => 'Staffdetail',
			'foreignKey' => 'staffdetail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
