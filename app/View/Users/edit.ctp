<?php echo $this->Form->create('User'); ?>
    <fieldset class="sectiondefinition1">
	<legend class="sectiondefinition">Edit User Details</legend>
        <?php 
		echo $this->Form->hidden('id', array('value' => $this->data['User']['id']));
		echo $this->Form->input('username');
		echo $this->Form->input('email',array('label' => 'Email address', 'maxLength' => 255, 'type'=>'email'));
		echo $this->Form->input('previous_password',array('label' => 'Previous Password ', 'maxLength' => 255, 'type'=>'password','required' => 0));
		echo $this->Form->input('password_update', array('label' => 'New Password ', 'maxLength' => 255, 'type'=>'password','required' => 0));
		echo $this->Form->input('password_confirm_update', array('label' => 'Confirm New Password', 'maxLength' => 255, 'title' => 'Confirm New password', 'type'=>'password','required' => 0));
		
		if(AuthComponent::user('role') == "admin"){
		      echo $this->Form->input('role', array(
			  'options' => array( 'admin' => 'Admin', 'teacher' => 'Teacher')
		      ));
		}
		
		echo $this->Form->submit('Edit User', array('class' => 'form-submit',  'title' => 'Click here to add the user') ); 
		
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
