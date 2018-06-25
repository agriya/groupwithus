<div class="dashboard-block">
<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Linked Accounts'); ?></span></span></span></h2>
<h3><?php echo __l('You can connect with').' '.Configure::read('site.name').' '.__l('using multiple connect.'); ?></h3>
<?php echo $this->Form->create('User', array('action' => 'profile_image', 'class' => 'normal',  'enctype' => 'multipart/form-data'));
      
	  echo $this->Form->input('User.id', array('type' => 'hidden'));
	  unset($profileimages[ConstProfileImage::Upload]);
?>
<div class="photo-upload-block">
<div class="photo-options">
<?php //echo $this->Form->input('User.profile_image_id', array('type' => 'radio', 'options' => $profileimages, 'legend' => false)); ?>
</div>
<div class="clearfix avatar-options">
<div class="dashboard-inner-block">
		<?php if(!empty($this->request->data['User']['twitter_avatar_url'])):
			echo $this->Html->image($this->request->data['User']['twitter_avatar_url'], array('title' => __l('Twitter Profile Image')));		
		?>
		<div class="connect-link-block clearfix">
		<?php
			echo __l('Connected with Twitter');
		?>
		</div>
		<?php

		else: ?>
		<div class="connect-link-block clearfix">
			<?php
        	   echo $this->Html->link(__l('Connect'), array('controller' => 'users', 'action' => 'connect', $this->request->data['User']['id'], 'type' => 'twitter'), array('escape' => false)). ' '. __l('with').' '.__l('Twitter');
        	?>
		</div>
		<?php endif;?>			  
</div>
<div class="dashboard-inner-block">
		<?php if(!empty($this->request->data['User']['fb_user_id'])):
			echo $this->Html->image('http://graph.facebook.com/'.$this->request->data['User']['fb_user_id'].'/picture?type=small', array('title' => __l('Facebook Profile Image')));
		?>
		<div class="connect-link-block clearfix">
		<?php
			echo __l('Connected with Facebook');
		?>
		</div>
		<?php
		else: ?>
		<div class="connect-link-block clearfix">
			<?php
			   echo $this->Html->link(__l('Connect'), $fb_login_url). ' '. __l('with').' '.__l('Facebook');
			?>
		</div>
		<?php endif;?>				  
</div>
</div>
</div>
<?php echo $this->Form->end(); ?>
</div>