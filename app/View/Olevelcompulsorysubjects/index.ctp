<?php
  
  echo $this->Form->create('Olevelcompulsorysubject', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  echo $this->Form->input('searchQuery', array('label' => 'Search for Class(es) using year','value' => h($searchQuery)));
  echo $this->Form->end(__('Search'));
  

?>
<table>
    <tr>
	<td><?php   echo $this->Html->link(
		    'Add class subject(s)',
		     array('action' => 'add')
		     );?>
	</td>
	<td></td>
	<td></td>
	<td></td>
    </tr>
    <tr>

	<th><?php echo $this->Paginator->sort('year','Year'); ?></th>
			<th><?php echo $this->Paginator->sort('class', 'Class'); ?></th>
			<th><?php echo $this->Paginator->sort('compulsorysubjects','Compulsory Subjects(Short subject Names)'); ?></th>
			<th>Action</th>
	</tr>

    <!-- Here is where we loop through the students array printing out each of the students details -->

	<?php foreach ($olevelcompulsorysubjects as $olevelcompulsorysubject): ?>
	<tr>
		<td><?php echo h($olevelcompulsorysubject['Olevelcompulsorysubject']['year']); ?>&nbsp;</td>
		<td><?php echo "Senior ".h($olevelcompulsorysubject['Olevelcompulsorysubject']['class']); ?>&nbsp;</td>
		<?php 
		   /* 
		   $current_compulsory_subjects = explode("$",$olevelcompulsorysubject['Olevelcompulsorysubject']['compulsorysubjects']);
		   $subjects = null;
		   foreach($current_compulsory_subjects as $value){
		   
			$subjects = $subjects.$value.", ";
		   
		   }
		
		   $subjects = trim($subjects,", ");
		   */
		
		?>
		<td><?php
		
		   $current_compulsory_subjects = explode("$",$olevelcompulsorysubject['Olevelcompulsorysubject']['compulsorysubjects']);
		   $subjects = null;
		   
		   $counter = 0;
		   
		   foreach($current_compulsory_subjects as $value){
		   
			//$subjects = $subjects.$value.", ";
			if(($counter >= 0) && ($counter < 6)){
			
			    $subjects = $subjects.$value.", ";
			    $counter++;
			
			}else{
			
			    if($counter == 6){
			    
				$subjects = $subjects.$value."<br/>";
				$counter = 0;
			    
			    }
			    
			}
			
			
		   }
		
		   $subjects = trim($subjects,", ");
		
		
		   echo $subjects/*h($olevelcompulsorysubject['Olevelcompulsorysubject']['compulsorysubjects'])*/; 
		
		
		?>&nbsp;</td>
		<td>
			<?php //echo $this->Html->link(__('View '), array('action' => 'view', $olevelcompulsorysubject['Olevelcompulsorysubject']['id'])); ?>
			<?php echo $this->Html->link(__('Edit '), array('action' => 'edit', $olevelcompulsorysubject['Olevelcompulsorysubject']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $olevelcompulsorysubject['Olevelcompulsorysubject']['id']), array(), __('Are you sure you want to delete # %s?', $olevelcompulsorysubject['Olevelcompulsorysubject']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
    <?php //unset($student); ?>
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