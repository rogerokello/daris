<?php
    
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
    //$idsselectedbystudent1 = $idsselectedbystudent;
    
    echo $this->Form->create(false);
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Edit reports for a class</legend>

    <table>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('enterspecificstudents', array(
			      'type' => 'checkbox',
			      'label' => 'Change only specific reports, You may enter the students\' registration number(s) below (Separate registration numbers with commas)',
			      'div' => false
		    ));
		    if(isset($idsselectedbystudent)){
			echo $this->Form->input('registrationnumbers', array(
			    'rows' => '3',
			    'label' => false,
			    //'placeholder' => "Registration numbers of reports to Change separated by commas"
			    'value' => $idsselectedbystudent
			    )
			);
		    }else{
		    
			echo $this->Form->input('registrationnumbers', array(
			    'rows' => '3',
			    'label' => false,
			    'placeholder' => "Registration numbers of reports to Change separated by commas"
			    )
			);
		    
		    }
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('reportname', array(
			'label' => 'Report Name',
			'default' => $report_name
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
					'selected' => $reportclass,
					'readonly' => 'readonly'
					)); 
		    
	
		?>
	    </td>
	</tr>
	
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('term', array(
					'label' => 'Choose term',
					'options' => $terms,
					'selected' => $reportterm)); 
	
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		      echo $this->Form->input('subject', array(
					'label' => 'Edit Subject(s)',
					'options' => $olevelsubjects,
					'selected' => 'none',
					'multiple' => 'checkbox',
					'selected' => $subjects_considered					
					));
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		      echo $this->Form->input('examtoenter', array(
					'label' => 'Edit Examination(s)',
					'options' => $examname,
					'selected' => 'none',
					'multiple' => 'checkbox',
					'selected' => $exams_considered					
					));
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
					'selected' => $report_year
					));
					
		?>
	    </td>
	</tr>
    </table>
</fieldset> 

<?php
    echo $this->Form->end('Update Report(s)');
?>
