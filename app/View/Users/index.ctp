<?php ?>
<h1 class="sectiondefinition1">Users</h1>
<table>
    <thead>
		<tr>
			<th><?php echo $this->Paginator->sort('username', 'Username');?>  </th>			
			<th><?php echo $this->Paginator->sort('created', 'Created');?></th>
			<th><?php echo $this->Paginator->sort('modified','Last Update');?></th>
			<th><?php echo $this->Paginator->sort('role','Role');?></th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php $numberofusers = sizeof($users);     ?>
		</tr>
		<?php foreach($users as $user): ?>				
			
			<?php if(AuthComponent::user('role') == "admin") { ?> 
			<td><?php echo $this->Html->link( $user['User']['username']  ,   array('action'=>'edit', $user['User']['id']),array('escape' => false) );?></td>
			<td><?php echo $this->Time->niceShort($user['User']['created']); ?></td>
			<td><?php echo $this->Time->niceShort($user['User']['modified']); ?></td>
			<td><?php echo $user['User']['role']; ?></td>
			<td>
			<?php echo $this->Html->link("Edit ",   array('action'=>'edit', $user['User']['id']) ); ?>
			<?php	
			    if( $numberofusers >= 2 ){
			    
				//echo " | ".$this->Html->link(" Delete", array('action'=>'delete', $user['User']['id']));
				
				echo $this->Form->postLink(
					'| Delete',
					array('action' => 'delete', $user['User']['id']),
					array('confirm' => 'This action will delete this user parmanently, Are you sure you want to continue?')
					    );
			    
			    } else {
			    
				echo "";
			    
			    }
			?>
			<?php }else { 
			
			    if(AuthComponent::user('username') == $user['User']['username']){
				?>
				<td><?php echo $this->Html->link( $user['User']['username']  ,   array('action'=>'edit', $user['User']['id']),array('escape' => false) );?></td>
				<td><?php echo $this->Time->niceShort($user['User']['created']); ?></td>
				<td><?php echo $this->Time->niceShort($user['User']['modified']); ?></td>
				<td><?php echo $user['User']['role']; ?></td>
				<td>
				<?php echo $this->Html->link("Edit ",   array('action'=>'edit', $user['User']['id']) ); ?>
				<?php
			    }else{
			    
				continue;
			    
			    }
			
			}
			?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php unset($user); ?>
	</tbody>
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
<?php //echo $this->Paginator->prev('<< ' . __('previous ', true), array(), null, array('class'=>'disabled'));?>
<?php //echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
<?php //echo $this->Paginator->next(__(' next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
