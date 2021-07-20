<h1 class="sectiondefinition1">Edit Subject Record</h1>
<?php
    echo $this->Form->create('Schooldonesubject');
?>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Biographical/Personal information</legend><?php
    //echo $this->Form->hidden('picturenumber', array('default' => $picturenumber));
    //echo $this->Form->hidden('fullnames', array('default' => ""));
    echo $this->Form->hidden('studenthaspic', array('default' => ""));
    if ($this->Form->isFieldError('picturenumber')){
	echo $this->Form->error('gender');
    }

    $sexes = array(
		   "F" => "F",
		   "M" => "M",
    );

    $nationality = array(
		   "Uganda" => "Uganda",
		   "South Sudun" => "South Sudan",
		   "Kenya" => "Kenya",
		   "Tanzania" => "Tanzania",
		   "Rwanda" => "Rwanda",
		   "Burundi" => "Burundi",
		   "Congo" => "Congo",
		   "Central African Republic" => "Central African Republic",
		   "Somalia" => "Somalia",
		   "Ethiopia" => "Ethiopia",
		   "Eritrea" => "Eritrea",
    );

    $regilions = array(
		   "Pentecostal" => "Pentecostal",
		   "Protestant" => "Protestant",
		   "Catholic" => "Catholic",
		   "Moslem" => "Moslem",
    );

    $marriagestatuses = array(
		   "Single" => "Single",
		   "Married" => "Married",
    );

    $availabilitystatus = array(
		   "Present" => "Present",
		   "Absent" => "Absent",
    );

    $leavingreasons = array(
		   "" => "",
		   "Contract not renewed" => "Contract not renewed",
		   "Contract Terminated impromptu" => "Contract Terminated impromptu",
    );

//     ?>
<table>
<tr class = "olevelresults">
<td>
<?php

   echo $this->Form->input('registrationnumber', array('label' => 'Registration Number'));
?>
</td>
<td colspan="2">
<?php
    echo $this->Form->input('name', array('label' => 'Names'));
?>
</td>
<td>
<?php
    echo $this->Form->input('sex', array(
					'label' => 'Sex',
					'options' => $sexes,
					'selected' => 'none')); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('phonenumbers', array('label' => 'Telephone number(s)'));
?>
</td>
<td>
<?php
    echo $this->Form->input('emailaddresses', array('label' => 'Email Address(es)'));
?>
</td>
<td>
<?php    echo $this->Form->input('homecountry', array(
					'label' => 'Country of origin',
					'options' => $nationality,
					'selected' => 'Uganda'));
?>
</td>
<td>
<?php
    echo $this->Form->input('homedistrict', array('label' => 'District of origin'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('tribe', array('label' => 'Tribe'));
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
<?php echo $this->Form->input('dateofbirth', array(
	'label' => 'Date of birth',
	'dateFormat' => 'DMY',
	'maxYear' => date('Y') - 10,
	'minYear' => date('Y') - 100,
    ));
?>
</td>
<td>
<?php echo $this->Form->input('maritalstatus', array(
					'label' => 'Marital Status',
					'options' => $marriagestatuses,
					'selected' => 'none')); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('spousename', array('label' => 'Names of Spouse'));
?>
</td>
<td>
<?php
    echo $this->Form->input('nextofkinname', array('label' => 'Names of next of kin'));
?>
</td>
<td>
<?php
    echo $this->Form->input('nextofkincontacts', array('label' => 'Phone contacts of next of kin'));
?>
</td>
<td>
<?php
    echo $this->Form->input('nssfnumber', array('label' => 'Social security number'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('accountdetails', array('rows' => '3', 'label' => 'Bank Account details'));
?>
</td>
<td>
<?php
    echo $this->Form->input('healthstatus', array('rows' => '3', 'label' => 'Health information'));
?>
</td>
</tr>
</table>
</fieldset> 
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Current residence address information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('currentresidentialvillage', array('label' => 'Village'));
?>
</td>
<td>
<?php
echo $this->Form->input('currentresidentialsubcounty', array('label' => 'Sub-county'));
?>
</td>
<td>
<?php
echo $this->Form->input('currentresidentialcounty', array('label' => 'County'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('currentresidentialdistrict', array('label' => 'District'));
?>
</td>
<td>
<?php
echo $this->Form->input('currentresidentialcountry', array('label' => 'Country'));
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
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Employment History</legend>
<table>
<?php
$i = 0;
foreach ( $staffrecords['Previousworkplace'] as $previousworkplace ){  
?>
  <tr class = "olevelresults2">
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.id', array('type' => 'hidden'));
	echo $this->Form->input('Previousworkplace.'.$i.'.organisation', array('label' => 'Organisation'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.responsibility', array('rows' => '3','label' => 'Responsibility'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.startdate', array('label' => 'Start Date'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.enddate', array('label' => 'End Date'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.salaryscale', array('label' => 'Salary Scale'));
      ?>
    </td>
  </tr>
<?php
$i = $i + 1;
}
?>
<tr class = "olevelresults2">
</tr>
<tr class = "olevelresults">
<td>
<button id="add-new-employment-history" type="button">Add New</button>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
<td>
</td>
</tr>
</table>
</fieldset>

<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Details of children or dependants</legend>
<table>
<?php
$j = 0;
foreach ( $staffrecords['Dependantdetail'] as $previousworkplace ){  
?>
  <tr class = "olevelresults3">
    <td>
      <?php
	echo $this->Form->input('Dependantdetail.'.$j.'.id', array('type' => 'hidden'));
	echo $this->Form->input('Dependantdetail.'.$j.'.childname', array('label' => 'Name(s)'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Dependantdetail.'.$j.'.dateofbirth', array('label' => 'Date of Birth'));
      ?>
    </td>
  </tr>
<?php
$j = $j + 1;
}
?>
<tr class = "olevelresults3">
</tr>
<tr class = "olevelresults">
<td>
<button id="add-new-dependant-details" type="button">Add New</button>
</td>
</tr>
</table>
</fieldset>

<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Presence/Arrival/Departure Information</legend>
<table>
<tr class = "olevelresults">
<td>
<?php
 echo $this->Form->input('joiningdate', array(
	'label' => 'Date of Joining',
	'dateFormat' => 'DMY',
	'maxMonth' => date('M'),
	'maxYear' => date('Y'),
	'minYear' => date('Y') - 100,
    )); 
?>
</td>
<td>
<?php
     echo $this->Form->input('availabilitystatus', array(
					'label' => 'Staff Present?',
					'options' => $availabilitystatus,
					'selected' => 'Present'));   
?>
</td>
</tr>
<tr class = "olevelresults">
    <td>
    <?php  
    echo $this->Form->input('leavingdate', array(
	'label' => 'Date of Leaving in the format (Day-Month-Year)',
	'dateFormat' => 'DMY',
	'maxYear' => date('Y'),
	'minYear' => date('Y') - 100,
	'empty' => ' ',
    )); 
    ?>
    </td>
    <td>
    <?php
    echo $this->Form->input('leavingreason', array(
					'label' => 'Reason for leaving',
					'options' => $leavingreasons,
					'empty' => ' ')); 
    //echo $i;
    ?>
    </td>
</tr>
</table>
</fieldset>
<?php

    //echo $this->Form->hidden('picture');
    echo $this->Form->hidden('picturenumber');
    //echo $this->Form->hidden('fullnames', array('default' => ""));
    echo $this->Form->hidden('studenthaspic', array('default' => ""));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->hidden('picture');
    echo $this->Form->end('Update');

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
<script type="text/javascript">
    var i = <?php echo $i?>;
    var j = <?php echo $j?>;
    $("#add-new-employment-history").click(function () {
        $(this).closest('tr').prev('tr').after('<tr class = "olevelresults2"><td><div class="input text"><label for="Previousworkplace'+i+'Organisation">Organisation</label><input name="data[Previousworkplace]['+i+'][organisation]" maxlength="50" type="text" id="Previousworkplace'+i+'Organisation"/></div></td><td><div class="input textarea"><label for="Previousworkplace'+i+'Responsibility">Responsibilities</label><textarea name="data[Previousworkplace]['+i+'][responsibility]" rows="3" cols="30" id="Previousworkplace'+i+'Responsibility"></textarea></div></td><td><div class="input text"><label for="Previousworkplace'+i+'Startdate">Start Date</label><input name="data[Previousworkplace]['+i+'][startdate]" maxlength="20" type="text" id="Previousworkplace'+i+'Startdate"/></div></td><td><div class="input text"><label for="Previousworkplace'+i+'Enddate">End Date</label><input name="data[Previousworkplace]['+i+'][enddate]" maxlength="20" type="text" id="Previousworkplace'+i+'Enddate"/></div></td><td><div class="input number"><label for="Previousworkplace'+i+'Salaryscale">Salary Scale</label><input name="data[Previousworkplace]['+i+'][salaryscale]" type="number" id="Previousworkplace'+i+'Salaryscale"/></div></td><td><br/><br/><button id="remove-new-employment-history" type="button">remove</button></td></tr>');
        i++;
    });
    
    $(document).on('click', '#remove-new-employment-history', function () {
	$(this).closest('tr').remove();
    });
    
    $("#add-new-dependant-details").click(function () {
        $(this).closest('tr').prev('tr').after('<tr class = "olevelresults3"><td><div class="input text"><label for="Dependantdetail'+j+'Childname">Name of child or dependant</label><input name="data[Dependantdetail]['+j+'][childname]" maxlength="50" type="text" id="Dependantdetail'+j+'Childname"/></div></td><td><div class="input text"><label for="Dependantdetail'+j+'Dateofbirth">Date of Birth</label><input name="data[Dependantdetail]['+j+'][dateofbirth]" maxlength="40" type="text" id="Dependantdetail'+j+'Dateofbirth"/></div></td><td><br/><br/><button id="remove-new-dependant-detail" type="button">remove</button></td></tr>');
        j++;
    });
    
    $(document).on('click', '#remove-new-dependant-detail', function () {
	$(this).closest('tr').remove();
    });
</script>