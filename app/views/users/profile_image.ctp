<div class="dashboard-block">

<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Profile Image'); ?></span></span></span></h2>
<h3><?php echo __l('Choose your profile image'); ?></h3>
<?php echo $this->Form->create('User', array('action' => 'profile_image', 'class' => 'normal',  'enctype' => 'multipart/form-data'));
      
	  echo $this->Form->input('User.id', array('type' => 'hidden'));
?>
<div class="photo-upload-block clearfix">
<div class="photo-options">
<?php echo $this->Form->input('User.profile_image_id', array('type' => 'radio', 'options' => $profileimages, 'legend' => false)); ?>
</div>
<div class="clearfix avatar-options">
<div class="dashboard-inner-block">
		<?php if(!empty($this->request->data['User']['twitter_avatar_url'])):
			echo $this->Html->image($this->request->data['User']['twitter_avatar_url'], array('title' => __l('Twitter Profile Image')));		
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
		else: ?>
		<div class="connect-link-block clearfix">
			<?php
			   echo $this->Html->link(__l('Connect'), $fb_login_url). ' '. __l('with').' '.__l('Facebook');
			?>
		</div>
		<?php endif;?>				  
</div>
<div class="dashboard-inner-block dashboard-inner-block1 clearfix">
		<?php if(!empty($this->request->data['UserAvatar']) && !empty($this->request->data['UserAvatar']['id'])){
			echo $this->Html->showImage('UserAvatar', $this->request->data['UserAvatar'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['User']['username'], false)),'class' => 'upload-avatar', 'title' => $this->Html->cText($this->request->data['User']['username'], false)), null, array('inline' => false));
			}
		?>
        <h4><?php echo __l('Upload'); ?></h4>
		<?php echo $this->Form->input('UserAvatar.filename', array('type' => 'file','size' => '20', 'label' => false,'class' =>'browse-field')); ?>
		
</div>

</div>
<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Update'));?>
</div>
</div>
<?php echo $this->Form->end(); ?>
</div>