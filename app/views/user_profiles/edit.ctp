<div class="userProfiles form js-responses">
	<div class="main-content-block js-corner round-5">
		  <?php if($this->request->params['action'] == 'my_account') { ?>
	    <div class="js-tabs">
			<ul class="clearfix">
				<li><?php echo $this->Html->link(__l('My Profile'), '#my-profile'); ?></li>
				<?php if(!$this->Auth->user('fb_user_id') && !$this->Auth->user('is_openid_register')){?>
				    <li><?php  echo $this->Html->link(__l('Change Password'),array('controller'=> 'users', 'action'=>'change_password'),array('title' => __l('Change Password'))); ?></li>
				<?php } ?>
			</ul>
		</div>
		<?php } ?>
		<div id='my-profile'>
		<?php if ($this->Auth->user('id') == $this->request->data['User']['id']) : ?>
			<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo sprintf(__l('Edit Profile - %s'), $this->request->data['User']['username']); ?></span></span></span></h2>
				<?php endif; ?>
			<div class="form-blocks  js-corner round-5">
				<?php echo $this->Form->create('UserProfile', array('action' => 'edit', 'class' => 'normal js-ajax-form', 'enctype' => 'multipart/form-data'));?>
					<fieldset class="form-block">
						<legend><?php echo __l('Personal'); ?></legend> 
						<div class="profile-image">
							<?php 
								$user_details = array(
									'username' => $this->request->data['User']['username'],
									'user_type_id' =>  $this->request->data['User']['user_type_id'],
									'id' =>  $this->request->data['User']['id'],
									'fb_user_id' =>  $this->request->data['User']['fb_user_id'],
									'UserAvatar' => $this->request->data['UserAvatar']
								);
								echo $this->Html->getUserAvatarLink($user_details, 'normal_thumb').' ';
							?>
							<p>
								<?php  echo $this->Html->link(__l('Change Image'),array('controller' => 'users', 'action' => 'profile_image', $this->request->data['User']['id'], 'admin' => false), array('title' => __l('Change Image'))); ?>	
							</p>
						</div>
						<?php
							if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
								echo $this->Form->input('User.id',array('label' => __l('User')));
							endif;
							if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
								echo $this->Form->input('User.username');
							endif;
							echo $this->Form->input('first_name',array('label' => __l('First Name')));
							echo $this->Form->input('last_name',array('label' => __l('Last Name')));
							echo $this->Form->input('gender_id', array('empty' => __l('Please Select'),'label' => __l('Gender')));
							if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
								echo $this->Form->input('User.email',array('label' => __l('Email')));
							endif;
						?>
						<div class="date-time-block clearfix">
						<div class="input date-time required">
							<div class="js-datetime">
								<?php echo $this->Form->input('dob', array('label' => __l('DOB'),'empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
							</div>
						</div>
                        </div>
							<?php
								if(Configure::read('site.currency_symbol_place') == 'left'):
									$currecncy_place = 'between';
								else:
									$currecncy_place = 'after';
								endif;	
							?>		
						<?php echo $this->Form->input('about_me', array('label' => __l('About Me'))); ?>
						<?php $currecncy_place = '<span class="currency">'.Configure::read('site.currency'). '</span>' ; ?>
						
					</fieldset>
					<fieldset class="form-block">
						<legend><?php echo __l('Address'); ?></legend> 
						<?php
                            echo $this->Form->input('home_town', array('label' => __l('Hometown')));
                            echo $this->Form->input('city_id', array('empty' => __l('Please Select'),'label' => __l('Primarily will grab in')));
						?>
					</fieldset>
					<fieldset class="form-block">
						<legend><?php echo __l('Settings'); ?></legend> 
						<?php echo $this->Form->input('is_auto_approve_friend_request', array('label' => __l('Auto approve friend request?'))); ?>
					</fieldset>
					<fieldset class="form-block">
						<legend><?php echo __l('Other'); ?></legend>
						<?php
							if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
								if($this->request->data['User']['id'] != ConstUserIds::Admin):
									echo $this->Form->input('User.is_active', array('label' => __l('Active')));
								endif;
								echo $this->Form->input('User.is_email_confirmed', array('label' => __l('Email confirmed')));
							endif;
							echo $this->Form->input('interesting_fact', array('label' => __l('Interesting Fact')));
							echo $this->Form->input('url', array('label' => __l('Personal Website')));
						?>
					</fieldset>
					<fieldset  class="form-block">
						<h3 class=""><?php echo __l('Regional'); ?></h3>
						<?php echo $this->Form->input('language_id', array('empty' => __l('Please Select'),'label' => __l('Language'), 'info'=>__l('This will be the default site languge after logged in')));?>				
                  </fieldset>
				  <div class="submit-block clearfix">
                    <?php
                    	echo $this->Form->submit(__l('Update'));
                    ?>
                    </div>
                <?php
                	echo $this->Form->end();
                ?>
			
			</div>
		</div>
	</div>
</div>