<!-- app/View/Users/add.ctp -->
<?php echo $this->Form->create('User');?>
    <fieldset class="sectiondefinition1">
	<legend class="sectiondefinition">Add New User</legend>
        <?php echo $this->Form->input('username');
	      echo $this->Form->input('email',array('label' => 'Email address', 'maxLength' => 30, 'type'=>'email'));
	      echo $this->Form->input('password');
	      echo $this->Form->input('password_confirm', array('label' => 'Confirm Password', 'maxLength' => 30, 'title' => 'Confirm password', 'type'=>'password'));
	      echo $this->Form->input('role', array(
		  'options' => array( 'admin' => 'Admin', 'teacher' => 'Teacher')
	      ));
	
	    echo $this->Form->submit('Add User', array('class' => 'form-submit',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>