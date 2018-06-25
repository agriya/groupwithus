<?php /* SVN: $Id: buy.ctp 54596 2011-05-25 12:35:27Z arovindhan_144at11 $ */ ?>
	<h2 class="ribbon-title clearfix">
		<span class="ribbon-left">
			<span class="ribbon-right">
				<span class="ribbon-inner">
					<?php echo __l('Buy Item'); ?>
				</span>
			</span>
		</span>
	</h2>
	<div class="buying-form">
	<?php echo $this->Form->create('Item', array('action' => 'buy', 'class' => 'normal')); ?>
    	<table class="list purchase-list">
        	<tr>
            	<th class="dl"><?php echo __l('Description'); ?></th>
                <th><?php echo __l('Quantity'); ?></th>
                <th class="dr"><?php echo __l('Price') . ' (' . Configure::read('site.currency') . ')'; ?></th>
                <th class="dr"><?php echo __l('Total') . ' (' . Configure::read('site.currency') . ')'; ?></th>
            </tr>
            <tr>
            	<td class="dl">
					<p class="item-name"><?php echo $this->Html->cText($item['Item']['name'],false);?></p>
                </td>
				<td><?php
						$min_info = !empty($item['Item']['buy_min_quantity_per_user']) ? $item['Item']['buy_min_quantity_per_user'] :'1';
						$max_info = $item['Item']['buy_max_quantity_per_user'];
						if(empty($item['Item']['buy_max_quantity_per_user']) && empty($item['Item']['max_limit'])){
							$max_info = __l('Unlimited');
						}
						elseif(!empty($item['Item']['buy_max_quantity_per_user']) && !empty($item['Item']['max_limit'])){
							if(!empty($user_quantity)){
								$user_balance = $item['Item']['buy_max_quantity_per_user'] - $user_quantity;
							}
							else{
								$user_balance = $item['Item']['buy_max_quantity_per_user'];
							}
							$current_balance = $item['Item']['max_limit'] - $item['Item']['item_user_count'];
                            if($current_balance  < $user_balance) {
                                $max_info = $current_balance;
                            } else{
								 $max_info = $user_balance;
							}							
						}
						elseif(!empty($item['Item']['buy_max_quantity_per_user']) && empty($item['Item']['max_limit'])){
							if(!empty($user_quantity)){
								$max_info = $item['Item']['buy_max_quantity_per_user'] - $user_quantity;
							}
							else{
								$max_info = $item['Item']['buy_max_quantity_per_user'];
							}
						}
						elseif(empty($item['Item']['buy_max_quantity_per_user']) && !empty($item['Item']['max_limit'])){
							$max_info = $item['Item']['max_limit'] - $item['Item']['item_user_count'];
						}
						
						if(!empty($max_info)){
							if($max_info < $min_info){
								$max_info = $min_info;
							}
						}							
						echo $this->Form->input('quantity',array('label' => false, 'class' => 'js-quantity', 'after' => '<span class="info">' . sprintf(__l('Minimum Quantity: %s <br /> Maximum Quantity: %s'),$min_info,$max_info). '</span>'));?>
                        <?php echo $this->Form->input('user_available_balance',array('type' => 'hidden', 'value' => $user_available_balance));  ?>
                </td>
				<td class="dr"><?php echo $this->Html->cCurrency($this->request->data['Item']['item_amount']); ?></td>
				<td class="dr"><span class="js-item-total"><?php echo $this->Html->cCurrency($this->request->data['Item']['total_item_amount']); ?></span></td>
            </tr>
	<?php if(Configure::read('wallet.is_handle_wallet') && $this->Auth->sessionValid()):?>
			<?php if(!empty($user_available_balance) && $user_available_balance != '0.00'):?>
			<tr>
				<td class="dr buy-dr" colspan="3"><?php echo Configure::read('site.name').' '.__l('bucks');?>
                    <span>(<?php
                        if($this->request->data['Item']['total_item_amount'] > $user_available_balance){
                            echo __l('You will have used all your Bucks.');
                        }elseif($this->request->data['Item']['total_item_amount'] < $user_available_balance){
                            $balance_amount = $user_available_balance - $this->request->data['Item']['total_item_amount'];
							echo "<span class='js-update-remaining-bucks'>".__l('You will have').' '.$balance_amount.' '.__l('Bucks remaining.')."</span>";
                        }elseif($this->request->data['Item']['total_item_amount'] == $user_available_balance){
                            echo __l('You will have used all your Bucks.');
                        }
                     ?>)</span>
                </td>
				<td class="dr buy-dr">
					<span>
						<?php 
							if($this->request->data['Item']['total_item_amount'] > $user_available_balance){
								$used_bucks = $user_available_balance;
							}elseif($this->request->data['Item']['total_item_amount'] < $user_available_balance){
								$used_bucks = $this->request->data['Item']['total_item_amount'];
							}elseif($this->request->data['Item']['total_item_amount'] == $user_available_balance){
								$used_bucks = $user_available_balance;
							} 
						?>
						<span class="js-update-total-used-bucks"><?php echo $this->Html->cCurrency($used_bucks);?></span>
                    </span>
                </td>
			</tr>
			<?php endif;?>			
			<tr>
				<td class="dr buy-dr" colspan="3"><?php echo __l('My Price:').' '?></td>
				<td class="dr buy-dr">
					<?php $my_price = ($user_available_balance > $this->request->data['Item']['total_item_amount']) ? 0 : ($this->request->data['Item']['total_item_amount'] - $user_available_balance); ?>
					<span class="js-amount-need-to-pay"><?php echo $this->Html->cCurrency($my_price);?></span>
				</td>
			</tr>
			<?php endif;?>
			<?php if(Configure::read('charity.is_enabled') == 1 && $item['Item']['charity_percentage'] > 0):?>
                <tr>
				   <td class="dr buy-dr" colspan="4">
					<?php if(Configure::read('charity.who_will_choose') == ConstCharityWhoWillChoose::Buyer):?>
					<p><?php echo sprintf(__l('For every item purchased, %s will donate %s of amount to charity that you selected from the pull-down'),Configure::read('site.name'),$item['Item']['charity_percentage'].'%');?></p>
					  <?php echo $this->Form->input('charity_id',array('label' => false));
					?>
					<?php else: ?>
						<?php 
						echo $this->Form->input('charity_id',array('type' => 'hidden'));  
						echo sprintf(__l('For every item purchased, %s will donate %s of amount to '),Configure::read('site.name'),$item['Item']['charity_percentage'].'%');?>
						<?php if(!empty($item['Charity']) && !(env('HTTPS'))): ?>
							<a href="<?php echo $item['Charity']['url']; ?>" target="_blank"><?php echo $this->Html->cText($item['Charity']['name']); ?></a>
						<?php else:  
						    echo __l('charity');
						endif; ?>
					<?php endif; ?>					
					</td>
				</tr>
		   <?php endif; ?>
        </table>
        <div class="js-guest-clone">
        <h2 class="js-test"></h2>
		<div class="js-field-list hide">
		<div class="clearfix">
		<div class="guest-name grid_9">
		 <?php
            echo $this->Form->input('ItemUserPass.0.guest_name'); ?> </div>
		<div class="guest-email grid_8">
		<?php
            echo $this->Form->input('ItemUserPass.0.guest_email');
        ?></div>
		</div>
		</div>
		<?php if(!empty($this->request->data['ItemUserPass'])):
			foreach($this->request->data['ItemUserPass'] as $key => $itemuser){
				if($key!=0){
		?>
		<div class="js-field-list js-new-clone-<?php echo $key; ?>">
		<div class="clearfix">
		<div class="guest-name grid_9">
		<?php
					echo $this->Form->input('ItemUserPass.'.$key.'.guest_name'); ?> </div>
		<div class="guest-email grid_8">
		<?php
					echo $this->Form->input('ItemUserPass.'.$key.'.guest_email');
		?> </div>
		</div>
		</div>
		<?php
				}
			}
		?>
			
		<?php endif; ?>


        </div>
		 <?php 
            echo $this->Form->input('item_id',array('type' => 'hidden'));
            echo $this->Form->input('user_id',array('type' => 'hidden')); 
            echo $this->Form->input('is_gift',array('type' => 'hidden')); 
            echo $this->Form->input('item_amount',array('type' => 'hidden'));
        ?>
		<?php if($this->request->data['Item']['is_gift'] || !$this->Auth->sessionValid() || (!empty($user['User']['fb_user_id']) && empty($user['User']['email'])) ||!empty($gateway_options['paymentGateways'])):	 ?>
			<div>
				<?php if($this->request->data['Item']['is_gift']): ?>
					<div class="item-gift-form login-left-block">
						<?php
						echo $this->Form->input('gift_from',array('label' => __l('From'))); 
						echo $this->Form->input('gift_to',array('label' => __l('Friend Name'))); 
						echo $this->Form->input('gift_email',array('label' => __l('Friend Email'))); 
						echo $this->Form->input('message',array('type' => 'textarea', 'label' => __l('Message'))); 
						?>
					</div>
				<?php endif; ?>
					<?php
						$show_class= '';
						if (empty($error) && $this->request->data['Item']['total_item_amount'] <= $user_available_balance):
							$show_class = 'hide';
						endif;
						if (empty($this->request->data['Item']['item_amount'])):
							$show_class = '';	
						endif;
					?>		
					<div class="js-payment-gateway-option <?php echo $show_class; ?>">

				<?php if(Configure::read('wallet.is_handle_wallet')):?>

					<div class="js-payment-gateway <?php echo $show_class; ?>">
						<?php $get_conversion_currency = $this->Html->getConversionCurrency();?>
						<?php if(isset($get_conversion_currency['supported_currency']) && empty($get_conversion_currency['supported_currency'])):?>
       <table>
							<tr>
							<td class="dl">
							<div class="page-info" id="currency-changing-info">
							<?php
							echo __l("<p>Note: Currently, Payment Gateways doesn't allow").' '.$get_conversion_currency['currency_code'].' '.__l("currency to be processed. It'll converted to").' '.$get_conversion_currency['conv_currency_code'].' '.__l("before processing. <strong>You wont be charged extra.</strong></p><p>You can also check the converted amount in <strong>My Transactions</strong>.</p>");
							?>
							</div>    
							</td>
							</tr>
							</table>
						<?php endif;?>
					</div>
				<?php endif;?>
				<?php if(!$this->Auth->sessionValid() || (!empty($user['User']['fb_user_id']) && empty($user['User']['email']))): ?>
					<div class="item-gift-form login-left-block">
						<?php
							if(!$this->Auth->sessionValid()):
								echo $this->Form->input('User.username',array('label' => __l('Username'),'info' => __l('Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed')));
								echo $this->Form->input('User.email',array('label' => __l('Email')));
								echo $this->Form->input('User.passwd', array('label' => __l('Password')));
								echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => __l('Password Confirmation')));
							elseif(!empty($user['User']['fb_user_id']) && empty($user['User']['email'])):
								echo $this->Form->input('User.email',array('label' => __l('Email')));
							endif;
						?>
					</div>
				<?php endif; ?>
				<?php
				if(!isset($is_show_credit_card)):
				$is_show_credit_card = 0;
					if (empty($gateway_options['Paymentprofiles'])):
					$is_show_credit_card = 1;
					endif;
				endif;
				?>
				<div class="js-show-payment-gateway <?php if (empty($this->request->data['Item']['item_amount']) || isset($my_price)&& $my_price==0): ?> hide<?php endif; ?>">
					<?php
						echo $this->Form->input('payment_gateway_id', array('legend' => __l('Payment Type'), 'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type {"is_show_credit_card":"' . $is_show_credit_card . '"}'));
					?>
					<div class="user-payment-profile js-show-payment-profile <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && (empty($this->request->data['Item']['payment_gateway_id']) || $this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet)) ? '' : 'hide'; ?>">
						<?php 
							if (!empty($gateway_options['Paymentprofiles'])):
								echo $this->Form->input('payment_profile_id', array('legend' => __l('Pay with this card(s)'), 'type' => 'radio', 'options' => $gateway_options['Paymentprofiles'])); ?>
								<div class="add-block clearfix"><?php echo $this->Html->link(__l('Add new card'), '#', array('class' => 'js-add-new-card add')); ?></div>
							<?php endif;
						?>
					</div>
					<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::CreditCard]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
						<div class="login-left-block">
							<div class="clearfix js-credit-payment <?php echo ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard || (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $is_show_credit_card)) ? '' : 'hide'; ?>">
								<div class="billing-left grid_9">
									<h3><?php echo __l('Billing Information'); ?></h3>
									<?php
									echo $this->Form->input('Item.firstName', array('label' => __l('First Name')));
									echo $this->Form->input('Item.lastName', array('label' => __l('Last Name')));
									echo $this->Form->input('Item.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $gateway_options['creditCardTypes']));
									echo $this->Form->input('Item.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number'))); ?>
									<div class="input date">
										<label><?php echo __l('Expiration Date'); ?> </label>
										<?php echo $this->Form->month('Item.expDateMonth', array('value' => date('m'),'empty'=>'Please Select'));?>
										<div class="exp-year">
										<?php
										echo $this->Form->year('Item.expDateYear', date('Y'), date('Y')+25, array('value' => date('Y')+2,'empty'=>'Please Select'));?>
										</div>
									</div>
									<?php echo $this->Form->input('Item.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number:')));
									?>
								</div>
								<div class="billing-right grid_9">
									<h3><?php echo __l('Billing Address'); ?></h3>
									<?php
									echo $this->Form->input('Item.address', array('label' => __l('Address')));
									echo $this->Form->input('Item.city', array('label' => __l('City')));
									echo $this->Form->input('Item.state', array('label' => __l('State')));
									echo $this->Form->input('Item.zip', array('label' => __l('Zip code')));
									echo $this->Form->input('Item.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $gateway_options['countries'], 'empty' => __l('Please Select')));
									echo $this->Form->input('Item.is_show_new_card', array('type' => 'hidden', 'id' => 'UserIsShowNewCard'));
									?>   
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="submit-block clearfix">
				<?php if(Configure::read('wallet.is_handle_wallet')):?>
					<?php echo $this->Form->input('is_purchase_via_wallet', array('type' => 'hidden', 'value' => ($this->request->data['Item']['total_item_amount'] <= $user_available_balance) ? 1 : 0));?>
				<?php endif;?>                    
				<?php echo $this->Form->submit(__l('Complete My Order'),array('title' => __l('Complete My Order'), 'class' => ((!empty($user_available_balance) || $user_available_balance != '0.00')  ? 'js-buy-confirm' : '')));?>
				<div class="cancel-block">
				<?php
				if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'gift'){
				echo $this->Html->link(__l('Cancel'), array('controller' => 'items', 'action' => 'buy',$item['Item']['id'], 'admin' => false), array('class' => 'cancel-button'));
				} else {
				echo $this->Html->link(__l('Cancel'), array('controller' => 'items', 'action' => 'view',$item['Item']['slug'], 'admin' => false), array('class' => 'cancel-button'));
				}
				?>
				</div>
			</div>
		</div>
		<?php else: ?>
			<div class="submit-block clearfix">
				<?php echo $this->Form->submit(__l('Complete My Order'),array('title' => __l('Complete My Order'), 'class' => ($user_available_balance ? 'js-buy-confirm' : '')));?>
				<div class="cancel-block">
					<?php
						if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'gift'){
							echo $this->Html->link(__l('Cancel'), array('controller' => 'items', 'action' => 'buy',$item['Item']['id'], 'admin' => false), array('class' => 'cancel-button'));
						}else{
							echo $this->Html->link(__l('Cancel'), array('controller' => 'items', 'action' => 'view',$item['Item']['slug'], 'admin' => false), array('class' => 'cancel-button'));
						}
					?>
				</div>
			</div>
		<?php endif; ?>
		<?php	echo $this->Form->end();?>
    <?php if(!$this->Auth->sessionValid()):?>
		<div class="login-right-block js-right-block">
            <div class="login-message-lineheight js-login-message">
                <h3><?php echo __l('Already Have An Account?');?></h3>
               
                <div class="clearfix">
                 <p class="login-info-block"><?php echo sprintf(__l('If you have purchased a %s before, you can sign in using your %s.'), Configure::read('site.name'),Configure::read('user.using_to_login')); ?></p>
                <div class="clearfix submit-block">
				<div class="cancel-block submit-cancel-block">
                    <?php echo $this->Html->link(__l('Login'), '#', array('title' => __l('Sign In'), 'class' => "cancel-button js-toggle-show {'container':'js-login-form', 'hide_container':'js-login-message'}"));?>
                </div>
                </div>
                </div>
                <div class="facebook-block">
            <?php if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') and Configure::read('facebook.is_enabled_facebook_connect')):  ?>
                <div class="facebook-left">
                <p class="already-info"><?php echo __l('Already have an account on Facebook?'); ?></p>
                <p><?php echo sprintf(__l('Use it to sign in to %s!'), Configure::read('site.name')); ?></p>
                </div>
                <div class="facebook-right">
					<?php  if (env('HTTPS')) { $fb_prefix_url = 'https://www.facebook.com/images/fbconnect/login-buttons/connect_dark_medium_short.gif';}else{ $fb_prefix_url = 'http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_short.gif';}?>
					<?php echo $this->Html->link($this->Html->image($fb_prefix_url, array('alt' => __l('[Image: Facebook Connect]'), 'title' => __l('Facebook connect'))), array('controller' => 'users', 'action' => 'login','type'=>'facebook'), array('escape' => false)); ?>
                </div>
			
            <?php endif; ?>
            	</div>
            </div>
            <div class="js-login-form hide">
                <?php
				// Temp Fix Avoid teh Validation Message in login Page due the Validation the Another Form
				unset($this->validationErrors['User']['username']);
				unset($this->validationErrors['User']['passwd']);
				echo $this->element('users-login', array('f' => 'items/buy/'.$this->request->data['Item']['item_id'], 'cache' => array('config' => 'site_element_cache')));?>
            </div>
        </div>
    <?php endif;?>

			</div>