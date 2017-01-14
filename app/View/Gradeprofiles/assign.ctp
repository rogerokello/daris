<?php
    echo $this->Form->create(false);
?>
<fieldset class="sectiondefinition1">
    <legend class="sectiondefinition">Assign Grade profile</legend>
    
    <?php
	$uploadOptions = array(
	    "" => "Select a value",
	);
	
	$uploadOptions = $uploadOptions + $gradeprofilesintheschool;
    ?>
    
    <table>
	<tr>
	    <th>Class</th>
	    <th>Grade profile</th>
	</tr>
	
	<?php
	    $i = 0;
	    foreach ($profileassignments as $key => $value):
	    $i++;
	?>
	<tr class = "olevelresults">
	    
	    <td>
		<?php
		    echo $this->Form->input('class'.$i, array('label' => false, 'value' => 'Senior '.$i, 'readonly' => 'readonly'));
		?>
	    </td>
	    <td>
		<?php
		    
		    if($value != null){
			$selected = $value;
		    }else{
			$selected = "";
		    }
		    
		    echo $this->Form->input('profile'.$i, array('label' => false,'options' => $uploadOptions,'selected' => $selected));
		    $this->Js->get('#profile'.$i)->event('focus', 
			$this->Js->request(array(
			    'controller'=>'gradeprofiles',
			    'action'=>'getprofiles'
			    ), array(
				  'update'=>'#profile'.$i,
				  'async' => true,
				  //'method' => 'post',
				  //'dataExpression'=>true,
				  //'data'=> $this->Js->serializeForm(array('isForm' => true,'inline' => true))
			      )
			 )
		    );
		    
		?>
	    </td>
	</tr>
	<?php endforeach; ?>
    </table>
</fieldset> 

<?php
    echo $this->Form->end('Assign');
?>
