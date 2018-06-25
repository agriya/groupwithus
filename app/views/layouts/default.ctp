<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		echo $this->Html->css('default.cache', null, array('inline' => true));
		$js_inline = "document.documentElement.className = 'js';";
		$js_inline .= 'var cfg = ' . $this->Javascript->object($js_vars_for_layout) . ';';
		$js_inline .= "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		if (!$_jsPath = Configure::read('cdn.js')) {
			$_jsPath = Router::url('/', true);
		}
		$js_inline .= "js.src = \"" . $_jsPath . 'js/default.cache.js' . "\";";
		$js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
		echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
		if (Configure::read('paypal.is_embedded_payment_enabled') && ($this->request->params['controller'] == 'payments' || ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'add_to_wallet'))):
	?>
			<script type="text/javascript" src="https://www.paypalobjects.com/js/external/dg.js"></script>
	<?php
		endif;
		// For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
		if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
			echo '<!--', "\n";
		endif;
	?>
	<?php if(!empty($this->request->params['named']['city'])): ?>
	<link href="<?php echo Router::url('/', true) . $this->request->params['named']['city'] .'.rss';?>" type="application/rss+xml" rel="alternate" title="RSS Feeds" target="_blank" />
	<?php endif; ?>
	<meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
	<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
	<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
	<?php if(!empty($meta_for_layout['item_name'])) { ?>
		<meta property="og:image" content="<?php echo $meta_for_layout['item_image'];?>"/>
		<meta property="og:title" content="<?php echo $meta_for_layout['item_name'];?>"/>
	<?php } else { ?>
		<meta property="og:image" content="<?php echo Router::url(array(
				'controller' => 'img',
				'action' => 'logo.png',
				'admin' => false
			) , true);?>"/>
	<?php } ?>
	<?php
		if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
			echo '-->', "\n";
		endif;
	?>
	<?php echo $this->element('site_tracker', array('cache' => 30, 'plugin' => 'site_tracker')); ?>
</head>
<body>
	<?php
		if (empty($city_name)):
			$tmp_city = $this->Html->getCityDetails($this->request->params['named']['city']);
			$city_id = $tmp_city['City']['id'];
            $city_name = $tmp_city['City']['name'];
            $city_slug = $tmp_city['City']['slug'];
            $city_attachment = $tmp_city['Attachment'];
		endif;
	?>
	<div class="content container_24  clearfix <?php if($this->Auth->sessionValid() && $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?> admin-logged  <?php endif; ?>" id="<?php echo $this->Html->getUniquePageId();?>">
		<?php if ($this->Session->check('Message.error') || $this->Session->check('Message.success') || $this->Session->check('Message.flash')): ?>
			<div class="js-flash-message flash-message-block">
				<?php
					if ($this->Session->check('Message.error')):
						echo $this->Session->flash('error');
					endif;
					if ($this->Session->check('Message.success')):
						echo $this->Session->flash('success');
					endif;
					if ($this->Session->check('Message.flash')):
						echo $this->Session->flash();
					endif;
				?>
			</div>
		<?php endif; ?>
			
	
   
		<div class="grid_4 alphe omega" id="header">
			<div class="clearfix">
				<h1><?php echo $this->Html->link(Configure::read('site.name'), Router::url('/',true).$city_slug, array('title' => Configure::read('site.name'))); ?></h1>
			</div>
			<?php if($this->Auth->sessionValid() && $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
			<div class="clearfix admin-wrapper">
    			<h3 class="admin-site-logo">
					<?php echo $this->Html->link((Configure::read('site.name').' '.'<span>Admin</span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'title' => (Configure::read('site.name').' '.'Admin')));?>
    			</h3>
                <p class="logged-info"><?php echo __l('You are logged in as Admin'); ?></p>
    			<ul class="admin-menu clearfix">
    			 		<li class="logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));?></li>
				</ul>
			</div>
			 <?php endif; ?>
			<div id="tag-text" class="tag-text"><?php echo Configure::read('site.tag_text'); ?></div>
			<div id="citySharebox">
				<?php $cities = $this->Html->getCities(); ?>
				<?php echo $this->Form->create('City', array('url' => array('city' => Configure::read('site.city'), 'action' => 'change_city'), 'class' => 'language-form'));?>
				<?php echo $this->Form->input('city_id', array('label' => false, 'type'=>'hidden','value' => $city_id)); ?>
				<div class="city-list-block">
					<a class="cityBox js-city-selected" href="#"><?php echo $city_name;?></a>
					<div class="city-list js-city-list">
					<ul class="cityinfo-inner-block shadow-light clearfix">
							<?php 
								foreach($cities as $cityList):
									if($city_id == $cityList['City']['id']):
										$city_name = $cityList['City']['name'];
									endif;
							?>
							<li class="js-select-city js-city-<?php echo $cityList['City']['id'];?> {'city_id':'<?php echo $cityList['City']['id'];?>'}"><?php echo $this->Html->cText($cityList['City']['name']). ' (' . $this->Html->cInt($cityList['City']['active_item_count']) . ')';?></li>
							<?php 
								endforeach;
							?>
					</ul>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
				<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
				<?php 
					$url = $this->Html->getCityTwitterFacebookURL($city_slug);
					// Twitter
					$tw_url = (!empty($url['City']['twitter_url']))?$url['City']['twitter_url']:Configure::read('twitter.site_twitter_url');
							?>
					<div class="clearfix social-sharing-container" id="social-sharing-container">
					<div class="fb-like" data-href="<?php echo Router::url('/', true);?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
					<div id="twitter-social-container" class="social-sharing twitter-social-container clearfix">
						<a href="<?php echo $tw_url; ?>" class="twitter-follow-button" data-show-count="false"><?php echo __l('Follow'); ?></a>
					</div>
				</div>
			</div>
			<ul class="menu">
		     	<li <?php if(($this->request->params['controller'] == 'items' && $this->request->params['action'] == 'index' && empty($this->request->params['named']['type']))) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $this->Html->link(__l('Items'), array('controller' => 'items', 'action' => 'index', 'admin' => false), array('title' => __l('Items')));?></li>
				<li <?php if(($this->request->params['controller'] == 'items' && $this->request->params['action'] == 'index' && (!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='past'))) { echo 'class="active"'; } else { echo '';}?>><?php echo $this->Html->link(__l('Past Items'), array('controller' => 'items', 'action' => 'index','type' => 'past', 'admin' => false), array('title' => __l('Past Items')));?></li>
				<li <?php if(($this->request->params['controller'] == 'user_interests' && $this->request->params['action'] == 'index')) { echo 'class="active"'; } else { echo ' ';}?>><?php echo $this->Html->link(__l('Interests'),  array('controller' => 'user_interests', 'action' => 'index', 'admin' => false), array('title' => __l('Interests')));?></li>
				<li <?php if(($this->request->params['controller'] == 'pages' && $this->request->params['action'] == 'view' &&  $this->request->params['pass'][0] == 'learn')) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $this->Html->link(sprintf(__l('How It Works')), array('controller' => 'pages', 'action' => 'view', 'learn', 'admin' => false), array('title' => sprintf(__l('How It Works'))));?></li>
				<?php if(!$this->Auth->sessionValid()): ?>
					<li <?php if(($this->request->params['controller'] == 'pages' && $this->request->params['action'] == 'view' &&  $this->request->params['pass'][0] == 'merchant')) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $this->Html->link(__l('Merchant'), array('controller' => 'pages', 'action' => 'view', 'merchant', 'admin' => false), array('title' => __l('Merchant')));?></li>
					<?php endif; ?>


			</ul>
		</div>

		<div class="grid_20 alpha omega clearfix" id="main">
			<div class="main-left-shadow">
				<div class="main-right-shadow">
					<div class="main-inner">
						<div class="main-inner-content clearfix">	
						<div class="global_block clearfix" id="top-bar">
		
							<div class="global-left-block clearfix js-responses" id="subscription">
							<?php if($this->Html->isAllowed($this->Auth->user('user_type_id')) && $this->request->params['controller'] != 'subscriptions'): ?>
                               		<?php if ($this->request->params['controller'] != 'subscriptions' && $this->request->params['action']!='confirmation'): ?>
									<?php echo $this->element('../subscriptions/add', array('step' => 1, 'config' => 'sec'));?>
										<?php endif;?>
									<?php endif;?>
								<div class="language-form-block">
									<?php echo $this->element('lanaguge-change-block'); ?>
								</div>
							</div>
							<ul class="global-links">
								   <?php if(Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer  && Configure::read('referral.referral_enable')):?>
										<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) :
											if(Configure::read('merchant.is_show_referred_friends')) :?>
												<li class="refer"><?php echo $this->Html->link(__l('Refer a Friend'), array('controller' => 'pages', 'action' => 'refer_a_friend'), array('title' => __l('Refer a Friend'),'class'=>'refer-friends'));?></li>
											<?php endif; ?>
											<?php else : ?>
												<li class="refer"><?php echo $this->Html->link(__l('Refer a Friend'), array('controller' => 'pages', 'action' => 'refer_a_friend'), array('title' => __l('Refer a Friend'),'class'=>'refer-friends'));?></li>
											<?php endif; ?>
									<?php elseif(Configure::read('referral.referral_enabled_option') == ConstReferralOption::XRefer):?>
										<li class="refer"><?php echo $this->Html->link(__l('Refer a Friend'), array('controller' => 'pages', 'action' => 'refer_friend'), array('title' => __l('Refer a Friend'),'class'=>'refer-friends'));?></li>
									<?php endif; ?>
									<?php if (!$this->Auth->sessionValid()): ?>
										<li class="login  <?php if($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'login') { echo 'active'; } ?> "><?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'),'class'=>'login-link'));?></li>
										<li  class="join  <?php if($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'register') { echo 'active'; } ?>" ><?php echo $this->Html->link(__l('Join Us'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Join us'),'class'=>'login-link'));?></li>
									<?php endif; ?>
									<?php if($this->Auth->sessionValid()) { ?>
										<?php
											$message_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'));
											$message_count = !empty($message_count) ? ' ('.$message_count.')' : '';
										?>
										 <li class="inbox">
												<?php echo $this->Html->link(__l('Inbox'), array('controller' => 'messages', 'action' => 'index'), array('title' => __l('Inbox'))); ?>
												<?php echo $message_count; ?>
											</li>
									 <?php } ?>
									<?php if ($this->Auth->sessionValid()): ?>

										<?php
											if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):
												$merchant = $this->Html->getMerchant($this->Auth->user('id'));
											endif;
										?>

										<li class="username clearfix">
											<?php
												$reg_type_class='normal';
												if($this->Auth->user('is_openid_register')):
													$reg_type_class='open-id';
												endif;
												if($this->Auth->user('fb_user_id')):
													$reg_type_class='facebook';
												endif;
												$current_user_details = array(
													'username' => $this->Auth->user('username'),
													'user_type_id' =>  $this->Auth->user('user_type_id'),
													'id' =>  $this->Auth->user('id'),
													'fb_user_id' =>  $this->Auth->user('fb_user_id')
												);
												echo __l('Hi, ');
											?>
											<span class="<?php echo $reg_type_class; ?>">
												<?php
													$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($this->Auth->user('id'));
													echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
													echo $this->Html->getUserLink($current_user_details);
												?>
											</span>
											<div class="sub-menu shadow">
											<?php if(!empty($user_available_balance)):?>
												<?php if ($this->Html->isWalletEnabled('is_enable_for_add_to_wallet')): ?>
													<h4><?php echo __l('Balance: '); ?><span><?php echo $this->Html->siteCurrencyFormat($user_available_balance); ?></span></h4>
                                                <?php endif; ?>
                                                <?php endif; ?>
												<div class="clearfix submenu-block">
												<ul class="sub-menu-inner-left grid_4 clearfix">
													<li>
														<h5><?php if ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant):?>
															<?php echo $this->Html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
														<?php else: ?>
															<?php echo __l('My Stuff'); ?>
														<?php endif; ?></h5>
														<ul>
															<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
																<?php $user = $this->Html->getMerchant($this->Auth->user('id')); ?>
																<li><?php  echo $this->Html->link(__l('Dashboard'), array('controller' => 'merchants', 'action' => 'dashboard'), array('title' => __l('Dashboard')));?></li>
																<li><?php echo $this->Html->link(__l('My Merchant'), array('controller' => 'merchants', 'action' => 'edit', $user['Merchant']['id']), array('title' => 'My Merchant')); ?></li>
															<?php else: ?>
																<li><?php echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'my_account', $this->Auth->user('id')), array('title' => 'My Account')); ?></li>
															<?php endif; ?>
															<?php if ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant || $this->Html->isAllowed($this->Auth->user('user_type_id'))):?>
															<li><?php  echo $this->Html->link(sprintf(__l('My %s'), Configure::read('site.name')), array('controller' => 'item_users', 'action' => 'index'), array('title' => 'My Purchases'));?></li>
															<?php endif; ?>
															<li><?php echo $this->Html->link(__l('My Transactions'), array('controller' => 'transactions', 'action' => 'index', 'admin' => false), array('title' => 'My Transactions'));?></li>
															<?php if(Configure::read('friend.is_enabled')): ?>
																	<li><?php echo $this->Html->link(__l('My Friends'), array('controller' => 'user_friends', 'action' => 'lst', 'admin' => false), array('title' => 'My Friends'));?></li>
																	<li><?php echo $this->Html->link(__l('Import Friends'), array('controller' => 'user_friends', 'action' => 'import', 'admin' => false), array('title' => 'Import Friends')); ?></li>
															<?php endif; ?>
															<?php if ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant || $this->Html->isAllowed($this->Auth->user('user_type_id'))):?>
																<li><?php echo $this->Html->link(__l('My Notifications'), array('controller' => 'user_notifications', 'action' => 'edit', $this->Auth->user('id')), array('title' => 'My Notifications')); ?></li>
																<li><?php echo $this->Html->link(__l('My Subscriptions'), array('controller' => 'subscriptions', 'action' => 'index'), array('title' => 'My Subscriptions')); ?></li>
															<?php endif; ?>
															<?php if ((Configure::read('merchant.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User) && $massPayEnableCount > 0): ?>
    															<li><?php echo $this->Html->link(__l('Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index', 'admin' => false), array('title' => 'Transfer Accounts'));?></li>
															<?php endif; ?>
														</ul>
													</li>
													<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
														<li>
															<h5><?php echo __l('Items'); ?></h5>
															<ul>
																<li><?php echo $this->Html->link(__l('My Items'), array('controller' => 'items', 'action' => 'index', 'merchant' => $merchant['Merchant']['slug'] ), array('title' => __l('My Items')));?></li>
																<li><?php echo $this->Html->link(__l('Add Item'), array('controller' => 'items', 'action' => 'add'), array('class'=>'add-item', 'title' => __l('Add Item')));?></li>
															</ul>
														</li>
													<?php endif; ?>
												</ul>
												<ul class="sub-menu-inner-right grid_4 clearfix">
													<?php if ($this->Html->isWalletEnabled('is_enable_for_add_to_wallet') && ($this->Html->isAllowed($this->Auth->user('user_type_id')) || ((Configure::read('merchant.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User)))): ?>
														<li>
															<h5><?php echo __l('Wallet'); ?></h5>
															<ul>
																<?php if ($this->Html->isAllowed($this->Auth->user('user_type_id'))): ?>
																	<li><?php echo $this->Html->link(__l('Add Amount to Wallet'), array('controller' => 'users', 'action' => 'add_to_wallet'), array('title' => __l('Add amount to wallet'))); ?></li>
																<?php endif; ?>
																<?php if ((Configure::read('merchant.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User)): ?>
																	<li><?php echo $this->Html->link(__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Withdraw Fund Request')));?></li>
																<?php endif; ?>
															</ul>
														</li>
													<?php endif; ?>
													<?php if (Configure::read('affiliate.is_enabled')):?>
														<li>
															<h5><?php echo __l('Affiliates'); ?></h5>
															<ul>
																<li><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'), array('title' => __l('Affiliates')));?></li>
																<?php if ($this->Auth->user('is_affiliate_user')): ?>
																	<li><?php echo $this->Html->link(__l('Affiliate Cash Withdrawals'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'), array('title' => __l('Affiliate Cash Withdrawals')));?></li>
																<?php endif; ?>
															</ul>
														</li>
													<?php endif; ?>
													<li class="logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));?></li>
												</ul>
											</div>
											</div>
										</li>
									<?php endif; ?>
								</ul>
						</div>
						<?php if($this->request->params['controller']=='items' && $this->request->params['action']=='index' && empty($this->request->params['named']['type']) && empty($this->request->params['named']['merchant'])): ?>
							<div class="banner">
								<?php echo $this->Html->showImage('City', $city['Attachment'], array('dimension' => 'city_banner_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($city['City']['name'], false)), 'title' => $this->Html->cText($city['City']['name'], false)));?>
							</div>
						<?php endif; ?>
						<?php if(($this->request->params['controller']=='items' && $this->request->params['action']=='index')): ?>
							<div class="js-lazyload">
						<?php endif; ?>
							<?php echo $content_for_layout;?>
						<?php if(($this->request->params['controller']=='items' && $this->request->params['action']=='index')): ?>
							</div>
						<?php endif; ?>
						<?php if(($this->request->params['controller']=='items' && $this->request->params['action']=='index') && empty($this->request->params['named']['type']) && empty($this->request->params['named']['merchant'])): ?>
							<?php echo $this->element('users-index-home', array('cache' => array('config' => 'sec')));?>
							<?php echo $this->element('items-past', array('step' => 1, 'cache' => array('config' => 'sec')));?>
						<?php endif; ?>
						</div>
						<div id="footer" class="clearfix">
							<div class="footer-section1 grid_12 alpha omega clearfix">
								<ul class="grid_2 footer-nav">
									<li><?php echo $this->Html->link(__l('Home'), Router::url('/',true).$city_slug , array('title' =>__l('Home'))); ?></li>
									<?php $class = ($this->request->params['controller'] == 'pages' && $this->request->params['action'] == 'view' && $this->request->params['pass'][0] == 'about') ? ' class="active"' : null; ?>
									<li <?php echo $class;?>><?php echo $this->Html->link(__l('About'), array('controller' => 'pages', 'action' => 'view', 'about', 'admin' => false), array('title' => __l('About')));?> </li>
									<?php $class = ($this->request->params['controller'] == 'contacts' && $this->request->params['action'] == 'add') ? ' class="active"' : null; ?>
									<li <?php echo $class;?>><?php echo $this->Html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact Us')));?></li>
									<?php if(Configure::read('affiliate.is_enabled')):?>
										<?php $class = ($this->request->params['controller'] == 'affiliates') ? ' class="active"' : null; ?>
										<li <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array('title' => __l('Affiliates'))); ?></li>
									<?php endif; ?>
								</ul>
								<ul class="grid_2 footer-nav">
									<?php $class = ($this->request->params['controller'] == 'pages' && $this->request->params['action'] == 'view' && $this->request->params['pass'][0] == 'faq') ? ' class="active"' : null; ?>
									<li <?php echo $class;?>><?php echo $this->Html->link(__l('FAQ'), array('controller' => 'pages', 'action' => 'view', 'faq', 'admin' => false), array('title' => __l('FAQ')));?></li>
									<li <?php if($this->request->params['controller'] == 'pages' && $this->request->params['action'] == 'view'  && $this->request->params['pass'][0] == 'how_it_works') { echo 'class="active"'; } ?>><?php echo $this->Html->link(sprintf(__l('How It Works')), array('controller' => 'pages', 'action' => 'view', 'learn', 'admin' => false), array('title' => sprintf(__l('How It Works'))));?></li>
									<?php if(Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer):?>
										<?php $class = ($this->request->params['controller'] == 'pages') && ($this->request->params['pass'][0] == 'refer_a_friend') ? ' class="active"' : null; ?>
										<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) :
												 if(Configure::read('merchant.is_show_referred_friends')) :?>
													<li <?php echo $class;?>><?php echo $this->Html->link(__l('Refer a Friend'), array('controller' => 'pages', 'action' => 'refer_a_friend'), array('title' => __l('Refer a Friend')));?></li>
													<?php endif; ?>
												<?php else : ?>
													<li <?php echo $class;?>><?php echo $this->Html->link(__l('Refer a Friend'), array('controller' => 'pages', 'action' => 'refer_a_friend'), array('title' => __l('Refer a Friend')));?></li>
												<?php endif; ?>
									<?php elseif(Configure::read('referral.referral_enabled_option') == ConstReferralOption::XRefer):?>
										<?php
											if(Configure::read('referral.refund_type') == ConstReferralRefundType::RefundItemAmount):
												$refund_type = __l('Get a Free Item!!!');
											else:
												$refund_type = __l('Get').' '.$this->Html->siteCurrencyFormat(Configure::read('referral.refund_amount'), false) . ' ';
											endif;
											$msg = __l('Refer').' '.Configure::read('referral.no_of_refer_to_get_a_refund').' '.__l('Friends').', '.$refund_type;
										?>
										<?php $class = ($this->request->params['controller'] == 'pages')  && ($this->request->params['pass'][0] == 'refer_friend') ? ' class="active"' : null; ?>
										<li <?php echo $class;?>><?php echo $this->Html->link($msg, array('controller' => 'pages', 'action' => 'refer_friend'), array('title' => $msg));?></li>
									<?php endif; ?>
									<li <?php echo $class;?>><?php echo $this->Html->link(__l('Item Etiquette'), array('controller' => 'pages', 'action' => 'view', 'etiquette', 'admin' => false), array('title' => __l('Item Etiquette')));?></li>
								</ul>
								<ul class="grid_2 footer-nav">
									<?php
										if(!empty($city_slug)):
											$tmpURL= $this->Html->getCityTwitterFacebookURL($city_slug);
										endif;
									?>
									
									
									<li class="face2"><?php echo $this->Html->link(__l('Facebook'), Configure::read('facebook.site_facebook_url'), array('title' => __l('Facebook'), 'target'=>'_blank','escape' => false));?></li>
									<li class="tweet2"><a href="<?php echo !empty($tmpURL['City']['twitter_url']) ? $tmpURL['City']['twitter_url'] : '#'; ?>" title="<?php echo __l('Follow Us in Twitter'); ?>" target="_blank"><?php echo __l('Twitter'); ?></a></li>
									<?php if($this->Html->isAllowed($this->Auth->user('user_type_id'))):?>
										<li class="mail2"><?php echo $this->Html->link(__l('Email'), array('controller' => 'subscriptions', 'action' => 'add', 'admin' => false), array('title' => __l('Email'))); ?></li>
									<?php endif;?>
									<?php
										$cityArray = array();
										if(!empty($city_slug)):
											$tmpURL= $this->Html->getCityTwitterFacebookURL($city_slug);
											$cityArray = array('city'=>$city_slug);
										endif;
									?>
									<li class="rss2"><?php echo $this->Html->link(__l('RSS'), array_merge(array('controller'=>'items', 'action'=>'index', 'ext'=>'rss'), $cityArray), array('target' => '_blank','title'=>__l('RSS Feed'))); ?></li>
								</ul>
							</div>
							<div class="grid_5 copyright-block">
								<p class="reserve"><?php echo sprintf(__l('%s items builds friendship among any radicals. Reserve any theme of your choice to meet a group of new people and discover new neighborhoods and group activities.'), Configure::read('site.name')); ?></p>
								<p class="copy"><?php echo date('Y');?> Copyright, <?php echo $this->Html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
								<p class="powered clearfix"><span><a href="<?php echo (env('HTTPS') )? '#' :  'http://groupwithus.dev.agriya.com/'; ?>" title="Powered by GroupWithUs" target="_blank" class="powered">Powered by GroupWithUs</a>,</span> <span>made in</span> <?php echo $this->Html->link('Agriya Web Development', (env('HTTPS') )? '#' : 'http://www.agriya.com/', array('target' => '_blank', 'title' => 'Agriya Web Development', 'class' => 'company'));?>  <span><?php echo Configure::read('site.version');?></span></p>
								<div id="agriya" class="clearffix">
									<p><?php echo $this->Html->link('CSSilized by CSSilize, PSD to XHTML Conversion', (env('HTTPS') )? '#' : 'http://www.cssilize.com/', array('target' => '_blank', 'title' => 'CSSilized by CSSilize, PSD to XHTML Conversion', 'class' => 'cssilize'));?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="main-bl">
				<div class="main-br">
					<div class="main-bm"> </div>
				</div>
			</div>
			<div class="goTop-block">
				<a href="#top" title="Top" class="js-top"><?php echo __l('Top'); ?></a>
			</div>
			<?php if ($_SERVER['HTTP_HOST'] == 'groupwithus.dev.agriya.com'): ?>
				<div class="js-home-page"></div>
			<?php endif; ?>
		</div>
	</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='<?php echo Configure::read('facebook.app_id');?>'";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>