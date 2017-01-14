<table>
    <tr>
	<td><?php //echo $this->Html->link('Home', array('controller' => 'Users','action' => 'loginhome'));?></td>
	<td><?php //echo $this->Html->link('Add New', array('action' => 'add_olevel')); ?></td>
    </tr>
</table>

<?php
  echo $this->Form->create('Student', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  echo $this->Form->input('searchQuery', array('label' => 'Search for Student','value' => h($searchQuery)));
  echo $this->Form->end(__('Search'));
?>
<table>
    <tr>
	<th>Picture</th>
	<th><?php echo $this->Paginator->sort('registrationnumber','Registration Number');?></th>
	<th><?php echo $this->Paginator->sort('surname','Surname');?></th>
	<th><?php echo $this->Paginator->sort('othernames','Other Names');?></th>
	<th>Sex</th>
	<th>Current Class</th>
	<th>Current Stream</th>
	<th>Present?</th>
	<th>Action</th>
    </tr>

    <!-- Here is where we loop through the students array printing out each of the students details -->

    <?php foreach ($students as $student): ?>
    <tr class='studentpic'>
	<?php     
		$picuturepresent = $student['Student']['studenthaspic'];
		 if($picuturepresent == "YES"){
		    $picvariable = "background: url(/daris/students/displayImage/".$student['Student']['id'].");background-size: 80%;background-repeat: no-repeat;	background-position: center top;";
		    //echo $this->Html->image('studentpics/'.$student['Student']['picturenumber'].'.jpg', array('alt' => 'Student\'s Picture', 'id' => 'shayhowe', 'class' =>'resizestudentpic'));
		 }else{
		    $picvariable = "background: url(/daris/img/studentpics/person.png);background-size: 70%;background-repeat: no-repeat;	background-position: center top;";		    
		    //echo $this->Html->image('studentpics/person.png', array('alt' => 'Student\'s Picture', 'id' => 'shayhowe' , 'class' =>'resizestudentpic'));
		 } 
	?>
	<td class='studentpic' style="<?php echo $picvariable?>">
	
	</td>
	<td><?php echo $student['Student']['registrationnumber']; ?></td>
	<td><?php echo $student['Student']['surname'];?></td>
	<td><?php echo $student['Student']['othernames'];?></td>
	<td><?php echo $student['Student']['sex']; ?></td>
	<td><?php echo "Senior ".$student['Student']['currentclass']; ?></td>
	<td><?php echo $student['Student']['currentstream']; ?></td>
	<td><?php echo $student['Student']['availabilitystatus']; ?></td>
	<td><?php
		  /*echo $this->Html->link(
				    'View ',
				     array('action' => 'view', $student['Student']['id'])
				     );*/
		  echo $this->Html->link(
				    'Edit ',
				     array('action' => 'edit', $student['Student']['id'])
				     );
		  echo $this->Form->postLink(
					'Delete ',
					array('action' => 'delete', $student['Student']['id']),
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