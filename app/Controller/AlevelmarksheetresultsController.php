<?php
App::uses('Folder','Utility');
App::uses('Files','Utility');
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class AlevelmarksheetresultsController extends AppController {
    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session','PhpExcel.PhpExcel');


    public function entermarks(){
      $this->layout = 'default2';

      $this->loadModel('Schooldoneexam');
      $this->loadModel('Schooldonesubject');
      $this->loadModel('Schooldoneasubject');
      $this->loadModel('Schoolstream');

      $papers = array(
        "1" => 'Paper 1',
        "2" => 'Paper 2',
        "3" => 'Paper 3',
      );

      if ($this->request->is('post')){
	      if(isset($this->request->data['Alevelmarksheetresult']['marksheet_id'])){
          // Validate the data being sent before anything else;
          $paper = "";
          if (array_key_exists('form_paper', $this->request->data['Alevelmarksheetresult']))  {
            $paper = $this->request->data['Alevelmarksheetresult']['form_paper'];
          }

          $subject_short_name = $this->request->data['Alevelmarksheetresult']['form_subject_short_name'];
          $mark = $this->request->data['Alevelmarksheetresult'][$subject_short_name.$paper.'_mark'];
          $mark = is_string($mark) ? trim($mark) : $mark;

          $condition_1 = !(is_null($mark));
          $condition_2 = is_numeric($mark);
          $condition_3 = $condition_1 && $condition_2 && ((int)$mark >= 0 && (int)$mark <= 100);
          $condition_4 = $condition_1 && !$condition_2 && (strtolower($mark) == 'x'); 

          if (empty($mark) || $condition_3 || $condition_4) {
            $this->Alevelmarksheetresult->id = $this->request->data['Alevelmarksheetresult']['marksheet_id'];

            if (!$condition_2 && (strtolower($mark) == 'x')) {
              $this->request->data['Alevelmarksheetresult'][$subject_short_name.$paper.'_mark'] = 1111;
            }

            if ($this->Alevelmarksheetresult->save($this->request->data)){
              if (array_key_exists('form_paper', $this->request->data['Alevelmarksheetresult'])){
                $this->Session->setFlash(
                  __(
                    'Successfully updated the marks for '.$this->request->data['Alevelmarksheetresult']['form_subject'].' Paper '.$this->request->data['Alevelmarksheetresult']['form_paper']
                  )
                );
              }else{
                $this->Session->setFlash(
                  __(
                    'Successfully updated the marks for '.$this->request->data['Alevelmarksheetresult']['form_subject']
                  )
                );
              }
              //return $this->redirect(array('action' => 'index'));
            }else{
              $this->Session->setFlash(__('Was Unable to update the marks'));
            }

          } else {
            $this->Session->setFlash(__('Invalid result entered, Either leave blank, Enter X or a value between 0 and 100'));
          }

	      }else{
	
          if($this->request->data['criterea'] === "singlestudent"){
      
            $this->loadModel('Schooldoneasubject');
            $this->loadModel('Schooldoneexam');
            
            $foundsubjectname = $this->Schooldoneasubject->find('all', 
              array(
                'fields' => array('Schooldoneasubject.fullsubjectname', 'Schooldoneasubject.shortsubjectname'),
                'conditions' => array('Schooldoneasubject.shortsubjectname =' => $this->request->data['subject'])
              )
            );

            $foundexamname = $this->Schooldoneexam->find('all', 
              array(
                'fields' => array('Schooldoneexam.fullexamname'),
                'conditions' => array('Schooldoneexam.alias =' => $this->request->data['examtoenter'])
              )
            );

            $registrationnumber = $this->request->data['registrationnumber'];	    
            $subject = $foundsubjectname[0]['Schooldoneasubject']['fullsubjectname'];
            $subject_short_name = $foundsubjectname[0]['Schooldoneasubject']['shortsubjectname'];		    
            $examtoenter = $foundexamname[0]['Schooldoneexam']['fullexamname'];
            //the short exam name
            $shortexamtoenter = $this->request->data['examtoenter'];

            $this->loadModel('Student');      	      
            $students = $this->Student->find('all', array(
              'conditions' => array(
                'Student.registrationnumber' => $registrationnumber,
                'AND' => array(
                  'OR' => array(
                    array('Student.currentclass =' => 5),
                    array('Student.currentclass =' => 6),
                  )
                )
              )
            ));

            if($students != null){
          
              if(file_exists("img/studentpics/".$students[0]['Student']['picturenumber'].".jpg") == true){
                $webcampic = $students[0]['Student']['picturenumber'];		  
                $this->set('webcampic', $students[0]['Student']['picturenumber']);
              }else{ 
                $webcampic = false;
                $this->set('webcampic', $webcampic);
              }
          
          
              // Start process of checking if marksheet for the class has been created 
              $this->loadModel('Marksheetcriterea');
          
              $Marksheetcriterea = $this->Alevelmarksheetresult
                ->checkIfMarksheetIsCreated($shortexamtoenter,date("Y"),$students[0]['Student']['currentclass']);
          
              // if the marksheet has not been created perform these actions
              if($Marksheetcriterea == false){
          
                $this->Alevelmarksheetresult
                  ->createMarksheet($shortexamtoenter,$students[0]['Student']['currentclass'],date("Y"));
    
                // Extract ,the id of the marksheet containing the students marks
                $olevelresult_table_id = $this->Alevelmarksheetresult->field('id',
                  array('student_id' => $students[0]['Student']['id'],
                    'exam_name' => $this->request->data['examtoenter'],
                    'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
                  )
                );
        
                // Extract the current marks for the subject
                $olevelresult_table_mark = $this->Alevelmarksheetresult->field(
                  $this->request->data['subject'].$this->request->data['Paper']."_mark",
                  array('student_id' => $students[0]['Student']['id'],
                    'exam_name' => $this->request->data['examtoenter'],
                    'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
                  )
                );
        
                if ($olevelresult_table_mark == '1111') {
                  $olevelresult_table_mark = "X";
                }
        
                $results = $this->Alevelmarksheetresult->findById($olevelresult_table_id);
                if (!$results){
                  throw new NotFoundException(__('Invalid Result'));
                }
                if (!$this->request->data){
                  $this->request->data = $results;
                }

                $this->set('subjecttoedit',$this->request->data['subject'].$this->request->data['Paper']."_mark");
                $this->set('current_mark',$olevelresult_table_mark);
                $this->set('marksheet_id',$olevelresult_table_id);
                $this->set('examtoenter', $examtoenter);
                $this->set('subjecttoenter', $subject);
                $this->set('paper', $this->request->data['Paper']);
                $this->set('subject_short_name', $subject_short_name);
                $this->set('student', $students);
                $this->render('entermarksforsinglestudent');

              }else{
        
                $this->Alevelmarksheetresult
                  ->updateMarksheet($shortexamtoenter,$students[0]['Student']['currentclass'],date("Y"));
        
                // Extract ,the id of the marksheet containing the students marks
                $olevelresult_table_id = $this->Alevelmarksheetresult->field('id',
                  array('student_id' => $students[0]['Student']['id'],
                    'exam_name' => $this->request->data['examtoenter'],
                    'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
                  )
                );

                if(array_key_exists('Paper', $this->request->data)){
                  $subject_to_edit = $this->request->data['subject'].$this->request->data['Paper']."_mark";
                  $paper = $this->request->data['Paper'];
                }else{
                  $subject_to_edit = $this->request->data['subject']."_mark";
                  $paper=null;
                }
                
                // Extract the current marks for the subject
                $olevelresult_table_mark = $this->Alevelmarksheetresult->field(
                  $subject_to_edit,
                  array('student_id' => $students[0]['Student']['id'],
                    'exam_name' => $this->request->data['examtoenter'],
                    'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
                  )
                );

                if ($olevelresult_table_mark == '1111') {
                  $olevelresult_table_mark = "X";
                }
        
                $results = $this->Alevelmarksheetresult->findById($olevelresult_table_id);
                if (!$results){
                  throw new NotFoundException(__('Invalid Result'));
                }
                if (!$this->request->data){
                  $this->request->data = $results;
                }
                $this->set('subjecttoedit',$subject_to_edit);
                $this->set('current_mark',$olevelresult_table_mark);
                $this->set('marksheet_id',$olevelresult_table_id);
                $this->set('examtoenter', $examtoenter);
                $this->set('subjecttoenter', $subject);
                $this->set('paper', $paper);
                $this->set('subject_short_name', $subject_short_name);
                $this->set('student', $students);
                $this->render('entermarksforsinglestudent');
              }
            }else{
      
              $examsdoneintheschool = $this->Schooldoneexam->find('list', 
                array(
                  'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
                  'recursive' => 0
                )
              );
      
              $subjectsdoneintheschool = $this->Schooldoneasubject->find('list',
                array(
                  'fields' => array('Schooldoneasubject.shortsubjectname','Schooldoneasubject.fullsubjectname'),
                  'recursive' => 0
                )
              );

              $a_level_subjects_done = $this->Schooldoneasubject->find('list', array(
                'fields' => array('Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.fullsubjectname'),
                'recursive' => 0
              ));
              $subjectsdoneintheschool = $a_level_subjects_done;
      
              $streamsintheschool = $this->Schoolstream->find('list',
                array(
                  'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
                  'recursive' => 0
                )
              );
    
              $this->set('examsdoneintheschool', $examsdoneintheschool);
              $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
              $this->set('papers', $papers);
              $this->set('streamsintheschool',$streamsintheschool);
        
              $entrycriterea = "singlestudent";
              $this->set('entrycriterea', $entrycriterea); 
          
              if($registrationnumber == null){
                $this->Session->setFlash(__('Please enter a Registration number'));
                $this->render('entermarks');
              }else{
                $this->Session->setFlash(__('The Registration number entered does not exist. Please enter one belonging to a student in A-Level'));
                $this->render('entermarks');
              }
		        }

	        }else{
	          if(($this->request->data['criterea'] === "allstudents")){
	      
		          $this->loadModel('Student');
	
              $subject = $this->request->data['subject'];
              $subject_paper = $this->request->data['Paper'];
              $examtoenter = $this->request->data['examtoenter'];
              $examyear = $this->request->data['examyear'];
                
              $this->loadModel('Schooldoneexam');
              $this->loadModel('Schooldonesubject');
              $this->loadModel('Schooldoneasubject');

              $theexamtoenterfilename = $this->Schooldoneexam->field('fullexamname',
                  array('alias =' => $examtoenter)
              );
                
              $thesubjectfilename = $this->Schooldoneasubject->field('fullsubjectname',
                  array('shortsubjectname =' => $subject)
              );	            
		  
              if ($this->request->data['classischecked'] === "0") {
            
                  $examsdoneintheschool = $this->Schooldoneexam->find('list', array(
                    'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
                    'recursive' => 0
                  ));
            
                  $subjectsdoneintheschool = $this->Schooldoneasubject->find('list', array(
                    'fields' => array('Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.fullsubjectname'),
                    'recursive' => 0
                  ));

                  $a_level_subjects_done = $this->Schooldoneasubject->find('list', array(
                    'fields' => array('Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.fullsubjectname'),
                    'recursive' => 0
                  ));
                  $subjectsdoneintheschool = $a_level_subjects_done;
            
                  $streamsintheschool = $this->Schoolstream->find('list', array(
                    'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
                    'recursive' => 0
                  ));
          
                  $this->set('examsdoneintheschool', $examsdoneintheschool);
                  $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
                  $this->set('streamsintheschool',$streamsintheschool);
                  $this->set('papers', $papers);
                  $entrycriterea = "allstudents";
                  $this->set('entrycriterea', $entrycriterea);
                  
                  $this->Session->setFlash(__('Please ensure the Class option is checked'));
                  $this->render('entermarks');
              }
		  
              if($this->request->data['classischecked'] === "1"){
                  $stream_exists = 0;
                  if($this->request->data['streamischecked'] === "1"){
                    $stream = $this->request->data['stream'];
                    $stream_exists = 1;
                  }
                  
                  $subject_id = $this->Schooldoneasubject->field('id',
                    array('shortsubjectname =' => $subject)
                  );

                  switch($this->request->data['class']){
                      case "5":
                        // Start process of checking if marksheet for the class has been created 
                        $this->loadModel('Marksheetcriterea');
                        $Marksheetcriterea = $this->Alevelmarksheetresult
                          ->checkIfMarksheetIsCreated($examtoenter,date("Y"),5);
                        
                        // if the marksheet has not been created perform these actions
                        if($Marksheetcriterea == false){	      
                          $this->Alevelmarksheetresult->createMarksheet($examtoenter,5,date("Y"));
                        }else{
                          $this->Alevelmarksheetresult->updateMarksheet($examtoenter,5,date("Y"));
                        }
                      
                        if($stream_exists == 0){
                          $studentsbyclass = $this->Student->find('all',
                            array(
                              'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
                              'conditions' => array(
                                'Student.currentclass =' => 5,
                                'Student.leavingreason =' => "None",
                                'AND' => array(
                                  'OR' => array(
                                    'Alevelsubjectcombination.subject1 =' => (string)$subject_id,
                                    'Alevelsubjectcombination.subject2 =' => (string)$subject_id,
                                    'Alevelsubjectcombination.subject3 =' => (string)$subject_id,
                                    'Alevelsubjectcombination.subject4 =' => (string)$subject_id,
                                  )
                                )
                              ),
                              'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
                              'recursive' => 0
                            )
                          );
                        }else{
                          $studentsbyclass = $this->Student->find('all',
                            array(
                              'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
                              'conditions' => array(
                                'Student.currentclass =' => 5,
                                'Student.leavingreason =' => "None",
                                'Student.currentstream =' => $stream,
                                'AND' => array(
                                  'OR' => array(
                                    'Alevelsubjectcombination.subject1 =' => (string)$subject_id,
                                    'Alevelsubjectcombination.subject2 =' => (string)$subject_id,
                                    'Alevelsubjectcombination.subject3 =' => (string)$subject_id,
                                    'Alevelsubjectcombination.subject4 =' => (string)$subject_id,
                                  )
                                )
                              ),
                              'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
                              'recursive' => 0
                            )
                          );
                        }
                      
                        break;
                      case "6":
                        // Start process of checking if marksheet for the class has been created 
                        $this->loadModel('Marksheetcriterea');
                        $Marksheetcriterea = $this->Alevelmarksheetresult
                          ->checkIfMarksheetIsCreated($examtoenter,date("Y"),6);
                          
                        // if the marksheet has not been created perform these actions
                        if($Marksheetcriterea == false){	      
                          $this->Alevelmarksheetresult->createMarksheet($examtoenter,6,date("Y"));
                        }else{
                          $this->Alevelmarksheetresult->updateMarksheet($examtoenter,6,date("Y"));
                        }
                    
                        if($stream_exists == 0){
                          $studentsbyclass = $this->Student->find('all', array(
                            'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
                            'conditions' => array(
                              'Student.currentclass =' => 6,
                              'Student.leavingreason =' => "None",
                              'AND' => array(
                                'OR' => array(
                                  'Alevelsubjectcombination.subject1 =' => (string)$subject_id,
                                  'Alevelsubjectcombination.subject2 =' => (string)$subject_id,
                                  'Alevelsubjectcombination.subject3 =' => (string)$subject_id,
                                  'Alevelsubjectcombination.subject4 =' => (string)$subject_id,
                                )
                              )
                            ),
                            'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
                            'recursive' => 0
                          ));
                        }else{
                          $studentsbyclass = $this->Student->find('all', array(
                            'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
                            'conditions' => array(
                              'Student.currentclass =' => 6,
                              'Student.leavingreason =' => "None",
                              'Student.currentstream =' => $stream,
                              'AND' => array(
                                'OR' => array(
                                  'Alevelsubjectcombination.subject1 =' => (string)$subject_id,
                                  'Alevelsubjectcombination.subject2 =' => (string)$subject_id,
                                  'Alevelsubjectcombination.subject3 =' => (string)$subject_id,
                                  'Alevelsubjectcombination.subject4 =' => (string)$subject_id,
                                )
                              )
                            ),
                            'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
                            'recursive' => 0
                          ));
                        }
                    
                        break;
                  }
          
                  if($studentsbyclass != null){
          
                    $objPhpExcel  = $this->PhpExcel->createWorksheet()
                        ->setDefaultFont('Calibri', 11);
                                
                    $passwordHasher = new BlowfishPasswordHasher();

                    # The subject has separate papers which must be graded
                    if (empty($subject_paper) == False){
                      $thesubjectfilename = $thesubjectfilename."_"."Paper ".$subject_paper;
                    }

                    $table = array(
                      array('label' => __("S".$this->request->data['class']." - ".$thesubjectfilename." - ".$theexamtoenterfilename." - ".$examyear." - "."Examination Mark Sheet"))
                    );
          
                    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
          
                    // merge particular cells
                    $objPhpExcel->getActiveSheet()->mergeCells('A1:E1');
          
                    // change the cell alignment
                    $objPhpExcel->getActiveSheet()->getStyle('A1:E1')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          
                    // change the text wrapping to false
                    $objPhpExcel->getActiveSheet()->getStyle('A1:E1')
                        ->getAlignment()
                        ->setWrapText(true);
          
                    // increase row height for the first row 
                    $objPhpExcel->getActiveSheet()->getRowDimension(1)
                        ->setRowHeight(30);
          
                    $tobehashed = $objPhpExcel->getActiveSheet()->getCell('A1')->getValue();
                
                    $salt = "12345-+5tgijmdlwi84je9d,w+-984m$";
                
                    $tobehashed = $tobehashed."+-1";
                
                    Security::setHash('blowfish');
                
                    $objPhpExcel->getActiveSheet()->setCellValue('CC3',Security::hash($tobehashed));
                
                
                    // define table cells
                    $table = array(
                        array('label' => __('No.'), 'filter' => false),
                        array('label' => __('Registration Number'), 'filter' => false,),
                        array('label' => __('Student Name'), 'filter' => false),
                        array('label' => __('Stream')),
                        array('label' => __('Subject Marks'))
                    );
          
                    // add heading with different font and bold text
                    $this->PhpExcel
                      ->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
                
                    // close table and output
          
                    $rowtobemodified = 0;
                    $numberofstudent = 1;
                
                    $registrationnumberhash = "";
                
                    foreach ($studentsbyclass as $d) {
                      $rowtobemodified++;
                      $this->PhpExcel->addTableRow(
                        array(
                          $numberofstudent++,
                          $d['Student']['registrationnumber'],		
                          $d['Student']['surname']." ".$d['Student']['othernames'],
                          $d['Student']['currentstream']
                        )
                      );
                    
                      $registrationnumberhash = $registrationnumberhash.$d['Student']['registrationnumber'];
                    }

                    $registrationnumberhash = (string)$registrationnumberhash."+-=";
                
                    Security::setHash('blowfish');
                
                    $objPhpExcel->getActiveSheet()->setCellValue('CC4',Security::hash($registrationnumberhash/*,'sha1', '1'*/)/*$passwordHasher->hash($registrationnumberhash)*/);

                
                    // start the setting validation rules for the cells where marks are going to be entered
          
                    for($i=0; $i<$rowtobemodified; $i++){
                      $objValidation = $objPhpExcel->getActiveSheet()
                        ->getCell('E'.($i+3))
                        ->getDataValidation();
                      
                      $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_CUSTOM);
                      $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
                      $objValidation->setAllowBlank(true);
                      $objValidation->setShowInputMessage(true);
                      $objValidation->setShowErrorMessage(true);
                      $objValidation->setErrorTitle('Input error');
                      $objValidation->setError('This value is not allowed! Please enter a number between 0 and 100 or X for a missing mark');
                      $objValidation->setPromptTitle('Allowed input');
                      $objValidation->setFormula1('=if(OR(AND(E'.($i+3).'>=0,E'.($i+3).'<=100),lower(E'.($i+3).')="x"), True, False)');
                    }
          
                    //Start protecting cells
                    $objSheet = $objPhpExcel->getActiveSheet();
                
                    // SET BORDERS ON A PARTCULAR CELL RANGE IN THE ACTIVE SHEET
                    $styleArray = array(
                      'borders' => array(
                        'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN,
                          //'color' => array('argb' => 'FFFF0000'),
                        ),
                      ),
                    );			  
                
                    $objSheet->getStyle('A2:E'.($rowtobemodified+2))->applyFromArray($styleArray);
          
                    // UNPROTECT THE CELL RANGE
                    $objSheet->getStyle('E3:E'.($rowtobemodified+2))
                      ->getProtection()
                      ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
          
                    $this->PhpExcel->addTableFooter();
                
                    // PROTECT THE WORKSHEET SHEET
                    $objSheet->getProtection()->setSheet(true);

                    $objPhpExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                    $objPhpExcel->getActiveSheet()->getProtection()->setInsertColumns(true);


                    $objPhpExcel->getActiveSheet()->getProtection()->setPassword('PHPExcel');



                    //Check if the password on the sheet is the hashed pass word
                    if(PHPExcel_Shared_PasswordHasher::hashPassword('PHPExcel') == $objPhpExcel->getActiveSheet()->getProtection()->getPassword() ){
                      $objPhpExcel->output("S".$this->request->data['class'].' - '.$thesubjectfilename.' - '.$theexamtoenterfilename.' - '.'Examinations'.' - '.$examyear.' - marksheet'.'.xlsx','Excel2007');
                    }
          
          
                    $this->Session->setFlash(__('Successfully created a file for you to enter your marks'));
                    $this->render('entermarks'); 
                  }else{
                    $examsdoneintheschool = $this->Schooldoneexam->find('list', array(
                      'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
                      'recursive' => 0
                    ));
              
                    $subjectsdoneintheschool = $this->Schooldoneasubject->find('list', array(
                      'fields' => array('Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.fullsubjectname'),
                      'recursive' => 0
                    ));
  
                    $a_level_subjects_done = $this->Schooldoneasubject->find('list', array(
                      'fields' => array('Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.fullsubjectname'),
                      'recursive' => 0
                    ));
                    $subjectsdoneintheschool = $a_level_subjects_done;
              
                    $streamsintheschool = $this->Schoolstream->find('list', array(
                      'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
                      'recursive' => 0
                    ));
            
                    $this->set('examsdoneintheschool', $examsdoneintheschool);
                    $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
                    $this->set('streamsintheschool',$streamsintheschool);
                    $this->set('papers', $papers);
                    $entrycriterea = "allstudents";
                    $this->set('entrycriterea', $entrycriterea);

                    $this->Session->setFlash(__('No students taking on the Subject Found'));
                    $this->render('entermarks');
                  }
              }
	          }
	        }
	      }
      }
    
      $examsdoneintheschool = $this->Schooldoneexam->find('list', array(
	      'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
	      'recursive' => 0
      ));

      $a_level_subjects_done = $this->Schooldoneasubject->find('list', array(
	      'fields' => array('Schooldoneasubject.shortsubjectname', 'Schooldoneasubject.fullsubjectname'),
	      'recursive' => 0
      ));
      $subjectsdoneintheschool = $a_level_subjects_done;
      $streamsintheschool = $this->Schoolstream->find('list', array(
	      'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
	      'recursive' => 0
      ));
   
      $this->set('examsdoneintheschool', $examsdoneintheschool);
      $this->set('subjectsdoneintheschool', $subjectsdoneintheschool);
      $this->set('streamsintheschool', $streamsintheschool);
      $this->set('papers', $papers);
      $entrycriterea = "allstudents";
      $this->set('entrycriterea', $entrycriterea); 
    }


    public function upLoadData(){
	    $this->layout = 'default2';
	    Controller::disableCache();

	    if ($this->request->is('Post')){

	      $condition1 = ($this->request->data['uploadedfile']['error'] == 0);
	      $condition2 = (
          $this->request->data['uploadedfile']['type']
            == 
			    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
			  );
	      $condition3 = (
          ($this->request->data['uploadedfile']['size'] > 0)
            && 
			    ($this->request->data['uploadedfile']['size'] <= 6291456)
			  );
	      $condition4 = ($this->request->data['uploadData'] == "alevelstudentresults");
	    
	      if($condition1 != true){
		      $this->Session->setFlash(__("There was an error during the upload, Please try again"));
	      }
	    
	      if($condition2 != true){
		      $this->Session->setFlash(__("Please use a Microsoft Excel 2007 file during upload"));
	      }

	      if($this->request->data['uploadedfile']['size'] == 0){
		      $this->Session->setFlash(__("Please choose an Excel 2007 file to upload"));
	      }
	    
	      if($condition3 != true && ($this->request->data['uploadedfile']['size'] != 0)){
		      $this->Session->setFlash(__("Please choose an Excel 2007 which is less than 7MB"));
	      }
	    
	      if( $condition1 && $condition2 && $condition3 && $condition4){
	    
		      $file = $this->request->data['uploadedfile']['tmp_name'];
	    
		      //load the worksheet from a file
		      $objPHPExcel = $this->PhpExcel->loadWorksheet($file);
		      $objPHPExcel->setActiveSheetIndex(0);
		
		      $header1 = $objPHPExcel->getActiveSheet()->getCell('A1')->getValue();
		
		      $header = $header1."+-1";
		
		      $salt = "12345-+5tgijmdlwi84je9d,w+-984m$";
		
		      Security::setHash('blowfish');
		
		      // Check for the header match
		      $condition5 = (
            Security::hash(
              $header,
              'blowfish',
              $objPHPExcel->getActiveSheet()->getCell('CC3')->getValue()
            )  === $objPHPExcel->getActiveSheet()->getCell('CC3')->getValue()
          );
		
		      $i = 3;
		
		      $reghash = "";
		
		      while($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue() != null){
		        $reghash = $reghash.$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
		        $i = $i + 1;
		      }

		      $reghash = $reghash."+-=";
		
		      Security::setHash('blowfish');
		
		      // Check for Registration match
		      $condition6 = (
            (
              Security::hash(
                $reghash,
                'blowfish',
                $objPHPExcel->getActiveSheet()->getCell('CC4')->getValue()
              )
            )  === ($objPHPExcel->getActiveSheet()->getCell('CC4')->getValue())
          );
		
		
		      if (($condition5 == true) && ($condition6 == true)) {
		        if ((strlen($header1) <= 100) && (strlen($header1) >= 1)){
              $file_contents_error = 0;
			        //split the title to extract values
			        $splitTitle = explode(" - ",(string)$header1);

			        // put split values of split array in different variables
			        $classname   = $splitTitle[0];
			        $subjectname_array = explode("_",$splitTitle[1]);
              $paper="";
              if(sizeof($subjectname_array) == 1){
                $subjectname = explode("_",$splitTitle[1])[0];
              }
              if(sizeof($subjectname_array) == 2){
                $subjectname = explode("_",$splitTitle[1])[0];
                $paper = explode(
                  " ",
                  explode(
                    "_",
                    $splitTitle[1]
                  )[1]
                )[1];
              }
			        $examname    = $splitTitle[2];
			        $examyear    = $splitTitle[3];
			
			        if(strlen($classname) != 2){
			          $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
                $file_contents_error=1;
			        }
			
			        // Get the registration number, look for its id in the database
			        // and replace the subject with the mark in the marksheet
			
			        $registationnumber = "";
			        $this->loadModel("Student");
			        $this->loadModel("Schooldoneexam");
			        $this->loadModel("Schooldonesubject");
              $this->loadModel("Schooldoneasubject");
			
			        $trueexamname = $this->Schooldoneexam->field('alias',
			          array('fullexamname =' => $examname)
			        );
			
			        if ($trueexamname == false) {
			          $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
                $file_contents_error=1;
			        }
			    
			        $truesubjectname = $this->Schooldoneasubject->field('shortsubjectname',
			          array('fullsubjectname =' => $subjectname)
			        );
			
			        if ($truesubjectname == false) {
			          $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
                $file_contents_error=1;
			        }

              if ($paper) {
                $truesubjectname=$truesubjectname.$paper;
              }

              $truesubjectname=$truesubjectname."_mark";

			        if ($examyear != date('Y')) {
			          $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
                $file_contents_error=1;
			        }

              // Check that the file has values that data validation of excel files has not been broken
              $i = 3;
              $data_validation_broken = False;
              while ($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue() != null) {
                $mark = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
                if (is_numeric($mark) && ($mark <=0 or $mark >=100)) {
                  $data_validation_broken = True;
                  break;
                }

                if (!(is_numeric($mark)) && strtolower($mark) != "x") {
                  $data_validation_broken = True;
                  break;
                }
                $i++;
              }

              if ($data_validation_broken) {
                $this->Session->setFlash(__("Invalid values for results encountered! Please check your mark entries"));
              }

			
              if($file_contents_error == 0 && $data_validation_broken == False){
                $i = 3;
                $number_of_entries_made = 0;
                while($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue() != null){
      
                  $reghash = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
            
                  $mark = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
                  
                  // If the value supplied is an x we store 1111 to be a representative of
                  // x because all marks are stored in an integer field an so x will not be stored
                  if (strtolower($mark) == "x") {
                    $mark = '1111';
                  }
            
                  //look for the id with the particular
                  //of that registration number
                  $studentid = $this->Student->field('id',
                    array('registrationnumber =' => $reghash)
                  );
          
                  // find the id in the a-level results table
                  $olevelmarksheetresultId = $this->Alevelmarksheetresult->field(
                    'id',
                    array(
                      'student_id =' => $studentid,
                      'year =' => $examyear,
                      'class =' => substr($classname, -1, 1),
                      'exam_name' => $trueexamname
                    )
                  );
            
                  $data = array(
                    'Alevelmarksheetresult' => array(
                      'id' => $olevelmarksheetresultId,
                      $truesubjectname => $mark				    
                    )
                  );
            
                  $this->Alevelmarksheetresult->save($data);
            
                  $i = $i + 1;
            
                  $number_of_entries_made = $number_of_entries_made + 1;
      
                }
        
                if ($number_of_entries_made == 1) {
                  $this->Session->setFlash(__("Successfully updated ".$number_of_entries_made." record"));
                }
                
                if ($number_of_entries_made > 1) {
                  $this->Session->setFlash(__("Successfully updated ".$number_of_entries_made." records"));
                }
        
                if ($number_of_entries_made == 0) {
                  $this->Session->setFlash(__("Failed to update any records"));
                }
              }
		        }
		      }else{
		        $this->Session->setFlash(__("Error in input file. Please upload a correct file")); 
		      }
		
	      }
	    }
	
	    $this->render('up_load_data');
    }


    public function subjects(){
	    if($this->request->is('post')){

	    }
    }
    
    public function entermarksforsinglestudent(){
	    $this->layout = 'default2';
	    $this->render('index');
    }
    
    public function viewOlevelResults(){
	$this->layout = 'default2';
	Controller::disableCache();
	$this->loadModel('Schooldoneexam');
	$this->loadModel('Schooldonesubject');
	$this->loadModel('Student');
	$this->loadModel('Profileassignment');
	$this->loadModel('Gradeprofileusesetting');
	$this->loadModel('Gradeprofile');
	$this->loadModel('Grading');
	$this->loadModel('Ordinaryleveldivisionaward');
	$this->loadModel('Ordinaryleveldivisionawardsetting');
	$this->loadModel('Advancedlevelpointsaward');
	$this->loadModel('Advancedlevelpointsawardsetting');
	
	if ($this->request->is('Post')){
	
	    //$this->layout = 'default2';
	    $regno = $this->request->data['registrationNumber'];
	    $subjects = $this->request->data['subject'];
	    $examtoview = $this->request->data['examtoenter'];
	    $viewyear = $this->request->data['year'];
	    
	    if ($regno != null) {

		$studentid = $this->Student->field('id',
		    array('registrationnumber =' => $regno)
		);
		
		if ($studentid != null) {
		
		    $studentcurrentclass = $this->Student->field('currentclass',
			array('registrationnumber =' => $regno)
		    );
				
		    $gradeprofile_id_of_student_class = $this->Profileassignment
			  ->field('gradeprofile_id',
			array('class =' => $studentcurrentclass)
		    );
		
		    $gradecriterea = $this->Gradeprofileusesetting->field('criterea',
			array('gradeprofile_id =' => $gradeprofile_id_of_student_class)
		    );
		    
		    $marksgrading = $this->Grading->find('all', array(
			      'fields' => array('Grading.lowestvalue','Grading.highestvalue',
						'Grading.award'
						),
			      'conditions' => array('Grading.gradeprofile_id =' 
							=> $gradeprofile_id_of_student_class
						    ),
			      'order' => array( 'Grading.lowestvalue' => 'asc'),
			      'recursive' => 0
		    ));
		    
		    
		    if($gradecriterea == "ordinarylevel"){
			
			$olevelmarksdivision = $this->Ordinaryleveldivisionaward->find('all', array(
			      'fields' => array('Ordinaryleveldivisionaward.lowestvalue',
						'Ordinaryleveldivisionaward.highestvalue',
						'Ordinaryleveldivisionaward.award'
						),
			      'conditions' => array('Ordinaryleveldivisionaward.gradeprofile_id =' 
							=> $gradeprofile_id_of_student_class
						    ),
			      'order' => array( 'Ordinaryleveldivisionaward.lowestvalue' => 'asc'),
			));
			
			$oleveldivisionawardsetting = $this->Ordinaryleveldivisionawardsetting->find('all', array(
			      'conditions' => array('Ordinaryleveldivisionawardsetting.gradeprofile_id =' 
							=> $gradeprofile_id_of_student_class
						    ),
			));
		    
		    } else {
		    
			$alevelpointsawards = $this->Advancedlevelpointsaward->find('all', array(
			      'fields' => array('Advancedlevelpointsaward.lowestvalue',
						'Advancedlevelpointsaward.highestvalue',
						'Advancedlevelpointsaward.award',
						'Advancedlevelpointsaward.weight',
						),
			      'conditions' => array('Advancedlevelpointsaward.gradeprofile_id =' => $gradeprofile_id_of_student_class),
			      'order' => array( 'Advancedlevelpointsaward.lowestvalue' => 'asc'),
			      
			));
			
			$alevelpointsawardsetting = $this->Advancedlevelpointsawardsetting->find('all', array(
			
			      'conditions' => array('Advancedlevelpointsawardsetting.gradeprofile_id =' => $gradeprofile_id_of_student_class),
			      
			));	
		    
		    }
		
		    if ( $subjects == null ) {
			$this->Session->setFlash(__("Please select atleast one subject"));
			
		    }

		    if ( $examtoview == null ) {
			$this->Session->setFlash(__("Please select atleast one examination"));
		    }
		    
		    if ( $viewyear == null ) {
			$this->Session->setFlash(__("Please select a year"));
		    }
		    
		    $results = array();
		    $results2 = array();
		    
		    if(($subjects != null) && ($examtoview != null) && ($viewyear != null)) {
			foreach ( $subjects as $subject ) {
		    
			    foreach ( $examtoview as $exam ) {
			
				$results[$subject][$exam] =
				$this->Alevelmarksheetresult->field($subject,
				      array('student_id =' => $studentid,
					    'exam_name =' => $exam,
					    'year =' => $viewyear
				      )
				);
			    
			    }
			
			}
			
			foreach ( $subjects as $subject ) {
			
			    $fullsubjectname = $this->Schooldonesubject->field('fullsubjectname',
				array('shortsubjectname =' => $subject)
			    );
			
			    foreach ( $examtoview as $exam ) {
			    
				$fullexamname = $this->Schooldoneexam->field('fullexamname',
				    array('alias =' => $exam)
				);
				
				$results2[$fullsubjectname][$fullexamname] = $results[$subject][$exam];
			    
			    }
			
			}
			
			if( $results2 == null ) {
			    $results2 = " ";
			}
			
			$this->set('results2', $results2);
			$this->set('results3', $results2);
			$this->set('gradecriterea', $gradecriterea);
			$this->set('marksgrading', $marksgrading);
			
			
			if ( $gradecriterea == "ordinarylevel" ) {
			
			    $this->set('olevelmarksdivision', $olevelmarksdivision);
			    $this->set('oleveldivisionawardsetting', $oleveldivisionawardsetting);
			
			} else {
			
			    $this->set('alevelpointsawards', $alevelpointsawards);
			    $this->set('alevelpointsawardsetting', $alevelpointsawardsetting);
			
			}
			
			
			$this->render('view_olevel_student_results','default2');
			
		    }
		
		} else {
		
		    $this->Session->setFlash(__("Please supply a valid Registration Number"));
		
		}
		
		
	    
	    } else {
		$this->Session->setFlash(__("Please supply a Registration Number"));
	    }
	
	}

	
	$subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
	    'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),	    
	    'recursive' => 0
	));
	
	$examsdoneintheschool = $this->Schooldoneexam->find('list', array(
	    'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),	    
	    'recursive' => 0
	));
	
	
	$this->set('examsdoneintheschool', $examsdoneintheschool);
	$this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
	
    }

    public function getSubjectPapers() {
      
      $this->layout = 'ajax_response';

      $this->loadModel('Schooldoneasubject');
      $subject = $this->request->data['subject'];
      print_r("data", $subject);
      $a_level_subjects_done = $this->Schooldoneasubject->find('first', array(
	      'fields' => array('Schooldoneasubject.papersdone', 'Schooldoneasubject.issubsidiary'),
	      'conditions' => array('Schooldoneasubject.shortsubjectname' => $subject)
      ));

      $subjectsdoneintheschool = explode("$", $a_level_subjects_done["Schooldoneasubject"]["papersdone"]);

      $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
      
   }

}
?>
