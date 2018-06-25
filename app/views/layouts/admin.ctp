<?php
/* SVN FILE: $Id: admin.ctp 69894 2011-11-01 05:20:47Z josephine_065at09 $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo sprintf(__l('Admin - %s'), $this->Html->cText($title_for_layout, false)); ?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		echo $this->Html->css('admin.cache', null, array('inline' => true));
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
		echo $this->element('site_tracker');
	?>
</head>
<?php	
	
	if (!empty($city_attachment['id']) && empty($this->request->params['requested']) && $this->request->params['controller'] != 'images' && empty($_SESSION['city_attachment'])):
		$_SESSION['city_attachment'] =  $this->Html->url(getImageUrl('City', $city_attachment, array('dimension' => 'original')));
	endif; 		
?>
<body class="admin">	
    <div class="admin-content-block">
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
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content admin-content admin-container-24 ">
		<div id="header" class="clearfix">
		    <div id="header-content">
			<div class="header-top-content">
  	            <div class="clearfix">
        			<h1 class="grid_5 mega alpha">
    					<?php echo $this->Html->link((Configure::read('site.name').' '.'<span>Admin</span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'title' => (Configure::read('site.name').' '.'Admin')));?>
        			</h1>
        			 <ul class="admin-menu clearfix">
    				    <li class="view-site"><?php echo $this->Html->link(__l('View Site'), array('controller' => 'items', 'action' => 'index','admin' => false), array('escape' => false, 'title' => __l('View Site')));?></li>
                        <li><?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true),array('title' => __l('Diagnostics'))); ?></li>
    					<li><?php echo $this->Html->link(__l('Tools'), array('controller' => 'pages', 'action' => 'display', 'tools', 'admin' => true), array('escape' => false, 'title' => __l('View Site')));?></li>
    					 <?php $class = (($this->request->params['controller'] == 'user_profiles') && ($this->request->params['action'] == 'my_account')) ? ' class="active"' : null; ?>
                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'user_account', $this->Auth->user('id')), array('title' => __l('My Account')));?></li>
        			    <li class="logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));?></li>
                   	</ul>
				</div>
				<div class="clearfix">
        		   <?php
                        echo $this->element('admin-sidebar');
                    ?>
                </div>
				</div>
				<div class="header-bottom-content clearfix">
            	 <p class="admin-welcome-info grid_10 omega alpha"><?php echo __l('Welcome, ').$this->Html->link($this->Auth->user('username'), array('controller' => 'users', 'action' => 'stats', 'admin' => true),array('title' => $this->Auth->user('username'))); ?></p>
    			 <div class="grid_11 grid_right omega alpha admin-language-block">
      				<?php echo $this->element('lanaguge-change-block', array('cache' => array('config' => 'site_element_cache', 'key' => $this->request->params['controller'].'_'.$this->request->params['action'])));?>
    				<?php echo $this->element('admin-cities-filter', array('cache' => array('config' => '2sec', 'key' => $this->request->params['controller'].'_'.$this->request->params['action'])));?>
				</div>
				</div>
		</div>
		</div>
		<div id="main" class="clearfix">
			<?php
				$user_menu = array('users', 'user_profiles',  'user_logins',  'user_comments');
				$merchant_menu = array('merchants');
				$item_menu = array('items',  'item_passes');
				$subscriptions_menu = array('subscriptions', 'mail_chimp_lists');
				$payment_menu = array('payment_gateways', 'transactions', 'user_cash_withdrawals');
				$charity_menu = array('charity_cash_withdrawals', 'charities','charity_money_transfer_accounts');
				$affiliate_menu = array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_types', 'affiliate_widget_sizes');
				$master_menu = array('currencies', 'email_templates',  'pages', 'transaction_types', 'translations', 'languages',  'banned_ips', 'cities', 'city_suggestions', 'states', 'countries',  'user_educations', 'genders', 'item_categories', 'charity_categories', 'affiliate_widget_sizes', 'ips');
				$diagnostics_menu = array('paypal_transaction_logs', 'paypal_docapture_logs', 'authorizenet_docapture_logs');
				if(($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_referred_users') || ($this->request->params['controller'] == 'item_users' && $this->request->params['action'] == 'admin_referral_commission')) {
					$class = "referral-title";
				} elseif(in_array($this->request->params['controller'], $user_menu) && $this->request->params['action'] != 'admin_diagnostics') {
					$class = "users-title";
				} elseif(in_array($this->request->params['controller'], $merchant_menu)) {
					$class = "merchant-title";
				} elseif(in_array($this->request->params['controller'], $item_menu)) {
					$class = "items-title";
				} elseif(in_array($this->request->params['controller'], $subscriptions_menu) && $this->request->params['action'] != 'admin_subscription_customise') {	
					$class = "subscriptions-title";
				} elseif(in_array($this->request->params['controller'], $payment_menu)) {
					$class = "payment-title";
				} elseif(in_array($this->request->params['controller'], $charity_menu)) {
					$class = "charity-title";
				} elseif(in_array($this->request->params['controller'], $affiliate_menu)) {
					$class = "affiliate-title";
				} elseif(in_array($this->request->params['controller'], $master_menu)) {
					$class = "master-title";
				} elseif(in_array($this->request->params['controller'], $diagnostics_menu)) {
					$class = "diagnostics-title";
				} elseif($this->request->params['controller'] == 'settings') {
					$class = "settings-title";				
				} elseif($this->request->params['controller'] == 'subscriptions' && $this->request->params['action'] == 'admin_subscription_customise') {
					$class = "customize-subscriptions-title";
				} elseif($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_diagnostics') {
					$class = "diagnostics-title";
				}
		  if(($this->request->params['controller'] == 'users' && ($this->request->params['action'] == 'admin_stats' || $this->request->params['action'] == 'admin_demographic_stats'))){
                echo $content_for_layout;
             } else { ?>
			 <div class="main-tl">
				<div class="main-tr">
					<div class="main-tm"> </div>
				</div>
			</div>   
               <div class="main-left-shadow">
				<div class="main-right-shadow">
					<div class="main-inner clearfix">
					<?php if($this->request->params['controller'] != 'devs' && $this->request->params['action'] != 'admin_logs') { ?>
					<h2 class="ribbon-title clearfix <?php echo $class; ?>"><span class="ribbon-right">
	                       <span class="ribbon-inner">
							<?php if($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'index') { ?>
								<?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> 				
							<?php }elseif($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'admin_edit' ) { ?>
								<?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> &raquo; <?php echo $setting_categories['SettingCategory']['name']; ?>					
							<?php } elseif(in_array( $this->request->params['controller'], $diagnostics_menu) || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_logs') { ?>
							<?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true), array('title' => __l('Diagnostics')));?> &raquo; <?php echo $this->pageTitle;?>
							<?php } elseif($this->request->params['controller'] == 'items' && $this->request->params['action'] == 'admin_index') { ?>
								<?php echo $this->Html->link(__l('Items'), array('controller' => 'items', 'action' => 'index', 'admin' => true), array('title' => __l('Items'))); ?>
								<?php if (isset($this->request->params['named']['filter_id'])) { ?> &raquo; <?php echo $title; } ?>
							<?php } else { ?>
								<?php echo $this->Html->cText($this->pageTitle,false);?>
							<?php } ?>
							</span>
							</span>
							<?php if($this->request->params['controller'] == 'settings') { ?>
								<span class="setting-info info grid_right"><?php echo __l('To reflect setting changes, you need to') . ' ' . $this->Html->link(__l('clear cache'), array('controller' => 'devs', 'action' => 'clear_cache', '?f=' . $this->request->url), array('title' => __l('clear cache'), 'class' => 'js-delete'));  ?>.</span>
							<?php } ?>
						</h2>
					<?php } ?>
                	<?php if(!Configure::read('affiliate.is_enabled') && in_array( $this->request->params['controller'], array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_widget_sizes'))) { ?>
                         <div class="page-info"><?php echo __l('Affiliate module is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 9),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } elseif(!Configure::read('referral.referral_enable') && (($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_referred_users') || ($this->request->params['controller'] == 'item_passes' && $this->request->params['action'] == 'admin_referral_commission'))) { ?>
                         <div class="page-info"><?php echo __l('Referral module is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 10),array('title' => __l('Settings'))). __l(' page');?>
                          </div>
					 <?php } elseif(!Configure::read('charity.is_enabled') && in_array( $this->request->params['controller'], array('charities', 'charity_cash_withdrawals'))) { ?>
                         <div class="page-info"><?php echo __l('Charity module is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 8),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } elseif(!Configure::read('mailchimp.is_enabled') && in_array( $this->request->params['controller'], array('mail_chimp_lists'))) { ?>
                         <div class="page-info"><?php echo __l('MailChimp module is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 14, '#' => 'MailChimp'),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } elseif(!Configure::read('site.is_currency_convertion_histroy_updation') && in_array( $this->request->params['controller'], array('currency_conversion_histories'))) { ?>
                         <div class="page-info"><?php echo __l('Currency Conversion History Updation is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 4),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } else {
					 		echo $content_for_layout;
					 }?>
                      </div>
                      </div>
               	</div>
				<div class="main-bl">
    				<div class="main-br">
    					<div class="main-bm"> </div>
				    </div>
			 </div>
        <?php } ?>
           
		</div>
	    <div id="agriya" class="clearfix">
            <div class="grid_right">
              	<p class="copy">&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
        		<p class="powered clearfix"><span><a href="http://groupwithus.dev.agriya.com/" title="Powered by GroupWithUs" target="_blank" class="powered">Powered by GroupWithUs</a>,</span> <span>made in</span> <?php echo $this->Html->link('Agriya Web Development', 'http://www.agriya.com/', array('target' => '_blank', 'title' => 'Agriya Web Development', 'class' => 'company'));?>  <span><?php echo Configure::read('site.version');?></span></p>
        		<p><?php echo $this->Html->link('CSSilized by CSSilize, PSD to XHTML Conversion', 'http://www.cssilize.com/', array('target' => '_blank', 'title' => 'CSSilized by CSSilize, PSD to XHTML Conversion', 'class' => 'cssilize'));?></p>
            </div>
        </div>
	</div>
    </div>
	<?php echo $this->element('site_tracker');?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>