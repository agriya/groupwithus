<?php /* SVN: $Id: $ */ ?>
<div class="admin-top-block clearfix">
			<div class="admin-tm">
<ul class="dashboard-menu admin-sub-menu clearfix">
	<li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard', 'admin' => false), array('title'=>__l('Dashboard'), 'escape' => false)); ?></li>
	<li class="active"><?php echo $this->Html->link(__l('Inbox'), array('controller' => 'messages', 'action' => 'index', 'admin' => false), array('title'=>__l('Inbox'),'escape' => false)); ?></li>
	<li><?php echo $this->Html->link(__l('Edit profile'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id'), 'admin' => false), array('title' => __l('Edit profile'), 'escape' => false)); ?></li>
	<li><?php echo $this->Html->link(__l('My Friends'), array('controller' => 'user_friends', 'action' => 'lst', 'admin' => false), array('title' => 'My Friends'));?></li>
	<li><?php echo $this->Html->link(__l('Invite Friends'), array('controller' => 'contacts', 'action' => 'invite', 'admin' => false), array('title' => __l('Invite Friends'), 'escape' => false));?></li>
</ul>
</div></div>
<div class="clearfix message-section-left grid_5">
<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
</div>
<div class="clearfix message-section-right grid_14">
<div class="messages-settings">
	<h2 class="title"><?php echo __l('General Settings'); ?> </h2>
	<div id="message-settings">
		<?php
			echo $this->Form->create('Message', array('action' => 'settings', 'class' => 'normal clearfix  js-form-settings'));
			echo $this->Form->input('UserProfile.message_page_size', array('label'=>__l('Message Page Size'),'info' => __l('Show conversations per page')));
			echo $this->Form->input('UserProfile.message_signature', array('type' => 'textarea', 'label'=>__l('Message Signature')));
			echo $this->Form->submit(__l('Update'));
			echo $this->Form->end();
		?>
	</div>
</div>
</div>