<?php
App::uses('AppModel', 'Model');

/*
 * Staffdetail Model
 *
 * @property Dependantdetail $Dependantdetail
 * @property Previousworkplace $Previousworkplace
 */
class Schooldonesubject extends AppModel {

/*
 * Display field
 *
 * @var string
 */
	//public $displayField = 'name';

	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

    public $validate = array(
      'fullsubjectname' => array(
	  'fullsubjectnamerule-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The subject name already exists, please choose another subject name',
	   )
      ),
      'shortsubjectname' => array(
	  'shortsubjectname-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The short subject name already exists, please choose another subject name',
	   ),
	   'shortsubjectname-2' => array(
	      'rule' => '/^[a-z]{3,8}$/i',
	      'message' => 'Only alphabetic words allowed, they must be between 3 to 8 letters long',
	   ),
	   'shortsubjectname-3' => array(
	      'on' => 'create',
	      'rule' => array('checkcolumnnameexistence'),
	      'message' => 'The subject name already exists, please choose another subject name',
	   ),
      ),
      'subjectcode' => array(
	  'subjectcoderule-1' => array(
	      'rule' => 'isUnique',
	      'message' => 'The subject code already exists, please choose another subject name',
	   )
      ),

    );

public function checkcolumnnameexistence($check)
{
    //pick out the value in the array(The value that was in the post data)
    $uploadData = array_shift($check);

    // load the model with the data
    $new = ClassRegistry::init('Olevelmarksheetresult');

    // perform a query using the model you loaded
    $livequery = $new->query("DESCRIBE olevelmarksheetresults;");

  $newarray = array();

    $arraycouter = 0;  
    foreach($livequery as $livequery2){
	    if($arraycouter >=12){
		   array_push($newarray,$livequery2['COLUMNS']['Field']);
	    }
	    $arraycouter++;
    }

    if(in_array($uploadData,$newarray)){
	return false;
    }else
    {
	/*
	  perform column name addition to the database table once you have found out
	  that the column name does not exist and also that the the field names are as specified
	*/
	//$new->query("ALTER TABLE olevelmarksheetresults ADD ".$uploadData." INT(11) UNSIGNED NULL DEFAULT NULL;");
	
	return true;
    }

}

public function deleteColumninTable($shortsubjectname){
    // load the marksheet model with the data
    $new = ClassRegistry::init('Olevelmarksheetresult');
    $grade = "_grade";
    $new->query("ALTER TABLE olevelmarksheetresults DROP ".$shortsubjectname.";");
    $new->query("ALTER TABLE olevelmarksheetresults DROP ".$shortsubjectname.$grade.";");
    $new2 = ClassRegistry::init('Olevelreport');
    $new2->query("ALTER TABLE olevelreports DROP ".$shortsubjectname.";");
    $examsconsidered = "_examsconsidered";
    $new2->query("ALTER TABLE olevelreports DROP ".$shortsubjectname.$examsconsidered.";");
    
    $new2->query("ALTER TABLE olevelreports DROP ".$shortsubjectname.$grade.";");
    $date_created = "_datecreated";
    $new2->query("ALTER TABLE olevelreports DROP ".$shortsubjectname.$date_created.";");
    
}

public function alterColumninTable($previousshortsubjectname,$newshortsubjectname){
    // load the marksheet model with the data
    $new = ClassRegistry::init('Olevelmarksheetresult');
    $grade = "_grade";
    $new->query("ALTER TABLE olevelmarksheetresults CHANGE ".$previousshortsubjectname." ".$newshortsubjectname." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $new->query("ALTER TABLE olevelmarksheetresults CHANGE ".$previousshortsubjectname.$grade." ".$newshortsubjectname.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $new2 = ClassRegistry::init('Olevelreport');
    $new2->query("ALTER TABLE olevelreports CHANGE ".$previousshortsubjectname." ".$newshortsubjectname." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $examsconsidered = "_examsconsidered";
    $new2->query("ALTER TABLE olevelreports CHANGE ".$previousshortsubjectname.$examsconsidered." ".$newshortsubjectname.$examsconsidered." VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");
    
    $new2->query("ALTER TABLE olevelreports CHANGE ".$previousshortsubjectname.$grade." ".$newshortsubjectname.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $date_created = "_datecreated";
    $new2->query("ALTER TABLE olevelreports CHANGE ".$previousshortsubjectname.$date_created." ".$newshortsubjectname.$date_created."  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;");
    
    //ALTER TABLE `olevelmarksheetresults` CHANGE `klkjlpj` `klkjlpjj` INT(11) UNSIGNED NULL DEFAULT NULL;
}

public function addColumninTable($newcolumnname){
    // load the marksheet model with the data
    
    $new  = ClassRegistry::init('Olevelmarksheetresult');
    $new2 = ClassRegistry::init('Olevelreport');
    $grade = "_grade";
    $new->query("ALTER TABLE olevelmarksheetresults ADD ".$newcolumnname." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $new->query("ALTER TABLE olevelmarksheetresults ADD ".$newcolumnname.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $new2->query("ALTER TABLE olevelreports ADD ".$newcolumnname." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $examsconsidered = "_examsconsidered";
    $new2->query("ALTER TABLE olevelreports ADD ".$newcolumnname.$examsconsidered." VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");
    
    $new2->query("ALTER TABLE olevelreports ADD ".$newcolumnname.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");
    $date_created = "_datecreated";
    $new2->query("ALTER TABLE olevelreports ADD ".$newcolumnname.$date_created." TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;");
    
}

public function checkIfResultsAreInColumn($columnname){
    //load the marksheet model with the data
    $new = ClassRegistry::init('Olevelmarksheetresult');
    //$findby = 
    //$found = $new->
}

public $findMethods = array('search' => true);
protected function _findSearch($state, $query, $results = array())
{
  //$new = ClassRegistry::init('Student');
  if ($state === 'before') {
    $searchQuery = Hash::get($query, 'searchQuery');
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.fullsubjectname LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.shortsubjectname LIKE" => '%' . $searchQuery . '%',
        "{$this->alias}.subjectcode LIKE" => '%' . $searchQuery . '%',
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
