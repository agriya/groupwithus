<?php /* SVN: $Id: $ */ ?>
<div class="js-responses">
	<div class="userNotifications form">
	<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('My Notifications'); ?></span>
</span>
</span>
</h2>
		<?php echo $this->Form->create('UserNotification', array('action'=>'edit','class' => 'normal js-ajax-form {"container" : "js-responses"}'));?>
		<fieldset>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->data['UserNotification']['user_id']));
				echo $this->Form->input('when_user_message_me', array('label' => __l('When user message me')));
				echo $this->Form->input('when_user_comment_me', array('label' => __l('When user comment me')));
				echo $this->Form->input('when_user_follow_or_request_to_follow_me', array('label' => __l('When user follow or request to follow me')));
				echo $this->Form->input('when_user_booked_an_item_followed_by_me', array('label' => __l('When user booked an item followed my me')));
				echo $this->Form->input('when_new_item_was_added_from_my_interests', array('label' => __l('When new item was added from my interests groups')));
				echo $this->Form->input('when_user_registered_from_my_invitation', array('label' => __l('When user registered from my invitation')));
				echo $this->Form->input('when_user_book_an_item_after_your_invitation', array('label' => __l('When user book an item after your invitation')));
			?>
		</fieldset>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Update'));?>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>