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
      'surname' => array(
	  
	  'surnameRule-1' => array(
	      'rule' => array('minLength', 1),
	      'message' => 'A Surname is required',	  
	  )
	  
      ),      
      'othernames' => array(
	  
	  'othernamesRule-1' => array(
	      'rule' => array('minLength', 1),
	      'message' => 'Othername(s) is(are) required',	  
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
    $studentnotpartofschool = Hash::get($query, 'studentnotpartofschool');
    $elementsofquery = array();
    $elementsofquery['currentclass'] = Hash::get($query, 'currentclass');
    $elementsofquery['joiningdate'] = Hash::get($query, 'joiningdate');
    $elementsofquery['leavingdate'] = Hash::get($query, 'leavingdate');
    $elementsofquery['currentstream'] = Hash::get($query, 'currentstream');
    $elementsofquery['sex'] = Hash::get($query, 'sex');
    $elementsofquery['availabilitystatus'] = Hash::get($query, 'availabilitystatus');
    $elementsofquery['religion'] = Hash::get($query, 'religion');
    
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.registrationnumber LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.surname LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.othernames LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.fullnames LIKE" => '%' . $searchQuery . '%'
      ), 
      'and' => array(
        
      )
    );
    
    if($studentnotpartofschool === "1"){
    
	$searchConditions = array(
	  'or' => array(
	    "{$this->alias}.registrationnumber LIKE" => '%' . $searchQuery . '%',
	    "{$this->alias}.surname LIKE" => '%' . $searchQuery . '%',
	    "{$this->alias}.othernames LIKE" => '%' . $searchQuery . '%',
	    "{$this->alias}.fullnames LIKE" => '%' . $searchQuery . '%'
	  ), 
	  'and' => array(
	    "{$this->alias}.leavingreason NOT LIKE" => 'None',
	  )
	);
    
    }else{
    
	$searchConditions = array(
	  'or' => array(
	    "{$this->alias}.registrationnumber LIKE" => '%' . $searchQuery . '%',
	    "{$this->alias}.surname LIKE" => '%' . $searchQuery . '%',
	    "{$this->alias}.othernames LIKE" => '%' . $searchQuery . '%',
	    "{$this->alias}.fullnames LIKE" => '%' . $searchQuery . '%',
	    //"{$this->alias}.joiningdate like" => "".$elementsofquery['joiningdate']/*['year']*/.""
	  ), 
	  'and' => array(
	    "{$this->alias}.leavingreason LIKE" => 'None',
	  )
	); 	  
    
    }
    
    
    
    if($elementsofquery['currentclass'] != ''){
	    $searchConditions['and']["{$this->alias}.currentclass ="] = $elementsofquery['currentclass'];
    }
    
    if($elementsofquery['joiningdate']['year'] != ''){
	    $searchConditions['and']["{$this->alias}.joiningdate like"] = '%'.(string)$elementsofquery['joiningdate']['year'].'%';
    }

    if($elementsofquery['leavingdate']['year'] != ''){
	    $searchConditions['and']["{$this->alias}.leavingdate like"] = '%'.(string)$elementsofquery['leavingdate']['year'].'%';
    }
    
    if($elementsofquery['currentstream'] != ''){
	    $searchConditions['and']["{$this->alias}.currentstream like"] = '%'.(string)$elementsofquery['currentstream'].'%';
    }
    
    if($elementsofquery['sex'] != ''){
	    $searchConditions['and']["{$this->alias}.sex like"] = '%'.(string)$elementsofquery['sex'].'%';
    }
    
    if($elementsofquery['availabilitystatus'] != ''){
	    $searchConditions['and']["{$this->alias}.availabilitystatus like"] = '%'.(string)$elementsofquery['availabilitystatus'].'%';
    }

    if($elementsofquery['religion'] != ''){
	    $searchConditions['and']["{$this->alias}.religion like"] = '%'.(string)$elementsofquery['religion'].'%';
    }
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
?>
