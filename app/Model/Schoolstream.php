<?php
App::uses('AppModel', 'Model');
class Schoolstream extends AppModel {

/*
 * Display field
 *
 * @var string
 */
	//public $displayField = 'name';

	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

    public $validate = array(
      'stream' => array(
	  'streamrule-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The stream name already exists, please choose another stream name',
	      )
	  ),
      'shortstreamname' => array(
	  'shortstreamnamerule-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The short stream name already exists, please choose another short stream name',
	      )
	  ),
      );


public $findMethods = array('search' => true);
protected function _findSearch($state, $query, $results = array())
{
  //$new = ClassRegistry::init('Student');
  if ($state === 'before') {
    $searchQuery = Hash::get($query, 'searchQuery');
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.stream LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.shortstreamname LIKE" => '%' . $searchQuery . '%',
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
?>