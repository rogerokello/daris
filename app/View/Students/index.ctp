<!--<table>
    <tr>
	<td><?php //echo $this->Html->link('Home', array('controller' => 'Users','action' => 'loginhome'));?></td>
	<td><?php //echo $this->Html->link('Add New', array('action' => 'add_olevel')); ?></td>
    </tr>
</table>
-->
<?php
  echo $this->Form->create('Student', array('action' => 'search'));
  if (!isset($searchQuery)) {
    $searchQuery = '';
  }
  
  
  echo $this->Form->input('searchQuery', array('label' => 'Search for Student (Use a Registration number, Surname or Other Names)','value' => h($searchQuery)));
  if($extrasearchison == 0){
  
      echo $this->Form->input('showextracriterea', array('label' => 'Show extra search criterea','type' => 'checkbox'));
      echo "<span id=\"extrasearchcriterea\" class=\"hide\">";
  
  }else{
  
      echo $this->Form->input('showextracriterea', array('label' => 'Show extra search criterea','type' => 'checkbox', 'checked'));
      echo "<span id=\"extrasearchcriterea\" class=\"\">";
  
  }
  ?>
  <fieldset class="sectiondefinition1" id ="StudentSearchfieldset_"><legend class="sectiondefinition1">Extra Search criterea</legend><?php
  if(($studentsnotpartofschool == 1)){
  
      echo $this->Form->input('studentnotpartofschool', array('label' => 'Search for students who are nolonger part of school(Old Boys and Old Girls)','type' => 'checkbox', 'checked' => 'checked'));
  
  }else {
  
      echo $this->Form->input('studentnotpartofschool', array('label' => 'Search for students who are nolonger part of school(Old Boys and Old Girls)','type' => 'checkbox'));
  
  }
  
  $currentstream = $streamsintheschool;
  //$currentstream[""] = "";
  $currentstream = array_merge(array("" => ""),$currentstream);
  $sexes = array(
		   "" => "",
		   "F" => "F",
		   "M" => "M",
    );
    
    $regilions = array(
		   "" => "",
		   "Pentecostal" => "Pentecostal",
		   "Protestant" => "Protestant",
		   "Catholic" => "Catholic",
		   "Moslem" => "Moslem",
    );
    
    $availabilitystatus = array(
		   "" => "",
		   "Present" => "Present",
		   "Absent" => "Absent",
    );
    
    $currentclass = array(
		   ""  => "",
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
		   "5" => "Senior Five",
		   "6" => "Senior Six",
    );?>
  <table>
      <tr class = "olevelresults">
      <td>
      <?php
	  echo $this->Form->input('currentclass', array(
					'label' => 'Choose class',
					'options' => $currentclass,
					'selected' => ''));     
      ?>
      </td>
      <td>
      <?php
	  echo $this->Form->input('currentstream', array(
					'label' => 'Choose stream',
					'options' => $currentstream,
					'selected' => ""));     
      ?>
      </td>
      <td>
      <?php
	  echo $this->Form->input('sex', array(
					'label' => 'Gender(sex)',
					'options' => $sexes,
					'selected' => ''));
      ?>
      </td>
      <td>
      <?php
	  echo $this->Form->input('availabilitystatus', array(
					'label' => 'Present/Absent',
					'options' => $availabilitystatus,
					'selected' => ''));
      
      ?>
      </td>
      <td>
      <?php
	echo $this->Form->input('joiningdate', array(
	    'label' => 'Year of Joining',
	    'dateFormat' => 'Y',
	    'maxYear' => date('Y'),
	    'minYear' => date('Y') - 100,
	    'empty' => ' ',
	));      
      ?>
      </td>
      <td>
      <?php
	echo $this->Form->input('leavingdate', array(
	    'label' => 'Year of leaving',
	    'dateFormat' => 'Y',
	    'maxYear' => date('Y'),
	    'minYear' => date('Y') - 100,
	    'empty' => ' ',
	));      
      ?>
      </td>
      </tr>
      <tr class = "olevelresults">
      <td>
      <?php
	  echo $this->Form->input('religion', array(
					'label' => 'Religion',
					'options' => $regilions,
					'selected' => ''));
      ?>
      </td>
      <td>
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
  <?php

	
	
  ?>
  
  </fieldset><?php
  echo "</span>";
  echo $this->Form->end(__('Search'));
?>
<br/>
<?php   echo $this->Html->link(
		    'Add O-level',
		     array('action' => 'add_olevel')
		     );?>
	    <?php   echo $this->Html->link(
		    'Add A-level',
		     array('action' => 'add_alevel')
		     );
?>
<br/>
<table>
    <tr>
	<td><?php //echo $this->Html->link('Home', array('controller' => 'Users','action' => 'loginhome'));?></td>
	<td><?php //echo $this->Html->link('Add New', array('action' => 'add_olevel')); ?></td>
    </tr>
</table>
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
    <?php
	//loop through the whole array of the result set that has been obtained to extract the 
	//student ids of the records selected
	$array_of_ids = array();
	foreach($students as $student){
	
	    array_push($array_of_ids, intval($student['Student']['id']));
	
	}
    ?>
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
				     array('action' => 'edit', $student['Student']['id']/*,$array_of_ids*/)
				     );
		/*echo $this->Form->postLink(
					'Edit ',
					array('action' => 'edit', $student['Student']['id'])//,
					//array('confirm' => 'This action will delete this record parmanently, Are you sure you want to continue?')
					    );*/
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
    </div> -->
    <script>
   
	
	    //$("#StudentShowextracriterea_").click(function(e) {
	    $("#StudentShowextracriterea").change(function(e) {
		if(document.getElementById('StudentShowextracriterea').checked == true){
		
		    
		    document.getElementById("extrasearchcriterea").classList.remove('hide');
		
		}else{
		
		    
		    document.getElementById("extrasearchcriterea").classList.add("hide");
		
		}
	    });
 
    
    </script>
    