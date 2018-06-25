<?php /* SVN: $Id: $ */ ?>
<div class="blockedUsers form">
<?php echo $this->Form->create('BlockedUser', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Blocked Users'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit Blocked User');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id',array('label' => __l('user')));
		echo $this->Form->input('blocked_user_id',array('label' => __l('Blocked user')));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
