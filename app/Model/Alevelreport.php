<?php
App::uses('AppModel', 'Model');
/**
 * Dependantdetail Model
 *
 * @property Staffdetail $Staffdetail
 */
class Alevelreport extends AppModel {

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
	
	public function report_add_examsconsidered($report_id = null, $subjects = null){
	
	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    $Olevelmarksheetresult = ClassRegistry::init('Olevelmarksheetresult');
	    $Olevelreportdetail = ClassRegistry::init('Olevelreportdetail');
	
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
		    
		    $year_examdone = $Olevelreportdetail->field('reportyear',
			array('id =' => $report_id)
		    );
		    
		    $term_examdone = $Olevelreportdetail->field('reportterm',
			array('id =' => $report_id)
		    );
		    
		    /*
		    $report_ids_toconsider = Olevelreport::field('id',
			array('olevelreportdetail_id =' => $report_id)
		    );
		    */
		    
		    $report_ids_toconsider = Olevelreport::find('all', array(
			      'fields' => array('Olevelreport.id'),
			      'conditions' => array(
						    'olevelreportdetail_id =' => $report_id
						    )
			      //'recursive' => 0
		    ));
		    
		    foreach ( $report_ids_toconsider as $areport_id ){
		    
			$student_id_onreport = Olevelreport::field('student_id',
			    array('id =' => $areport_id['Olevelreport']['id'])
			);
		    
			foreach ( $shortsubjectnames as $shortsubjectname ){
			
			    $shortsubjectname_exam_considered = $shortsubjectname['Schooldonesubject']['shortsubjectname']."_examsconsidered";
			    $exams_considered = Olevelreport::field($shortsubjectname_exam_considered,
				array('id =' => $areport_id['Olevelreport']['id'])
			    );
			    
			    $exams_considered_array = explode("<::>",$exams_considered);
			    
			    $added_marks = null;
			    $counter = 0;
			    
			    foreach ($exams_considered_array as $anexamconsidered) {
			    
				$mark = $Olevelmarksheetresult->field($shortsubjectname['Schooldonesubject']['shortsubjectname'],				    
					array('student_id =' => $student_id_onreport,
					      'exam_name  =' => $anexamconsidered,
					      'year ='	     => $year_examdone
					)
				);
				
				// I've grayed out the non - strict mode
				/*
				if( $mark != null ) {
				
				    $added_marks = $added_marks + $mark;
				    $counter++;
				    
				}
				*/
				
				// operate using strict mode
				
				$added_marks = $added_marks + $mark;
				$counter++;
			    
			    }
			    
			    $average_mark = null;
			    
			    
			    // I've grayed out the non - strict mode
			    /*
			    if( ($added_marks != null) && ($counter != 0) ){
			    
				$average_mark = $added_marks/$counter;
			    
			    }
			    */
			    
			    if( $counter != 0 ){
			    
				$average_mark = $added_marks/$counter;
			    
			    }
			    
			    //Olevelreport::create();
		
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
	
	public function report_get_total_mark($report_id = null,$subjects = null){
	
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
	
	public function report_getaggregates($report_id = null){
	
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
			
			if(($shortsubjectname_exam_grade != null) && ($shortsubjectname_exam_grade > 0)){
			
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
	
	public function report_getdivision($report_id = null){
	
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
	
	public function report_gradesubjects($report_id = null,$subjects = null ){

	    $Schooldonesubject = ClassRegistry::init('Schooldonesubject');
	    $Olevelreportdetail = ClassRegistry::init('Olevelreportdetail');
	    $Gradeprofile = ClassRegistry::init('Gradeprofile');
	
	    if( $report_id != null ){
	    
		if( $subjects == null ){
		
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
		    
		    foreach ( $report_ids_toconsider as $areport_id ){
		    
			$student_id_onreport = Olevelreport::field('student_id',
			    array('id =' => $areport_id['Olevelreport']['id'])
			);
		    
			foreach ( $shortsubjectnames as $shortsubjectname ){
			
			    $shortsubjectname_for_a_subject = $shortsubjectname['Schooldonesubject']['shortsubjectname'];
			    
			    $shortsubjectname_exam_mark = Olevelreport::field($shortsubjectname_for_a_subject,
				  array('id =' => $areport_id['Olevelreport']['id'])
			    );
		    
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
?>