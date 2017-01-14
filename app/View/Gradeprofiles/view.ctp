<h1 class="sectiondefinition1">Grade profile view</h1>
    <?php
    //print_r($staffrecords);
    echo $this->Form->create('Gradeprofile');
    
    echo $this->Form->input('profilename', array('label' => 'Profile Name', 'readonly' => 'readonly'));
    ?>
<?php  
?>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Grading Marks and awards</legend>
<table>
<tr>
	<th>Lowest Value</th>
	<th>Highest Value</th>
	<th>Award</th>
</tr>
<?php
$j = 0;
foreach ( $staffrecords['Grading'] as $previousworkplace ){ 
?>
  <tr class = "olevelresults3">
    <td>
      <?php
	echo $this->Form->input('Grading.'.$j.'.id', array('type' => 'hidden'));
	echo $this->Form->input('Grading.'.$j.'.lowestvalue', array('label' => false,'rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Grading.'.$j.'.highestvalue', array('label' => false,'rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Grading.'.$j.'.award', array('label' => false,'rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
  </tr>
<?php
$j = $j + 1;
}
?>
</table>
</fieldset>


<?php

    echo $this->Form->end();

 
    ?>
<script type="text/javascript">
    var i = 1;
    var j = 1;
    $("#add-new-grade").click(function () {
        $(this).closest('tr').prev('tr').after('<tr class = "olevelresults2"><td><div class="input text"><input name="data[Grading]['+i+'][lowestvalue]" maxlength="10" type="text" id="Grading'+i+'lowestvalue"/></div></td><td><div class="input text"><input name="data[Grading]['+i+'][highestvalue]" maxlength="10" type="text" id="Grading'+i+'highestvalue"/></div></td><td><div class="input text"><input name="data[Grading]['+i+'][award]" maxlength="10" type="text" id="Grading'+i+'award"/></div></td><td><br/><br/><button id="remove-new-grade" type="button">remove</button></td></tr>');
        i++;
    });
    
    $(document).on('click', '#remove-new-grade', function () {
	$(this).closest('tr').remove();
    });
</script>