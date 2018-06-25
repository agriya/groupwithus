<?php /* SVN: $Id: view.ctp 54451 2011-05-24 12:26:17Z arovindhan_144at11 $ */  ?>
<h2 class="ribbon-title clearfix">
		<span class="ribbon-left">
			<span class="ribbon-right">
				<span class="ribbon-inner">
					<?php echo !empty($user['UserProfile']['first_name'])? ucfirst($this->Html->cText($user['UserProfile']['first_name'], false).__l(' ').$user['UserProfile']['last_name']):ucfirst($this->Html->cText($user['User']['username'], false)); ?>
				</span>
			</span>
		</span>
	</h2>
<div class="users view">
	 <div class="clearfix users-view-block">
	 <?php if (Configure::read('user.is_show_user_statistics')): ?>
		<div class="clearfix grid_7">
			<div class="js-responses">
				<?php if (Configure::read('user.is_show_referred_friends') && Configure::read('referral.referral_enable')) {?>
				<dl class="list statistics-list shadow clearfix">
					<dt><?php echo __l('Referred Users');?></dt>
						<dd>(<?php echo $this->Html->cInt($statistics['referred_users']);?>)</dd>
				 </dl>
					<?php } ?>
					<?php if (Configure::read('user.is_show_friend') && Configure::read('friend.is_enabled')) {?>
				 <dl class="list statistics-list shadow clearfix">
					<dt><?php echo __l('Friends');?></dt>
						<dd>(<?php echo $this->Html->cInt($statistics['user_friends']);?>)</dd>	
				 </dl>
					<?php } ?>	
					<?php if (Configure::read('user.is_show_item_purchased')) {?>
				 <dl class="list statistics-list shadow clearfix">
					<dt><?php echo __l('Item Purchased');?></dt>
						<dd>(<?php echo $this->Html->cInt($statistics['item_purchased']);?>)</dd>
			      </dl>
					<?php } ?>	
		  	</div>
		</div>	
	<?php endif; ?>
	<div class="user-avatar user-view-image grid_12">
                        <?php
                            $current_user_details = array(
								'username' => $user['User']['username'],
								'user_type_id' =>  $user['User']['user_type_id'] ,
								'id' =>  $user['User']['id'],
								'fb_user_id' => $user['User']['fb_user_id']
							);
							?>
	                  <?php
    						$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($user['User']['id']);
    						echo $this->Html->getUserAvatarLink($user['User'], 'big_thumb'); ?>

	 </div>
	 </div>
	 <?php if ($user['User']['id'] != $this->Auth->user('id') && $this->Auth->sessionValid() && empty($friend) && $this->Html->isAllowed($this->Auth->user('user_type_id')) && Configure::read('friend.is_enabled')): ?>
		<div class="grab-block user-grab-block clearfix">
			<div class="reserve-now sold-green">
				<?php echo $this->Html->link(__l('Grab With Me'), array('controller' => 'user_friends', 'action' => 'add', $user['User']['username']), array('title' => __l('Grab With Me'))); ?>
				<span><?php echo __l('To get notified when grab item'); ?></span>
			</div>
		</div>
	<?php endif; ?>
	 <div class="clearfix viewpage-content">
	 <?php if(!empty($user['UserProfile'])){ ?>
	   <div class="other-info-content grid_10">
	   <h3><?php echo __l('Other info');?></h3>
		<dl class="list merchant-list clearfix round-5">
        <?php if($user['UserProfile']['created'] != '0000-00-00 00:00:00'){ ?>
			<dt><?php echo __l('Member Since');?></dt>
			<dd><?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?></dd>
		<?php if(!empty($user['UserProfile']['home_town']) ): ?>
			<dt><?php echo __l('Home Town');?></dt>
			<dd><?php echo $this->Html->cText($user['UserProfile']['home_town'],false);?></dd>
		<?php endif; ?>
		<?php if(!empty($user['UserProfile']['interesting_fact']) ): ?>
			<dt><?php echo __l('Interesting Fact');?></dt>
			<dd><?php echo nl2br($this->Html->cText($user['UserProfile']['interesting_fact']));?></dd>
		<?php endif; ?>
			<?php if(!empty($user['UserJob'])):?>
			
			<?php foreach($user['UserJob'] as $userjob){
			?>
				<dt><?php echo __l('Company');?></dt>
					<dd><?php echo $this->Html->cText($userjob['Company']['name']);?></dd>
				<dt><?php echo __l('Position');?></dt>
					<dd><?php echo $this->Html->cText($userjob['position']);?></dd>
			<? }?>
		
			<?php endif; ?>



			<?php if(!empty($user['UserSchool'])):?>
			<?php foreach($user['UserSchool'] as $userSchool){
			?>
			<dt><?php echo __l('College');?></dt>
					<dd><?php echo $this->Html->cText($userSchool['College']['name']);?></dd>
					<dt><?php echo __l('Degree');?></dt>
					<dd><?php echo $this->Html->cText($userSchool['UserSchoolDegree']['name']).','.$user['UserSchool'][0]['year'] ;?></dd>
			<? }?>
			
			<?php endif; ?>
		<?php } ?>
        <?php
			if (Configure::read('Profile-is_show_name')  || $this->Auth->user('user_type_id') == ConstUserTypes::Admin):
				$name = array();
				if(!empty($user['UserProfile']['first_name'])):
					$name[]= $this->Html->cText($user['UserProfile']['first_name']);
				endif;
				if(!empty($user['UserProfile']['middle_name'])):
					$name[]= $this->Html->cText($user['UserProfile']['middle_name']);
				endif;
				if(!empty($user['UserProfile']['last_name'])):
					$name[]= $this->Html->cText($user['UserProfile']['last_name']);
				endif;
				if($name):
				?>
				<dt><?php echo __l('Name');?></dt>
					<dd>
					<?php echo implode(' ',$name);?>

					</dd>

				<?php
				endif;
			endif;
		?>
		<?php
			if (Configure::read('Profile-is_show_gender')  || $this->Auth->user('user_type_id') == ConstUserTypes::Admin):
				if (!empty($user['UserProfile']['Gender']['name'])):
		?>
					<dt><?php echo __l('Gender');?></dt>
						<dd><?php echo $this->Html->cText($user['UserProfile']['Gender']['name']);?></dd>
		<?php
				endif;
			endif;
		?>
		<?php
			if ($this->Auth->user('username')== $user['User']['username'] || $this->Auth->user('user_type_id') == ConstUserTypes::Admin):
				if (!empty($user['UserProfile']['paypal_account'])):
		?>
					<dt><?php echo __l('Paypal Account');?></dt>
						<dd><?php echo $this->Html->cText($user['UserProfile']['paypal_account']);?></dd>
		<?php
				endif;
			endif;
		?>
		<?php
			if (!empty($user['UserProfile']['language_id'])):
		?>
				<dt><?php echo __l('Language');?></dt>
					<dd><?php echo $this->Html->cText($user['UserProfile']['Language']['name']);?></dd>
		<?php
			endif;
		?>
	</dl>
	<?php if(!empty($user['UserInterest'])): ?>
		<div class='interest other-info-content'>
			<h3><?php echo __l('Interest') . ' (' . count($user['UserInterest']) . ')'; ?></h3>
			<div class="view-interest-block">
			<ul class="merchant-namelist clearfix">
				<?php foreach($user['UserInterest'] as $user_interest):?>
					<li><?php  echo $this->Html->link($this->Html->cText($user_interest['name'], false), array('controller' => 'user_interest', 'action' => 'view', $user_interest['slug']), array('title' => $this->Html->cText($user_interest['name'], false), 'escape' => false)); ?></li>
				<?php endforeach; ?>
			</ul>
			</div>
		</div>
	<?php endif; ?>
	 </div>
	 <div class="about-content round-5 other-info-content grid_9">
	    <h3><?php echo __l('About Me');?></h3>
        <div class="about-content-block round-5">
      	   <?php if(!empty($user['UserProfile']['about_me'])){ ?>
    	        <?php if(!empty($user['UserProfile']['about_me'])): ?>
    			<p><?php echo nl2br($this->Html->cText($user['UserProfile']['about_me']));?></p>
    		  <?php endif; ?>
            <?php } ?>
    	    <?php if(!empty($user['UserProfile']['url'])): ?>
    		<dl class="list clearfix">
    		  <dt><?php echo __l('Website'); ?>
    		  <dd> <?php echo $this->Html->cText($user['UserProfile']['url'],false); ?></dd>
    		</dl>
    		<?php endif; ?>
                <?php }?>
            </div>
 		</div>
	</div>
	<div class="js-tabs user-view-tabs">
        <ul class="clearfix">
					<?php if ($this->Auth->user('id') and ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant || Configure::read('user.is_merchant_actas_normal_user')) || $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
				<li><?php echo $this->Html->link(__l('Comments'), '#tabs-1');?></li>
			<?php endif; ?>
            <?php if($this->Auth->user('id')): ?>
                <?php //if (Configure::read('user.is_show_user_intrests')): ?>
                <?php //endif; ?>
				<?php if (Configure::read('user.is_show_item_purchased')): ?>
                    <li><?php echo $this->Html->link(__l('Item Purchased'), array('controller' => 'item_users', 'action' => 'user_items', 'user_id' =>  $user['User']['id']),array('title' => __l('Items Purchased'))); ?></li>
                <?php endif; ?>
                <?php if (Configure::read('user.is_show_friend') && Configure::read('friend.is_enabled')): ?>
                    <li><?php echo $this->Html->link(__l('Friends'), array('controller' => 'user_friends', 'action' => 'myfriends', 'user_id' =>  $user['User']['id'], 'status' => ConstFriendRequestStatus::Approved),array('title' => __l('Friends'))); ?></li>
                <?php endif; ?>
                <?php if (Configure::read('user.is_show_referred_friends') && (Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer) && Configure::read('referral.referral_enable')): ?>
                    <li><?php echo $this->Html->link(__l('Referred Users'), array('controller' => 'users', 'action' => 'referred_users', 'user_id' =>  $user['User']['id']),array('title' => __l('Referred Users'))); ?></li>
                <?php endif; ?>
              <?php endif; ?>
        </ul>
		<?php if ($this->Auth->user('id') and ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant || Configure::read('user.is_merchant_actas_normal_user')) || $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
			<div id='tabs-1'>
				<div class="js-corner round-5">
					<div class="js-responses">
						<?php echo $this->element('user_comments-index', array('username' => $user['User']['username'], 'config' => 'sec', 'key' => $user['User']['username']));?>
					</div>
				</div>
                <?php if($this->Auth->user('id') and $this->Auth->user('id')!= $user['User']['id']): ?>
                    <div class="js-corner round-5">
                        <h2><?php echo __l('Add Your comments'); ?></h2>
                        <?php echo $this->element('../user_comments/add');?>
                    </div>
                <?php endif; ?>
			</div>
		<?php endif; ?>
    </div>
</div>