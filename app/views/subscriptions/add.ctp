<?php /* SVN: $Id: add.ctp 54697 2011-05-26 09:46:53Z aravindan_111act10 $ */ ?>
<?php
	if (empty($city_name)):
	if(!empty($this->request->params['named']['city'])):
		$tmp_city = $this->Html->getCityDetails($this->request->params['named']['city']);
		endif;
		$city_id = $tmp_city['City']['id'];
		$city_name = $tmp_city['City']['name'];
		$city_slug = $tmp_city['City']['slug'];
		$city_attachment = $tmp_city['Attachment'];
	endif;
?>
<?php if(empty($isAjax)): $isAjax=0; endif; ?>
<?php if(!$isAjax): ?>
<?php if(Configure::read('site.is_in_prelaunch_mode') && (!empty($this->request->params['named']['is_from_pages']) || $this->request->data['Subscription']['is_from_pages'])):?>
		<div class="form js-responses">
			<?php echo $this->Form->create('Subscription', array('id' => 'homeSubscriptionFrom', 'class' => 'normal js-ajax-form'));?>
				<?php echo $this->Form->input('email',array('id' => 'homeEmail', 'label' => __l('Enter your Email address:'))); ?>
				<span class="subcription-info-second">(<?php echo __l('We\'ll never share your e-mail address)');?></span>
				<?php echo $this->Form->input('city_id',array('id' => 'homeCityId', 'label' => __l('Choose your city:'), 'options' => $cities)); ?>
				<?php echo $this->Form->input('is_from_pages',array('type' => 'hidden', 'value' => (!empty($this->request->params['named']['is_from_pages']) ? $this->request->params['named']['is_from_pages'] : $this->request->data['Subscription']['is_from_pages']))); ?>
				<div class="submit-block clearfix">
					<?php echo $this->Form->submit(__l('Subscribe'));?>
				</div>
				<?php echo $this->Form->end(); ?>
		</div>
	<?php else:?>
		<?php if(preg_match('/subscribe/s',$this->request->url) && Configure::read('site.enable_three_step_subscription') && !$this->Auth->sessionValid() && empty($this->layoutPath)): ?>
			<div class="form">
			
			<?php echo $this->Form->create('Subscription', array('id' => 'homeSubscriptionFrom', 'class' => 'normal js-grouponpro_sub_form {Currentstep:'.$Currentstep.'}'));?>
				
					<div class="clearfix">
						<div class="js-step_one step-one js-form_step">
							<div class="step-content-info round-10">
							<div class="step-input-block">
							<?php echo $this->Form->input('city_id',array('id' => 'homeCityId', 'label' => __l('Choose your city:'), 'options' => $cities)); ?>				
							</div>
							<div class="js-buttons">
							<div class="clearfix">
								<?php echo $this->Form->submit(__l('Continue'), array('type'=>'button','id' => 'step_one', 'class' => 'js-button js-continue'));?>							
									<ul class="sign-in">
										<?php if(!$this->Auth->sessionValid()): ?>
										<li>
										   <?php echo $this->Html->link(__l('Sign in'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Sign in'),'class'=>'login-link'));?>
                                        </li>
                                            <?php elseif($this->Auth->user('user_type_id') == ConstUserTypes::User):?>
                                            <li>
                                            <?php echo $this->Html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
                                            </li>
                                        <?php elseif($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
                                            <li>
											<?php echo $this->Html->link(__l('My Items'), array('controller' => 'items', 'action' => 'index', 'merchant' => $merchant['Merchant']['slug'] ), array('title' => __l('My Items')));?>
                                            </li>
                                        <?php elseif($this->Auth->user('user_type_id') == ConstUserTypes::Admin):?>
                                            <li>
                                            <?php echo $this->Html->link(__l('Admin'), array('controller' => 'users' , 'action' => 'stats' , 'admin' => true), array('title' => __l('Admin'))); ?>
                                            </li>
										<?php endif;?>
                                        <?php if(configure::read('site.subscription_skip_option_enabled')):?>
                                            <li>
											<?php echo $this->Html->link(__l('Already Registered').'?', array('controller' => 'subscriptions', 'action' => 'skip'), array('title' => __l('Already Registered').'?', 'class'=>'login-link'));?>
                                            </li>
                                        <?php endif; ?>    
									</ul>
										</div>
							</div>
						</div>
						</div>
						<div class="js-step_two step-one js-form_step">
						<div class="step-content-info round-10">
						<div class="step-input-block">
							<?php echo $this->Form->input('email',array('id' => 'homeEmail', 'label' => __l('Enter your email address:'))); ?>	
							<p class="email_never_share"><?php echo __l("Don't worry, your email is safe and secure with us."); ?></p>
							</div>
								 <div class="clearfix">
									<?php echo $this->Form->submit(__l('Subscribe'));?>
							
									<ul class="sign-in">
										<?php if(!$this->Auth->sessionValid()): ?>
										<li>
											<?php echo $this->Html->link(__l('Sign in'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Sign in'),'class'=>'login-link')) ;?>
                                            </li>
                                            <?php elseif($this->Auth->user('user_type_id') == ConstUserTypes::User):?>
                                            <li>
                                            <?php echo $this->Html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
                                            </li>
                                        <?php elseif($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
                                            <li>
                                        	<?php echo $this->Html->link(__l('My Items'), array('controller' => 'items', 'action' => 'index', 'merchant' => $merchant['Merchant']['slug'] ), array('title' => __l('My Items')));?>
                                            </li>
                                        <?php elseif($this->Auth->user('user_type_id') == ConstUserTypes::Admin):?>
                                            <li>
                                            <?php echo $this->Html->link(__l('Admin'), array('controller' => 'users' , 'action' => 'stats' , 'admin' => true), array('title' => __l('Admin'))); ?>
                                            </li>
                                    	<?php endif;?>
                                         <?php if(configure::read('site.subscription_skip_option_enabled')):?>
                                        <li>
											<?php echo $this->Html->link(__l('Already Registered').'?', array('controller' => 'subscriptions', 'action' => 'skip'), array('title' => __l('Already Registered').'?', 'class'=>'login-link'));?>
                                         </li>
                                          <?php endif; ?>    
									</ul>
										</div>
						</div>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		<?php elseif(preg_match('/subscribe/s',$this->request->url) && empty($step) ): ?>
        <div class="pages">
        <div class="main-content-block">
		<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo $city_name ;?> <?php echo __l('Item of the Day'); ?></span>
</span>
</span>
</h2>
			<div class="form subscriptions-add">
				<?php echo $this->Form->create('Subscription', array('id' => 'homeSubscriptionFrom', 'class' => 'normal'));?>
					<h2 class="welcome-head"> <?php echo __l('Welcome to').' ';?><span><?php echo Configure::read('site.name'); ?></span></h2>
						<div class="subscriptions-content">
							<?php echo sprintf(__l('Every day, %s e-mails you one exclusive offer to do, see, taste, or experience something amazing in').' '.$city_name.' '.__l('at an unbeatable price.'),Configure::read('site.name')); ?>
						</div>
						
						<div class="subscriptions-content-form shadow round-10 clearfix">
						<div class="signup-content"><?php echo __l('Sign up now for free, and prepare to discover') . ' ' . $city_name . ' ' . __l('at 40% to 90% off! '); ?></div>
						<div class="clearfix">
							<?php echo $this->Form->input('email',array('id' => 'homeEmail', 'label' => __l('Enter your Email address:'))); ?>
							<?php echo $this->Form->input('city_id',array('id' => 'homeCityId', 'label' => __l('Choose your city:'), 'options' => $cities)); ?>
								<div class="clearfix submit-block">
							<?php echo $this->Form->submit(__l('Subscribe'));?>
							</div>
						</div>
						<p class="subcription-info"><?php echo __l('(We\'ll never share your e-mail address) '); ?></p>
						</div>

						<?php echo $this->Form->end(); ?>
						</div>
			</div>
			</div>
		<?php else: ?> 
				<h5 class="top-text-block"><?php echo __l('Get item updates in ') . $city_name;?></h5>
				<div class="top-form-block grid_8 alpha omega">
				<?php echo $this->Form->create('Subscription', array('class' => 'subscription round-10 clearfix', 'id' => 'SubscriptionAddForm'.$step ));?>

					<?php
						if(!empty($city_id)):
							$this->request->data['Subscription']['city_id'] = $city_id;
						endif;
					?>
					<div class ='js-overlabel'>
					<?php echo $this->Form->input('email',array('label' => __l('Enter your Email address:'), 'class' => 'emailsubscription', 'id' => 'SubscriptionEmail'.$step)); ?>
					</div>
					<?php 
					if(!empty($this->request->data['Subscription']['city_id'])):
						echo $this->Form->input('city_id',array('type' => 'hidden', 'value' => $this->request->data['Subscription']['city_id'], 'id' => 'SubscriptionCityId'.$step)); 
					else:
						echo $this->Form->input('city_id',array('type' => 'hidden', 'id' => 'SubscriptionCityId'.$step)); 
					endif;			
					?>
				<?php echo $this->Form->end(__l('Count Me In'));?>
				</div>
		<?php endif; ?>
<?php endif; ?>
<?php endif; ?>