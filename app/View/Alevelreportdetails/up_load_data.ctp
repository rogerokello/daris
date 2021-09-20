<?php
    echo $this->Form->create(false,array('type' => 'file'));
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Upload Advanced Level comment file</legend>
    
    <?php
	$uploadOptions = array(
	    "alevelstudentreports" => "Advanced level comments"
	);
    ?>
    
    <table>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('uploadData', array(
			'label' => 'Upload file for',
			'options' => $uploadOptions,
			'selected' => 'none')
		    );
		?>
	    </td>
	</tr>
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('uploadedfiles.',
						  array( 
						      'type' => 'file',
						      'label' => 'Choose file',
						      'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                  'multiple'
						  )
					    );
		?>
	    </td>
	</tr>
    </table>
</fieldset> 

<?php
    echo $this->Form->end('Upload data');
?>
