<?php
  echo $this->Form->create('Gradeprofile', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  echo $this->Form->input('searchQuery', array('label' => 'Search for Profile','value' => h($searchQuery)));
  echo $this->Form->end(__('Search'));
?>
<table>
    <tr>
	<td><?php   echo $this->Html->link(
		    'Add Profile',
		     array('action' => 'add')
		     );
		     
		     echo $this->Html->link(
		    '     Assign a class a profile',
		     array('action' => 'assign')
		     );
	     ?>
	</td>
	<td></td>
    </tr>
    <tr>
	<th><?php echo $this->Paginator->sort('name','Profile names');?></th>
	<th>Action</th>
    </tr>

    <!-- Here is where we loop through the students array printing out each of the students details -->

    <?php foreach ($students as $student): ?>
    <tr>
	<td><?php echo $student['Gradeprofile']['profilename'];?></td>
	<td><?php
		  echo $this->Html->link(
				    'View ',
				     array('action' => 'view', $student['Gradeprofile']['id'])
				     );
		  echo $this->Html->link(
				    'Edit ',
				     array('action' => 'edit', $student['Gradeprofile']['id'])
				     );
		  echo $this->Form->postLink(
					'Delete ',
					array('action' => 'delete', $student['Gradeprofile']['id']),
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
?>