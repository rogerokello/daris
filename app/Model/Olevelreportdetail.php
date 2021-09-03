<?php
//App::uses('Student','Model');
class Olevelreportdetail extends AppModel {
    
    public $hasMany = array(

		'Olevelreport' => array(
			'className' => 'Olevelreport',
			'foreignKey' => 'olevelreportdetail_id',
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
		// 'Alevelreport' => array(
		// 	'className' => 'Olevelreport',
		// 	'foreignKey' => 'olevelreportdetail_id',
		// 	'dependent' => true,
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => '',
		// 	'limit' => '',
		// 	'offset' => '',
		// 	'exclusive' => '',
		// 	'finderQuery' => '',
		// 	'counterQuery' => ''
		// )
	);
	
	
    public function updateReport($reportdetail_id = null, $updateflag = null){
    
	$Olevelreports = ClassRegistry::init('Olevelreport');
	if(($reportdetail_id != null) && ($updateflag == 1)){
	
	      $Olevelreports->report_add_examsconsidered($reportdetail_id,null);// Expensive operation
	      $Olevelreports->report_gradesubjects($reportdetail_id,null);// Expensive operation
	      $Olevelreports->report_getaggregates($reportdetail_id);
	      $Olevelreports->report_get_total_mark($reportdetail_id,null);
	      $Olevelreports->report_getdivision($reportdetail_id);
	      $Olevelreports->report_get_position($reportdetail_id, null); // Expensive operation
	
	}
	
	if(($reportdetail_id != null) && ($updateflag == 2)){
	
	
	
	}
    
    }
    
    
/*
    public $validate = array(
      'registrationnumber' => array(
	  'registrationnumberRule-2' => array(
	      'rule' => 'isUnique',
	      'message' => 'This registration number is already taken, please enter another one',
	   )   
      ),
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
*/
/*
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
*/

public $findMethods = array('search' => true);
protected function _findSearch($state, $query, $results = array())
{
  if ($state === 'before') {
    $searchQuery = Hash::get($query, 'searchQuery');
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.reportname LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.reportyear LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.reportterm LIKE" => '%' . $searchQuery . '%',
        //"{$this->alias}.fullnames LIKE" => '%' . $searchQuery . '%'
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
?>
