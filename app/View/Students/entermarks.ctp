<!-- <h1 class="sectiondefinition1"></h1> -->
<?php
 print_r($one);
    ?>
    <?php
    echo $this->Form->create(false);
    ?><?php
    ?>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">Choose your entry method</legend><?php
    $classes = array(
		   "1" => "Senior One",
		   "2" => "Senior Two",
    );

    $streams = array(
		   "white" => "White",
		   "blue" => "Blue",
    );
    
    
    $olevelsubjects = array(
		   "eng" => "English Language",
		   "math" => "Mathematics",
		   "phy" => "Physics",
		   "chem" => "Chemistry",
		   "bio" => "Biology",
		   "hist" => "History",
		   "geog" => "Geography",
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

    $examname = array(
		   "midterm1" => "Mid Term I",
		   "endofterm1" => "End of Term I",
		   "midterm2" => "Mid Term II",
		   "endofterm2" => "End of Term II",
    );

    $currentclass = array(
		   "5" => "Senior Five",
		   "6" => "Senior Six",
    );

    $currentstream = array(
		   "Arts" => "Arts",
		   "Science" => "Science",
    );

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
		   "" => "",
		   "Finished a candidate class" => "Finished a candidate class",
		   "Not promoted to the next class and left" => "Not promoted to the next class and left",
		   "Fees Defaulter" => "Fees Defaulter",
		   "Expelled" => "Expelled",
		   "Just chose not to come back" => "Just chose not to come back",
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
    
    $optionsradio = array('singlestudent' => 'Single Student');
    $attributes = array('legend' => false, 'value' => 'allstudents');
    
//     ?>
<table>
<tr class = "olevelresults">
<td>
<?php
?>
<?php
   echo $this->Form->radio('criterea', $optionsradio, $attributes);
   $optionsradio = array('allstudents' => 'All students');
   echo $this->Form->input('registrationnumber', array('label' => 'Registration Number'));   
?>
<!-- </fieldset> -->
</td>
<td>
<!-- <fieldset class="sectiondefinition1"> -->
<?php
    echo $this->Form->radio('criterea', $optionsradio, $attributes);

?>
<table>
<tr class = "olevelresults">
<td>
<?php
    echo "Class " .$this->Form->checkbox('class');
    echo $this->Form->input('class', array(
					'label' => false,
					'options' => $classes,
					'selected' => 'none')); 
?>
</td>
<td>
<?php
    echo "Stream " .$this->Form->checkbox('stream');
    echo $this->Form->input('stream', array(
					'label' => false,
					'options' => $streams,
					'selected' => 'none')); 
?>
</td>
</tr>
</table>
</td>
<td>

</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('subject', array(
					'label' => 'Subject to enter',
					'options' => $olevelsubjects,
					'selected' => 'none'));
echo $this->Form->input('examtoenter', array(
					'label' => 'Examination to enter',
					'options' => $examname,
					'selected' => 'none')); 
?>
</td>
</tr>
</table>
</fieldset> 

<?php

    echo $this->Form->end('Start entry');
    ?>
