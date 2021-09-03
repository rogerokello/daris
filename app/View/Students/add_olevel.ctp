<?php
  
?>
<!-- <div id="newmessage"></div> -->
<div id="flashMessage"></div>
<h1 class="sectiondefinition1">New Ordinary-level Student</h1>
 <?php 
    $lastnumberused = (string)$lastnumberused;
    $currentyear = (string)$currentyear;
    $picturenumber = $currentyear.$lastnumberused;
    //echo "<br/>";
    echo $this->Html->image('studentpics/person.png', array('alt' => 'Student Picture', 'id' => 'shayhowe'));
 ?>
    <div id="shayhowe1"></div>
    <span id="takeaphoto">Turn on camera and take photo</span>
    <?php
    echo $this->Form->create('Student', array('type' => 'file'));
    ?><table><tr><td><?php
    
    //echo $this->Html->link('Upload your picture file', array('controller' => '','action' => ''));
    echo $this->Form->input('Student.picturepath', array('between' => '<br />', 'type' => 'file', 'label' => 'Attach your picture(A jpeg of not more than 200 Kilobytes)', 'accept' =>'image/*'));
    ?>
    </td>
    <td>
    <?php
    echo $this->Form->checkbox('multiple')."Enter multiple records for the same class and stream continously"."<br/>";
    ?>
    <!--
	<?php   echo $this->Html->link(
		    '<< Previous ',
		     array('action' => '')
		     );?>
		     |
      <?php   echo $this->Html->link(
		    ' Next >>',
		     array('action' => '')
		     );
	?>
    -->
    </td>
    </tr></table>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">Biographical/Personal information</legend><?php
    echo $this->Form->hidden('picturenumber', array('default' => $picturenumber));
    echo $this->Form->hidden('fullnames', array('default' => ""));
    echo $this->Form->hidden('studenthaspic', array('default' => ""));
    if ($this->Form->isFieldError('picturenumber')){
	echo $this->Form->error('gender');
    }

    $sexes = array(
		   "F" => "F",
		   "M" => "M",
    );
    $olevelsubjects = array(
		   "eng" => "ENG",
		   "math" => "MATH",
		   "phy" => "PHY",
		   "chem" => "CHEM",
		   "bio" => "BIO",
		   "hist" => "HIST",
		   "geog" => "GEOG",
		   "cre" => "CRE",
    );
    

    $nationality = array(
		   "Ug" => "Uganda",
		   "S.Sud" => "South Sudan",
		   "Ky" => "Kenya",
		   "Tz" => "Tanzania",
		   "Rwd" => "Rwanda",
		   "Brd" => "Burundi",
		   "Cng" => "Congo",
		   "CAR" => "Central African Republic",
		   "Smla" => "Somalia",
		   "Ethio" => "Ethiopia",
		   "Erit" => "Eritrea",
    );
    
    $regilions = array(
		   "Pentecostal" => "Pentecostal",
		   "Protestant" => "Protestant",
		   "Catholic" => "Catholic",
		   "Moslem" => "Moslem",
    );

    $currentclass = array(
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
    );

    $currentstream = $streamsintheschool;

    $availabilitystatus = array(
		   "Present" => "Present",
		   "Absent" => "Absent",
    );

    $studentrating = array(
		  "High Achiever" => "High Achiever",
		  "Middle Achiever" => "Middle Achiever",
		  "Low Achiever" => "Low Achiever",
    );

    $leavingreasons = array(
		   "None" => "None - still a student with the school",
		   "Finished a candidate class" => "Finished a candidate class",
		   "Not promoted to the next class and left" => "Not promoted to the next class and left",
		   "Fees Defaulter" => "Fees Defaulter",
		   "Expelled" => "Expelled",
		   "Just chose not to come back" => "Just chose not to come back",
		   "Reason not known" => "Unknown reason"
    );

//     ?>
<table>
<tr class = "olevelresults">
<td>
<?php

   echo $this->Form->input('registrationnumber', array('label' => 'Registration Number','readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('surname', array('label' => 'Surname'));
?>
</td>
<td>
<?php
    echo $this->Form->input('othernames', array('label' => 'Other Names'));
?>
</td>
<td>
<?php
     echo $this->Form->input('availabilitystatus', array(
					'label' => 'Student Present?',
					'options' => $availabilitystatus,
					'selected' => 'Present'));   
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('sex', array(
					'label' => 'Sex',
					'options' => $sexes,
					'selected' => 'none')); 
?>
</td>
<td>
<?php    echo $this->Form->input('nationality', array(
					'label' => 'Country of origin',
					'options' => $nationality,
					'selected' => 'Uganda'));
?>
</td>
<td>
<?php echo $this->Form->input('religion', array(
					'label' => 'Religion',
					'options' => $regilions,
					'selected' => 'none')); 
?>
</td>
<td>
<?php echo $this->Form->input('birthdate', array(
	'label' => 'Birth Date',
	'dateFormat' => 'DMY',
	'maxYear' => date('Y') - 10,
	'minYear' => date('Y') - 100,
    ));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
 echo $this->Form->input('currentclass', array(
					'label' => 'Current Class',
					'options' => $currentclass,
					'selected' => '1'));
?>
</td>
<td>
<?php  echo $this->Form->input('currentstream', array(
					'label' => 'Current Stream',
					'options' => $currentstream,
					'selected' => 'white')); 
?>
</td>
<td>
<?php
     echo $this->Form->input('studentrating', array(
					'label' => 'Student Rating',
					'options' => $studentrating,
					'selected' => 'Middle Achiever'));   
?>
</td>
<td>
<?php
 echo $this->Form->input('joiningdate', array(
	'label' => 'Date of Joining(Admission)',
	'dateFormat' => 'DMY',
	'maxMonth' => date('M'),
	'maxYear' => date('Y'),
	'minYear' => date('Y') - 100,
    )); 
?>
</td>
</tr>
</table>
</fieldset> 
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Home address information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('village', array('label' => 'Village'));
?>
</td>
<td>
<?php
echo $this->Form->input('parish', array('label' => 'Parish'));
?>
</td>
<td>
<?php
echo $this->Form->input('subcounty', array('label' => 'Sub county'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('county', array('label' => 'County'));
?>
</td>
<td>
<?php
echo $this->Form->input('district', array('label' => 'District'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php

?>
</td>
<td>
<?php
//echo $this->Form->input('county', array('label' => 'County'));
?>
</td>
</tr>
</table>
<?php  
?>
</fieldset>

<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Parent/Guardian Information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('mothername', array('label' => 'Mother\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('mothertelcontact', array('label' => 'Mother\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('mothercurrentresidence', array('label' => 'Mother\'s current residence'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('fathername', array('label' => 'Father\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('fathertelcontact', array('label' => 'Father\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('fathercurrentresidence', array('label' => 'Father\'s current residence'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('guardianname', array('label' => 'Guardian\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('guardiantelcontact', array('label' => 'Guardian\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('guardiancurrentresidence', array('label' => 'Guardian\'s current residence'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('nearestrelativename', array('label' => 'Nearest relative\'s name(s)'));
?>
</td>
<td>
<?php
echo $this->Form->input('nearestrelativetelcontact', array('label' => 'Nearest relative\'s telephone contact'));
?>
</td>
<td>
<?php
echo $this->Form->input('nearestrelativecurrentresidence', array('label' => 'Nearest relative\'s current residence'));
?>
</td>
</tr>
</table>

</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Primary Leaving Examination Results</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Pleresult.english', array('label' => 'English'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.mathematics', array('label' => 'Mathematics'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.sst', array('label' => 'Social Studies'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.science', array('label' => 'Science'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.aggregate', array('label' => 'Aggregates'));
?>
</td>
<td>
<?php
echo $this->Form->input('Pleresult.grade', array('label' => 'Grade'));
?>
</td>
</tr>
</table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Previous School information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('pleprimaryschoolname', array('label' => 'Name of PLE primary school'));
?>
</td>
<td>
<?php echo $this->Form->input('pleindexnumber', array('label' => 'Index number at PLE')); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
 echo $this->Form->input('plesittingyear', array(	'label' => 'Year of sitting PLE',
	'dateFormat' => 'Y',
	'maxYear' => date('Y') - 1,
	'minYear' => date('Y') - 50,)); 
?>
</td>
<td>
<?php 
echo $this->Form->input('previousschoolzlastclassposition', array('label' => 'Class position in last examination done'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('lastpreviousschoolzname', array('label' => 'Name of previous secondary school (Fill if applicable)')); 
?>
</td>
<td>
<?php 
echo $this->Form->input('lastpreviousschoolzdistrictname', array('label' => 'District of previous secondary school (Fill if applicable)')); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('lastpreviousschooltransreas', array('rows' => '3', 'label' => 'Reason(s) for transfer from last previous school'));
?>
</td>
<td>
<?php 
echo $this->Form->input('previousschoolresponsibility', array('rows' => '3', 'label' => 'Responsibility in previous school(s)')); 
?>
</td>
</tr>
</table>
<?php



?>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Health/Games/Sports Information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('sicknesses', array('rows' => '3', 'label' => 'Medical Conditions that need special attention'));
?>
</td>
<td>
<?php 
echo $this->Form->input('bestgamesorsportsorclubsorextracuriactiv', array('rows' => '3', 'label' => 'Best Games/Sports/Extracurricular activity'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php 
echo $this->Form->input('hobbies', array('rows' => '3', 'label' => 'Hobbies'));
?>
</td>
</tr>
</table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Departure Information(Choose only if student has left the school)</legend>
<table><tr class = "olevelresults"><td><?php  echo $this->Form->input('leavingdate', array(
	'label' => 'Date of Leaving in the format (Day-Month-Year)',
	'dateFormat' => 'DMY',
	'maxYear' => date('Y'),
	'minYear' => date('Y') - 100,
	'empty' => ' ',
    )); ?></td><td><?php
    echo $this->Form->input('leavingreason', array(
					'label' => 'Reason for leaving',
					'options' => $leavingreasons,
					/*'empty' => 'None'*/)); ?></td></tr></table>
</fieldset>
<script>
function getnextregistrationnumber(){
    $.ajax({
      type:"POST",
      datatype:'json',
      cache: false,
      data: {"currentclass":$("#StudentCurrentclass").val()},
      url:"get_the_registrationnumber",
      //update:"#StudentRegistrationnumber"
      success: function(data){
	  document.getElementById('StudentRegistrationnumber').value = data;
	  //$("#StudentRegistrationnumber").removeAttr("readonly");
      },
      error: function(){
	alert("Failed to get a registration number");
      }
    });
}
$(function() {
  $('#StudentCurrentclass').change(function() {
    //var a = $("#StudentCurrentclass").val ;
    var one = document.getElementById('StudentCurrentclass').value;
    $.ajax({
      type:"POST",
      datatype:'json',
      cache: false,
      data: {"currentclass":one/*$("#StudentCurrentclass").val()*/},
      url:"get_the_registrationnumber",
      //update:"#StudentRegistrationnumber"
      success: function(data){
	  document.getElementById('StudentRegistrationnumber').value = data;
	  //$("#StudentRegistrationnumber").removeAttr("readonly");
      }
    });
    //getnextregistrationnumber();
  });
});

$(function() {
  $('#StudentSurname').change(function() {
    //var a = $("#StudentCurrentclass").val ;
    if(document.getElementById('StudentRegistrationnumber').value == ""){
	var one = document.getElementById('StudentCurrentclass').value;
	$.ajax({
	  type:"POST",
	  datatype:'json',
	  cache: false,
	  data: {"currentclass":one/*$("#StudentCurrentclass").val()*/},
	  url:"get_the_registrationnumber",
	  //update:"#StudentRegistrationnumber"
	  success: function(data){
	      document.getElementById('StudentRegistrationnumber').value = data;
	      //$("#StudentRegistrationnumber").removeAttr("readonly");
	  }
	});
	//getnextregistrationnumber();
    }else{
    
	
    
    }
  });
});

$(function() {
  $('body').on('submit','#StudentAddOlevelForm',function(e) {
  if($("#StudentMultiple").prop('checked')){
    $("#StudentRegistrationnumber").removeAttr("readonly");
    var formData = $(this).serialize();
    //$("#newmessage").html("Success");
    var a = $("#StudentRegistrationnumber").val();
    var studentsurname = $("#StudentSurname").val();
    var studentothernames = $("#StudentOthernames").val();
    var selectedclass = $("#StudentCurrentclass").val();
    var selectedstream = $("#StudentCurrentstream").val();
    e.preventDefault();
    $.ajax({
      type:"POST",
      datatype:'json',
      cache: false,
      async: true,
      data: formData,
      url:"add_olevel",
      //update:"#StudentRegistrationnumber"
      success: function(data){
	//document.getElementById('newmessage').value = data;
	$("#StudentRegistrationnumber").attr("readonly", "readonly");
	$("#flashMessage").addClass("message"); 
	$("#flashMessage").html("Added "+studentsurname+" "+studentothernames+ " ,"+"registration number:"+a);
	//$("#StudentAddOlevelForm")[0].reset();
	document.getElementById('StudentAddOlevelForm').reset();
	$("#shayhowe").attr("src","\/daris\/img\/studentpics\/person.png");
	$("#StudentPicture").removeAttr("value");
	$("#StudentMultiple").attr("checked",true);
	$("#StudentCurrentclass option[value="+selectedclass+"]").attr("selected",true);
	$("#StudentCurrentstream option[value="+selectedstream+"]").attr("selected",true);
	document.getElementById("StudentSurname").focus();
	getnextregistrationnumber();
	//e.preventDefault();
	  //document.getElementById("newmessage").innerHTML = "New text!";
      },
      error: function(data){
        $("#StudentRegistrationnumber").attr("readonly", "readonly");
        $("#flashMessage").addClass("message"); 
	$("#flashMessage").html("Failed to save details for Student with registration number:"+a);      
      }
    });
  }else{
  
      $("#StudentRegistrationnumber").removeAttr("readonly");  
      //$( "#StudentAddOlevelForm" ).submit();
  }
  });
});
</script>
<?php

    echo $this->Form->hidden('picture');


    echo $this->Form->end('Save Details');

    /*$data =  $this->Js->get('#StudentAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
    
    $this->Js->get('#StudentSurname')->event(
      'change',
      $this->Js->request(
	array('action' => 'checkifnumber'),
	array(
	    'update' => '#shayhowe1',
	    'async' => true,
	    'method' => 'post',
	    'dataExpression' => true,
	    //'data' => $this->Js->serializeForm(array(
		//'isForm' => true,
		//'inline' => true
		//)),
	    'data' => $data
	    ))
	
   );
*/
    ?>
