<?php
App::uses('AppModel', 'Model');

/*
 * Staffdetail Model
 *
 * @property Dependantdetail $Dependantdetail
 * @property Previousworkplace $Previousworkplace
 */
class Schooldoneasubject extends AppModel {

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
	      'rule' => '/^[a-zA-Z_]{2,8}$/i',
	      'message' => 'Only alphabetic words allowed, they must be from 2 to 8 letters long',
	   ),
	   'shortsubjectname-3' => array(
	      'on' => 'create',
	      'rule' => array('checkcolumnnameexistence'),
	      'message' => 'The subject name already exists, please choose another subject name',
	   )
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
    $new = ClassRegistry::init('Alevelmarksheetresult');

    // perform a query using the model you loaded
    $livequery = $new->query("DESCRIBE alevelmarksheetresults;");

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

public function deleteColumninTable($shortsubjectname,$value2,$is_subsidiary){
        
    if($is_subsidiary == 0){
	// Start modification of 
	$grade = "_grade";
	$new  = ClassRegistry::init('Alevelmarksheetresult');
	$new2 = ClassRegistry::init('Alevelreport');
	$new->query("ALTER TABLE alevelmarksheetresults DROP ".$shortsubjectname."_finalgrade".";");
	$new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname."_finalgrade".";");
    
	if( ($value2 != null) && (is_array($value2))){
    
	    foreach ($value2 as $avalue) {	
	
		$avalue = (string)$avalue;
	    
		if($avalue != ""){
	    
		    $new->query("ALTER TABLE alevelmarksheetresults DROP ".$shortsubjectname.$avalue."_mark".";");	    
		    $new->query("ALTER TABLE alevelmarksheetresults DROP ".$shortsubjectname.$avalue.$grade.";");	    
	    
		    $new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname.$avalue."_finalaveragemark".";");
		    $new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname.$avalue."_finalaveragemarkgrade".";");
		    $examsconsidered = "_examsconsidered";
		    $new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname.$avalue.$examsconsidered.";");    
	    
		}
	    }
	}
    }else{
    
	// Start modification of 
	$grade = "_grade";
	$new  = ClassRegistry::init('Alevelmarksheetresult');
	$new2 = ClassRegistry::init('Alevelreport');
	$new->query("ALTER TABLE alevelmarksheetresults DROP ".$shortsubjectname."_finalgrade".";");
	$new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname."_finalgrade".";");
    

	    
	$new->query("ALTER TABLE alevelmarksheetresults DROP ".$shortsubjectname."_mark".";");	    
	$new->query("ALTER TABLE alevelmarksheetresults DROP ".$shortsubjectname.$grade.";");	    
	    
	$new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname."_finalaveragemark".";");
	$new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname."_finalaveragemarkgrade".";");
	$examsconsidered = "_examsconsidered";
	$new2->query("ALTER TABLE alevelreports DROP ".$shortsubjectname.$examsconsidered.";");    	
    
    }
}

public function alterSubsidiaryColumn($previousshortsubjectname, $newshortsubjectname) {

}

public function alterColumninTable( $previousshortsubjectname,$newshortsubjectname,
				    $subjectpaperstoremove,$subjectpaperstoadd,$subjectpaperstochange,$subject_was_sub_before
				  ) {

    // load the marksheet model with the data    
    $grade = "_grade";
    $new  = ClassRegistry::init('Alevelmarksheetresult');
    $datasourcemarksheet = $new->getDataSource();
    $datasourcemarksheet->begin();
    $new2 = ClassRegistry::init('Alevelreport');
    $datasourcereport = $new->getDataSource();
    $datasourcereport->begin();
    $new->query("ALTER TABLE alevelmarksheetresults CHANGE ".$previousshortsubjectname."_finalgrade"." ".$newshortsubjectname."_finalgrade"." VARCHAR(1) NULL DEFAULT NULL;");
    
    $new2->query("ALTER TABLE alevelreports CHANGE ".$previousshortsubjectname."_finalgrade"." ".$newshortsubjectname."_finalgrade"." VARCHAR(1) NULL DEFAULT NULL;");
    
    if($subject_was_sub_before == 1){
    
	// First remove the information for the subsidiary subject from the table
	$new->query("ALTER TABLE alevelmarksheetresults DROP ".$previousshortsubjectname."_mark".";");	    
	$new->query("ALTER TABLE alevelmarksheetresults DROP ".$previousshortsubjectname.$grade.";");	    
	    
	$new2->query("ALTER TABLE alevelreports DROP ".$previousshortsubjectname."_finalaveragemark".";");
	$new2->query("ALTER TABLE alevelreports DROP ".$previousshortsubjectname."_finalaveragemarkgrade".";");
	$examsconsidered = "_examsconsidered";
	$new2->query("ALTER TABLE alevelreports DROP ".$previousshortsubjectname.$examsconsidered.";");
	
	if( ($subjectpaperstoadd != null) && (is_array($subjectpaperstoadd))){
    
	    foreach ($subjectpaperstoadd as $avalue) {	
	
		$avalue = (string)$avalue;
	    
		if($avalue != ""){
	    
		    $new->query("ALTER TABLE alevelmarksheetresults ADD ".$newshortsubjectname.$avalue."_mark"." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
		    $new->query("ALTER TABLE alevelmarksheetresults ADD ".$newshortsubjectname.$avalue.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
	    
		    $new2->query("ALTER TABLE alevelreports ADD ".$newshortsubjectname.$avalue."_finalaveragemark"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $new2->query("ALTER TABLE alevelreports ADD ".$newshortsubjectname.$avalue."_finalaveragemarkgrade"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $examsconsidered = "_examsconsidered";
		    $new2->query("ALTER TABLE alevelreports ADD ".$newshortsubjectname.$avalue.$examsconsidered." VARCHAR(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");    
	    
		}
	    }
	}	
    
    }else{
	if( ($subjectpaperstoremove != null) && (is_array($subjectpaperstoremove))){
    
	    foreach ($subjectpaperstoremove as $avalue) {	
	
		$avalue = (string)$avalue;
	    
		if($avalue != ""){
	    
		    $new->query("ALTER TABLE alevelmarksheetresults DROP ".$previousshortsubjectname.$avalue."_mark".";");	    
		    $new->query("ALTER TABLE alevelmarksheetresults DROP ".$previousshortsubjectname.$avalue.$grade.";");	    
	    
		    $new2->query("ALTER TABLE alevelreports DROP ".$previousshortsubjectname.$avalue."_finalaveragemark".";");
		    $new2->query("ALTER TABLE alevelreports DROP ".$previousshortsubjectname.$avalue."_finalaveragemarkgrade".";");
		    $examsconsidered = "_examsconsidered";
		    $new2->query("ALTER TABLE alevelreports DROP ".$previousshortsubjectname.$avalue.$examsconsidered.";");    
	    
		}
	    }
	}    
    
	if( ($subjectpaperstoadd != null) && (is_array($subjectpaperstoadd))){
    
	    foreach ($subjectpaperstoadd as $avalue) {	
	
		$avalue = (string)$avalue;
	    
		if($avalue != ""){
	    
		    $new->query("ALTER TABLE alevelmarksheetresults ADD ".$newshortsubjectname.$avalue."_mark"." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
		    $new->query("ALTER TABLE alevelmarksheetresults ADD ".$newshortsubjectname.$avalue.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
	    
		    $new2->query("ALTER TABLE alevelreports ADD ".$newshortsubjectname.$avalue."_finalaveragemark"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $new2->query("ALTER TABLE alevelreports ADD ".$newshortsubjectname.$avalue."_finalaveragemarkgrade"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $examsconsidered = "_examsconsidered";
		    $new2->query("ALTER TABLE alevelreports ADD ".$newshortsubjectname.$avalue.$examsconsidered." VARCHAR(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");    
	    
		}
	    }
	}
    
	if( ($subjectpaperstochange != null) && (is_array($subjectpaperstochange))){
    
	    foreach ($subjectpaperstochange as $avalue) {	
	
		$avalue = (string)$avalue;
	    
		if($avalue != ""){
	    
		    $new->query("ALTER TABLE alevelmarksheetresults CHANGE ".$previousshortsubjectname.$avalue."_mark"." ".$newshortsubjectname.$avalue."_mark"." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
		    $new->query("ALTER TABLE alevelmarksheetresults CHANGE ".$previousshortsubjectname.$avalue.$grade." ".$newshortsubjectname.$avalue.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
	    
		    $new2->query("ALTER TABLE alevelreports CHANGE ".$previousshortsubjectname.$avalue."_finalaveragemark"." ".$newshortsubjectname.$avalue."_finalaveragemark"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $new2->query("ALTER TABLE alevelreports CHANGE ".$previousshortsubjectname.$avalue."_finalaveragemarkgrade"." ".$newshortsubjectname.$avalue."_finalaveragemarkgrade"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $examsconsidered = "_examsconsidered";
		    $new2->query("ALTER TABLE alevelreports CHANGE ".$previousshortsubjectname.$avalue.$examsconsidered." ".$newshortsubjectname.$avalue.$examsconsidered." VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");    
	    
		}
	    }
	}
	
    }
    $datasourcereport->commit();
    $datasourcemarksheet->commit();
    
}

public function addColumninTable($newcolumnname,$value2,$paper_is_subsidiary = null){
    // load the marksheet model with the data
    if($paper_is_subsidiary == 1){
	$grade = "_grade";
	$new  = ClassRegistry::init('Alevelmarksheetresult');
	$new2 = ClassRegistry::init('Alevelreport');
	$new->query("ALTER TABLE alevelmarksheetresults ADD ".$newcolumnname."_finalgrade"." VARCHAR(1) NULL DEFAULT NULL;");
	$new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname."_finalgrade"." VARCHAR(1) NULL DEFAULT NULL;");
    
  
	$new->query("ALTER TABLE alevelmarksheetresults ADD ".$newcolumnname."_mark"." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
	$new->query("ALTER TABLE alevelmarksheetresults ADD ".$newcolumnname.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
	    
	$new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname."_finalaveragemark"." INT(11) UNSIGNED NULL DEFAULT NULL;");
	$new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname."_finalaveragemarkgrade"." INT(11) UNSIGNED NULL DEFAULT NULL;");
	$examsconsidered = "_examsconsidered";
	$new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname.$examsconsidered." VARCHAR(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");    
	    
		
    
    } else {
	$grade = "_grade";
	$new  = ClassRegistry::init('Alevelmarksheetresult');
	$new2 = ClassRegistry::init('Alevelreport');
	$new->query("ALTER TABLE alevelmarksheetresults ADD ".$newcolumnname."_finalgrade"." VARCHAR(1) NULL DEFAULT NULL;");
	$new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname."_finalgrade"." VARCHAR(1) NULL DEFAULT NULL;");
    
	if( ($value2 != null) && (is_array($value2))){
    
	    foreach ($value2 as $avalue) {	
	
		$avalue = (string)$avalue;
	    
		if($avalue != ""){
	    
		    $new->query("ALTER TABLE alevelmarksheetresults ADD ".$newcolumnname.$avalue."_mark"." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
		    $new->query("ALTER TABLE alevelmarksheetresults ADD ".$newcolumnname.$avalue.$grade." INT(11) UNSIGNED NULL DEFAULT NULL;");	    
	    
		    $new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname.$avalue."_finalaveragemark"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname.$avalue."_finalaveragemarkgrade"." INT(11) UNSIGNED NULL DEFAULT NULL;");
		    $examsconsidered = "_examsconsidered";
		    $new2->query("ALTER TABLE alevelreports ADD ".$newcolumnname.$avalue.$examsconsidered." VARCHAR(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;");    
	    
		}
	    }
	}
    }
}

public function checkIfResultsAreInColumn($subjectpaper,$shortsubjectname){
    //load the marksheet model with the data
    $new = ClassRegistry::init('Alevelmarksheetresult');
    $new2 = ClassRegistry::init('Alevelreport');
    //$findby = 
    //$found = $new->
    $marksheetresult = $new->field($shortsubjectname.$subjectpaper."_mark",
	array($shortsubjectname.$subjectpaper."_mark !=" => "")
    );
    
    $reportresult = $new2->field($shortsubjectname.$subjectpaper."_finalaveragemark",
	array($shortsubjectname.$subjectpaper."_finalaveragemark !=" => "")
    );
    
    if(($marksheetresult == false) && ($reportresult == false)){

	return false;
	
    }else {
    
	return true;
    
    }
}

public function checkIfResultsAreInatleastaColumn($subjectpapers,$shortsubjectname){

    $counter = 0;
    foreach($subjectpapers as $subjectpaper){
    
	if($this->checkIfResultsAreInColumn($subjectpaper,$shortsubjectname) == true){
	    $counter = $counter + 1;
	    break;
	}
	
    }
    
    if($counter == 0){
	return false;
    }else{
	return true;
    }
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
