<?php
    echo $this->Form->create(false,array('type' => 'file'));
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Upload your data</legend>
    
    <?php
	$uploadOptions = array(
	    "alevelstudentresults" => "Advanced level results",
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
