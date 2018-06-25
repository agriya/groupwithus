<?php /* SVN: $Id: $ */ ?>
<div class="blockedUsers form">
<?php echo $this->Form->create('BlockedUser', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $this->Html->link(__l('Blocked Users'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Blocked User');?></legend>
	<?php
		echo $this->Form->input('user_id',array('label' => __l('User')));
		echo $this->Form->input('blocked_user_id',array('label' => __l('Blocked User')));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
