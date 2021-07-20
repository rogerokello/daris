<h1 class="sectiondefinition1">New Advanced-level Student</h1>
<?php
    //$this->Js->get('#StudentPicturepath')->event('change', $this->Js->alert('heyyou!'));
?> <?php 
    $lastnumberused = (string)$lastnumberused;
    $currentyear = (string)$currentyear;
    $picturenumber = $currentyear.$lastnumberused;
    echo $this->Html->image('studentpics/person.png', array('alt' => 'CakePHP', 'id' => 'shayhowe'));
    //echo $this->Html->image('studentpics/person.png', array('alt' => 'CakePHP', 'id' => 'shayhowe1'));
    //echo "<br/>";
    ?>
    <div id="shayhowe1"></div>
    <span id="takeaphoto">Turn on camera and take photo</span>
    <?php
    echo $this->Form->create('Student', array('type' => 'file'));
    ?><table><tr><td><?php
    echo "<br/>";
    //echo $this->Html->link('Upload your picture file', array('controller' => '','action' => ''));
    echo $this->Form->input('Student.picturepath', array('between' => '<br />', 'type' => 'file', 'label' => 'Attach your picture','accept' =>'image/*'));
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
    ?>
    <fieldset class="sectiondefinition1"><legend class="sectiondefinition">Biographical/Personal information</legend><?php
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
		   "5" => "Senior Five",
		   "6" => "Senior Six",
    );

    $currentstream = array(
		   "Arts" => "Arts",
		   "Science" => "Science",
    );

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
    
    $subjectofolevel = array(
		   "English Language" => "ENG",
		   "Mathematics" => "MATH",
		   "Biology" => "BIOS",
		   "Chemistry" => "CHEM",
		   "Physics" => "PHY",
		   "History" => "HIST",
		   "Geography" => "GEOG",
		   "Christian Religious Education" => "CRE",
		   "Commerce" => "COMM",
		   "Entreprenuership Education" => "ENTRE",
		   "Computer Studies" => "COMP",
		   "Fine Art" => "ART",
		   "Literature In English" => "LIT",
		   "Principles And Practices of Agriculture" => "AGRIC",
		   "Luganda" => "LUG",
		   "Lango" => "LNGO",
		   "French" => "FRCH",
    );
    
    $subjectofalevel = array(
		   "Math" => "Math",
		   "Bio" => "Bio",
		   "Chem" => "Chem",
		   "Phy" => "Phy",
		   "Hist" => "Hist",
		   "Geog" => "Geog",
		   "Cre" => "Cre",
		   "Econ" => "Econ",
		   "Entr" => "Entr",
		   "sict" => "sict",
		   "Art" => "Art",
		   "Lit" => "Lit",
		   "Agri" => "Agri",
    );
    
    $subjectofalevel = $alevel_subjects;
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
					'selected' => ''));
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
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Subject Combination</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Alevelsubjectcombination.subject1', array('label' => 'Subject One','options' => $subjectofalevel,'empty' => ' ','selected' => 'none',));
?>
</td>
<td>
<?php
echo $this->Form->input('Alevelsubjectcombination.subject2', array('label' => 'Subject Two','options' => $subjectofalevel,'empty' => ' ','selected' => 'none'));
?>
</td>
<td>
<?php
echo $this->Form->input('Alevelsubjectcombination.subject3', array('label' => 'Subject Three','options' => $subjectofalevel,'empty' => ' ','selected' => 'none'));
?>
</td>
<td>
<?php
echo $this->Form->input('Alevelsubjectcombination.subject4', array('label' => 'Subject Four (Subsidiary)','options' => $subjectofalevel,'empty' => ' ','selected' => 'none'));
?>
</td>
<td></td>
<td></td>
<td></td>
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
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Uganda Certificate of Education(UCE) Results</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Uceresult.subject1name', array('label' => false,'options' => $subjectofolevel,'selected' => 'English Language')); 
echo $this->Form->input('Uceresult.subject1mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject2name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Mathematics')); 
echo $this->Form->input('Uceresult.subject2mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject3name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Physics')); 
echo $this->Form->input('Uceresult.subject3mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject4name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Geography')); 
echo $this->Form->input('Uceresult.subject4mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject5name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Chemistry')); 
echo $this->Form->input('Uceresult.subject5mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject6name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Biology')); 
echo $this->Form->input('Uceresult.subject6mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject7name', array('label' => false,'options' => $subjectofolevel,'selected' => 'History')); 
echo $this->Form->input('Uceresult.subject7mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject8name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Commerce')); 
echo $this->Form->input('Uceresult.subject8mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject9name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Principles And Practices of Agriculture')); 
echo $this->Form->input('Uceresult.subject9mark', array('label' => false));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.subject10name', array('label' => false,'options' => $subjectofolevel,'selected' => 'Fine Art')); 
echo $this->Form->input('Uceresult.subject10mark', array('label' => false));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('Uceresult.aggregate', array('label' => 'AGG'));
?>
</td>
<td>
<?php
echo $this->Form->input('Uceresult.division', array('label' => 'DIV'));
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
  $('body').on('submit','#StudentAddAlevelForm',function(e) {
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
	//$("#StudentAddAlevelForm")[0].reset();
	document.getElementById('StudentAddAlevelForm').reset();
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
    
    echo $this->Form->hidden('studentpicture');


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
