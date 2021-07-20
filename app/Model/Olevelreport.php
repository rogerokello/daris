<?php
App::uses('AppModel', 'Model');
/**
 * Dependantdetail Model
 *
 * @property Staffdetail $Staffdetail
 */
class Olevelreport extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'staffdetail_id';

	//public $primaryKey = 'id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Olevelreportdetail' => array(
			'className' => 'Olevelreportdetail',
			'foreignKey' => 'olevelreportdetail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	// add and find the average of the exams considered
	public function report_add_examsconsidered (
      $report_id = null, $subjects = null, $student_ids_on_reports_to_change = null) {
	
	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    $Olevelmarksheetresult = ClassRegistry::init('Olevelmarksheetresult');
	    $Olevelreportdetail = ClassRegistry::init('Olevelreportdetail');
	    $Olevelcompulsorysubject = ClassRegistry::init('Olevelcompulsorysubject');
	
	    if( $report_id != null ){
	    
		    if( $subjects == null ){
		
		      $shortsubjectnames = $Schooldonesubject->find(
            'all',
            array(
			        'fields' => array('Schooldonesubject.shortsubjectname'),
			        'conditions' => array(
						    "NOT" => array(						    
								  'Schooldonesubject.shortsubjectname' => null						    
							  )
						  ),
		        )
          );
		    
		      $year_examdone = $Olevelreportdetail->field(
            'reportyear',
			      array('id =' => $report_id)
          );
		    
		      $term_examdone = $Olevelreportdetail->field(
            'reportterm',
			      array('id =' => $report_id)
		      );
		    
		      $class_examdone = $Olevelreportdetail->field(
            'reportclass',
			      array('id =' => $report_id)
		      );
		    
		      $compulsory_subjects = $Olevelcompulsorysubject->field(
            'compulsorysubjects',
			      array('year =' => $year_examdone, 'class =' => $class_examdone)
		      );
		    
		      if ($compulsory_subjects != null) {
			      $compulsory_subjects = explode("$",$compulsory_subjects);
			      unset($compulsory_subjects[0]);
		      }
		    
		      $report_ids_toconsider = Olevelreport::find(
            'all', array(
			        'fields' => array('Olevelreport.id'),
			        'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						  )
		        )
          );
		    
		      foreach ( $report_ids_toconsider as $areport_id ) {
		    
			      $student_id_onreport = Olevelreport::field(
              'student_id',
			        array('id =' => $areport_id['Olevelreport']['id'])
			      );
		    
			      foreach ( $shortsubjectnames as $shortsubjectname ) {
			
			        $shortsubjectname_exam_considered = $shortsubjectname['Schooldonesubject']['shortsubjectname']."_examsconsidered";
			    
              $exams_considered = Olevelreport::field(
                $shortsubjectname_exam_considered,
				        array('id =' => $areport_id['Olevelreport']['id'])
			        );
			    
			        $exams_considered_array = explode("<::>",trim($exams_considered,"<::>"));
			    
			        $added_marks = null;
			        $counter = 0;
			    
			        // validate that the subject is or is not compulsory; set the flag to zero
			        $subject_is_compulsory = 0;
			    
			        if (($compulsory_subjects != null) && (is_array($compulsory_subjects))) {
				
				        if (in_array($shortsubjectname['Schooldonesubject']['shortsubjectname'],$compulsory_subjects)) {
					        //subject has been found to be compulsory
					        $subject_is_compulsory = 1;
				        }
				
			        }
			    
			        //count how many exams are to be considered
			        $number_of_exams_considered = count($exams_considered_array);
			    
			        // if the number of exams considered is one, operate using 
			        // non compulsory subject mode
			        if ($number_of_exams_considered == 1) {
			          $subject_is_compulsory = 0;
			        }
			    
			        $number_of_null_marks = null;
			    
			        // TODO: Convert to a single sql query instead of a for loop
              // find out how many exams have null added_marks
			        foreach ($exams_considered_array as $anexamconsidered) {

				        $mark = $Olevelmarksheetresult->field(
                  $shortsubjectname['Schooldonesubject']['shortsubjectname'],				    
					        array(
                    'student_id =' => $student_id_onreport,
					          'exam_name  =' => $anexamconsidered,
					          'year ='	     => $year_examdone
					        )
				        );
				
				        if  ($mark == null) {
				          $number_of_null_marks = $number_of_null_marks + 1;
				        }
			        }
			    
			        // if number of exams entered is equal to the number of exams without marks
			        // operate using non-strict mode
			        if  ($number_of_null_marks == $number_of_exams_considered)  {
				        $subject_is_compulsory = 0;
			        }
			    
			        foreach ($exams_considered_array as $anexamconsidered) {
			    
                $mark = $Olevelmarksheetresult->field(
                  $shortsubjectname['Schooldonesubject']['shortsubjectname'],				    
                  array(
                    'student_id =' => $student_id_onreport,
                    'exam_name  =' => $anexamconsidered,
                    'year ='	     => $year_examdone
                  )
                );
								
				        // I've grayed out the non - strict mode.
				
				        // Non
				        if ($subject_is_compulsory == 0)  {
				          // This is the non - strict mode
				          if( $mark != null ) {
					          $added_marks = $added_marks + $mark;
					          $counter++;
				          }
				        } else  {
				          // This is the strict mode
				          $added_marks = $added_marks + $mark;
				          $counter++;
				        }
			    
			        }
			    
			        $average_mark = null;
			    
			        // I've grayed out the non - strict mode

			        if  ($subject_is_compulsory == 0) {
				        // Non- strict mode
				        if  ( ($added_marks != null) && ($counter != 0) ) {
				          $average_mark = $added_marks/$counter;
				        }
			        } else  {
				        // strict mode
				        if  ( $counter != 0 ) {
				          $average_mark = $added_marks/$counter;
				        }
			        }
		
			        $data = array(
				        'Olevelreport' => array(
				          'id' => $areport_id['Olevelreport']['id'],
				          $shortsubjectname['Schooldonesubject']['shortsubjectname'] => $average_mark,				    
				        )
			        );

			        Olevelreport::save($data);
			      } 
		      }
		    }
	    
	    }
	
	}
	
	public function report_get_total_mark($report_id = null,$subjects = null,$student_ids_on_reports_to_change = null){
	
	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    //$Olevelmarksheetresult = ClassRegistry::init('Olevelmarksheetresult');
	    //$Olevelreportdetail = ClassRegistry::init('Olevelreportdetail');
	
	    if( $report_id != null ){
	    
		if( $subjects == null ){
		
		    /*
		    $shortsubjectnames = $Schooldonesubject->field('shortsubjectname',
			array('shortsubjectname LIKE' => '*')
		    );
		    */
		    $shortsubjectnames = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array(
						    "NOT" => array(						    
								'Schooldonesubject.shortsubjectname' => null						    
							  )
						    
						    ),
			      //'recursive' => 0
		    ));
		    
		    
		    $report_ids_toconsider = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.id'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		    ));
		    
		    foreach ( $report_ids_toconsider as $areport_id ){
		    
			$added_marks = null;
		    
			foreach ( $shortsubjectnames as $shortsubjectname ){
			    
			    
			    $counter = 0;
			    
			    $mark = Olevelreport::field($shortsubjectname['Schooldonesubject']['shortsubjectname'],				    
					array('id =' => $areport_id['Olevelreport']['id'],
					)
			    );
				
			    if( $mark != null ) {
				
				    $added_marks = $added_marks + $mark;
				    $counter++;
				    
			    }
			    
			    
			    

			}
			
			$average_mark = null;
			    
			if( ($added_marks != null) && ($counter != 0) ){
			    
			    $average_mark = $added_marks/$counter;
			    
			}
			
			//Olevelreport::create();
		
			$data = array(
				'Olevelreport' => array(
				    'id' => $areport_id['Olevelreport']['id'],
				    'totalmark' => $added_marks,				    
				)
			);
			  
			Olevelreport::save($data);			
		    
		    }
		
		}
	    
	    }
		    
	
	}
	
	public function report_getaggregates($report_id = null,$student_ids_on_reports_to_change = null){
	
	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    $Olevelreportdetail = ClassRegistry::init('Olevelreportdetail');
	    $Gradeprofile = ClassRegistry::init('Gradeprofile');
	    
	    
	    if( $report_id != null ){
	    
		$shortsubjectnames = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array(
						    "NOT" => array(						    
								'Schooldonesubject.shortsubjectname' => null						    
							  )
						    
						    ),
			      //'recursive' => 0
		));

		$report_ids_toconsider = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.id'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		));
		
		$classtograde = Olevelreport::find('first', array(
			      'fields' => array('Olevelreport.classthen'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		));
		
		$is_number_of_best_aggregatesconsidered = $Gradeprofile
							      ->gradeprofile_return_getbestsubjects($classtograde['Olevelreport']['classthen']);
		
		$number_of_best_subjects_considered = $Gradeprofile
							->gradeprofile_return_number_of_bestsubjects_considered($classtograde['Olevelreport']['classthen']);
							
		foreach ( $report_ids_toconsider as $areport_id ){
		
		    $aggregate = 0;
		    
		    $counter = 0;
		    
		    $gradearray = array();
		
		    foreach ( $shortsubjectnames as $shortsubjectname ){
		    
			$shortsubjectname_for_a_subject = $shortsubjectname['Schooldonesubject']['shortsubjectname'];
			
			$shortsubjectname_exam_grade = Olevelreport::field($shortsubjectname_for_a_subject."_grade",
				  array('id =' => $areport_id['Olevelreport']['id'])
			);
			
			if(($shortsubjectname_exam_grade != null) && (($shortsubjectname_exam_grade > 0) && ($shortsubjectname_exam_grade < 10))){
			
			    $gradearray[] = $shortsubjectname_exam_grade;
			    $counter = $counter + 1;
			
			}
		    
		    }
		    
		    if(($is_number_of_best_aggregatesconsidered == 1) && 
			  ($counter >= $number_of_best_subjects_considered)
		    ){
		    
			sort($gradearray);
			
			$counter2 = 0;
			
			foreach ($gradearray as $value) {
			    if($counter2 != $number_of_best_subjects_considered){
			    
				$aggregate = $aggregate + $value;
				$counter2++;
			    
			    }else{
			    
				break;
			    
			    }
			}
			
			$data = array(
			    'Olevelreport' => array(
					'id' => $areport_id['Olevelreport']['id'],
					'besteightaggregates' => $aggregate,				    
			    )
			);
			
			Olevelreport::save($data);
		    
		    }
		
		}
	    
	    }
	
	}
	
	public function report_getdivision($report_id = null,$student_ids_on_reports_to_change = null){
	
	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    $Gradeprofile = ClassRegistry::init('Gradeprofile');
	    
	    if( $report_id != null ){
	    
		$shortsubjectnames = $Schooldonesubject->find('all', array(
			      'fields' => array('Schooldonesubject.shortsubjectname'),
			      'conditions' => array(
						    "NOT" => array(						    
								'Schooldonesubject.shortsubjectname' => null						    
							  )
						    
						    ),
			      //'recursive' => 0
		));		    
		    
		$report_ids_toconsider = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.id'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		));
		    
		$classtograde = Olevelreport::find('first', array(
			      'fields' => array('Olevelreport.classthen'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		));	
		
		foreach ( $report_ids_toconsider as $areport_id ) {
		
		    $subject = array();
		
		    foreach ( $shortsubjectnames as $shortsubjectname ){
			
			    $shortsubjectname_for_a_subject = $shortsubjectname['Schooldonesubject']['shortsubjectname'];
			    
			    $shortsubjectname_exam_grade = Olevelreport::field($shortsubjectname_for_a_subject."_grade",
				  array('id =' => $areport_id['Olevelreport']['id'])
			    );
						    
			    $subject[$shortsubjectname_for_a_subject] = $shortsubjectname_exam_grade;
			
		    }
		    
		    $student_aggregate = Olevelreport::field('besteightaggregates',
				  array('id =' => $areport_id['Olevelreport']['id'])
		    );
		    
		    $division = $Gradeprofile->gradeprofile_return_division($subject,
									    $student_aggregate,
									    $classtograde['Olevelreport']['classthen']
									   );
		    
		    $data = array(
			'Olevelreport' => array(
				'id' => $areport_id['Olevelreport']['id'],
				'division' => $division				    
			)
		    );
		    
		    Olevelreport::save($data);
		
		}
	    
	    }
	
	}
	
	public function report_gradesubjects($report_id = null,$subjects = null,$student_ids_on_reports_to_change = null ){

	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    $Olevelreportdetail = ClassRegistry::init('Olevelreportdetail');
	    $Gradeprofile = ClassRegistry::init('Gradeprofile');
	    $Olevelcompulsorysubject = ClassRegistry::init('Olevelcompulsorysubject');
	    
	    if ( $report_id != null ) {
	    
		    if ( $subjects == null ) {
		
		      $year_examdone = $Olevelreportdetail->field(
            'reportyear',
			      array('id =' => $report_id)
		      );
		    
		      $term_examdone = $Olevelreportdetail->field(
            'reportterm',
			      array('id =' => $report_id)
		      );
		    
		      $class_examdone = $Olevelreportdetail->field(
            'reportclass',
			      array('id =' => $report_id)
		      );
		    
		      $compulsory_subjects = $Olevelcompulsorysubject->field(
            'compulsorysubjects',
			      array(
              'year =' => $year_examdone,
              'class =' => $class_examdone
            )
		      );
		    
		      if  ($compulsory_subjects != null)  {
			      $compulsory_subjects = explode("$",$compulsory_subjects);
			      unset($compulsory_subjects[0]);
		      }
		
		      $shortsubjectnames = $Schooldonesubject->find(
            'all',
            array(
			        'fields' => array('Schooldonesubject.shortsubjectname'),
			        'conditions' => array(
						    "NOT" => array(						    
								  'Schooldonesubject.shortsubjectname' => null						    
							  )
						  ),
		        )
          );		    
		    
		      $report_ids_toconsider = Olevelreport::find(
            'all',
            array(
			        'fields' => array('Olevelreport.id'),
			        'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						  )
		        )
          );
		    
          $classtograde = Olevelreport::find(
            'first',
            array(
              'fields' => array('Olevelreport.classthen'),
              'conditions' => array(
                'olevelreportdetail_id =' => $report_id
              )
            )
          );
          
          foreach ( $report_ids_toconsider as $areport_id ) {
          
            $student_id_onreport = Olevelreport::field(
              'student_id',
              array('id =' => $areport_id['Olevelreport']['id'])
            );
          
            foreach ( $shortsubjectnames as $shortsubjectname ) {
        
              $shortsubjectname_for_a_subject = $shortsubjectname['Schooldonesubject']['shortsubjectname'];
            
              // validate that the subject is or is not compulsory; set the flag to zero
              $subject_is_compulsory = 0;
            
              if  (($compulsory_subjects != null) && (is_array($compulsory_subjects)))  {
          
                if  (in_array($shortsubjectname['Schooldonesubject']['shortsubjectname'],$compulsory_subjects)) {
                  //subject has been found to be compulsory
                  $subject_is_compulsory = 1;
                }
          
              }
            
              $shortsubjectname_exam_mark = Olevelreport::field(
                $shortsubjectname_for_a_subject,
                array(
                  'id =' => $areport_id['Olevelreport']['id']
                )
              );
            
              // if subject is compulsory and there is no mark for it,
              // award a grade of 0 to signify a grade X
          
              if  (($subject_is_compulsory == 1) && ($shortsubjectname_exam_mark == null))  {
          
                $data = array(
                  'Olevelreport' => array(
                    'id' => $areport_id['Olevelreport']['id'],
                    $shortsubjectname['Schooldonesubject']['shortsubjectname']."_grade" => 10,				    
                  )
                );
            
                Olevelreport::save($data);
              } else {
            
                $data = array(
                  'Olevelreport' => array(
                    'id' => $areport_id['Olevelreport']['id'],
                    $shortsubjectname['Schooldonesubject']['shortsubjectname']."_grade" => $Gradeprofile->gradeprofile_returnsubjectgrade($classtograde['Olevelreport']['classthen'], $shortsubjectname_exam_mark)/*(int)$award*/,				    
                  )
                );
          
                Olevelreport::save($data);
              }
            }
          }
		    }
	    }
	}
	
	public function report_get_position($report_id = null,$subjects = null,$student_ids_on_reports_to_change = null){
	
		if($report_id != null){
		
		    $report_ids_toconsider = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.id'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		    ));
		    
		    $streams_to_useforposition = Olevelreport::find('all', array(
			      'fields' => array('DISTINCT Olevelreport.streamthen'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		    ));
		    
		    $student_class = Olevelreport::field('classthen',
				  array('olevelreportdetail_id =' => $report_id)
		    );
		    
		    $streams_array = array();
		    $totals_for_each_stream = array();
		    
		    foreach ( $streams_to_useforposition as $areport_id ){
		    
			array_push($streams_array,$areport_id['Olevelreport']['streamthen']);
		    
		    }
		    
		    //create an array that will handle the totals
		    foreach ($streams_array as $astream){
		    
			$totals_for_each_stream[$astream] = array();
		    
		    }
		    
		    foreach ($streams_array as $astream){
		    
			// Generate an array to handle all the totals of the class streams
			$totals_to_useforposition = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.totalmark'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id,
						    'streamthen' => $astream
						    )
			      //'recursive' => 0
			));
			
			
			// Push the total for each stream in the total array
			foreach( $totals_to_useforposition as $atotal ){
			
			    array_push($totals_for_each_stream[$astream],intval($atotal['Olevelreport']['totalmark']));
			
			}
		    
		    }
		    
		    //Sort all the individual stream totals
		    
		    foreach($streams_array as $astream){
		    
			rsort($totals_for_each_stream[$astream]);
		    
		    }
		    
		    //Generate an array to get all the totals for the whole class
		    $totals_to_useforpositionClass = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.totalmark'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id,
						    //'streamthen' => $astream
						    )
			      //'recursive' => 0
		    ));
		    
		    // an array to store totals for every one in the class
		    $totals_for_whole_class = array();
		    
		    foreach($totals_to_useforpositionClass as $atotal){
		    
			array_push($totals_for_whole_class, intval($atotal['Olevelreport']['totalmark']));
		    
		    }
		    
		    rsort($totals_for_whole_class);
		    
		    //get the stream positions and class positions for S1 and S2
		    if((intval($student_class) == 1) || (intval($student_class) == 2)){
		    
			// Get the stream position and class position
			foreach($report_ids_toconsider as $areport_id){
			
			      $student_totalmark = Olevelreport::field('totalmark',
				  array('id =' => $areport_id['Olevelreport']['id'])
			      );
			      
			      $student_streamthen = Olevelreport::field('streamthen',
				  array('id =' => $areport_id['Olevelreport']['id'])
			      );
			      $stream_position2 = 0;
			      $stream_position = 0;
			      $class_position = 0;
			      $class_position2 = 0;
			      //get the stream position
			      $stream_position = array_search($student_totalmark, $totals_for_each_stream[$student_streamthen]);
			      $stream_position = $stream_position + 1;
			      
			      //get the class position
			      $class_position = array_search($student_totalmark, $totals_for_whole_class);
			      $class_position = $class_position + 1;
			      
			      if(($stream_position != false) && ($class_position != false)){
				  $data = array(
					'Olevelreport' => array(
					    'id' => $areport_id['Olevelreport']['id'],
					    'streamposition' => $stream_position,
					    'classposition' => $class_position,
					)
				  );
			      
				  Olevelreport::save($data);
			      }/*else{
			      
				  $data = array(
					'Olevelreport' => array(
					    'id' => $areport_id['Olevelreport']['id'],
					    'streamposition' => null,
					    'classposition' => null,
					)
				  );
			      		      
			      }*/
			
			}
		    
		    }
		    
		    if((intval($student_class) == 3) || (intval($student_class) == 4)){
		    
		    
		    }
		
		}
	
	}
}
?>