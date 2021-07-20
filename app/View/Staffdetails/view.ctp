<?php /*
<div class="staffdetails view">
<h2><?php echo __('Staffdetail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sex'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['sex']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['age']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Maritalstatus'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['maritalstatus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Spousename'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['spousename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numberofchildren'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['numberofchildren']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numberofdependants'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['numberofdependants']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Picturenumber'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['picturenumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Healthstatus'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['healthstatus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tribe'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['tribe']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homecountry'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['homecountry']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homedistrict'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['homedistrict']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nssfnumber'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['nssfnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dateofbirth'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['dateofbirth']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accountdetails'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['accountdetails']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nextofkinname'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['nextofkinname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nextofkincontacts'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['nextofkincontacts']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currentposition'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['currentposition']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currentresidentialvillage'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['currentresidentialvillage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currentresidentialsubcounty'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['currentresidentialsubcounty']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currentresidentialcounty'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['currentresidentialcounty']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currentresidentialdistrict'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['currentresidentialdistrict']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currentresidentialcountry'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['currentresidentialcountry']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phonenumbers'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['phonenumbers']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Emailaddresses'); ?></dt>
		<dd>
			<?php echo h($staffdetail['Staffdetail']['emailaddresses']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Staffdetail'), array('action' => 'edit', $staffdetail['Staffdetail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Staffdetail'), array('action' => 'delete', $staffdetail['Staffdetail']['id']), array(), __('Are you sure you want to delete # %s?', $staffdetail['Staffdetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Staffdetails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staffdetail'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dependantdetails'), array('controller' => 'dependantdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dependantdetail'), array('controller' => 'dependantdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Previousworkplaces'), array('controller' => 'previousworkplaces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Previousworkplace'), array('controller' => 'previousworkplaces', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Dependantdetails'); ?></h3>
	<?php if (!empty($staffdetail['Dependantdetail'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Staffdetail Id'); ?></th>
		<th><?php echo __('Childname'); ?></th>
		<th><?php echo __('Dateofbirth'); ?></th>
		<th><?php echo __('Picturenumber'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($staffdetail['Dependantdetail'] as $dependantdetail): ?>
		<tr>
			<td><?php echo $dependantdetail['id']; ?></td>
			<td><?php echo $dependantdetail['staffdetail_id']; ?></td>
			<td><?php echo $dependantdetail['childname']; ?></td>
			<td><?php echo $dependantdetail['dateofbirth']; ?></td>
			<td><?php echo $dependantdetail['picturenumber']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'dependantdetails', 'action' => 'view', $dependantdetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'dependantdetails', 'action' => 'edit', $dependantdetail['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'dependantdetails', 'action' => 'delete', $dependantdetail['id']), array(), __('Are you sure you want to delete # %s?', $dependantdetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Dependantdetail'), array('controller' => 'dependantdetails', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Previousworkplaces'); ?></h3>
	<?php if (!empty($staffdetail['Previousworkplace'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Staffdetail Id'); ?></th>
		<th><?php echo __('Organisation'); ?></th>
		<th><?php echo __('Responsiblilty'); ?></th>
		<th><?php echo __('Startdate'); ?></th>
		<th><?php echo __('Enddate'); ?></th>
		<th><?php echo __('Salaryscale'); ?></th>
		<th><?php echo __('Salaryscaleunits'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($staffdetail['Previousworkplace'] as $previousworkplace): ?>
		<tr>
			<td><?php echo $previousworkplace['id']; ?></td>
			<td><?php echo $previousworkplace['staffdetail_id']; ?></td>
			<td><?php echo $previousworkplace['organisation']; ?></td>
			<td><?php echo $previousworkplace['responsiblilty']; ?></td>
			<td><?php echo $previousworkplace['startdate']; ?></td>
			<td><?php echo $previousworkplace['enddate']; ?></td>
			<td><?php echo $previousworkplace['salaryscale']; ?></td>
			<td><?php echo $previousworkplace['salaryscaleunits']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'previousworkplaces', 'action' => 'view', $previousworkplace['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'previousworkplaces', 'action' => 'edit', $previousworkplace['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'previousworkplaces', 'action' => 'delete', $previousworkplace['id']), array(), __('Are you sure you want to delete # %s?', $previousworkplace['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Previousworkplace'), array('controller' => 'previousworkplaces', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
*/?>

<h1 class="sectiondefinition1">Staff Record</h1>
 <?php 
    //$lastnumberused = (string)$lastnumberused;
    //$currentyear = (string)$currentyear;
    //$picturenumber = $currentyear.$lastnumberused;
    echo "<br/>";
    $staffpicuture = $webcampic;
    if($staffpicuture != false){
	echo $this->Html->image('staffpics/'.$staffpicuture.'.jpg', array('alt' => 'Staff\'s Picture', 'id' => 'shayhowe'));
    }else{
	echo $this->Html->image('staffpics/person.png', array('alt' => 'Staff Picture', 'id' => 'shayhowe'));
    }
    
    //echo $this->Html->image('staffpics/person.png', array('alt' => 'Staff Picture', 'id' => 'shayhowe'));
 ?>
    <div id="shayhowe1"></div>
    <span id="takeaphoto"><?php //Turn on camera and take photo?></span>
    <?php
    echo $this->Form->create('Staffdetail', array('type' => 'file'));
    ?><table><tr><td><?php
    
    //echo $this->Html->link('Upload your picture file', array('controller' => '','action' => ''));
    //echo $this->Form->input('Staffdetail.picturepath', array('between' => '<br />', 'type' => 'file', 'label' => 'Attach your picture', 'accept' =>'image/*'));
    ?>
    </td>
    </tr></table>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">Biographical/Personal information</legend><?php
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

   echo $this->Form->input('registrationnumber', array('label' => 'Registration Number','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td colspan="2">
<?php
    echo $this->Form->input('name', array('label' => 'Names','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('sex', array(
					'label' => 'Sex',
					'options' => $sexes,
					'selected' => 'none'
					)); 
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('phonenumbers', array('label' => 'Telephone number(s)','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('emailaddresses', array('label' => 'Email Address(es)','rows' => '1', 'readonly' => 'readonly'));
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
    echo $this->Form->input('homedistrict', array('label' => 'District of origin','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('tribe', array('label' => 'Tribe','rows' => '1', 'readonly' => 'readonly'));
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
    echo $this->Form->input('spousename', array('label' => 'Names of Spouse','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('nextofkinname', array('label' => 'Names of next of kin','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('nextofkincontacts', array('label' => 'Phone contacts of next of kin','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('nssfnumber', array('label' => 'Social security number','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
    echo $this->Form->input('accountdetails', array('rows' => '3', 'label' => 'Bank Account details','readonly' => 'readonly'));
?>
</td>
<td>
<?php
    echo $this->Form->input('healthstatus', array('rows' => '3', 'label' => 'Health information', 'readonly' => 'readonly'));
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
echo $this->Form->input('currentresidentialvillage', array('label' => 'Village','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
echo $this->Form->input('currentresidentialsubcounty', array('label' => 'Sub-county','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
echo $this->Form->input('currentresidentialcounty', array('label' => 'County','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
</tr>
<tr class = "olevelresults">
<td>
<?php
echo $this->Form->input('currentresidentialdistrict', array('label' => 'District','rows' => '1', 'readonly' => 'readonly'));
?>
</td>
<td>
<?php
echo $this->Form->input('currentresidentialcountry', array('label' => 'Country','rows' => '1', 'readonly' => 'readonly'));
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
	echo $this->Form->input('Previousworkplace.'.$i.'.organisation', array('label' => 'Organisation','rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.responsibility', array('rows' => '3','label' => 'Responsibility','readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.startdate', array('label' => 'Start Date','rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.enddate', array('label' => 'End Date','rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Previousworkplace.'.$i.'.salaryscale', array('label' => 'Salary Scale','rows' => '1', 'readonly' => 'readonly'));
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
	echo $this->Form->input('Dependantdetail.'.$j.'.childname', array('label' => 'Name(s)','rows' => '1', 'readonly' => 'readonly'));
      ?>
    </td>
    <td>
      <?php
	echo $this->Form->input('Dependantdetail.'.$j.'.dateofbirth', array('label' => 'Date of Birth','rows' => '1', 'readonly' => 'readonly'));
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
    //echo $this->Form->end('Update');

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