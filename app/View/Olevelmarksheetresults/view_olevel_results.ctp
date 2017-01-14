<?php
      
    $examname = $examsdoneintheschool;
    $olevelsubjects = $subjectsdoneintheschool;
    echo $this->Form->create(false);
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">View a single student's results</legend>

    <table>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('registrationNumber', array(
			'label' => 'Registration Number'
			)
		    );
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		      echo $this->Form->input('subject', array(
					'label' => 'Subject(s) to view',
					'options' => $olevelsubjects,
					'selected' => 'none',
					'multiple' => true,
					'size' => 3));
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		      echo $this->Form->input('examtoenter', array(
					'label' => 'Examination(s) to view',
					'options' => $examname,
					'selected' => 'none',
					'multiple' => true,
					'size' => 3)); 
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		    
		    $year_options = array(date('Y') => date('Y'));
		    $year_range = range((date('Y') - 10),(date('Y') - 1));
		    rsort($year_range); 
		    
		    foreach ($year_range as $ayear){
			$year_options[$ayear] = $ayear;
		    }

		    echo $this->Form->input('year', array(
					'label' => 'Year',
					'options' => $year_options,
					'selected' => date('Y')
					)); 
		?>
	    </td>
	</tr>
    </table>
</fieldset> 

<?php
    echo $this->Form->end('View');
?>
