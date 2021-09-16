<?php
App::uses('Folder','Utility');
App::uses('Files','Utility');
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class OlevelmarksheetresultsController extends AppController {
    public $helpers = array('Paginator','Html', 'Form', 'Js');
    public $components = array('Paginator','Session','PhpExcel.PhpExcel');


    
    public function entermarks(){
      $this->layout = 'default2';
      if ($this->request->is('post')) {
	
	    if(isset($this->request->data['Olevelmarksheetresult']['marksheet_id']) 
	      ){
	    
		$this->Olevelmarksheetresult->id = $this->request->data['Olevelmarksheetresult']['marksheet_id'];
		if ($this->Olevelmarksheetresult->save($this->request->data)){
		    $this->Session->setFlash(__('Successfully updated the students marks'));
		    //return $this->redirect(array('action' => 'index'));
		}else{
		
		    $this->Session->setFlash(__('Was Unable to update the marks'));
		
		}
	    
	    }else{
	
	    if($this->request->data['criterea'] === "singlestudent"){
	  
		$this->loadModel('Schooldonesubject');
		$this->loadModel('Schooldoneexam');
		$foundsubjectname = $this->Schooldonesubject->find('all', 
		    array(
			'fields' => array('Schooldonesubject.fullsubjectname'),
			'conditions' => array('Schooldonesubject.shortsubjectname =' => $this->request->data['subject'])
		    )
		);
		$foundexamname = $this->Schooldoneexam->find('all', 
		    array(
			'fields' => array('Schooldoneexam.fullexamname'),
			'conditions' => array('Schooldoneexam.alias =' => $this->request->data['examtoenter'])
		    )
		);
		$registrationnumber = $this->request->data['registrationnumber'];	    
		$subject = $foundsubjectname[0]['Schooldonesubject']['fullsubjectname'];	    
		$examtoenter = $foundexamname[0]['Schooldoneexam']['fullexamname'];
		//the short exam name
		$shortexamtoenter = $this->request->data['examtoenter'];
		$this->loadModel('Student');	    
		$foundname = $this->Student->find('all', 
		    array(
			'fields' => array('Student.id'),
			'conditions' => array('Student.id =' => $registrationnumber),
			'recursive' => -1
		    )
		);	      	      
		$students = $this->Student->find('all', array(
      'conditions' => array(
        'Student.registrationnumber' => $registrationnumber,
        'AND' => array(
          'OR' => array(
            array('Student.currentclass =' => 1),
            array('Student.currentclass =' => 2),
            array('Student.currentclass =' => 3),
            array('Student.currentclass =' => 4),
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
	      
		    $Marksheetcriterea = $this->Olevelmarksheetresult
					    ->checkIfMarksheetIsCreated($shortexamtoenter,date("Y"),$students[0]['Student']['currentclass']);
	      
		    // if the marksheet has not been created perform these actions
		    if($Marksheetcriterea == false){
	      
			$this->Olevelmarksheetresult
			     ->createMarksheet($shortexamtoenter,$students[0]['Student']['currentclass'],date("Y"));
	
			// Extract ,the id of the marksheet containing the students marks
			$olevelresult_table_id = $this->Olevelmarksheetresult->field('id',
			    array('student_id' => $students[0]['Student']['id'],
				  'exam_name' => $this->request->data['examtoenter'],
				  'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
			    )
			);
			
			// Extract the current marks for the subject
			$olevelresult_table_mark = $this->Olevelmarksheetresult->field($this->request->data['subject'],
			    array('student_id' => $students[0]['Student']['id'],
				  'exam_name' => $this->request->data['examtoenter'],
				  'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
			    )
			);
			
			
			$results = $this->Olevelmarksheetresult->findById($olevelresult_table_id);
			if (!$results){
			    throw new NotFoundException(__('Invalid Result'));
			}
			if (!$this->request->data){
			    $this->request->data = $results;
			}
			$this->set('subjecttoedit',$this->request->data['subject']);
			$this->set('current_mark',$olevelresult_table_mark);
			$this->set('marksheet_id',$olevelresult_table_id);
			$this->set('examtoenter', $examtoenter);
			$this->set('subjecttoenter', $subject);
			$this->set('student', $students);			
			$this->render('entermarksforsinglestudent');

		  
		    }else{
		  
			$this->Olevelmarksheetresult
			      ->updateMarksheet($shortexamtoenter,$students[0]['Student']['currentclass'],date("Y"));
			
			// Extract ,the id of the marksheet containing the students marks
			$olevelresult_table_id = $this->Olevelmarksheetresult->field('id',
			    array('student_id' => $students[0]['Student']['id'],
				  'exam_name' => $this->request->data['examtoenter'],
				  'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
			    )
			);
			
			// Extract the current marks for the subject
			$olevelresult_table_mark = $this->Olevelmarksheetresult->field($this->request->data['subject'],
			    array('student_id' => $students[0]['Student']['id'],
				  'exam_name' => $this->request->data['examtoenter'],
				  'year' => date("Y"), 'class' => $students[0]['Student']['currentclass']
			    )
			);
			
			$results = $this->Olevelmarksheetresult->findById($olevelresult_table_id);
			if (!$results){
			    throw new NotFoundException(__('Invalid Result'));
			}
			if (!$this->request->data){
			    $this->request->data = $results;
			}
			$this->set('subjecttoedit',$this->request->data['subject']);
			$this->set('current_mark',$olevelresult_table_mark);
			$this->set('marksheet_id',$olevelresult_table_id);
			$this->set('examtoenter', $examtoenter);
			$this->set('subjecttoenter', $subject);
			$this->set('student', $students);
			$this->render('entermarksforsinglestudent');
		  
		    }
		}else{
		    $this->loadModel('Schooldoneexam');
		    $this->loadModel('Schooldonesubject');
		    $this->loadModel('Schoolstream');
    
		    $examsdoneintheschool = $this->Schooldoneexam->find('list', 
			array(
			    'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
			    'recursive' => 0
			)
		    );
    
		    $subjectsdoneintheschool = $this->Schooldonesubject->find('list',
			array(
			    'fields' => array('Schooldonesubject.shortsubjectname','Schooldonesubject.fullsubjectname'),
			    'recursive' => 0
			)
		    );
    
		    $streamsintheschool = $this->Schoolstream->find('list',
			array(
			    'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
			    'recursive' => 0
			)
		    );
   
		    $this->set('examsdoneintheschool', $examsdoneintheschool);
		    $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
		    $this->set('streamsintheschool',$streamsintheschool);
		  
		    $entrycriterea = "singlestudent";
		    $this->set('entrycriterea', $entrycriterea); 
		    
		    if($registrationnumber == null){
			$this->Session->setFlash(__('Please enter a Registration number'));
			$this->render('entermarks');
		    }else{
			$this->Session->setFlash(__('The Registration number entered does not exist. Please enter one belonging to a student in O-Level'));
			$this->render('entermarks');
		    }
		}

	      
	  }else{
	      if(($this->request->data['criterea'] === "allstudents")){
	      
		  $this->loadModel('Student');
	
		  $subject = $this->request->data['subject'];
		  $examtoenter = $this->request->data['examtoenter'];
		  $examyear = $this->request->data['examyear'];
	      
		  $this->loadModel('Schooldoneexam');
		  $this->loadModel('Schooldonesubject');

	      
		  $theexamtoenterfilename = $this->Schooldoneexam->field('fullexamname',
		      array('alias =' => $examtoenter)
		  );
	      
		  $thesubjectfilename = $this->Schooldonesubject->field('fullsubjectname',
		      array('shortsubjectname =' => $subject)
		  );	            
		  
		  if ($this->request->data['classischecked'] === "0") {
		      $this->loadModel('Schooldoneexam');
		      $this->loadModel('Schooldonesubject');
		      $this->loadModel('Schoolstream');
    
		      $examsdoneintheschool = $this->Schooldoneexam->find('list', array(
			  'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
			  //’conditions’ => array(’Article.status !=’ => ’pending’),
			  'recursive' => 0
		      ));
    
		      $subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
			  'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
			  //’conditions’ => array(’Article.status !=’ => ’pending’),
			  'recursive' => 0
		      ));
    
		      $streamsintheschool = $this->Schoolstream->find('list', array(
			  'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
			  //’conditions’ => array(’Article.status !=’ => ’pending’),
			  'recursive' => 0
		      ));
   
		      $this->set('examsdoneintheschool', $examsdoneintheschool);
		      $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
		      $this->set('streamsintheschool',$streamsintheschool);
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
		      
		      switch($this->request->data['class']){
			  case "1":
			      // Start process of checking if marksheet for the class has been created 
			      $this->loadModel('Marksheetcriterea');
			      $Marksheetcriterea = $this->Olevelmarksheetresult
							->checkIfMarksheetIsCreated($examtoenter,date("Y"),1);
							
			      // if the marksheet has not been created perform these actions
			      if($Marksheetcriterea == false){	      
				  $this->Olevelmarksheetresult->createMarksheet($examtoenter,1,date("Y"));
			      }else{
				  $this->Olevelmarksheetresult->updateMarksheet($examtoenter,1,date("Y"));
			      }
			      
			      if($stream_exists == 0){
			      
				  $studentsbyclass = $this->Student->find('all',
				      array(
					  'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
					  'conditions' => array('Student.currentclass =' => 1,'Student.leavingreason =' => "None"),
					  'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
					  'recursive' => 0
				      )
				  );
				  
			      }else{
			      
				  $studentsbyclass = $this->Student->find('all',
				      array(
					  'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
					  'conditions' => array('Student.currentclass =' => 1,'Student.leavingreason =' => "None",'Student.currentstream =' => $stream),
					  'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
					  'recursive' => 0
				      )
				  );
		   
			      }
			      
			      break;
			  case "2":
			      // Start process of checking if marksheet for the class has been created 
			      $this->loadModel('Marksheetcriterea');
			      $Marksheetcriterea = $this->Olevelmarksheetresult
						      ->checkIfMarksheetIsCreated($examtoenter,date("Y"),2);
						      
			      // if the marksheet has not been created perform these actions
			      if($Marksheetcriterea == false){	      
				  $this->Olevelmarksheetresult->createMarksheet($examtoenter,2,date("Y"));
			      }else{
				  $this->Olevelmarksheetresult->updateMarksheet($examtoenter,2,date("Y"));
			      }
			      
			      if($stream_exists == 0){
				  $studentsbyclass = $this->Student->find('all', array(
				      'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
				      'conditions' => array('Student.currentclass =' => 2,'Student.leavingreason =' => "None"),
				      'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
				      'recursive' => 0
				  ));
			      }else{
				  $studentsbyclass = $this->Student->find('all', array(
				      'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
				      'conditions' => array('Student.currentclass =' => 2,'Student.leavingreason =' => "None",'Student.currentstream =' => $stream),
				      'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
				      'recursive' => 0
				  ));
		   
			      }
			      
			      break;
			  case "3":
			      // Start process of checking if marksheet for the class has been created 
			      $this->loadModel('Marksheetcriterea');
			      $Marksheetcriterea = $this->Olevelmarksheetresult
							->checkIfMarksheetIsCreated($examtoenter,date("Y"),3);
		    
			      // if the marksheet has not been created perform these actions
			      if($Marksheetcriterea == false){	      
				  $this->Olevelmarksheetresult->createMarksheet($examtoenter,3,date("Y"));
			      }else{
				  $this->Olevelmarksheetresult->updateMarksheet($examtoenter,3,date("Y"));
			      }
			      
			      if($stream_exists == 0){
				  $studentsbyclass = $this->Student->find('all', array(
				      'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
				      'conditions' => array('Student.currentclass =' => 3,'Student.leavingreason =' => "None"),
				      'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
				      'recursive' => 0
				  ));
			      }else{
				  $studentsbyclass = $this->Student->find('all', array(
				      'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
				      'conditions' => array('Student.currentclass =' => 3,'Student.leavingreason =' => "None",'Student.currentstream =' => $stream),
				      'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
				      'recursive' => 0
				  ));
		   
			      }		
			      break;
			  case "4":
			      // Start process of checking if marksheet for the class has been created 
			      $this->loadModel('Marksheetcriterea');
			      $Marksheetcriterea = $this->Olevelmarksheetresult->checkIfMarksheetIsCreated($examtoenter,date("Y"),4);
		   
			      // if the marksheet has not been created perform these actions
			      if($Marksheetcriterea == false){	      
				  $this->Olevelmarksheetresult->createMarksheet($examtoenter,4,date("Y"));
			      }else{
				  $this->Olevelmarksheetresult->updateMarksheet($examtoenter,4,date("Y"));
			      }
			      
			      if($stream_exists == 0){
				  $studentsbyclass = $this->Student->find('all', array(
				      'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
				      'conditions' => array('Student.currentclass =' => 4,'Student.leavingreason =' => "None"),
				      'order' => array( 'Student.currentstream' => 'asc','Student.surname' => 'asc'),
				      'recursive' => 0
				  ));
			      }else{
				  $studentsbyclass = $this->Student->find('all', array(
				      'fields' => array('Student.registrationnumber','Student.id','Student.surname','Student.othernames','Student.currentstream'),
				      'conditions' => array('Student.currentclass =' => 4,'Student.leavingreason =' => "None",'Student.currentstream =' => $stream),
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
			  
			  foreach ($studentsbyclass as $key => $value) {
			      $rowtobemodified++;
			      $this->PhpExcel->addTableRow(array(
				  $numberofstudent++,
				  $value['Student']['registrationnumber'],		
				  $value['Student']['surname']." ".$value['Student']['othernames'],
				  $value['Student']['currentstream']
			      ));
			      
			      $registrationnumberhash = $registrationnumberhash.$value['Student']['registrationnumber'];
			  }

			  $registrationnumberhash = (string)$registrationnumberhash."+-=";
			  
			  Security::setHash('blowfish');
			  
			  $objPhpExcel->getActiveSheet()->setCellValue('CC4',Security::hash($registrationnumberhash/*,'sha1', '1'*/)/*$passwordHasher->hash($registrationnumberhash)*/);

			  
			  // start the setting validation rules for the cells where marks are going to be entered
	
			  for($i=0; $i<$rowtobemodified; $i++){
			      $objValidation = $objPhpExcel->getActiveSheet()
							    ->getCell('E'.($i+3))
							    ->getDataValidation();
							
			      $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_DECIMAL );
			      $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
			      $objValidation->setAllowBlank(true);
			      $objValidation->setShowInputMessage(true);
			      $objValidation->setShowErrorMessage(true);
			      $objValidation->setErrorTitle('Input error');
			      $objValidation->setError('This value is not allowed! Please enter a number from 0 to 100');
			      $objValidation->setPromptTitle('Allowed input');
			      $objValidation->setFormula1(0);
			      $objValidation->setFormula2(100);	
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
		    }
	      
	      }
	  
	  }

	  }
	  
	  }
    	
 
      }
   
      $this->loadModel('Schooldoneexam');
      $this->loadModel('Schooldonesubject');
      $this->loadModel('Schoolstream');
    
      $examsdoneintheschool = $this->Schooldoneexam->find('list', array(
	  'fields' => array('Schooldoneexam.alias','Schooldoneexam.fullexamname'),
	  'recursive' => 0
      ));
    
      $subjectsdoneintheschool = $this->Schooldonesubject->find('list', array(
	  'fields' => array('Schooldonesubject.shortsubjectname', 'Schooldonesubject.fullsubjectname'),
	  'recursive' => 0
      ));
    
      $streamsintheschool = $this->Schoolstream->find('list', array(
	  'fields' => array('Schoolstream.shortstreamname','Schoolstream.stream'),
	  'recursive' => 0
      ));
   
      $this->set('examsdoneintheschool', $examsdoneintheschool);
      $this->set('subjectsdoneintheschool',$subjectsdoneintheschool);
      $this->set('streamsintheschool',$streamsintheschool);
      $entrycriterea = "allstudents";
      $this->set('entrycriterea', $entrycriterea); 
    }
    
   // public function 
    
    public function upLoadData(){
	$this->layout = 'default2';
	Controller::disableCache();
	if ($this->request->is('Post')){
	    $condition1 = ($this->request->data['uploadedfile']['error'] == 0);
	    $condition2 = ($this->request->data['uploadedfile']['type'] == 
			   "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
			  );
	    $condition3 = (($this->request->data['uploadedfile']['size'] > 0) && 
			   ($this->request->data['uploadedfile']['size'] <= 6291456)
			  );
			  
	    $condition4 = ($this->request->data['uploadData'] == "olevelstudentresults");
	    
	    if($condition1 != true){
		$this->Session->setFlash(__("There was an error during the upload, Please try again"));
	    }
	    
	    if($condition2 != true){
		$this->Session->setFlash(__("Please select an Excel 2007 file"));
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
		$condition5 = (Security::hash($header, 'blowfish', $objPHPExcel->getActiveSheet()->getCell('CC3')->getValue())  === $objPHPExcel->getActiveSheet()->getCell('CC3')->getValue());
		
		$i = 3;
		
		$reghash = "";
		
		while($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue() != null){
		
		    $reghash = $reghash.$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
		    
		    $i = $i + 1;
		
		}
		
		
		
		$reghash = $reghash."+-=";
		
		Security::setHash('blowfish');
		
		// Check for Registration match
		$condition6 = ((Security::hash($reghash, 'blowfish', $objPHPExcel->getActiveSheet()->getCell('CC4')->getValue()))  === ($objPHPExcel->getActiveSheet()->getCell('CC4')->getValue()));
		
		
		if (($condition5 == true) && ($condition6 == true)) {
		
		    if ((strlen($header1) <= 100) && (strlen($header1) >= 1)){
          $file_contents_error = 0;
			    //split the title to extract values
			    $splitTitle = explode(" - ",(string)$header1);
			
			    // put split values of split array in different variables
			    $classname   = $splitTitle[0];
			    $subjectname = $splitTitle[1];
			    $examname    = $splitTitle[2];
			    $examyear    = $splitTitle[3];
			
			    if(strlen($classname) != 2){
			      $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
            $file_contents_error = 1;
			    }
			
			    // Get the registration number, look for its id in the database
			    // and replace the subject with the mark in the marksheet
			
			    $registationnumber = "";
			    $this->loadModel("Student");
			    $this->loadModel("Schooldoneexam");
			    $this->loadModel("Schooldonesubject");
			
			    $trueexamname = $this->Schooldoneexam->field('alias',
			      array('fullexamname =' => $examname)
			    );
			
			    if ($trueexamname == false) {
			      $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
            $file_contents_error = 1;
			    }
			    
			    $truesubjectname = $this->Schooldonesubject->field('shortsubjectname',
			      array('fullsubjectname =' => $subjectname)
			    );
			
			    if ($truesubjectname == false) {
			      $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
            $file_contents_error = 1;
			    }
			
			    if ($examyear != date('Y')) {
			      $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
            $file_contents_error = 1;
			    }
			
          if($file_contents_error == 0){
			      $i = 3;
			      $number_of_entries_made = 0;
			      while($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue() != null){
		
			        $reghash = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
			    
			        $mark = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
			    
			        //look for the id with the particular
			        //of that registration number
			        $studentid = $this->Student->field(
                'id',
				        array('registrationnumber =' => $reghash)
			        );
		    
			        // find the id in the o-level results table
			        $olevelmarksheetresultId = $this->Olevelmarksheetresult->field(
                'id',
				        array(
                  'student_id =' => $studentid,
					        'year =' => $examyear,
					        'class =' => substr($classname, -1, 1),
					        'exam_name' => $trueexamname
				        )
			        );
			    
			        $data = array(
				        'Olevelmarksheetresult' => array(
				          'id' => $olevelmarksheetresultId,
				          $truesubjectname => $mark				    
				        )
			        );
			    
			        $this->Olevelmarksheetresult->save($data);
			    
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
		} else {
		    
		    $this->Session->setFlash(__("Error in input file. Please upload a correct file"));
		    
		}
		
	    }
	}
	
	$this->render('up_load_data'/*,'uploadlayout'*/);
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
				$this->Olevelmarksheetresult->field($subject,
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

}
?>
