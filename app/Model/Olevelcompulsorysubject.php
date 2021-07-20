<?php
App::uses('AppModel', 'Model');
/**
 * Olevelcompulsorysubject Model
 *
 */
class Olevelcompulsorysubject extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'compulsorysubjects';
	
	public $validate = array(
	
	    /*'year' => array(
		'rule' => array('isUnique', array('year', 'class'), false),
		'message' => 'Sorry this Year & Class combination has already been used.'
	    ),*/	    
	
	);
	
	
	
	public $findMethods = array('search' => true);
	protected function _findSearch($state, $query, $results = array())
	{
	  //$new = ClassRegistry::init('Student');
	    if ($state === 'before') {
		$searchQuery = Hash::get($query, 'searchQuery');
		$searchConditions = array(
		    'or' => array(
			"{$this->alias}.year LIKE" => '%' . $searchQuery . '%',
		    )
		);
    
		$query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
		return $query;
	    }
	    return $results;
	}

}
