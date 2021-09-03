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
		'Alevelreportdetail' => array(
			'className' => 'Alevelreportdetail',
			'foreignKey' => 'alevelreportdetail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function report_add_examsconsidered($report_id = null, $subjects = null) {
	
      $Schooldoneasubject = ClassRegistry::init('Schooldoneasubject');
      $Alevelmarksheetresult = ClassRegistry::init('Alevelmarksheetresult');
      $Alevelreportdetail = ClassRegistry::init('Alevelreportdetail');
	
	    if ( $report_id != null ) {
	    
		    if ( $subjects == null ) {

		      $shortsubjectnames = $Schooldoneasubject->find(
            'all',
            array(
			        'fields' => array(
                'Schooldoneasubject.shortsubjectname',
                'Schooldoneasubject.papersdone',
                'Schooldoneasubject.issubsidiary'
              ),
			        'conditions' => array(
						    "NOT" => array('Schooldoneasubject.shortsubjectname' => null)
						  ),
			      //'recursive' => 0
		        )
          );
		    
		      $year_examdone = $Alevelreportdetail->field(
            'reportyear',
			      array('id =' => $report_id)
		      );
		    
		      $term_examdone = $Alevelreportdetail->field(
            'reportterm',
			      array('id =' => $report_id)
		      );
		    
		      $report_ids_toconsider = $this->find(
            'all',
            array(
			        // 'fields' => array('Alevelreport.id', 'Alevelreport.student_id'),
			        'conditions' => array(
						    'alevelreportdetail_id =' => $report_id
						  )
			      //'recursive' => 0
		        )
          );

          $dataMulti = array();

		      foreach ( $report_ids_toconsider as $areport_id ) {
		    
			      // $student_id_onreport = $this->field(
            //   'student_id',
			      //   array('id =' => $areport_id['Alevelreport']['id'])
			      // );
            $student_id_onreport = $areport_id['Alevelreport']['student_id'];

            $data = array(
              'Alevelreport' => array(
                'id' => $areport_id['Alevelreport']['id']
              )
            );
		    
			      foreach ( $shortsubjectnames as $shortsubjectname ) {
              // Skip subject if it is not in the students Combination
              $subject_papers = array();

              if ($shortsubjectname['Schooldoneasubject']['issubsidiary'] == False) {
                $subject_papers
                 = 
                array_slice(
                  explode("$",$shortsubjectname['Schooldoneasubject']['papersdone']),
                  1
                );
              } else {
                $subject_papers = [""];
              }

              foreach ( $subject_papers as $paper ) {
                $shortsubjectname_exam_considered 
                  = $shortsubjectname['Schooldoneasubject']['shortsubjectname'].($paper)."_examsconsidered";
                $exams_considered = $areport_id['Alevelreport'][$shortsubjectname_exam_considered];
            
                $exams_considered_array = explode("<::>", $exams_considered);
            
                $added_marks = null;
                $counter = 0;
            
                foreach ($exams_considered_array as $anexamconsidered) {
                  $mark = $Alevelmarksheetresult->field(
                    $shortsubjectname['Schooldoneasubject']['shortsubjectname'].($paper)."_mark",				    
                    array(
                      'student_id =' => $student_id_onreport,
                      'exam_name  =' => $anexamconsidered,
                      'year ='	     => $year_examdone
                    )
                  );
                  
                  // Only add marks that exist.
                  if ($mark != null) {
                    // if we have a missing mark, increment counter
                    // to denote we will consider it for the average.
                    if ($mark == 1111) {
                      $mark = 0;
                      $added_marks = $added_marks + $mark;
                      $counter++;
                      continue;
                    }
                    
                    $added_marks = $added_marks + $mark;
                    $counter++;
                  }
                }
            
                $average_mark = null;
            
                if ($counter != 0) {
                  $average_mark = $added_marks/$counter;
                }

                $data["Alevelreport"][$shortsubjectname['Schooldoneasubject']['shortsubjectname'].($paper)."_finalaveragemark"] = $average_mark;
              }
			      }
            // Add the report details that you will soon later save in bulk
            array_push($dataMulti, $data);
		      }
          $this->saveMany($dataMulti);
		    }
	    }
	}

  public function report_grade_subjects($report_id = null, $subjects = null) {

    /**
     * Get the final grade for each of the subjects in the report
     */

    $Schooldoneasubject = ClassRegistry::init('Schooldoneasubject');
    $Alevelmarksheetresult = ClassRegistry::init('Alevelmarksheetresult');
    $Alevelreportdetail = ClassRegistry::init('Alevelreportdetail');
    $Gradeprofile = ClassRegistry::init('Gradeprofile');

    if ( $report_id != null ) {
    
      if ( $subjects == null ) {

        $shortsubjectnames = $Schooldoneasubject->find(
          'all',
          array(
            'fields' => array(
              'Schooldoneasubject.shortsubjectname',
              'Schooldoneasubject.papersdone',
              'Schooldoneasubject.issubsidiary'
            ),
            'conditions' => array(
              "NOT" => array('Schooldoneasubject.shortsubjectname' => null)
            ),
          //'recursive' => 0
          )
        );
      
        $year_examdone = $Alevelreportdetail->field(
          'reportyear',
          array('id =' => $report_id)
        );

        $student_class = $Alevelreportdetail->field(
          'reportclass',
          array('id =' => $report_id)
        );
      
        $term_examdone = $Alevelreportdetail->field(
          'reportterm',
          array('id =' => $report_id)
        );
      
        $reports = $this->find(
          'all',
          array(
            'conditions' => array(
              'alevelreportdetail_id =' => $report_id
            )
          )
        );

        $dataMulti = array();

        foreach ( $reports as $report ) {
          $data = array(
            'Alevelreport' => array(
              'id' => $report['Alevelreport']['id']
            )
          );

          foreach ( $shortsubjectnames as $shortsubjectname ) {
            // TODO: Skip subject if it is not in the students Combination
            $subject_papers = array();

            if ($shortsubjectname['Schooldoneasubject']['issubsidiary'] == False) {
              $subject_papers
               = 
              array_slice(
                explode("$", $shortsubjectname['Schooldoneasubject']['papersdone'])
                ,
                1
              );
            } else {
              $subject_papers = [""];
            }

            $shortsubjectname_simplified = $shortsubjectname['Schooldoneasubject']['shortsubjectname'];
            foreach ( $subject_papers as $paper ) {
              // TODO: Skip papers that are not the students combination
              $final_average_mark = $report['Alevelreport'][$shortsubjectname_simplified.($paper)."_finalaveragemark"];

              if ($final_average_mark != null) {
                $data["Alevelreport"][$shortsubjectname_simplified.($paper)."_finalaveragemarkgrade"]
                  =
                $Gradeprofile->gradeprofile_returnsubjectgrade(
                  $report['Alevelreport']['classthen'],
                  $final_average_mark
                );
              }
            }
          }
          // Add the report details that you will later save in bulk
          array_push($dataMulti, $data);
        }
        $this->saveMany($dataMulti);
      }
    }


  }

  
  public function get_final_subject_grade($subject_paper_grades, $is_subsidiary) { 
    /**
     * Get the final grades for a subject using UNEBs grading pattern. For example if the
     * subject_paper_grades passed is an array containing [2,2] then the returned value
     * should be an A according to the grading of UNEB
     */
    if ($is_subsidiary == True) {
      if (count($subject_paper_grades) == 1) {

        $o_grades = [1,2,3,4,5,6];
        $f_grades = [7,8,9];

        if (in_array($subject_paper_grades[0], $o_grades)) {
          return "O";
        }

        if (in_array($subject_paper_grades[0], $f_grades)) {
          return "F";
        }
        return null;
      }
    }
    
    if ($is_subsidiary == False) {
      // process situation of one subject paper
      if (count($subject_paper_grades) == 1) {
        if ($subject_paper_grades[0] == 1 || $subject_paper_grades[0] == 2) {
          return "A";
        }

        if ($subject_paper_grades[0] == 3) {
          return "B";
        }

        if ($subject_paper_grades[0] == 4) {
          return "C";
        }

        if ($subject_paper_grades[0] == 5) {
          return "D";
        }

        if ($subject_paper_grades[0] == 6) {
          return "E";
        }

        if ($subject_paper_grades[0] == 7 || $subject_paper_grades[0] == 8) {
          return "0";
        }

        if ($subject_paper_grades[0] == 9) {
          return "F";
        }
      }
      
      // process situation of two subject paper
      if (count($subject_paper_grades) == 2) {
        sort($subject_paper_grades);

        if ($subject_paper_grades[1] <= 2) {
          return "A";
        }
        
        if ($subject_paper_grades[1] <= 3) {
          return "B";
        }

        if ($subject_paper_grades[1] <= 4) {
          return "C";
        }

        if ($subject_paper_grades[1] <= 5) {
          return "D";
        }

        if ($subject_paper_grades[1] <= 6) {
          return "E";
        }

        $condition1 = (($subject_paper_grades[0] == 8) && ($subject_paper_grades[1] == 8));
        $condition2 = (($subject_paper_grades[1] == 8) && ($subject_paper_grades[0] < 8));
        $condition3 = (($subject_paper_grades[1] == 9) && ($subject_paper_grades[0] <= 6));

        if  ($condition1 || $condition2 || $condition3) {
          return "O";
        }

        return "F";
      }

      // process situation of three subject papers
      if (count($subject_paper_grades) == 3) {
        sort($subject_paper_grades);

        if ($subject_paper_grades[1] <= 2 && $subject_paper_grades[2] <= 3) {
          return "A";
        }
        
        if ($subject_paper_grades[1] <= 3 && $subject_paper_grades[2] <= 4) {
          return "B";
        }

        if ($subject_paper_grades[1] <= 4 && $subject_paper_grades[2] <= 5) {
          return "C";
        }

        if ($subject_paper_grades[1] <= 5 && $subject_paper_grades[2] <= 6) {
          return "D";
        }

        $condition1 = $subject_paper_grades[2] == 7 || $subject_paper_grades[2] == 8;
        if ($subject_paper_grades[1] <= 6 && $condition1) {
          return "E";
        }

        $count_of_grades = array_count_values($subject_paper_grades);

        $number_of_pass_7s = null;
        $number_of_pass_8s = null;

        if (array_key_exists(7, $count_of_grades)) {
          $number_of_pass_7s = $count_of_grades[7];
        }
        if (array_key_exists(8, $count_of_grades)) {
          $number_of_pass_8s = $count_of_grades[8];
        }

        // Possible conditions to be fulfilled before one gets an O
        $condition1 = $number_of_pass_8s == 3;
        $condition2 = (($number_of_pass_7s + $number_of_pass_8s) == 2) && ($subject_paper_grades[2] <= 6);
        $condition3 = $subject_paper_grades[0] <= 6 && $subject_paper_grades[1] <= 6 && $subject_paper_grades[2] == 9;
        $condition4 = $subject_paper_grades[0] <= 6 && $subject_paper_grades[1] <= 8 && $subject_paper_grades[2] == 9;
        $condition5 = $subject_paper_grades[0] <= 7 && $subject_paper_grades[1] <= 8 && $subject_paper_grades[2] == 9;
        $condition6 = $subject_paper_grades[0] <= 7 && $subject_paper_grades[1] <= 7 && $subject_paper_grades[2] == 9;

        if ($condition1 || $condition2 || $condition3 || $condition4 || $condition5 || $condition6) {
          return "O";
        }

        return "F";
      }
    }
    return null;
  }


  public function report_get_final_subject_grades($report_id = null, $subjects = null) {

    /**
     * Get the final grade for each of the subjects in the report. For example if Math has 
     * Two papers, Paper 1 and Paper 2 and Paper 1 has D1 and Paper 2 has D2 then final grade
     * subject grade is A
     */

    $Schooldoneasubject = ClassRegistry::init('Schooldoneasubject');

    if ( $report_id != null ) {
    
      if ( $subjects == null ) {

        $shortsubjectnames = $Schooldoneasubject->find(
          'all',
          array(
            'fields' => array(
              'Schooldoneasubject.shortsubjectname',
              'Schooldoneasubject.papersdone',
              'Schooldoneasubject.issubsidiary'
            ),
            'conditions' => array(
              "NOT" => array('Schooldoneasubject.shortsubjectname' => null)
            ),
          //'recursive' => 0
          )
        );
      
        $reports = $this->find(
          'all',
          array(
            'conditions' => array(
              'alevelreportdetail_id =' => $report_id
            )
          )
        );

        $dataMulti = array();

        foreach ( $reports as $report ) {
          $data = array(
            'Alevelreport' => array(
              'id' => $report['Alevelreport']['id']
            )
          );

          foreach ( $shortsubjectnames as $shortsubjectname ) {
            // TODO: Skip subject if it is not in the students Combination
            $subject_papers = array();

            if ($shortsubjectname['Schooldoneasubject']['issubsidiary'] == False) {
              $subject_papers
               = 
              array_slice(
                explode("$", $shortsubjectname['Schooldoneasubject']['papersdone'])
                ,
                1
              );
            } else {
              $subject_papers = [""];
            }

            $subject_grades = array();

            $shortsubjectname_simplified = $shortsubjectname['Schooldoneasubject']['shortsubjectname'];
            foreach ( $subject_papers as $paper ) {
              // TODO: Skip papers that are not the students combination
              $final_average_mark_grade = $report['Alevelreport'][$shortsubjectname_simplified.($paper)."_finalaveragemarkgrade"];

              if ($final_average_mark_grade != null) {
                array_push($subject_grades, $final_average_mark_grade);
              }
            }

            $data["Alevelreport"][$shortsubjectname_simplified."_finalgrade"] = 
              $this->get_final_subject_grade($subject_grades, $shortsubjectname['Schooldoneasubject']['issubsidiary']);
          }
          // Add the report details that you will later save in bulk
          array_push($dataMulti, $data);
        }
        $this->saveMany($dataMulti);
      }
    }

  }
	

  public function report_get_points($report_id, $class, $subjects = null) {

    /**
     * Get the final points for each student 
     */

    $Schooldoneasubject = ClassRegistry::init('Schooldoneasubject');
    $Profileassignment = ClassRegistry::init('Profileassignment');
    $Student = ClassRegistry::init('Student');

    if ( $report_id != null ) {
    
      if ( $subjects == null ) {
        // Extract the profile of the user 

        $shortsubjectnames = $Schooldoneasubject->find(
          'all',
          array(
            'fields' => array(
              'Schooldoneasubject.id',
              'Schooldoneasubject.shortsubjectname',
              'Schooldoneasubject.papersdone',
              'Schooldoneasubject.issubsidiary'
            ),
            'conditions' => array(
              "NOT" => array('Schooldoneasubject.shortsubjectname' => null)
            )
          )
        );

        $all_subjects = array();

        // Cache subject id and subject short names for quick lookup later on
        foreach ( $shortsubjectnames as $shortsubjectname ) {
          $all_subjects[$shortsubjectname['Schooldoneasubject']['id']]
           =
          $shortsubjectname['Schooldoneasubject']['shortsubjectname'];
        }

        $award_weights = $Profileassignment->find(
          'all',
          array(
            'conditions' => array(
              'class =' => $class
            ),
            'recursive' => 2
          )
        );

        $all_awards = array();
        // Cache award and weight for quick lookup later on
        foreach ( $award_weights["0"]['Gradeprofile']['Advancedlevelpointsaward'] as $value ) {
          $all_awards[$value['award']]
            =
          $value['weight'];
        }

        $students = $Student->find(
          'all',
          array(
            'fields' => array(
              'Alevelsubjectcombination.subject1',
              'Alevelsubjectcombination.subject2',
              'Alevelsubjectcombination.subject3',
              'Alevelsubjectcombination.subject4',
              'Alevelsubjectcombination.subject5',
              'Student.id',
            ),
            'conditions' => array(
              'currentclass' => $class
            ),
            'recursive' => 1
          )
        );

        /**
         * Cache student_ids and their subjects
         * subjects is an array of the form
         * array("subject1" => 1, "subject2" => 3, "subject3" => 3)
         */
        $student_subjects_cache = array();
        foreach ($students as $student) {
          $student_subjects_cache[$student["Student"]["id"]] = $student["Alevelsubjectcombination"];
        }

        $reports = $this->find(
          'all',
          array(
            'conditions' => array(
              'alevelreportdetail_id =' => $report_id
            ),
          )
        );
        // return $reports;

        $dataMulti = array();

        foreach ( $reports as $report ) {
          $student_id = $report["Alevelreport"]["student_id"];

          $student_subjects = $student_subjects_cache[$student_id];

          $data = array(
            'Alevelreport' => array(
              'id' => $report['Alevelreport']['id']
            )
          );
          $shortsubjectnames = array();

          // Compute the total points
          $subject_numbers = ["1","2", "3", "4", "5"];
          $total_points = null;
          foreach ( $subject_numbers as $value) {
            // 
            $shortsubjectname = $all_subjects[
                $student_subjects[
                  'subject'.$value
                ]
            ];

            $final_grade = $report["Alevelreport"][$shortsubjectname."_finalgrade"];

            // Get final grade and get its weight
            if ($final_grade != null) {

              if (array_key_exists($final_grade, $all_awards)) { 
                # Add the points found.
                $total_points +=(int)$all_awards[$final_grade];
              }
            }
          }
          
          $data["Alevelreport"]["totalpoints"] = $total_points;

          // Add the report details that you will later save in bulk
          array_push($dataMulti, $data);
        }
        $this->saveMany($dataMulti);
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