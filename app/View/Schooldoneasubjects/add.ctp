<?php
    $subjectgroups = array(
		   "1" => "Paper 1",
		   "2" => "Paper 2",
		   "3" => "Paper 3",
		   "4" => "Paper 4",
		   "5" => "Paper 5",
		   "6" => "Paper 6",
		   "7" => "Paper 7",
		   "8" => "Paper 8",
		   "9" => "Paper 9",		   
    );
    $selectedoptions1 = $selectedoptions;
    echo $this->Form->create('Schooldoneasubject');
?>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">New Subject Details</legend>
<table>
<tr class = "olevelresults">
  <td>
    <?php
      echo $this->Form->input('fullsubjectname', array('label' => 'Full Subject Name'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('shortsubjectname', array('label' => 'Short Subject Name (Must be a single word without any spaces)'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('subjectcode', array('label' => 'Subject Code'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('issubsidiary', array('label' => 'Subsidiary Subject'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('papersdone', array('label' => 'Choose papers',
						      'options' => $subjectgroups,
						      'selected' => $selectedoptions1,						      
						      'multiple' => 'checkbox',
						      'size' => 3
						      ));
    ?>
  </td>
</tr>
</table>
<?php
 echo $this->Form->end('Add Subject');
?>