<?php
    
    $streams = $student_streams;
    
    echo $this->Form->create(false);
?>

<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Download Class teacher comment file for Senior <?php echo $commentfile." Reports"; ?></legend>

    <table>
	
	<tr class = "olevelresults">
	    <td>
		<?php
		    echo $this->Form->input('term', array(
					'label' => 'Choose Stream for which you are a class teacher:',
					'options' => $streams,
					//'selected' => $reportterm
		    )); 
	
		?>
	    </td>
	</tr>
	
    </table>
</fieldset> 

<?php
    echo $this->Form->end('Comment file');
?>
