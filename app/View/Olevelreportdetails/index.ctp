<?php

//print_r($students);
//print_r($report_ids_to_be_edited);
  echo $this->Form->create('Olevelreportdetail', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  echo $this->Form->input('searchQuery', array('label' => 'Search for Report','value' => h($searchQuery)));
  echo $this->Form->end(__('Search'));
  

?>
<table>
    <tr>
	<td><?php   echo $this->Html->link(
		    'New Class Report',
		     array('action' => 'add')
		     );?>
	</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
    </tr>
    <tr>
	<th><?php echo $this->Paginator->sort('reportname','Report Name');?></th>
	<th><?php echo $this->Paginator->sort('reportterm','Term');?></th>
	<th><?php echo $this->Paginator->sort('reportclass','Class');?></th>
	<th>Year</th>
	<th>Actions</th>
    </tr>

    <!-- Here is where we loop through the students array printing out each of the students details -->

    <?php foreach ($students as $report): ?>
    <tr>
	<td><?php echo $report['Olevelreportdetail']['reportname'];?></td>
	<td>
	    <?php echo $report['Olevelreportdetail']['reportterm'];?>
	
	</td>
	<td>
	<?php 
		if ( $report['Olevelreportdetail']['reportclass'] != null ) {
		
		    echo "Senior ".$report['Olevelreportdetail']['reportclass'];
		    
		}else{
		
		    echo $report['Olevelreportdetail']['reportclass'];
		
		}
	    ?>
	</td>
	<td><?php echo $report['Olevelreportdetail']['reportyear'];?></td>
	<td>
		  <span id="drop-nav2">
		  
		  <ul>
		  
		      <li><a href="#">View </a>
		      
		        <ul>
			    <li>
				<?php echo $this->Form->postLink(
					'Individudal ',
					array('action' => 'viewReports', $report['Olevelreportdetail']['id'],0)
					    );?>	  
			    </li>
			    <li>
				<?php echo $this->Form->postLink(
					'Marksheet ',
					array('action' => 'viewReports', $report['Olevelreportdetail']['id'],1)
					    );?>
			    </li>
			</ul>
		      
		      </li>
		      <li><a href="#">Download </a>
		      
		        <ul>
			    <li>
				<?php echo $this->Form->postLink(
					'Single Report',
					array('action' => 'downloadReports', $report['Olevelreportdetail']['id'],4)
					    );?>	  
			    </li>
		        
			    <li>
				<?php echo $this->Form->postLink(
					'Report(s)',
					array('action' => 'downloadReports', $report['Olevelreportdetail']['id'],3),
					array('confirm' => 'This action may take a while downloading a report file, Are you sure you want to continue?')
					    );?>	  
			    </li>
			    <li>
				<?php echo $this->Form->postLink(
					'Marksheets(Combined)',
					array('action' => 'downloadReports', $report['Olevelreportdetail']['id'],1),
					array('confirm' => 'This action may take a while downloading a marksheet file, Are you sure you want to continue?')

					    );?>
			    </li>
			    <li>
				<?php echo $this->Form->postLink(
					'Result(s) summary ',
					array('action' => 'downloadReports', $report['Olevelreportdetail']['id'],2),
					array('confirm' => 'This action may take a while downloading a summary file, Are you sure you want to continue?')

					    );?>
			    </li>
			</ul>
		      
		      </li>
		      <li><a href="#">Update  </a>
		      
		        <ul>
			    <li>
			    <?php
				echo $this->Form->postLink(
					'Marks ',
					array('action' => 'updateReports', $report['Olevelreportdetail']['id'],1),
					array('confirm' => 'This action will update all the individudal records parmanently, Are you sure you want to continue?')
					    ); 
					    ?>
			    </li>
			    <li>
				<?php
				echo $this->Form->postLink(
					'Missing Students',
					array('action' => 'updateReports', $report['Olevelreportdetail']['id'], 2),
					array('confirm' => 'This action will update all the individudal records parmanently, Are you sure you want to continue?')
					    ); 
					    ?>
			    </li>
			</ul>
		      
		      </li>
		      
		       <li><a href="#">Comment on </a>
		      
		        <ul>
			    <li>
			    <?php
				echo $this->Form->postLink(
					'Head Teacher Section ',
					array('action' => 'comment', $report['Olevelreportdetail']['id'],1),
					array('confirm' => 'This action will take a while downloading a comment file, Are you sure you want to continue?')
					    );
					    ?>
			    </li>
			    <li>
				<?php
				echo $this->Form->postLink(
					'Class Teacher Section ',
					array('action' => 'comment', $report['Olevelreportdetail']['id'],2),
					array('confirm' => 'This action will take a while downloading a comment file, Are you sure you want to continue?')
					    ); 
					    ?>
			    </li>
			    <li>
				<?php
				echo $this->Form->postLink(
					'Warden Section ',
					array('action' => 'comment', $report['Olevelreportdetail']['id'],3),
					array('confirm' => 'This action will take a while downloading a comment file, Are you sure you want to continue?')
					    ); 
					    ?>
			    </li>
			    <li>
				<?php echo $this->Form->postLink(
					'Matron Section ',
					array('action' => 'comment', $report['Olevelreportdetail']['id'],4),
					array('confirm' => 'This action will take a while downloading a comment file, Are you sure you want to continue?')
					    );?>
			    </li>
			</ul>
		      
		      </li>
		      
		      <li><!--  <a href="#">Edit</a> -->
		      <?php
				echo $this->Html->link(
				    'Edit',
				     array('action' => 'edit', $report['Olevelreportdetail']['id'], 1)
				     );
					    ?>
					    <!--
		        <ul>
			    <li>
			    <?php/*
				echo $this->Html->link(
				    'Subjects Considered',
				     array('action' => 'edit', $report['Olevelreportdetail']['id'], 1)
				     );
					    */?>
			    </li>
			    <li>
				<?php/*
				echo $this->Html->link(
				    'Exams Considered',
				     array('action' => 'edit', $report['Olevelreportdetail']['id'], 2)
				     ); 
					    */?>
			    </li>
			</ul>-->
		      
		      </li>
		      
		      <li><a href="#">Delete</a>
		      
		        <ul>
			    <li>
			    <?php
				echo $this->Form->postLink(
					'All report Details ',
					array('action' => 'delete', $report['Olevelreportdetail']['id']),
					array('confirm' => 'This action will delete this report parmanently, Are you sure you want to continue?')
					    );
					    ?>
			    </li>
			    <li>
			    <?php
				echo $this->Form->postLink(
					'Single report ',
					array('action' => 'delete', $report['Olevelreportdetail']['id'], 1 )
					//array('confirm' => 'This action will delete this report parmanently, Are you sure you want to continue?')
					    );
					    ?>
			    </li>
			</ul>
		      
		      </li>
		      
		  </ul>
		  
		  </span>
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