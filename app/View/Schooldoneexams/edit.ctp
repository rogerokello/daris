<?php
    $terms = array(
		   "ONE" => "Term One",
		   "TWO" => "Term Two",
		   "THREE" => "Term Three"
    );
    
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
	echo $this->Form->input('startdate', array('label' => 'Start date (For the entry of Examinations into the system)','empty' => ' ',));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('enddate', 
			  array('label' => 'End date (For the entry of Examinations into the system)','empty' => ' ',));
    ?>
  </td>
</tr>
</table>
<?php
 echo $this->Form->end('Edit Examination');
?>