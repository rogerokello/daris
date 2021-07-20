<?php
    $subjectgroups = array(
		   "I" => "Group I - English Language",
		   "II" => "Group II - Humanities",
		   "III" => "Group III - Languages",
		   "IV" => "Group IV - Mathematics",
		   "V" => "Group V - Science Subjects",
		   "VI" => "Group VI - Cultural Subjects and Others",
		   "VII" => "Group VII - Technical Subjects",
		   "VIII" => "Group VIII - Business Studies",
    );
    echo $this->Form->create('Schooldonesubject');
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
	echo $this->Form->input('subjectgroup', array('label' => 'Subject Group',
						      'options' => $subjectgroups,
						      'selected' => 'none'
						      ));
    ?>
  </td>
</tr>
</table>
<?php
 echo $this->Form->end('Add Subject');
?>