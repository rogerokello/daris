<?php
//App::uses('Student','Model');
class Student extends AppModel {

    public $hasOne = array(
	'Uceresult' => array(
	    'className' => 'Uceresult',
	    'foreignKey' => 'student_id',
	    'dependent' => true
	),

	'Pleresult' => array(
	    'className' => 'Pleresult',
	    'foreignKey' => 'student_id',
	    'dependent' => true
	),
	
	'Alevelsubjectcombination' => array(
	    'className' => 'Alevelsubjectcombination',
	    'foreignKey' => 'student_id',
	    'dependent' => true
	),	
    );
    
    public $hasMany = array(
		'Olevelmarksheetresult' => array(
			'className' => 'Olevelmarksheetresult',
			'foreignKey' => 'student_id',
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
		'Olevelreport' => array(
			'className' => 'Olevelreport',
			'foreignKey' => 'student_id',
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
      'registrationnumber' => array(
	  
	  'registrationnumberRule-1' => array(
	      'rule' => array('minLength', 1),
	      'message' => 'A registration number is required',	  
	  ),
	  
	  'registrationnumberRule-2' => array(
	      
	      'rule' => 'isUnique',
	      'message' => 'This registration number is already taken, please enter another one',
	   )   
      ),
      'picturepath' => array(


	    'checksize' => array(
		  'allowEmpty' => true,
		  'rule' => array('checkfilesize'),
		  'message' => 'Your image file must be less than or equal to 200 kilobytes',
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
    if ($uploadData['size'] >= 204800)
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
        "{$this->alias}.surname LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.othernames LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.fullnames LIKE" => '%' . $searchQuery . '%'
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
?>
