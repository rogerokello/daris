<?php
App::uses('AppModel', 'Model');
/*
 * Staffdetail Model
 *
 * @property Dependantdetail $Dependantdetail
 * @property Previousworkplace $Previousworkplace
 */
class Gradeprofile extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'profilename';

	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/*
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Grading' => array(
			'className' => 'Grading',
			'foreignKey' => 'gradeprofile_id',
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
		'Ordinaryleveldivisionaward' => array(
			'className' => 'Ordinaryleveldivisionaward',
			'foreignKey' => 'gradeprofile_id',
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
		'Advancedlevelpointsaward' => array(
			'className' => 'Advancedlevelpointsaward',
			'foreignKey' => 'gradeprofile_id',
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
    'Profileassignment' => array(
			'className' => 'Profileassignment',
			'foreignKey' => 'gradeprofile_id',
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
	
	public $hasOne = array(
		'Ordinaryleveldivisionawardsetting' => array(
			'className' => 'Ordinaryleveldivisionawardsetting',
			'foreignKey' => 'gradeprofile_id',
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
		'Advancedlevelpointsawardsetting' => array(
			'className' => 'Advancedlevelpointsawardsetting',
			'foreignKey' => 'gradeprofile_id',
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
		'Gradeprofileusesetting' => array(
			'className' => 'Gradeprofileusesetting',
			'foreignKey' => 'gradeprofile_id',
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
	);

    public $validate = array(
    
	'profilename' => array(
	    'profilenamerule-1' => array(
		'on' => 'create',
		'rule'=> 'isUnique',
		'message' => 'This profile name has already been used. Please choose another one'	    
	    ),    
	    'profilenamerule-2' => array(	    
		'rule'	=> array('between', 1, 50),
		'message'	=> 'The profile name must be between 1 and 50 characters'
	    
	    )
	
	)
    
    );
    
    public function gradeprofile_return_getbestsubjects($class = null){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Ordinaryleveldivisionawardsetting = ClassRegistry::init('Ordinaryleveldivisionawardsetting');
	
	if($class != null){
	
	      $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => $class)
	      );
	      
	      $getbestsubjects = $Ordinaryleveldivisionawardsetting->field('getbestsubjects',
		    array('gradeprofile_id =' => $gradeprofile_id)
	      );
	      
	      if($getbestsubjects == 1){
	      
		  return 1;
	      
	      }else{
	      
		  return 0;
	      
	      }
		
	}
    
    }
    
    public function gradeprofile_return_automaticallycaptodiv2forpassineng($class = null){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Ordinaryleveldivisionawardsetting = ClassRegistry::init('Ordinaryleveldivisionawardsetting');
	
	if($class != null){
	
	      $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => $class)
	      );
	      
	      $getbestsubjects = $Ordinaryleveldivisionawardsetting->field('captodiv2forpassineng',
		    array('gradeprofile_id =' => $gradeprofile_id)
	      );
	      
	      if($getbestsubjects == 1){
	      
		  return 1;
	      
	      }else{
	      
		  return 0;
	      
	      }
		
	}
    
    }
    
    public function gradeprofile_return_automaticallycaptodiv2forF9inmaths($class = null){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Ordinaryleveldivisionawardsetting = ClassRegistry::init('Ordinaryleveldivisionawardsetting');
	
	if($class != null){
	
	      $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => $class)
	      );
	      
	      $getbestsubjects = $Ordinaryleveldivisionawardsetting->field('captodiv2forF9inmaths',
		    array('gradeprofile_id =' => $gradeprofile_id)
	      );
	      
	      if($getbestsubjects == 1){
	      
		  return 1;
	      
	      }else{
	      
		  return 0;
	      
	      }
		
	}
    
    }

    
    public function gradeprofile_return_automaticallycaptodiv3forF9inenglish($class = null){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Ordinaryleveldivisionawardsetting = ClassRegistry::init('Ordinaryleveldivisionawardsetting');
	
	if($class != null){
	
	      $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => $class)
	      );
	      
	      $getbestsubjects = $Ordinaryleveldivisionawardsetting->field('captodiv3forF9inenglish',
		    array('gradeprofile_id =' => $gradeprofile_id)
	      );
	      
	      if($getbestsubjects == 1){
	      
		  return 1;
	      
	      }else{
	      
		  return 0;
	      
	      }
		
	}
    
    }
    
    public function gradeprofile_return_automaticallyshifttodiv7forlessthanbestnumberofsubjects($class = null){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Ordinaryleveldivisionawardsetting = ClassRegistry::init('Ordinaryleveldivisionawardsetting');
	
	if($class != null){
	
	      $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => $class)
	      );
	      
	      $getbestsubjects = $Ordinaryleveldivisionawardsetting->field('shifttodiv7forlessthanbestnumberofsubjects',
		    array('gradeprofile_id =' => $gradeprofile_id)
	      );
	      
	      if($getbestsubjects == 1){
	      
		  return 1;
	      
	      }else{
	      
		  return 0;
	      
	      }
		
	}
    
    }
    
    // Returns number of best done subjects or null if it is not set
    public function gradeprofile_return_number_of_bestsubjects_considered( $class = null ){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Ordinaryleveldivisionawardsetting = ClassRegistry::init('Ordinaryleveldivisionawardsetting');
	
	if($class != null){
	
	      $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => $class)
	      );
	      
	      $nobestsubjectstoget = $Ordinaryleveldivisionawardsetting->field('nobestsubjectstoget',
		    array('gradeprofile_id =' => $gradeprofile_id)
	      );
	      
	      if(($nobestsubjectstoget != null) || (($nobestsubjectstoget > 0)) ){
	      
		  return $nobestsubjectstoget;
	      
	      }else{
	      
		  return null;
	      
	      }
	}
    
    }
    
    public function gradeprofile_return_division($subjectnamesandgrades = null, $aggregates = null, $class = null){
    
	$Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	
	$group1name = $Schooldonesubject->field('shortsubjectname',
				  array('subjectgroup =' => 'I')
	);
	
	// get the group I subjects (English Language)
	$group1subjects = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array('Schooldonesubject.subjectgroup =' => 'I'),
			      'recursive' => 0
	));
	
	$group1subjects_array = array();
	
	foreach ( $group1subjects as $group1subject ) {
	
	    $group1subjects_array[] = $group1subject['Schooldonesubject']['shortsubjectname'];
	
	}
	
	// get the group II subjects (Humanities)
	$group2subjects = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array('Schooldonesubject.subjectgroup =' => 'II'),
			      'recursive' => 0
	));
	
	$group2subjects_array = array();
	
	foreach ( $group2subjects as $group2subject ) {
	
	    $group2subjects_array[] = $group2subject['Schooldonesubject']['shortsubjectname'];
	
	}
	
	
	// get the group IV subjects (Mathematics)
	$group4subjects = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array('Schooldonesubject.subjectgroup =' => 'IV'),
			      'recursive' => 0
	));
	
	$group4subjects_array = array();
	
	foreach ( $group4subjects as $group4subject ) {
	
	    $group4subjects_array[] = $group4subject['Schooldonesubject']['shortsubjectname'];
	
	}
	
	// get the group V subjects (Science Subjects)
	$group5subjects = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array('Schooldonesubject.subjectgroup =' => 'V'),
			      'recursive' => 0
	));
	
	$group5subjects_array = array();
	
	foreach ( $group5subjects as $group5subject ) {
	
	    $group5subjects_array[] = $group5subject['Schooldonesubject']['shortsubjectname'];
	
	}
	
	$keys = array_keys($subjectnamesandgrades);
	
	// Get the gradeforenglishlanguage (english_grade)
	
	if(in_array($group1name,$keys)){
	
	    $english_grade = $subjectnamesandgrades[$group1name];
	
	} else {
	
	    $english_grade = 0;
	
	}
	
	// Get the number of passes in maths subjects (passes_in_mathsubjects)
	$passes_in_mathsubjects = 0;
	// Get the number of passes in humanity subjects (passes_in_humanities)
	$passes_in_humanities = 0;
	// Get the number of passes in science subjects (passes_in_sciences)
	$passes_in_sciences = 0;
	// Get the number of subjects with a pass or better (number_of_subjectswithpassorbetter)
	$number_of_subjectswithpassorbetter = 0;
	// Get the number of subjects with a credit or better (number_of_subjectswithcreditorbetter)
	$number_of_subjectswithcreditorbetter = 0;
	// Get the number of subjects done (where a grade exists) - (number_of_subjects_done)
	$number_of_subjects_done = 0;
	// Number of subjects with pass 7
	$number_of_subjects_with_pass7 = 0;
	// Number of subjects with pass 8
	$number_of_subjects_with_pass8 = 0;	
	
	foreach ($subjectnamesandgrades as $subjectname => $value){
	
	    if(in_array($subjectname,$group2subjects_array)){
	    
		if($value != null){
		    if($value <= 8){
			$passes_in_humanities++;
		    }
		}
	    
	    }
	    
	    if(in_array($subjectname,$group4subjects_array)){
	    
		if($value != null){
		    if($value <= 8){
			$passes_in_mathsubjects++;
		    }
		}
	    
	    }
	    
	    if(in_array($subjectname,$group5subjects_array)){
	    
		if($value != null){
		    if($value <= 8){
			$passes_in_sciences++;
		    }
		}
	    
	    }
	    
	    if($value != null){
	    
		if($value <= 8){
			$number_of_subjectswithpassorbetter++;
		}
		
	    }
	    
	    if($value != null){
	    
		if($value == 8){
			$number_of_subjects_with_pass8++;
		}
		
	    }

	    if($value != null){
	    
		if($value == 7){
			$number_of_subjects_with_pass7++;
		}
		
	    }
	    
	    if($value != null){
	    
		if($value <= 6){
			$number_of_subjectswithcreditorbetter++;
		}
		
	    }
	    
	    if($value != null){
	    
		$number_of_subjects_done++;
		
	    }
	
	}
		
	
	/*
	if((count($keys) > 0) && ($aggregates != null) && ($class != null)){
	
	    return $passes_in_humanities;
	
	}else {
	
	    return 0;
	
	}
	*/
	
	$conditionsb4gradingcanstart = ( ($this->gradeprofile_return_getbestsubjects($class) == 1) &&
					 ($this->gradeprofile_return_automaticallycaptodiv2forpassineng($class) == 1) &&
					 ($this->gradeprofile_return_automaticallycaptodiv2forF9inmaths($class) == 1) &&
					 ($this->gradeprofile_return_automaticallycaptodiv3forF9inenglish($class) == 1) &&
					 ($this->gradeprofile_return_automaticallyshifttodiv7forlessthanbestnumberofsubjects($class) == 1)
				       );
	
	
	
	if($conditionsb4gradingcanstart){
	
	    if(($number_of_subjects_done >= 8)){
		  if(($aggregates >= 8) && ($aggregates <= 71)){
		  $div1conditions = (	
					($number_of_subjectswithpassorbetter >= 8) &&
					(($english_grade <= 6) && ($english_grade > 0)) &&
					($passes_in_humanities >= 1) &&
					($passes_in_sciences >= 1) &&
					($passes_in_mathsubjects >= 1) &&
					($number_of_subjectswithcreditorbetter >= 7) &&
					(($aggregates <= 32) && ($aggregates >= 8))
				    );
				    
		  if($div1conditions){
		  
		      return "I";
		      
		  } else {
		  
			$div2conditions = (
					    ($number_of_subjectswithpassorbetter >= 8) &&
					    (($english_grade <= 8) && ($english_grade > 0)) &&
					    ($number_of_subjectswithcreditorbetter >= 6) &&
					    (($aggregates <= 45))					 
			); 
		  
		      if($div2conditions ){
		      
			  return "II";
		      
		      } else {
		      
			    $div3conditions = (
			    
						(
						
						    ($number_of_subjectswithpassorbetter >= 8) &&
						    ($number_of_subjectswithcreditorbetter >= 3) &&
						    (($aggregates <= 58))
						
						
						)
						
						||
						
						(
						
						    ($number_of_subjectswithpassorbetter >= 7) &&
						    ($number_of_subjectswithcreditorbetter >= 4) &&
						    (($aggregates <= 58))						
						
						)
						
						||
						
						(

						    ($number_of_subjectswithcreditorbetter >= 5) &&
						    (($aggregates <= 58))
						
						)			  
			    );
			    if($div3conditions){
			    
				return "III";
			    
			    } else {
			    
				$div4conditions = (
				
				      (
				      
					  ($number_of_subjectswithcreditorbetter >= 1) &&
					  (($aggregates <= 71))
				      
				      )
				      
				      ||
				      
				      (
				      
					  ($number_of_subjects_with_pass7 >= 2) &&
					  (($aggregates <= 71))					  
				      
				      )
				      
				      ||
				      
				      (
				      
					  ($number_of_subjects_with_pass8 >= 3) &&
					  (($aggregates <= 71))
				      
				      )
				
				);
				
				if($div4conditions){
				
				    return "IV";
				
				} else {
				
				    return "IV";
				
				}
			    
			    }
		      
		      }
		  
		  }
		 } else {
		 
		    return "U";
		 
		 }

	    } else {
	    
		if($number_of_subjects_done == 0){
		
		    return "X";
		
		} else {
		
		    return "VII";
		    
		}
	    
	    }
	    
	}
    
    }
    
    public function gradeprofile_returnsubjectgrade($class = null, $subject_mark = null){
    
	$Profileassignment = ClassRegistry::init('Profileassignment');
	$Grading = ClassRegistry::init('Grading');
	$grade_to_be_returned = null;
    
	switch ($class) {

	    case 1:
	    
		$gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => 1)
		);
		
		$grading = $Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
			      'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
			      'order' => array('Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		));
		
		$matchfound = 0;
		$award = -1;
		if(($subject_mark != null) && is_numeric($subject_mark) ){
		    foreach ($grading as $key1){
			foreach($key1 as $key2){
			      //echo $key2['lowestvalue']."<br/>";
			      if(($subject_mark >= $key2['lowestvalue']) 
					&&
			      ($subject_mark < $key2['highestvalue'])
			      ){
			      
				    $matchfound = 1;
				    $award = $key2['award'];
				    $grade_to_be_returned = $award;
				    break;
				    break;
				}
			    }
		    }
		}
		
		break;
	    case 2:
	    
		$gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => 2)
		);
		
		$grading = $Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
			      'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
			      'order' => array('Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		));
		
		$matchfound = 0;
		$award = -1;
		if(($subject_mark != null) && is_numeric($subject_mark) ){
		    foreach ($grading as $key1){
			foreach($key1 as $key2){
			      //echo $key2['lowestvalue']."<br/>";
			      if(($subject_mark >= $key2['lowestvalue']) 
					&&
			      ($subject_mark < $key2['highestvalue'])
			      ){
			      
				    $matchfound = 1;
				    $award = $key2['award'];
				    $grade_to_be_returned = $award;
				    break;
				    break;
				}
			    }
		    }
		}
		
		break;
	    case 3:
	    
		$gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => 3)
		);
		
		$grading = $Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
			      'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
			      'order' => array('Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		));
		
		$matchfound = 0;
		$award = -1;
		if(($subject_mark != null) && is_numeric($subject_mark) ){
		    foreach ($grading as $key1){
			foreach($key1 as $key2){
			      //echo $key2['lowestvalue']."<br/>";
			      if(($subject_mark >= $key2['lowestvalue']) 
					&&
			      ($subject_mark < $key2['highestvalue'])
			      ){
			      
				    $matchfound = 1;
				    $award = $key2['award'];
				    $grade_to_be_returned = $award;
				    break;
				    break;
				}
			    }
		    }
		}
		
		break;
	    case 4:
	    
		$gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => 4)
		);
		
		$grading = $Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
			      'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
			      'order' => array('Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		));
		
		$matchfound = 0;
		$award = -1;
		if(($subject_mark != null) && is_numeric($subject_mark) ){
		    foreach ($grading as $key1){
			foreach($key1 as $key2){
			      //echo $key2['lowestvalue']."<br/>";
			      if(($subject_mark >= $key2['lowestvalue']) 
					&&
			      ($subject_mark < $key2['highestvalue'])
			      ){
			      
				    $matchfound = 1;
				    $award = $key2['award'];
				    $grade_to_be_returned = $award;
				    break;
				    break;
				}
			    }
		    }
		}
		
		break;
	    case 5:
	    
		$gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => 5)
		);
		
		$grading = $Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
			      'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
			      'order' => array('Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		));
		
		$matchfound = 0;
		$award = -1;
		if  (($subject_mark != null) && is_numeric($subject_mark) ) {
		    foreach ($grading as $key1){
			foreach($key1 as $key2){
			      //echo $key2['lowestvalue']."<br/>";
			      if(($subject_mark >= $key2['lowestvalue']) 
					&&
			      ($subject_mark < $key2['highestvalue'])
			      ){
			      
				    $matchfound = 1;
				    $award = $key2['award'];
				    $grade_to_be_returned = $award;
				    break;
				    break;
				}
			    }
		    }
		}
		
		break;
	    case 6:
	    
		$gradeprofile_id = $Profileassignment->field('gradeprofile_id',
		    array('class =' => 6)
		);
		
		$grading = $Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
			      'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
			      'order' => array('Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		));
		
		$matchfound = 0;
		$award = -1;
		if(($subject_mark != null) && is_numeric($subject_mark) ){
		    foreach ($grading as $key1){
			foreach($key1 as $key2){
			      //echo $key2['lowestvalue']."<br/>";
			      if(($subject_mark >= $key2['lowestvalue']) 
					&&
			      ($subject_mark < $key2['highestvalue'])
			      ){
			      
				    $matchfound = 1;
				    $award = $key2['award'];
				    $grade_to_be_returned = $award;
				    break;
				    break;
				}
			    }
		    }
		}
		
		break;
		default:
		break;
	
	}
	
	return $grade_to_be_returned;
    
    }

    
    public function gradeprofile_returnsubjectremark($class = null, $subject_mark = null){
    
        $Profileassignment = ClassRegistry::init('Profileassignment');
        $Grading = ClassRegistry::init('Grading');
        $grade_to_be_returned = null;
          
        switch ($class) {

            case 1:
            
          $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
              array('class =' => 1)
          );
          
          $grading = $Grading->find('all', array(
                  'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.remarks'),
                  'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                  'order' => array('Grading.lowestvalue' => 'asc'),
                  'recursive' => 0
          ));
          
          $matchfound = 0;
          $award = -1;
          if(($subject_mark != null) && is_numeric($subject_mark) ){
              foreach ($grading as $key1){
            foreach($key1 as $key2){
                  //echo $key2['lowestvalue']."<br/>";
                  if(($subject_mark >= $key2['lowestvalue']) 
                &&
                  ($subject_mark < $key2['highestvalue'])
                  ){
                  
                  $matchfound = 1;
                  $award = $key2['remarks'];
                  $grade_to_be_returned = $award;
                  break;
                  break;
              }
                }
              }
          }
          
          break;
            case 2:
            
          $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
              array('class =' => 2)
          );
          
          $grading = $Grading->find('all', array(
                  'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.remarks'),
                  'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                  'order' => array('Grading.lowestvalue' => 'asc'),
                  'recursive' => 0
          ));
          
          $matchfound = 0;
          $award = -1;
          if(($subject_mark != null) && is_numeric($subject_mark) ){
              foreach ($grading as $key1){
            foreach($key1 as $key2){
                  //echo $key2['lowestvalue']."<br/>";
                  if(($subject_mark >= $key2['lowestvalue']) 
                &&
                  ($subject_mark < $key2['highestvalue'])
                  ){
                  
                  $matchfound = 1;
                  $award = $key2['remarks'];
                  $grade_to_be_returned = $award;
                  break;
                  break;
              }
                }
              }
          }
          
          break;
            case 3:
            
          $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
              array('class =' => 3)
          );
          
          $grading = $Grading->find('all', array(
                  'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.remarks'),
                  'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                  'order' => array('Grading.lowestvalue' => 'asc'),
                  'recursive' => 0
          ));
          
          $matchfound = 0;
          $award = -1;
          if(($subject_mark != null) && is_numeric($subject_mark) ){
              foreach ($grading as $key1){
            foreach($key1 as $key2){
                  //echo $key2['lowestvalue']."<br/>";
                  if(($subject_mark >= $key2['lowestvalue']) 
                &&
                  ($subject_mark < $key2['highestvalue'])
                  ){
                  
                  $matchfound = 1;
                  $award = $key2['remarks'];
                  $grade_to_be_returned = $award;
                  break;
                  break;
              }
                }
              }
          }
          
          break;
            case 4:
            
          $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
              array('class =' => 4)
          );
          
          $grading = $Grading->find('all', array(
                  'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.remarks'),
                  'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                  'order' => array('Grading.lowestvalue' => 'asc'),
                  'recursive' => 0
          ));
          
          $matchfound = 0;
          $award = -1;
          if(($subject_mark != null) && is_numeric($subject_mark) ){
              foreach ($grading as $key1){
            foreach($key1 as $key2){
                  //echo $key2['lowestvalue']."<br/>";
                  if(($subject_mark >= $key2['lowestvalue']) 
                &&
                  ($subject_mark < $key2['highestvalue'])
                  ){
                  
                  $matchfound = 1;
                  $award = $key2['remarks'];
                  $grade_to_be_returned = $award;
                  break;
                  break;
              }
                }
              }
          }
          
          break;
            case 5:
            
          $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
              array('class =' => 5)
          );
          
          $grading = $Grading->find('all', array(
                  'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.remarks'),
                  'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                  'order' => array('Grading.lowestvalue' => 'asc'),
                  'recursive' => 0
          ));
          
          $matchfound = 0;
          $award = -1;
          if(($subject_mark != null) && is_numeric($subject_mark) ){
              foreach ($grading as $key1){
            foreach($key1 as $key2){
                  //echo $key2['lowestvalue']."<br/>";
                  if(($subject_mark >= $key2['lowestvalue']) 
                &&
                  ($subject_mark < $key2['highestvalue'])
                  ){
                  
                  $matchfound = 1;
                  $award = $key2['remarks'];
                  $grade_to_be_returned = $award;
                  break;
                  break;
              }
                }
              }
          }
          
          break;
            case 6:
            
          $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
              array('class =' => 6)
          );
          
          $grading = $Grading->find('all', array(
                  'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.remarks'),
                  'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                  'order' => array('Grading.lowestvalue' => 'asc'),
                  'recursive' => 0
          ));
          
          $matchfound = 0;
          $award = -1;
          if(($subject_mark != null) && is_numeric($subject_mark) ){
              foreach ($grading as $key1){
            foreach($key1 as $key2){
                  //echo $key2['lowestvalue']."<br/>";
                  if(($subject_mark >= $key2['lowestvalue']) 
                &&
                  ($subject_mark < $key2['highestvalue'])
                  ){
                  
                  $matchfound = 1;
                  $award = $key2['remarks'];
                  $grade_to_be_returned = $award;
                  break;
                  break;
              }
                }
              }
          }
          
          break;
          default:
          break;
        
        }
        
        return $grade_to_be_returned;
    
    }


    public function get_grading_scheme($class)  {
    
      $Profileassignment = ClassRegistry::init('Profileassignment');
      $Grading = ClassRegistry::init('Grading');

      $award_mappings = array(
        1 => "D1",
        2 => "D2",
        3 => "C3",
        4 => "C4",
        5 => "C5",
        6 => "C6",
        7 => "P7",
        8 => "P8",
        9 => "F9"
      );
        
      switch ($class) {

          case 1:
          
            $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
                array('class =' => 1)
            );
            
            $grading = $Grading->find('all', array(
                    'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
                    'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                    'order' => array('Grading.highestvalue' => 'asc'),
                    'recursive' => -1
            ));
            break;
          case 2:
          
            $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
                array('class =' => 2)
            );
            
            $grading = $Grading->find('all', array(
                    'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
                    'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                    'order' => array('Grading.lowestvalue' => 'asc'),
                    'recursive' => -1
            ));
        
            break;
          case 3:
          
            $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
                array('class =' => 3)
            );
            
            $grading = $Grading->find('all', array(
                    'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
                    'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                    'order' => array('Grading.lowestvalue' => 'asc'),
                    'recursive' => -1
            ));
            
            break;
          case 4:
          
            $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
                array('class =' => 4)
            );
            
            $grading = $Grading->find('all', array(
                    'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
                    'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                    'order' => array('Grading.lowestvalue' => 'asc'),
                    'recursive' => -1
            ));
            
            break;
          case 5:
          
            $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
                array('class =' => 5)
            );
            
            $grading = $Grading->find('all', array(
                    'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
                    'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                    'order' => array('Grading.lowestvalue' => 'asc'),
                    'recursive' => -1
            ));
            break;
          case 6:
          
            $gradeprofile_id = $Profileassignment->field('gradeprofile_id',
                array('class =' => 6)
            );
            
            $grading = $Grading->find('all', array(
                    'fields' => array('Grading.lowestvalue','Grading.highestvalue','Grading.award'),
                    'conditions' => array('Grading.gradeprofile_id =' => $gradeprofile_id),
                    'order' => array('Grading.lowestvalue' => 'asc'),
                    'recursive' => -1
            ));

            break;
          default:
            $grading = array();
            break;
      }

      $counter = 1;
      $grading_criterea = array();
      $single_line = "";
      // return $grading;
      foreach ($grading as $key => $value) {
        $space = "          ";
        $lowest_value = $value["Grading"]["lowestvalue"];
        $highest_value = $value["Grading"]["highestvalue"];

        // Remove one space to maintain uniformity
        if (strlen($highest_value) > 2) {
          $space = substr($space, 3);
        }

        if (strlen($lowest_value) < 2) {
          $lowest_value = "0".$lowest_value;
        }

        $grade_single = ($lowest_value)." - < ".($highest_value)." - ".$award_mappings[$value["Grading"]["award"]];
        $single_line = $grade_single.$space.$single_line;

        if (($counter % 3) == 0) {
          array_unshift($grading_criterea, $single_line);
          $single_line = "";
        }
        $counter++;
      }
      return $grading_criterea;
      // return $grading_criterea;
    }



    public function get_advanced_level_grading_point_range($class = null) {
      /**
       * Get the weights of corresponding grades ie A is 6
       */
      if ($class == 5 || $class == 6) {
        $Profileassignment = ClassRegistry::init('Profileassignment');
	      $Advancedlevelpointsaward = ClassRegistry::init('Advancedlevelpointsaward');

        $gradeprofile_id = $Profileassignment->field(
          'gradeprofile_id',
		      array('class =' => (int)$class)
        );

        $grading_range = $Advancedlevelpointsaward->find(
          'all',
          array(
            'fields' => array('Advancedlevelpointsaward.award','Advancedlevelpointsaward.weight'),
            'conditions' => array('Advancedlevelpointsaward.gradeprofile_id =' => $gradeprofile_id),
            'order' => array('Advancedlevelpointsaward.award' => 'asc'),
            'recursive' => 0
          )
        );

        return $grading_range;
      }
      return null;

    }

public $findMethods = array('search' => true);
protected function _findSearch($state, $query, $results = array())
{
  if ($state === 'before') {
    $searchQuery = Hash::get($query, 'searchQuery');
    $searchConditions = array(
      'or' => array(
        "{$this->alias}.profilename LIKE" => '%' . $searchQuery . '%',
      )
    );
    
    $query['conditions'] = array_merge($searchConditions,(array)$query['conditions']);
    return $query;
  }
  return $results;
}

}
