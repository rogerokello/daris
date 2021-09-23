<?php
//App::uses('Student','Model');
class Alevelreportdetail extends AppModel {
    
    public $hasMany = array(
		'Alevelreport' => array(
			'className' => 'Alevelreport',
			'foreignKey' => 'alevelreportdetail_id',
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
	
    // Get how many rows may be contained for a piece of text in a cell
    public function getRowcount($text, $width=17) {
      $line_count = 0;
      $line = preg_split("/\s+/", $text);
      $complete_line = "";

      foreach ($line as $source) {
        if (strlen($complete_line." ".$source) == $width ){
          $complete_line = "";
          $line_count++;
          continue;
        }
        
        if (strlen($complete_line." ".$source) > $width ){
          $complete_line = $source;
          $line_count++;
          continue;
        }

        $complete_line.=" ".$source;
      }

      if ($line_count == 0 && strlen($text) == 0) {
        // Assume we have only one line.
        return 1;
      }

      if ($line_count == 0 && (strlen($complete_line) > 0 && strlen($complete_line) < $width)) {
        // We have only one line and return
        return 1;
      }

      if ($line_count > 0 && (strlen($complete_line) > 0 && strlen($complete_line) < $width)) {
        // We have an extra line so increment line count by one
        $line_count++;
      }
      return $line_count;
    }
	
    public function updateReport($reportdetail_id = null, $updateflag = null, $class = null){
      $Alevelreport = ClassRegistry::init('Alevelreport');
      if(($reportdetail_id != null) && ($updateflag == 1)){
        $Alevelreport->report_add_examsconsidered($reportdetail_id, null);
        $Alevelreport->report_grade_subjects($reportdetail_id,null); // Grade individual subjects ie D1 yadi yada
        $Alevelreport->report_get_final_subject_grades($reportdetail_id,null); // Grade all papers done ie A B C or D 
        $Alevelreport->report_get_points($reportdetail_id, $class, null); // Get the total points for each student
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
