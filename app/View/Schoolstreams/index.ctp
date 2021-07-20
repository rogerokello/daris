<?php
  echo $this->Form->create('Schoolstream', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  echo $this->Form->input('searchQuery', array('label' => 'Search for Stream','value' => h($searchQuery)));
  echo $this->Form->end(__('Search'));
  

?>
<table>
    <tr>
	<td><?php   echo $this->Html->link(
		    'Add Stream',
		     array('action' => 'add')
		     );?>
	</td>
	<td></td>
	<td></td>
    </tr>
    <tr>
	<th><?php echo $this->Paginator->sort('stream','Stream name');?></th>
	<th>Short Stream name</th>
	<th>Action</th>
    </tr>

    <!-- Here is where we loop through the students array printing out each of the students details -->

    <?php foreach ($students as $student): ?>
    <tr>
	<td><?php echo $student['Schoolstream']['stream'];?></td>
	<td><?php echo $student['Schoolstream']['shortstreamname'];?></td>
	<td><?php
		  echo $this->Html->link(
				    'Edit ',
				     array('action' => 'edit', $student['Schoolstream']['id'])
				     );
		  echo $this->Form->postLink(
					'Delete ',
					array('action' => 'delete', $student['Schoolstream']['id']),
					array('confirm' => 'This action will delete this record parmanently, Are you sure you want to continue?')
					    );
	    ?>
	</td>
    </tr>
    <?php endforeach; ?>   
    <?php unset($student); ?>
</table>
     <p>
      <?php
        echo "Showing record(s) ".$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
      ?>
     </p>
     <div class="paging">
       <?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		//echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
       
         //echo $this->Paginator->prev('< ' . __('Previous Page'), array(),null, array('class' => 'prev disabled'));
         //echo $this->Paginator->next(__('Next Page') . ' >', array(),null, array('class' => 'next disabled'));
       ?>
     </div>
     <?php
     //if($this->Paginator->current('Student') > 5){
	//echo $this->Paginator->prev('<< ' . __('previous ', true), array(), null, array('class'=>'disabled'));
	//echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));
	//echo $this->Paginator->next(__(' next', true) . ' >>', array(), null, array('class' => 'disabled'));
     
     ?>
     
    <!-- <div class="pagination pagination-right">
    <ul>
    <?php
    //echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled', 'tag' => 'li' ) );
    //echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'active', 'currentTag' => 'a' ) );
    //echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled', 'tag' => 'li' ) );
    ?>
    </ul>
    </div> !>




<?php // this is the separator ?>
<?php 
 /*<div class="staffdetails index">


	<h2><?php echo __('Staffdetails'); ?></h2>

	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('sex'); ?></th>
			<th><?php echo $this->Paginator->sort('age'); ?></th>
			<th><?php echo $this->Paginator->sort('maritalstatus'); ?></th>
			<th><?php echo $this->Paginator->sort('spousename'); ?></th>
			<th><?php echo $this->Paginator->sort('numberofchildren'); ?></th>
			<th><?php echo $this->Paginator->sort('numberofdependants'); ?></th>
			<th><?php echo $this->Paginator->sort('picturenumber'); ?></th>
			<th><?php echo $this->Paginator->sort('healthstatus'); ?></th>
			<th><?php echo $this->Paginator->sort('tribe'); ?></th>
			<th><?php echo $this->Paginator->sort('homecountry'); ?></th>
			<th><?php echo $this->Paginator->sort('homedistrict'); ?></th>
			<th><?php echo $this->Paginator->sort('nssfnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('dateofbirth'); ?></th>
			<th><?php echo $this->Paginator->sort('accountdetails'); ?></th>
			<th><?php echo $this->Paginator->sort('nextofkinname'); ?></th>
			<th><?php echo $this->Paginator->sort('nextofkincontacts'); ?></th>
			<th><?php echo $this->Paginator->sort('currentposition'); ?></th>
			<th><?php echo $this->Paginator->sort('currentresidentialvillage'); ?></th>
			<th><?php echo $this->Paginator->sort('currentresidentialsubcounty'); ?></th>
			<th><?php echo $this->Paginator->sort('currentresidentialcounty'); ?></th>
			<th><?php echo $this->Paginator->sort('currentresidentialdistrict'); ?></th>
			<th><?php echo $this->Paginator->sort('currentresidentialcountry'); ?></th>
			<th><?php echo $this->Paginator->sort('phonenumbers'); ?></th>
			<th><?php echo $this->Paginator->sort('emailaddresses'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($staffdetails as $staffdetail): ?>
	<tr>
		<td><?php echo h($staffdetail['Staffdetail']['id']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['name']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['sex']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['age']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['maritalstatus']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['spousename']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['numberofchildren']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['numberofdependants']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['picturenumber']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['healthstatus']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['tribe']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['homecountry']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['homedistrict']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['nssfnumber']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['dateofbirth']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['accountdetails']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['nextofkinname']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['nextofkincontacts']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['currentposition']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['currentresidentialvillage']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['currentresidentialsubcounty']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['currentresidentialcounty']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['currentresidentialdistrict']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['currentresidentialcountry']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['phonenumbers']); ?>&nbsp;</td>
		<td><?php echo h($staffdetail['Staffdetail']['emailaddresses']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $staffdetail['Staffdetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $staffdetail['Staffdetail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $staffdetail['Staffdetail']['id']), array(), __('Are you sure you want to delete # %s?', $staffdetail['Staffdetail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		//echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Staffdetail'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Dependantdetails'), array('controller' => 'dependantdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dependantdetail'), array('controller' => 'dependantdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Previousworkplaces'), array('controller' => 'previousworkplaces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Previousworkplace'), array('controller' => 'previousworkplaces', 'action' => 'add')); ?> </li>
	</ul>
</div>
*/
?>