<?php
    
    $year_options = array(date('Y') => date('Y'));
    $year_range = range((date('Y') - 10),(date('Y') - 1));
    rsort($year_range); 
		    
    foreach ($year_range as $ayear){
	$year_options[$ayear] = $ayear;
    }
    $classes = array(
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
    );
    
    $titles = array(
	"Mr" => "Mr",
	"Mrs" => "Mrs",
	"Ms" => "Ms",    
    );
    echo $this->Form->create('Classteacher');
?>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">Edit Class teachers details</legend>
<table>
<tr class = "olevelresults">
  <td>
    <?php
      echo $this->Form->input('title', array('label' => 'Title',
					     'options' => $titles
      ));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
      echo $this->Form->input('names', array('label' => 'Names'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('class', array('label' => 'Class',
			'options' => $classes,
			//'selected' => '1'
	));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('stream', array('label' => 'Stream',
						'options' => $streams
	));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	echo $this->Form->input('year', array('label' => 'Year',
							'options' => $year_options,
							'selected' => date('Y')
						      ));
    ?>
  </td>
</tr>
</table>
<?php
 echo $this->Form->end('Update');
?>