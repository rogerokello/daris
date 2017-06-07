<!-- <div class="olevelcompulsorysubjects form"> -->
<?php //print_r($selectedoptions); ?>
<?php echo $this->Form->create('Olevelcompulsorysubject'); ?>
	<fieldset class="sectiondefinition1">
		<legend class="sectiondefinition"><?php echo __('Edit Compulsory Subject(s) for a class'); ?></legend>
	<?php
	
		$year_options = array(date('Y') => date('Y'));
		$year_range = range((date('Y') - 10),(date('Y') - 1));
		rsort($year_range); 
		    
		foreach ($year_range as $ayear){
		    $year_options[$ayear] = $ayear;
		}
	
		echo $this->Form->input('year',array(
					'label' => 'Year',
					'options' => $year_options,
					//'selected' => date('Y')
					));
					
					
		$classes = array(
		   "1" => "Senior One",
		   "2" => "Senior Two",
		   "3" => "Senior Three",
		   "4" => "Senior Four",
		);
		
		echo $this->Form->input('class', array(
					    'label' => "Choose a class",
					    'options' => $classes,
					    //'selected' => '1'
					));
					
					
		$compulsorysubjects = $subjectsdoneintheschool;
		
		echo $this->Form->input('compulsorysubjects', array(
			'label' => "Choose Subjects",
			'options' => $compulsorysubjects,
			'multiple' => 'checkbox',
			'selected' => $selectedoptions
		
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
<!-- </div> -->
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>

		<li><?php //echo $this->Html->link(__('List Olevelcompulsorysubjects'), array('action' => 'index')); ?></li>
	</ul>
</div>
-->

