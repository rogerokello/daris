<?php
  echo $this->Form->create('Student', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  
  
  echo $this->Form->input('searchQuery', array('label' => 'Search for Student (Use a Registration number, Surname or Other Names)','value' => h($searchQuery)));
  if($extrasearchison == 0){
  
      echo $this->Form->input('showextracriterea', array('label' => 'Show extra search criterea','type' => 'checkbox'));
      echo "<span id=\"extrasearchcriterea\" class=\"hide\">";
  
  }else{
  
      echo $this->Form->input('showextracriterea', array('label' => 'Show extra search criterea','type' => 'checkbox', 'checked'));
      echo "<span id=\"extrasearchcriterea\" class=\"\">";
  
  }
  ?>
  <fieldset class="sectiondefinition1" id ="StudentSearchfieldset_"><legend class="sectiondefinition1">Extra Search criterea</legend><?php
  if(($studentsnotpartofschool == 1)){
  
      echo $this->Form->input('studentnotpartofschool', array('label' => 'Search for students who are nolonger part of school(Old Boys and Old Girls)','type' => 'checkbox', 'checked' => 'checked'));
  
  }else {
  
      echo $this->Form->input('studentnotpartofschool', array('label' => 'Search for students who are nolonger part of school(Old Boys and Old Girls)','type' => 'checkbox'));
  
  }
  
  $currentstream = $streamsintheschool;
  //$currentstream[""] = "";
  $currentstream = array_merge(array("" => ""),$currentstream);
  $sexes = array(
		   "" => "",
		   "F" => "F",
		   "M" => "M",
    );
    
    $regilions = array(
		   "" => "",
		   "Pentecostal" => "Pentecostal",
		   "Protestant" => "Protestant",
		   "Catholic" => "Catholic",
		   "Moslem" => "Moslem",
    );
    
    $availabilitystatus = array(
		   "" => "",
		   "Present" => "Present",
		   "Absent" => "Absent",
    );
    
    $currentclass = array(
		   ""  => "",
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
		   "5" => "Senior Five",
		   "6" => "Senior Six",
    );?>
  <table>
      <tr class = "olevelresults">
      <td>
      <?php
	  echo $this->Form->input('currentclass', array(
					'label' => 'Choose class',
					'options' => $currentclass,
					'selected' => ''));     
      ?>
      </td>
      <td>
      <?php
	  echo $this->Form->input('currentstream', array(
					'label' => 'Choose stream',
					'options' => $currentstream,
					'selected' => ""));     
      ?>
      </td>
      <td>
      <?php
	  echo $this->Form->input('sex', array(
					'label' => 'Gender(sex)',
					'options' => $sexes,
					'selected' => ''));
      ?>
      </td>
      <td>
      <?php
	  echo $this->Form->input('availabilitystatus', array(
					'label' => 'Present/Absent',
					'options' => $availabilitystatus,
					'selected' => ''));
      
      ?>
      </td>
      <td>
      <?php
	echo $this->Form->input('joiningdate', array(
	    'label' => 'Year of Joining',
	    'dateFormat' => 'Y',
	    'maxYear' => date('Y'),
	    'minYear' => date('Y') - 100,
	    'empty' => ' ',
	));      
      ?>
      </td>
      <td>
      <?php
	echo $this->Form->input('leavingdate', array(
	    'label' => 'Year of leaving',
	    'dateFormat' => 'Y',
	    'maxYear' => date('Y'),
	    'minYear' => date('Y') - 100,
	    'empty' => ' ',
	));      
      ?>
      </td>
      </tr>
      <tr class = "olevelresults">
      <td>
      <?php
	  echo $this->Form->input('religion', array(
					'label' => 'Religion',
					'options' => $regilions,
					'selected' => ''));
      ?>
      </td>
      <td>
      </td>
      <td>
      </td>
      <td>
      </td>
      <td>
      </td>
      <td>
      </td>
      </tr>
  </table>
  <?php

	
	
  ?>
  
  </fieldset><?php
  echo "</span>";
  echo $this->Form->end(__('Search'));
?>
<h1 class="sectiondefinition1">Edit Student Details</h1>
<?php

    //$this->Js->get('#StudentPicturepath')->event('change', $this->Js->alert('heyyou!'));
?> <?php 
    //$lastnumberused = (string)$lastnumberused;
    //$currentyear = (string)$currentyear;
    //$picturenumber = $currentyear.$lastnumberused;
    echo "<br/>";
    $studentpicuture = $webcampic;
    if($studentpicuture != false){
	//echo $this->Html->image('studentpics/'.$studentpicuture.'.jpg', array('alt' => 'Student\'s Picture', 'id' => 'shayhowe'));
  $student_pic_url = $this->Html->url(array(
    "controller" => "students",
    "action" => "displayImage",
    $studentpicid
  ));
	echo '<img src="'.$student_pic_url.'" alt="Student\'s Picture" id="shayhowe"/>';
    }else{
	echo $this->Html->image('studentpics/person.png', array('alt' => 'Student\'s Picture', 'id' => 'shayhowe'));
    }
   ?>
   
    <div id="shayhowe1"></div>
    <span id="takeaphoto">Turn on camera and take photo</span>
   
   <?php

    echo $this->Form->create('Student', array('type' => 'file'));
    ?><table><tr><td><?php

    //echo $this->Html->link('Upload your picture file', array('controller' => '','action' => ''));
    echo $this->Form->input('Student.picturepath', array('between' => '<br />', 'type' => 'file', 'label' => 'Attach a new picture','accept' =>'image/*'));
    ?>
    </td>
    </tr></table>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">Biographical/Personal information</legend><?php


    $sexes = array(
		   "F" => "F",
		   "M" => "M",
    );
    $olevelsubjects = array(
		   "eng" => "ENG",
		   "math" => "MATH",
		   "phy" => "PHY",
		   "chem" => "CHEM",
		   "bio" => "BIO",
		   "hist" => "HIST",
		   "geog" => "GEOG",
		   "cre" => "CRE",
    );
    $nationality = array(
		   "Ug" => "Uganda",
		   "S.Sud" => "South Sudan",
		   "Ky" => "Kenya",
		   "Tz" => "Tanzania",
		   "Rwd" => "Rwanda",
		   "Brd" => "Burundi",
		   "Cng" => "Congo",
		   "CAR" => "Central African Republic",
		   "Smla" => "Somalia",
		   "Ethio" => "Ethiopia",
		   "Erit" => "Eritrea",
    );

    $regilions = array(
		   "Pentecostal" => "Pentecostal",
		   "Protestant" => "Protestant",
		   "Catholic" => "Catholic",
		   "Moslem" => "Moslem",
    );

    $currentclass = array(
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
		   "5" => "Senior Five",
		   "6" => "Senior Six",
    );

    $currentstream = array(
		   "White" => "White",
		   "Blue" => "Blue",
		   "Arts" => "Arts",
		   "Science" => "Science",
    );

    $currentstream = $streamsintheschool;
    
    $availabilitystatus = array(
		   "Present" => "Present",
		   "Absent" => "Absent",
    );

    $studentrating = array(
		  "High Achiever" => "High Achiever",
		  "Middle Achiever" => "Middle Achiever",
		  "Low Achiever" => "Low Achiever",
    );

    $leavingreasons = array(
		   "None" => "None - still a student with the school",
		   "Finished a candidate class" => "Finished a candidate class",
		   "Not promoted to the next class and left" => "Not promoted to the next class and left",
		   "Fees Defaulter" => "Fees Defaulter",
		   "Expelled" => "Expelled",
		   "Just chose not to come back" => "Just chose not to come back",
		   "Reason not known" => "Unknown reason"
    );
    
    $subjectofolevel = array(
		   "English Language" => "ENG",
		   "Mathematics" => "MATH",
		   "Biology" => "BIOS",
		   "Chemistry" => "CHEM",
		   "Physics" => "PHY",
		   "History" => "HIST",
		   "Geography" => "GEOG",
		   "Christian Religious Education" => "CRE",
		   "Commerce" => "COMM",
		   "Entreprenuership Education" => "ENTRE",
		   "Computer Studies" => "COMP",
		   "Fine Art" => "F/AT",
		   "Literature In English" => "LIT",
		   "Principles And Practices of Agriculture" => "AGRIC",
    );
//     ?>
<table>
<tr class = "olevelresults">
<td>
<?php

   echo $this->Form->input('registrationnumber', array('label' => 'Registration Number', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('surname', array('label' => 'Surname'));
?>
</td>
<td>
<?php
    echo $this->Form->input('othernames', array('label' => 'Other Names'));
?>
</td>
<td>
<?php
     echo $this->Form->input('availabilitystatus', array(
					'label' => 'Student Present?',
					'options' => $availabilitystatus,
					));   
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('sex', array(
					'label' => 'Sex',
					'options' => $sexes,
					)); 
?>
</td>
<td>
<?php    echo $this->Form->input('nationality', array(
					'label' => 'Country of origin',
					'options' => $nationality,
					));
?>
</td>
<td>
<?php echo $this->Form->input('religion', array(
					'label' => 'Religion',
					'options' => $regilions,
					)); 
?>
</td>
<td>
<?php echo $this->Form->input('birthdate', array(
	'label' => 'Birth Date',
	'dateFormat' => 'DMY',
	'maxYear' => date('Y') - 10,
	'minYear' => date('Y') - 100,
    ));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
 echo $this->Form->input('currentclass', array(
					'label' => 'Current Class',
					'options' => $currentclass,
					));
?>
</td>
<td>
<?php  echo $this->Form->input('currentstream', array(
					'label' => 'Current Stream',
					'options' => $currentstream,
					)); 
?>
</td>
<td>
<?php
     echo $this->Form->input('studentrating', array(
					'label' => 'Student Rating',
					'options' => $studentrating,
					));   
?>
</td>
<td>
<?php
 echo $this->Form->input('joiningdate', array(
	'label' => 'Date of Joining(Admission)',
	'dateFormat' => 'DMY',
	'maxMonth' => date('M'),
	'maxYear' => date('Y'),
	'minYear' => date('Y') - 100,
    )); 
?>
</td>
</tr>
</table>
</fieldset> 
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Home address information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('village', array('label' => 'Village'));
?>
</td>
<td>
<?php
echo $this->Form->input('parish', array('label' => 'Parish'));
?>
</td>
<td>
<?php
echo $this->Form->input('subcounty', array('label' => 'Sub county'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('county', array('label' => 'County'));
?>
</td>
<td>
<?php
echo $this->Form->input('district', array('label' => 'District'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php

?>
</td>
<td>
<?php
//echo $this->Form->input('county', array('label' => 'County'));
?>
</td>
</tr>
</table>
<?php  
?>
</fieldset>

<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Parent/Guardian Information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('mothername', array('label' => 'Mother\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('mothertelcontact', array('label' => 'Mother\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('mothercurrentresidence', array('label' => 'Mother\'s current residence'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('fathername', array('label' => 'Father\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('fathertelcontact', array('label' => 'Father\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('fathercurrentresidence', array('label' => 'Father\'s current residence'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('guardianname', array('label' => 'Guardian\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('guardiantelcontact', array('label' => 'Guardian\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('guardiancurrentresidence', array('label' => 'Guardian\'s current residence'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('nearestrelativename', array('label' => 'Nearest relative\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('nearestrelativetelcontact', array('label' => 'Nearest relative\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('nearestrelativecurrentresidence', array('label' => 'Nearest relative\'s current residence'));
?>
</td>
</tr>
</table>

</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Primary Leaving Examination Results</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Pleresult.english', array('label' => 'English'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.mathematics', array('label' => 'Mathematics'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.sst', array('label' => 'Social Studies'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.science', array('label' => 'Science'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.aggregate', array('label' => 'Aggregates'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.grade', array('label' => 'Grade'));
?>
</td>
</tr>
</table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Uganda Certificate of Education(UCE) Results</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Uceresult.subject1name', array('label' => false,'options' => $subjectofolevel,'selected' => 'English Language')); 
echo $this->Form->input('Uceresult.subject1mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject2name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Mathematics')); 
echo $this->Form->input('Uceresult.subject2mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject3name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Physics')); 
echo $this->Form->input('Uceresult.subject3mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject4name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Geography')); 
echo $this->Form->input('Uceresult.subject4mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject5name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Chemistry')); 
echo $this->Form->input('Uceresult.subject5mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject6name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Biology')); 
echo $this->Form->input('Uceresult.subject6mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject7name', array('label' => false,'options' => $subjectofolevel,'selected' => 'History')); 
echo $this->Form->input('Uceresult.subject7mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject8name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Commerce')); 
echo $this->Form->input('Uceresult.subject8mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject9name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Principles And Practices of Agriculture')); 
echo $this->Form->input('Uceresult.subject9mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject10name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Fine Art')); 
echo $this->Form->input('Uceresult.subject10mark', array('label' => false));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Uceresult.aggregate', array('label' => 'AGG'));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.division', array('label' => 'DIV'));
?>
</td>
</tr>
</table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Previous School information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('pleprimaryschoolname', array('label' => 'Name of PLE primary school'));
?>
</td>
<td>
<?php echo $this->Form->input('pleindexnumber', array('label' => 'Index number at PLE')); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
 echo $this->Form->input('plesittingyear', array(	'label' => 'Year of sitting PLE',
	'dateFormat' => 'Y',
	'maxYear' => date('Y') - 1,
	'minYear' => date('Y') - 50,)); 
?>
</td>
<td>
<?php 
echo $this->Form->input('previousschoolzlastclassposition', array('label' => 'Class position in last examination done'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('lastpreviousschoolzname', array('label' => 'Name of previous secondary school (Fill if applicable)')); 
?>
</td>
<td>
<?php 
echo $this->Form->input('lastpreviousschoolzdistrictname', array('label' => 'District of previous secondary school (Fill if applicable)')); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('lastpreviousschooltransreas', array('rows' => '3', 'label' => 'Reason(s) for transfer from last previous school'));
?>
</td>
<td>
<?php 
echo $this->Form->input('previousschoolresponsibility', array('rows' => '3', 'label' => 'Responsibility in previous school(s)')); 
?>
</td>
</tr>
</table>
<?php



?>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Health/Games/Sports Information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('sicknesses', array('rows' => '3', 'label' => 'Medical Conditions that need special attention'));
?>
</td>
<td>
<?php 
echo $this->Form->input('bestgamesorsportsorclubsorextracuriactiv', array('rows' => '3', 'label' => 'Best Games/Sports/Extracurricular activity'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('hobbies', array('rows' => '3', 'label' => 'Hobbies'));
?>
</td>
</tr>
</table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Departure Information(Choose only if student has left the school)</legend>
<table><tr class = "olevelresults"><td><?php  echo $this->Form->input('leavingdate', array(
	'label' => 'Date of Leaving in the format (Day-Month-Year)',
	'dateFormat' => 'DMY',
	'maxYear' => date('Y'),
	'minYear' => date('Y') - 100,
	'empty' => ' ',
    )); ?></td><td><?php
    echo $this->Form->input('leavingreason', array(
					'label' => 'Reason for leaving',
					'options' => $leavingreasons,
					/*'empty' => 'None'*/)); ?></td></tr></table>
</fieldset>
<?php

    //echo $this->Form->create('Student');
    echo $this->Form->hidden('picturenumber', array('default' => $studentpicuture));
    echo $this->Form->hidden('fullnames', array('default' => ""));
    echo $this->Form->hidden('studenthaspic', array('default' => ""));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->hidden('picture');
    echo $this->Form->end('Update');
?>

    <script>
   
	
	    //$("#StudentShowextracriterea_").click(function(e) {
	    $("#StudentShowextracriterea").change(function(e) {
		if(document.getElementById('StudentShowextracriterea').checked == true){
		
		    
		    document.getElementById("extrasearchcriterea").classList.remove('hide');
		
		}else{
		
		    
		    document.getElementById("extrasearchcriterea").classList.add("hide");
		
		}
	    });
 
    
    </script>