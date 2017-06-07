<div class="olevelcompulsorysubjects view">
<h2><?php echo __('Olevelcompulsorysubject'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($olevelcompulsorysubject['Olevelcompulsorysubject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Year'); ?></dt>
		<dd>
			<?php echo h($olevelcompulsorysubject['Olevelcompulsorysubject']['year']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Class'); ?></dt>
		<dd>
			<?php echo h($olevelcompulsorysubject['Olevelcompulsorysubject']['class']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Compulsorysubjects'); ?></dt>
		<dd>
			<?php echo h($olevelcompulsorysubject['Olevelcompulsorysubject']['compulsorysubjects']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Olevelcompulsorysubject'), array('action' => 'edit', $olevelcompulsorysubject['Olevelcompulsorysubject']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Olevelcompulsorysubject'), array('action' => 'delete', $olevelcompulsorysubject['Olevelcompulsorysubject']['id']), array(), __('Are you sure you want to delete # %s?', $olevelcompulsorysubject['Olevelcompulsorysubject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Olevelcompulsorysubjects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Olevelcompulsorysubject'), array('action' => 'add')); ?> </li>
	</ul>
</div>
