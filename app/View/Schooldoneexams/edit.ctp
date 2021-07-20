<?php
    $terms = array(
		   "ONE" => "Term One",
		   "TWO" => "Term Two",
		   "THREE" => "Term Three"
    );
    
    $positions = array(0 => 0);
    
    $number_of_positions_to_choosefrom = 0;
    
    while($number_of_positions_to_choosefrom < $no_of_subjects_already_entered){
    
	array_push($positions,($number_of_positions_to_choosefrom+1));
	$number_of_positions_to_choosefrom++;
    }
    
    $positions = array_slice($positions,1,sizeof($positions),true);
    
    echo $this->Form->create('Schooldoneexam');
?>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">Edit Examination Details</legend>
<table>
<tr class = "olevelresults">
  <td>
    <?php
      echo $this->Form->input('fullexamname', array('label' => 'Full Examination Name'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('alias', array('label' => 'Short Examination Name (Will appear on the marksheet)'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('termdone', array(
					'label' => 'Term the Examination is done',
					'options' => $terms,
					'empty' => 'Choose a term')); 
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('reportorder', array(
						    'label' => 'The order of the exam on the report form',
						    'options' => $positions,
	
	));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('startdate', array('label' => 'Start date (First date students do the exam)','empty' => ' ',));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('enddate', 
			  array('label' => 'End date (last date students do the exam)','empty' => ' ',));
    ?>
  </td>
</tr>
</table>
<?php
 echo $this->Form->end('Edit Examination');
?>