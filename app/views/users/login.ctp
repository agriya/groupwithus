<div class="users pages form register-block <?php echo !empty($this->request->data['User']['is_requested']) ? 'js-login-response ajax-login-block' : ''; ?>">
<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('Login'); ?></span>
</span>
</span>
</h2>
    <div class="clearfix">
	<?php if (!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && empty($this->request->data['User']['is_requested'])): ?>
    
	<div class="openid-block multiple-logins clearfix">
        <h5><?php echo __l('Sign In using: '); ?></h5>
		<ul class="open-id-list clearfix">
			<li class="facebook">
				 <?php if(Configure::read('facebook.is_enabled_facebook_connect')):  ?>
					<?php echo $this->Html->link(__l('Sign in with Facebook'), array('controller' => 'users', 'action' => 'login','type'=>'facebook'), array('title' => __l('Sign in with Facebook'), 'escape' => false)); ?>
				 <?php endif; ?>
			</li>
			<?php if(Configure::read('foursquare.is_enabled_foursquare_connect')):?>
				<li class="foursquare"><?php echo $this->Html->link(__l('Sign in with Foursquare'), array('controller' => 'users', 'action' => 'login',  'type'=> 'foursquare', 'admin'=>false), array('class' => 'Foursquare', 'title' => __l('Sign in with Foursquare')));?></li>
			<?php endif;?>
			<?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
				<li class="twitter"><?php echo $this->Html->link(__l('Sign in with Twitter'), array('controller' => 'users', 'action' => 'login',  'type'=> 'twitter', 'admin'=>false), array('class' => 'Twitter', 'title' => __l('Sign in with Twitter')));?></li>
			<?php endif;?>
			<?php if(Configure::read('user.is_enable_yahoo_openid')):?>
				<li class="yahoo"><?php echo $this->Html->link(__l('Sign in with Yahoo'), array('controller' => 'users', 'action' => 'login', 'type'=>'yahoo'), array('title' => __l('Sign in with Yahoo')));?></li>
			<?php endif;?>
			<?php if(Configure::read('user.is_enable_gmail_openid')):?>
				<li class="gmail"><?php echo $this->Html->link(__l('Sign in with Gmail'), array('controller' => 'users', 'action' => 'login', 'type'=>'gmail'), array('title' => __l('Sign in with Gmail')));?></li>
			<?php endif;?>
			<?php if(Configure::read('user.is_enable_openid')):?>
				<li class="openid"><?php 	echo $this->Html->link(__l('Sign in with Open ID'), array('controller' => 'users', 'action' => 'login','type'=>'openid'), array('class'=>'','title' => __l('Sign in with Open ID')));?></li>
			<?php endif;?>
		</ul>
    </div>

    <?php endif; ?>
    </div>
	<?php
		$formClass = !empty($this->request->data['User']['is_requested']) ? 'js-ajax-login' : '';
		echo $this->Form->create('User', array('action' => 'login', 'class' => 'normal '.$formClass));
		echo $this->Form->input(Configure::read('user.using_to_login'));
		echo $this->Form->input('passwd', array('label' => __l('Password')));
		if(!empty($this->request->data['User']['is_requested'])) {
			echo $this->Form->input('is_requested', array('type' => 'hidden'));
		}
	?>
	<?php echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.'))); ?>
	<div class="fromleft">
		<?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false),array('title' => __l('Forgot your password?'))); ?>
		<?php if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && empty($this->request->data['User']['is_requested'])): ?> |
			<?php  echo $this->Html->link(__l('Signup') , array('controller' => 'users',	'action' => 'register'),array('title' => __l('Signup'))); ?>
		<?php endif; ?>
	</div>
	<?php
		@$_GET['f'] = (!empty($this->request->data['User']['is_requested']) ? $_GET['url'] : $_GET['f']);  // Fix for gift card redeem redirect
		$f = (!empty($_GET['f'])) ? $_GET['f'] : ((!empty($this->request->data['User']['f'])) ? $this->request->data['User']['f'] : (($this->request->params['controller'] != 'users' && ($this->request->params['action'] != 'login' && $this->request->params['action'] != 'admin_login')) ? $this->request->url : ''));
			if (!empty($f)):
				echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
			endif;
	?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Login')); ?>
		<?php if(!empty($this->request->data['User']['is_requested']) && $this->request->data['User']['is_requested']):  ?>
			<div class="cancel-block js-cancel-block">
				<?php echo $this->Html->link(__l('Cancel'), '#', array('title' => __l('Never Mind'),'class' => "cancel-button js-toggle-show {'container':'js-login-message', 'hide_container':'js-login-form'}"));?>
			</div>
		<?php endif; ?>
	</div>
	<?php echo $this->Form->end(); ?>

</div>