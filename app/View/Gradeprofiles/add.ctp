<h1 class="sectiondefinition1">New Grade profile</h1>
    <?php
    
    //$olevelsubjects = $subjectsdoneintheschool;
    $markswards = array(
		   ""  => "",
		   "1" => "D1",
		   "2" => "D2",
		   "3" => "C3",
		   "4" => "C4",
		   "5" => "C5",
		   "6" => "C6",
		   "7" => "P7",
		   "8" => "P8",
		   "9" => "F9"
		);
		
    $divisionwards = array(
		   ""  => "",
		   "I" => "I",
		   "II" => "II",
		   "III" => "III",
		   "IV" => "IV"
		);
		
    $pointawards = array(
		   ""  => "",
		   "A" => "A",
		   "B" => "B",
		   "C" => "C",
		   "D" => "D",
		   "E" => "E",
		   "O" => "O",
		   "F" => "F"
		);
    echo $this->Form->create('Gradeprofile');
    
    echo $this->Form->input('profilename', array('label' => 'Profile Name'));
    ?>
<?php  
?>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Grading Marks and awards</legend>
<table>
<tr>
	<th>Lowest Value</th>
	<th>Highest Value</th>
	<th>Grade</th>
	<th>Remarks</th>
	<!-- <th>Action</th> -->
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.0.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.0.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.0.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.0.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.1.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.1.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.1.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.1.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.2.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.2.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.2.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.2.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.3.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.3.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.3.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.3.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.4.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.4.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.4.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.4.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.5.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.5.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.5.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.5.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.6.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.6.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.6.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.6.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.7.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.7.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.7.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.7.remarks', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Grading.8.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.8.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Grading.8.award', array('label' => false,'options' => $markswards)); ?></td>
	<td><?php echo $this->Form->input('Grading.8.remarks', array('label' => false)); ?></td>
</tr>
<!-- <tr class = "olevelresults">
<td>
<button id="add-new-grade" type="button">Add New</button>
</td>
</tr> -->
</table>
</fieldset>
<?php
   $attributes = array('legend' => false, 'value' => 'ordinarylevel');
   $optionsradio = array('ordinarylevel' => 'Profile uses Ordinary - level grading');
   echo $this->Form->radio('Gradeprofileusesetting.criterea', $optionsradio, $attributes);
?>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Ordinary Level Division Awards</legend>
<?php
 echo $this->Form->checkbox('Ordinaryleveldivisionawardsetting.gradeusingtotalmark')." Get the class and stream position using the total mark"."<br/>";
?>
<table>
<tr>
	<th>Lowest Value</th>
	<th>Highest Value</th>
	<th>Division</th>
	<!-- <th>Action</th> -->
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.0.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.0.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.0.award', array('label' => false,'options' => $divisionwards)); ?></td>
	<!-- <td></td> -->
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.1.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.1.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.1.award', array('label' => false,'options' => $divisionwards)); ?></td>
	<!-- <td></td> -->
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.2.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.2.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.2.award', array('label' => false,'options' => $divisionwards)); ?></td>
	<!-- <td></td> -->
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.3.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.3.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Ordinaryleveldivisionaward.3.award', array('label' => false,'options' => $divisionwards)); ?></td>
	<!-- <td></td> -->
</tr>
<!--
<tr class = "olevelresults">
<td>
<button id="add-new-division" type="button">Add New</button>
</td>
</tr>
-->
</table>
<?php
 echo $this->Form->checkbox('Ordinaryleveldivisionawardsetting.getbestsubjects')." Get aggregates for best ".$this->Form->input('Ordinaryleveldivisionawardsetting.nobestsubjectstoget', array('label' => false,'maxlength' => '1','div' => false))." subjects (Minimum mandatory number of subjects)<br/>";
 echo $this->Form->checkbox('Ordinaryleveldivisionawardsetting.captodiv2forpassineng')." Automatically cap to Div II for P8 & P7 in English"."<br/>";
 echo $this->Form->checkbox('Ordinaryleveldivisionawardsetting.captodiv2forF9inmaths')." Automatically cap to Div II for F9 in Mathematics"."<br/>";
 echo $this->Form->checkbox('Ordinaryleveldivisionawardsetting.captodiv3forF9inenglish')." Automatically cap to Div III for F9 in English"."<br/>";
 echo $this->Form->checkbox('Ordinaryleveldivisionawardsetting.shifttodiv7forlessthanbestnumberofsubjects')." Automatically shift to Div VII for less than mandatory number of subjects"."<br/>";
 
?>
</fieldset>
<?php
   $attributes = array('legend' => false, 'value' => 'ordinarylevel');
   $optionsradio = array('advancedlevel' => 'Profile uses Advanced - level grading');
   echo $this->Form->radio('Gradeprofileusesetting.criterea', $optionsradio, $attributes);
?>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Advanced Level Point's grading</legend>
<table>
<tr>
	<th>Lowest Value</th>
	<th>Highest Value</th>
	<th>Award</th>
	<th>Award weight</th>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.0.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.0.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.0.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.0.weight', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.1.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.1.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.1.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.1.weight', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.2.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.2.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.2.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.2.weight', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.3.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.3.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.3.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.3.weight', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.4.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.4.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.4.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.4.weight', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.5.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.5.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.5.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.5.weight', array('label' => false)); ?></td>
</tr>
<tr class = "olevelresults2">
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.6.lowestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.6.highestvalue', array('label' => false)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.6.award', array('label' => false,'options' => $pointawards)); ?></td>
	<td><?php echo $this->Form->input('Advancedlevelpointsaward.6.weight', array('label' => false)); ?></td>
</tr>
<!-- <tr class = "olevelresults">
<td>
<button id="add-new-pointgrading" type="button">Add New</button>
</td>
</tr> -->
</table>
<?php
 echo $this->Form->checkbox('Advancedlevelpointsawardsetting.captoOforF9inanypaper')." Automatically award O for F9 in any paper"."<br/>";
?>
</fieldset>
<?php

    echo $this->Form->end('Save Details');

 
    ?>
<script type="text/javascript">
    var i = 1;
    var j = 1;
    $("#add-new-grade").click(function () {
        $(this).closest('tr').prev('tr').after('<tr class = "olevelresults2"><td><div class="input text"><input name="data[Grading]['+i+'][lowestvalue]" maxlength="3" type="number" id="Grading'+i+'lowestvalue"/></div></td><td><div class="input text"><input name="data[Grading]['+i+'][highestvalue]" maxlength="3" type="number" id="Grading'+i+'highestvalue"/></div></td><td><div class="input select"><select name="data[Grading]['+i+'][award]" id="Grading'+i+'award"><option value=""  selected="selected">Select</option><option value="1">D1</option><option value="2">D2</option><option value="3">C3</option><option value="4">C4</option><option value="5">C5</option><option value="6">C6</option><option value="7">P7</option><option value="8">P8</option><option value="9">F9</option></select></div></div></td><td><br/><br/><button id="remove-new-grade" type="button">remove</button></td></tr>');
        i++;
    });
    
    $(document).on('click', '#remove-new-grade', function () {
	$(this).closest('tr').remove();
    });
</script>
<script type="text/javascript">
    var i = 1;
    var j = 1;
    $("#add-new-division").click(function () {
        $(this).closest('tr').prev('tr').after('<tr class = "olevelresults2"><td><div class="input text"><input name="data[Ordinaryleveldivisionaward]['+i+'][lowestvalue]" maxlength="3" type="number" id="Ordinaryleveldivisionaward'+i+'lowestvalue"/></div></td><td><div class="input text"><input name="data[Ordinaryleveldivisionaward]['+i+'][highestvalue]" maxlength="3" type="number" id="Ordinaryleveldivisionaward'+i+'highestvalue"/></div></td><td><div class="input select"><select name="data[Ordinaryleveldivisionaward]['+i+'][award]" id="Ordinaryleveldivisionaward'+i+'award"><option value=""  selected="selected">Select</option><option value="I">Division I</option><option value="II">Division II</option><option value="III">Division III</option><option value="IV">Division IV</option></select></div></td><td><br/><br/><button id="remove-new-division" type="button">remove</button></td></tr>');
        i++;
    });
    
    $(document).on('click', '#remove-new-division', function () {
	$(this).closest('tr').remove();
    });
</script>
<script type="text/javascript">
    var i = 1;
    var j = 1;
    $("#add-new-pointgrading").click(function () {
        $(this).closest('tr').prev('tr').after('<tr class = "olevelresults2"><td><div class="input text"><input name="data[Advancedlevelpointsaward]['+i+'][lowestvalue]" maxlength="3" type="number" id="Advancedlevelpointsaward'+i+'lowestvalue"/></div></td><td><div class="input text"><input name="data[Advancedlevelpointsaward]['+i+'][highestvalue]" maxlength="3" type="number" id="Advancedlevelpointsaward'+i+'highestvalue"/></div></td><td><div class="input select"><select name="data[Advancedlevelpointsaward]['+i+'][award]" id="Advancedlevelpointsaward'+i+'award"><option value=""  selected="selected">Select</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="O">O</option><option value="F">F</option></select></div></td><td><br/><br/><button id="remove-new-pointgrading" type="button">remove</button></td></tr>');
        i++;
    });
    
    $(document).on('click', '#remove-new-pointgrading', function () {
	$(this).closest('tr').remove();
    });
</script>