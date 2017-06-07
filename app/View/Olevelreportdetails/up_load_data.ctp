<?php
    echo $this->Form->create(false,array('type' => 'file'));
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Upload a comment file</legend>
    
    <?php
	$uploadOptions = array(
	    "olevelstudentreports" => "Ordinary level comments",
	    "alevelstudentreports" => "Advanced level comments",
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
		    echo $this->Form->input('uploadedfile',
						  array( 
						      'type' => 'file',
						      'label' => 'Choose file',
						      'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
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
