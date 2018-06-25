<div class="js-tabs">
	<ul class="clearfix">
		<li><?php echo $this->Html->link(__l('My Profile'), array('controller' => 'user_profiles', 'action' => 'edit', $user_id, 'admin' => false), array('title' => 'My Profile', 'rel'=> '#Request_API_Key')); ?></li>
		<?php $is_show_credit_cards = $this->Html->isAuthorizeNetEnabled(); ?>
		<?php if (!empty($is_show_credit_cards)): ?>
			<li><?php echo $this->Html->link(__l('Credit Cards'), array('controller' => 'user_payment_profiles', 'action' => 'index', 'admin' => false), array('title' => 'Credit Cards', 'rel' => '#Credit_cards')); ?></li>
		<?php endif; ?>
		<?php if (!$this->Auth->user('is_twitter_register') && !$this->Auth->user('is_facebook_register') && !$this->Auth->user('is_gmail_register') && !$this->Auth->user('is_yahoo_register') && !$this->Auth->user('is_foursquare_register') && !$this->Auth->user('is_openid_register')) {?>
			<li><?php  echo $this->Html->link(__l('Change Password'),array('controller'=> 'users', 'action'=>'change_password'),array('title' => 'Change Password', 'rel' => '#Change_Password')); ?></li>
		<?php } ?>
		<li><?php echo $this->Html->link(__l('Job Info'), array('controller' => 'user_jobs', 'action' => 'index', 'admin' => false), array('title' => 'Job Info', 'rel'=> '#Job_Info')); ?></li>
		<li><?php echo $this->Html->link(__l('School Info'), array('controller' => 'user_schools', 'action' => 'index', 'admin' => false), array('title' => 'School Info', 'rel'=> '#School_Info')); ?></li>
	</ul>
</div>