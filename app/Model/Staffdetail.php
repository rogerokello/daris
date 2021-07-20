<?php
App::uses('AppModel', 'Model');
/**
 * Staffdetail Model
 *
 * @property Dependantdetail $Dependantdetail
 * @property Previousworkplace $Previousworkplace
 */
class Staffdetail extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Dependantdetail' => array(
			'className' => 'Dependantdetail',
			'foreignKey' => 'staffdetail_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Previousworkplace' => array(
			'className' => 'Previousworkplace',
			'foreignKey' => 'staffdetail_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public $validate = array(
      'picturepath' => array(
	  'checksize' => array(
	      'allowEmpty' => true,
	      'rule' => array('checkfilesize'),
	      'message' => 'Your image file must be less than 6MB',
	  ),

	  'rule2'=>array(
	      'allowEmpty' => true,
	      'rule' => array('checkimagetype'),
	      'message' => 'Select Valid Image file type, The only types allowed are jpeg,png and gif formats',
	  )
      )        
    );

 
public function checkfilesize($check)
{
    // Shift the array to easily access $_POST
    $uploadData = array_shift($check);

    // Basic checks
    if ($uploadData['size'] >= 6291456)
    {
        return false;
    }else
    {
	return true;
    }
}

public function checkimagetype($check)
{
	$uploadData = array_shift($check);
    
    
	$extension = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/jpg');
	$isValidFile = in_array($uploadData['type'], $extension);

	// Basic checks
	if ($isValidFile  || ($uploadData['size'] == 0 || $uploadData['error'] !== 0))
	{
	    return true;
	}else
	{
	    return false;
	}

}

public $findMethods = array('search' => true);
protected function _findSearch($state, $query, $results = array())
{
  if ($state === 'before') {
    $searchQuery = Hash::get($query, 'searchQuery');
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.registrationnumber LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.name LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.tribe LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.maritalstatus LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.homecountry LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.homedistrict LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.accountdetails LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.phonenumbers LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.emailaddresses LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.healthstatus LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.religion LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.availabilitystatus LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.sex LIKE" => '%' . $searchQuery . '%',
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
