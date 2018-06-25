<ul class="admin-links clearfix">

	<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_stats') ? 'admin-active' : null; ?>
    <li class="no-bor <?php echo $class;?>">
    	 <span class="amenu-left">
             <span class="amenu-right">
                 <span class="menu-center dashboard">
                      <em><?php echo __l('Dashboard'); ?></em>
                 </span>
            </span>
         </span>
          <div class="admin-sub-block">
			  <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
              <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
                        	<ul class="">
                            <li>
                                <h4><?php echo __l('Dashboard'); ?></h4>
                                <ul>
                                <?php $class = ($this->request->params['controller'] == 'users'  && ($this->request->params['action'] == 'admin_stats' ))? ' class="active"' : null; ?>
                                <li <?php echo $class;?>>
                                <?php echo $this->Html->link(__l('Snapshot'), array('controller' => 'users', 'action' => 'stats'),array('title' => __l('Snapshot'))); ?>
                                </li>
                                </ul>
                                </li>
                            </ul>
                        </div>
                	</div>
        	 </div>
             <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
    </li>
   <?php $controller = array('users', 'user_profiles',  'user_logins',  'user_comments',  'user_jobs',  'user_schools',  'user_interests',  'user_interest_comments',  'messages');
	$class = ( in_array( $this->request->params['controller'], $controller ) && !in_array($this->request->params['action'], array('admin_logs', 'admin_stats', 'admin_referred_users')) ) ? 'admin-active' : null; ?>
    
        <li class="no-bor <?php echo $class;?>">
	
		 <span class="amenu-left">
             <span class="amenu-right">
                 <span class="menu-center admin-users">
                
                      <em> <?php echo __l('Users'); ?></em>
                 </span>
            </span>
         </span>
         <div class="admin-sub-block">
		 <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
          <div class="admin-sub-lblock">
            <div class="admin-sub-rblock">
            <div class="admin-sub-cblock">
    		<ul class="admin-sub-links">
        	<li>
            	<h4><?php echo __l('Users'); ?></h4>
            	<?php
            	/*echo "<pre>";
                  print_r($this->params);*/
                 ?>
                <ul>
    			<?php $class = ($this->request->params['controller'] == 'user_profiles' ||  ($this->request->params['controller'] == 'users'  && ($this->request->params['action'] == 'admin_index' || $this->request->params['action'] == 'admin_change_password')) ) ? ' class="active"' : null; ?>
    			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index', 'main_filter_id' => 'all'),array('title' => __l('Users'))); ?></li>
    			<?php $class = ($this->request->params['controller'] == 'users'  && ($this->request->params['action'] == 'admin_add' ))? ' class="active"' : null; ?>
    			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Add User'), array('controller' => 'users', 'action' => 'add'),array('title' => __l('Add User'))); ?></li>
    			<?php $class = ($this->request->params['controller'] == 'user_profiles') ? ' class="active"' : null; ?>
                <?php $class = ($this->request->params['controller'] == 'user_logins') ? ' class="active"' : null; ?>
    			<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Logins'), array('controller' => 'user_logins', 'action' => 'index'),array('title' => __l('User Logins'))); ?></li>
    			<?php $class = ($this->request->params['controller'] == 'user_comments') ? ' class="active"' : '';?>
    			<li <?php echo $class; ?>><?php echo $this->Html->link(__l('User Comments'), array('controller' => 'user_comments', 'action' => 'index'), array('title' => __l('User Comments'), 'escape' => false)); ?></li>
				<?php $class = ($this->request->params['controller'] == 'user_jobs') ? ' class="active"' : '';?>
    			<li <?php echo $class; ?>><?php echo $this->Html->link(__l('User Jobs'), array('controller' => 'user_jobs', 'action' => 'index'), array('title' => __l('User Jobs'), 'escape' => false)); ?></li>
				<?php $class = ($this->request->params['controller'] == 'user_schools') ? ' class="active"' : '';?>
    			<li <?php echo $class; ?>><?php echo $this->Html->link(__l('User Schools'), array('controller' => 'user_schools', 'action' => 'index'), array('title' => __l('User Schools'), 'escape' => false)); ?></li>
				<?php $class = ($this->request->params['controller'] == 'user_interests') ? ' class="active"' : '';?>
    			<li <?php echo $class; ?>><?php echo $this->Html->link(__l('Interests'), array('controller' => 'user_interests', 'action' => 'index'), array('title' => __l('Interests'), 'escape' => false)); ?></li>
				<?php $class = ($this->request->params['controller'] == 'user_interest_comments') ? ' class="active"' : '';?>
    			<li <?php echo $class; ?>><?php echo $this->Html->link(__l('Interest Comments'), array('controller' => 'user_interest_comments', 'action' => 'index'), array('title' => __l('Interest Comments'), 'escape' => false)); ?></li>
				<?php $class = ($this->request->params['controller'] == 'messages') ? ' class="active"' : '';?>
    			<li <?php echo $class; ?>><?php echo $this->Html->link(__l('Messages'), array('controller' => 'messages', 'action' => 'index'), array('title' => __l('Messages'), 'escape' => false)); ?></li>
        		</ul>
               </li> 
            </ul>
        	</div>
        	</div>
    	 </div>
             <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
	</li>
    <?php $controller = array('merchants');
	$class = (in_array( $this->request->params['controller'], $controller )) ? 'admin-active' : null; ?>

    <li class="no-bor <?php echo $class;?>">
	
		 <span class="amenu-left">
             <span class="amenu-right">
                 <span class="menu-center admin-merchants">
                      <em> <?php echo __l('Merchants'); ?></em>
                 </span>
            </span>
         </span>
         <div class="admin-sub-block">
		 <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
          <div class="admin-sub-lblock">
            <div class="admin-sub-rblock">
            <div class="admin-sub-cblock">
    		<ul class="admin-sub-links">
        	<li>
            	<h4><?php echo __l('Merchants'); ?></h4>
                <ul>
                <?php $class = ($this->request->params['controller'] == 'merchants' and $this->request->params['action'] == 'admin_merchant_stats') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Snapshot'), array('controller' => 'merchants', 'action' => 'admin_merchant_stats'),array('title' => __l('Snapshot'))); ?>
				<span class="sub-link-info"><?php echo __l('Top 10, by revenue, by pass');?></span>
				</li>
				<?php $class = ($this->request->params['controller'] == 'merchants' and $this->request->params['action'] == 'admin_index' || $this->request->params['action'] == 'admin_edit') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Merchants'), array('controller' => 'merchants', 'action' => 'index'),array('title' => __l('Merchants'))); ?></li>
                <?php $class = ($this->request->params['controller'] == 'merchants' and $this->request->params['action'] == 'admin_add') ? ' class="active"' : null; ?>
            	<li <?php echo $class;?>><?php echo $this->Html->link(__l('Add Merchant'), array('controller' => 'merchants', 'action' => 'add'),array('title' => __l('Add Merchant'))); ?></li>
            	</ul>
             </li>
             </ul>
        	</div>
        	</div>
    	 </div>
             <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
	
	</li>
    <?php $controller = array('items',  'item_users');
	$class = ( in_array( $this->request->params['controller'], $controller )  && !in_array($this->request->params['action'], array('admin_referral_commission')) ) ? 'admin-active' : null; ?>
    <li class="no-bor  <?php echo $class;?>">
        <span class="amenu-left">
         <span class="amenu-right">
         <span class="menu-center admin-items">
            <em><?php echo __l('Items'); ?></em>
         </span>
        </span>
         </span>
      <div class="admin-sub-block">
	  <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
           <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
    	<ul class="admin-sub-links">
        	<li>
            	<h4><?php echo __l('Items'); ?></h4>
                <ul>
                 <?php $class = ($this->request->params['controller'] == 'items' && $this->request->params['action'] == 'admin_item_stats') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Snapshot'), array('controller' => 'items', 'action' => 'item_stats'),array('title' => __l('Snapshot'))); ?></li>
                 <?php $class = ($this->request->params['controller'] == 'items' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>>
                     <?php echo $this->Html->link(__l('Items'), array('controller' => 'items', 'action' => 'index', 'type' => 'all'),array('title' => __l('Items'))); ?>
                    </li>
                    <?php $class = ($this->request->params['controller'] == 'items' && $this->request->params['action'] == 'admin_add') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Add Item'), array('controller' => 'items', 'action' => 'admin_add'), array('title' => __l('Add Item'))); ?></li>
                    <?php $class = ($this->request->params['controller'] == 'item_users') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Item Orders/Passes'), array('controller' => 'item_users', 'action' => 'index'), array('title' => __l('Item Passes'))); ?></li>
                </ul>
        	</li>
        </ul>
        </div>
        </div>
         </div>
            <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
    </li>
   <?php $controller = array('subscriptions', 'mail_chimp_lists' );
	$class = ( in_array( $this->request->params['controller'], $controller ) ) ? 'admin-active' : null; ?>

    <li class="no-bor  <?php echo $class;?>">
     <span class="amenu-left">
         <span class="amenu-right">
         <span class="menu-center admin-subscriptions">
            <em><?php echo __l('Subscriptions'); ?></em>
         </span>
        </span>
         </span>
	 <div class="admin-sub-block">
	 <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
             <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
                    <ul class="admin-sub-links">
                        <li>
                            <h4><?php echo __l('Subscriptions'); ?></h4>
                            <ul>
							<?php $class = ($this->request->params['controller'] == 'subscriptions' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
                            <li <?php echo $class;?>><?php echo $this->Html->link(__l('Subscriptions'), array('controller' => 'subscriptions', 'action' => 'admin_index', 'type' => 'subscribed'),array('title' => __l('Subscriptions'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'mail_chimp_lists') ? ' class="active"' : null; ?>
                            <li <?php echo $class;?>><?php echo $this->Html->link(__l('MailChimp Mailing Lists'), array('controller' => 'mail_chimp_lists', 'action' => 'index'), array('title' => __l('MailChimp Mailing Lists'))); ?></li>
                            </ul>
                          </li> 
        </ul>
        </div>
        </div>
        </div>
               <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
	</li>
    <?php $controller = array('payment_gateways', 'transactions', 'user_cash_withdrawals',  'affiliate_cash_withdrawals' );
	$class = ( in_array( $this->request->params['controller'], $controller ) ) ? 'admin-active' : null; ?>

    <li class="no-bor  <?php echo $class;?>">
	 <span class="amenu-left">
             <span class="amenu-right">
                 <span class="menu-center admin-payment">
                    <em><?php echo __l('Payments'); ?></em>
                 </span>
            </span>
         </span>
     <div class="admin-sub-block">
	 <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
           <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
		<ul class="admin-sub-links">
            <li>
                <h4><?php echo __l('Payments'); ?></h4>
                <ul>
					<?php
                    $class = ($this->request->params['controller'] == 'transactions') ? ' class="active"' : null; ?>
                   <li <?php echo $class;?>><?php echo $this->Html->link(__l('Transactions'), array('controller' => 'transactions', 'action' => 'index'),array('title' => __l('Transactions'))); ?></li>
                    <?php $class = ($this->request->params['controller'] == 'payment_gateways') ? 'active' : null; ?>
                    <li class="setting-overview <?php echo $class;?>"><?php echo $this->Html->link(__l('Payment Gateways'), array('controller' => 'payment_gateways', 'action' => 'index'), array('title' => __l('Payment Gateways')));?></li>
                 </ul>
                <h4><?php echo __l('Withdraw Fund Requests'); ?></h4>
                <ul>
					<?php
                    if($this->Html->isWalletEnabled('is_enable_for_add_to_wallet')){
                       if((Configure::read('merchant.is_user_can_withdraw_amount')) || (Configure::read('user.is_user_can_with_draw_amount'))){?>
                    <?php $class = ($this->request->params['controller'] == 'user_cash_withdrawals') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Users & Merchants'), array('controller' => 'user_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstWithdrawalStatus::Pending),array('title' => __l('Users & Merchants'))); ?></li>
                    <?php } } ?>
                    <?php $class = ($this->request->params['controller'] == 'affiliate_cash_withdrawals' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
                   <li <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending),array('title' => __l('Affiliates'))); ?></li>
                 </ul>
                <h4><?php echo __l('Release payment'); ?></h4>
                <ul>
                <?php $class = ($this->request->params['controller'] == 'charities' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
                    <li  <?php echo $class;?>><?php echo $this->Html->link(__l('Charities'),array('controller'=>'charities','action'=>'index'),array('title' => __l('Charities')));?></li>
                 </ul>
               </li>    
               
		</ul>
		</div>
		</div>
		</div>
             <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
	</li>
    <?php $controller = array('charities', 'affiliates', 'affiliate_requests',  'charity_cash_withdrawals', 'charity_money_transfer_accounts','affiliate_types');
	$class = ( in_array( $this->request->params['controller'], $controller ) || in_array($this->request->params['action'], array('admin_referral_commission', 'admin_referred_users')) ) ? 'admin-active' : null; ?>
    <li class="no-bor  <?php echo $class;?>">
		 <span class="amenu-left">
             <span class="amenu-right">
                 <span class="menu-center admin-charity">
                    <em><?php echo __l('Partners'); ?></em>
                 </span>
            </span>
         </span>
        <div class="admin-sub-block">
		<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
           <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
                	   <ul class="admin-sub-links">
                            <li>
                                <h4><?php echo __l('Affiliates'); ?></h4>
                                <ul>
								<?php $class = ($this->request->params['controller'] == 'affiliates') ? ' class="active"' : null; ?>
                				<li <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array('title' => __l('Affiliates'))); ?></li>
                				<?php $class = ($this->request->params['controller'] == 'affiliate_requests') ? ' class="active"' : null; ?>
								<li <?php echo $class;?>><?php echo $this->Html->link(__l('Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'), array('title' => __l('Affiliate Requests'))); ?></li>
								<?php $class = ($this->request->params['controller'] == 'affiliate_cash_withdrawals') ? ' class="active"' : null; ?>
                                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Withdraw Fund Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending),array('title' => __l('Withdraw Fund Requests'))); ?></li>
                                 <?php $class = ($this->request->params['controller'] == 'settings' && ($this->request->params['pass'][0]==9)) ? 'active' : null; ?>
                                <li class="setting-overview <?php echo $class;?>"><?php echo $this->Html->link(__l('Common Settings'), array('controller' => 'settings', 'action' => 'edit', 9),array('title' => __l('Common Settings'), 'class' => 'affiliate-settings')); ?></li>
                                 <?php $class = ($this->request->params['controller'] == 'affiliate_types' && ($this->request->params['action']=='admin_edit')) ? ' class="active"' : null; ?>
                                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Commission Settings'), array('controller' => 'affiliate_types', 'action' => 'edit'),array('title' => __l('Commission Settings'))); ?></li>
                                </ul>
                             </li>   
                            <li>
                                <h4><?php echo __l('Referrals'); ?></h4>
                                <ul>
                                <?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_referred_users') ? ' class="active"' : null; ?>
                                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Referrals'), array('controller' => 'users', 'action' => 'referred_users'),array('title' => __l('Referrals'))); ?></li>
                                <?php $class = ($this->request->params['controller'] == 'item_users' && $this->request->params['action'] == 'admin_referral_commission') ? ' class="active"' : null; ?>
                				<li <?php echo $class;?>><?php echo $this->Html->link(__l('Referral Commissions'), array('controller' => 'item_users', 'action' => 'referral_commission'),array('title' => __l('Referral Commissions'))); ?></li>
								</ul>
                             </li> 
                            <li>
                                <h4><?php echo __l('Charities'); ?></h4>
                                <ul>
								<?php $controller = array('charities', 'charity_cash_withdrawals');
                                $class = (in_array( $this->request->params['controller'], $controller ) ) ? 'admin-active' : null; ?>
                                <?php $class = ($this->request->params['controller'] == 'charities' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
                                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Charities'), array('controller' => 'charities', 'action' => 'index'), array('title' => __l('Charities')));?></li>
                                <?php $class = ($this->request->params['controller'] == 'charities' && $this->request->params['action'] == 'admin_add') ? ' class="active"' : null; ?>
    							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Add Charity'),array('controller'=>'charities','action'=>'add'),array('title' => __l('Add Charity')));?></li>
    							<?php $class = ($this->request->params['controller'] == 'charity_cash_withdrawals' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
                   				<li <?php echo $class;?>><?php echo $this->Html->link(__l('Payment History'),array('controller'=>'charity_cash_withdrawals','action'=>'index'),array('title' => __l('Payment History')));?></li>
                                </ul>
                             </li>   
                        </ul>
                     </div>
            </div>
        </div>
            <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
		
	</li>
    <?php $class = ($this->request->params['controller'] == 'settings') ? 'admin-active' : null; ?>
	<li class="masters  setting-masters-block masters-block <?php echo $class;?>">
	 <span class="amenu-left">
         <span class="amenu-right">
             <span class="menu-center admin-settings">
                <em><?php echo __l('Settings'); ?></em>
             </span>
        </span>
    </span>
     <div class="admin-sub-block">
	 <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
           <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
                    		<ul class="admin-sub-links clearfix">
                                <li>
                                <ul>
                                <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && $this->request->params['pass']==null) ? 'active' : null; ?>
                                <li class="setting-overview setting-overview1 clearfix <?php echo $class;?>"><?php echo $this->Html->link(__l('Setting Overview'), array('controller' => 'settings', 'action' => 'index'),array('title' => __l('Setting Overview'), 'class' => 'setting-overview')); ?></li>
                                <li>
                            	    <ul>
                            	       <li class="admin-sub-links-left">
                                            <ul>
            	                               <li>
                                                <h4><?php echo __l('Settings'); ?></h4>
                                                    <ul>
                                                       <?php $class = (!empty($this->request->params['controller']) &&  $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==1)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('System'), array('controller' => 'settings', 'action' => 'edit', 1),array('title' => __l('System'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==2)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Developments'), array('controller' => 'settings', 'action' => 'edit', 2),array('title' => __l('Developments'))); ?></li>
                                                         <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==3)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('SEO'), array('controller' => 'settings', 'action' => 'edit', 3),array('title' => __l('SEO'))); ?></li>
                                                         <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==4)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Regional, Currency & Language'), array('controller' => 'settings', 'action' => 'edit', 4),array('title' => __l('Regional, Currency & Language'))); ?></li>
                                                         <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==5)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Account '), array('controller' => 'settings', 'action' => 'edit', 5),array('title' => __l('Account'))); ?></li>
                                                         <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==6)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Item'), array('controller' => 'settings', 'action' => 'edit', 6),array('title' => __l('Item'))); ?></li>
                                                         <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==7)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Payment'), array('controller' => 'settings', 'action' => 'edit', 7),array('title' => __l('Payment'))); ?></li>
                                                    </ul>
                                                </li>
                                            </ul>
                            	       </li>
                            	       <li class="admin-sub-links-right">
                                            <ul>
            	                               <li>
                                                    <ul>
                                                    <?php $class = (!empty($this->request->params['controller']) && ($this->request->params['controller'] == 'settings') && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==8)) ? ' class="active"' : null; ?>
														<li <?php echo $class;?>><?php echo $this->Html->link(__l('Charity'), array('controller' => 'settings', 'action' => 'edit', 8),array('title' => __l('Charity'))); ?></li>
														<?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==9)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliate'), array('controller' => 'settings', 'action' => 'edit', 9),array('title' => __l('Affiliate'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==10)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Referrals'), array('controller' => 'settings', 'action' => 'edit', 10),array('title' => __l('Referrals'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==11)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Messages'), array('controller' => 'settings', 'action' => 'edit', 11),array('title' => __l('Messages'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==13)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Friends'), array('controller' => 'settings', 'action' => 'edit', 13),array('title' => __l('Friends'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==14)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Third Party API'), array('controller' => 'settings', 'action' => 'edit', 14),array('title' => __l('Third Party API'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==16)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('Module Manager'), array('controller' => 'settings', 'action' => 'edit', 16),array('title' => __l('Module Manager'))); ?></li>
                                                        <?php $class = (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && !empty($this->request->params['pass'][0]) && ($this->request->params['pass'][0]==15)) ? ' class="active"' : null; ?>
                                                        <li <?php echo $class;?>><?php echo $this->Html->link(__l('CDN'), array('controller' => 'settings', 'action' => 'edit', 12),array('title' => __l('CDN'))); ?></li>
                                                    </ul>
                                                </li>
                                            </ul>
                            	       </li>
                                    </ul>
                            	</li>
                                </ul>
                                </li>
                            </ul>
		              </div>
	           	</div>
		</div>
             <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
	</li>
   	<?php $controller = array('currencies', 'email_templates',  'pages', 'transaction_types', 'translations', 'languages',  'banned_ips', 'cities', 'states', 'countries', 'genders', 'item_categories', 'charity_categories', 'affiliate_widget_sizes', 'ips');
	$class = (in_array( $this->request->params['controller'], $controller ) ) ? 'admin-active' : null; ?>
	<li class="masters  masters-block <?php echo $class;?>">
		 <span class="amenu-left">
             <span class="amenu-right">
                 <span class="menu-center admin-masters">
                   <em> <?php echo __l('Masters'); ?></em>
                 </span>
            </span>
         </span>
       <div class="admin-sub-block">
	   <div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
              </div>
            <div class="admin-sub-lblock">
                    <div class="admin-sub-rblock">
                        <div class="admin-sub-cblock">
	    <ul class="admin-sub-links clearfix">
	    <li>
	    <div class="page-info master-page-info"><?php echo __l('Warning! Please edit with caution.');?></div>
	    <ul>
	    <li class="admin-sub-links-left">
    	    <ul>
            	<li>
                <h4><?php echo __l('Regional'); ?></h4>
                <ul>
    				<?php $class = ($this->request->params['controller'] == 'cities') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Cities'), array('controller' => 'cities', 'action' => 'index'),array('title' => __l('Cities'))); ?></li>
                    <?php $class = ($this->request->params['controller'] == 'countries') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Countries'), array('controller' => 'countries', 'action' => 'index'),array('title' => __l('Countries'))); ?></li>
    				<?php $class = ($this->request->params['controller'] == 'states') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('States'), array('controller' => 'states', 'action' => 'index'),array('title' => __l('States'))); ?></li>
                    <?php $class = ($this->request->params['controller'] == 'currencies') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Currencies'), array('controller' => 'currencies', 'action' => 'index'),array('title' => __l('Currencies'))); ?></li>
    				<?php $class = ($this->request->params['controller'] == 'banned_ips') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Banned IPs'), array('controller' => 'banned_ips', 'action' => 'index'),array('title' => __l('Banned IPs'))); ?></li>					
                </ul>
                </li>
                <li>
                <h4><?php echo __l('Languages'); ?></h4>
                <ul>
                	<?php $class = ($this->request->params['controller'] == 'languages') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Languages'), array('controller' => 'languages', 'action' => 'index'),array('title' => __l('Languages'))); ?></li>
                    <?php $class = ($this->request->params['controller'] == 'translations') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Translations'), array('controller' => 'translations', 'action' => 'index'),array('title' => __l('Translations'))); ?></li>
                </ul>
                </li>
                <li>
                <h4><?php echo __l('Static pages'); ?></h4>
                <ul>
    				<?php $class = ($this->request->params['controller'] == 'pages') ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Manage Static Pages'), array('controller' => 'pages', 'action' => 'index', 'plugin' => NULL),array('title' => __l('Manage Static Pages')));?></li>
                </ul>
            </li>
            <li>
            <h4><?php echo __l('Email'); ?></h4>
            <ul>
        		<?php $class = ($this->request->params['controller'] == 'email_templates') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Email Templates'), array('controller' => 'email_templates', 'action' => 'index'),array('title' => __l('Email Templates'))); ?></li>
            </ul>
            </li>
            </ul>
            </li>
            
            <li class="admin-sub-links-right">
            <ul>
        	<li>
            <h4><?php echo __l('Demographics'); ?></h4>
            <ul>
				<?php $class = ($this->request->params['controller'] == 'genders') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Genders'), array('controller' => 'genders', 'action' => 'index'),array('title' => __l('Genders'))); ?></li>
				<?php $class = ($this->request->params['controller'] == 'colleges') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Colleges'), array('controller' => 'colleges', 'action' => 'index'),array('title' => __l('Colleges'))); ?></li>
				<?php $class = ($this->request->params['controller'] == 'companies') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Companies'), array('controller' => 'companies', 'action' => 'index'),array('title' => __l('Companies'))); ?></li>
				<?php $class = ($this->request->params['controller'] == 'user_school_degrees') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('School Degrees'), array('controller' => 'user_school_degrees', 'action' => 'index'),array('title' => __l('School Degrees'))); ?></li>
            </ul>
            </li>
        	<li>
            <h4><?php echo __l('Others'); ?></h4>
            <ul>
                <?php $class = ($this->request->params['controller'] == 'affiliate_widget_sizes') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Widgets'), array('controller' => 'affiliate_widget_sizes', 'action' => 'index'),array('title' => __l('Widgets'))); ?></li>
                <?php if(Configure::read('charity.is_enabled') == 1):?>
                 <?php $class = ($this->request->params['controller'] == 'charity_categories') ? ' class="active"' : null; ?>
                 <li <?php echo $class;?>><?php echo $this->Html->link(__l('Charity Categories'), array('controller' => 'charity_categories', 'action' => 'index'), array('title' => __l('Charity Categories')));?></li>
                <?php endif; ?>		
                <?php $class = ($this->request->params['controller'] == 'item_categories') ? ' class="active"' : null; ?>
                <li <?php echo $class;?>><?php echo $this->Html->link(__l('Item Categories'), array('controller' => 'item_categories', 'action' => 'index'),array('title' => __l('Item Categories'))); ?></li>
            	<?php $class = ($this->request->params['controller'] == 'transaction_types') ? ' class="active"' : null; ?>
				<li <?php echo $class;?>><?php echo $this->Html->link(__l('Transaction Types'), array('controller' => 'transaction_types', 'action' => 'index'),array('title' => __l('Transaction Types'))); ?></li>
				<?php $class = ($this->request->params['controller'] == 'ips') ? ' class="active"' : null; ?>
				<li<?php echo $class;?>><?php echo $this->Html->link(__l('IPs'), array('controller' => 'ips', 'action' => 'index'), array('title' => __l('IPs'))); ?></li>
             </ul>
            </li>
            </ul>
            </li>
            </ul>
            </li>
        </ul>
        </div>
        </div>
          </div>
               <div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
            </div>
        </div>
	</li>
    </ul>