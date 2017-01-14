<?php
    //print_r($data);
    $examname = $examsdoneintheschool;
    $olevelsubjects = $subjectsdoneintheschool;
    $classes = array(
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
    );
    $terms = array(
		   "ONE" => "Term One",
		   "TWO" => "Term Two",
		   "THREE" => "Term Three"
    );
    echo $this->Form->create(false);
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Create new reports for a class</legend>

    <table>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('reportname', array(
			'label' => 'Report Name'
			)
		    );
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('class', array(
					'label' => 'Choose Class',
					'options' => $classes,
					'selected' => 'none')); 
	
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('term', array(
					'label' => 'Choose term',
					'options' => $terms,
					'selected' => '1')); 
	
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		      echo $this->Form->input('subject', array(
					'label' => 'Choose Subject(s)',
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
					'label' => 'Choose Examination(s)',
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
    echo $this->Form->end('Create');
?>
