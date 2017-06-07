<?php
App::uses('AppModel', 'Model');
class Classteacher extends AppModel {

/*
 * Display field
 *
 * @var string
 */
	//public $displayField = 'name';

	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

    public $validate = array(
    /*
    'fullexamname' => array(
	  'fullexamnamerule-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The examination name already exists, please choose another subject name',
	   )
      ),
      'alias' => array(
	  'alias-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The short examination name already exists, please choose another subject name',
	   ),
	  'alias-2' => array(
	      'rule' => '/^[a-zA-Z0-9.\-\s]{3,12}$/i',
	      'message' => 'The short examination name must be between 3 to 12 characters long',
	   ),	   
      )
      
    */
    );


public $findMethods = array('search' => true);
protected function _findSearch($state, $query, $results = array())
{
  //$new = ClassRegistry::init('Student');
  if ($state === 'before') {
    $searchQuery = Hash::get($query, 'searchQuery');
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.names LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.stream LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.year LIKE" => '%' . $searchQuery . '%',
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
?>