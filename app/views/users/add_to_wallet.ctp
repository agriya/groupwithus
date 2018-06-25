<?php /* SVN: $Id: add_to_wallet.ctp 54745 2011-05-27 03:34:15Z arovindhan_144at11 $ */ ?>
<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Add Amount to Wallet'); ?></span></span></span></h2>
<?php
	if(Configure::read('site.currency_symbol_place') == 'left'):
		$currecncy_place = 'between';
	else:
		$currecncy_place = 'after';
	endif;	
?>		
<?php 
	echo $this->Form->create('User', array('action' => 'add_to_wallet', 'class' => 'normal add-to-wallet'));
	if (!Configure::read('wallet.max_wallet_amount')):
        $max_amount = 'No limit';
    else:
        $max_amount = $this->Html->siteCurrencyFormat(Configure::read('wallet.max_wallet_amount'));
    endif;
	echo $this->Form->input('amount',array('label' => __l('Amount'), $currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>')); ?>
	<span class="info"> <?php echo sprintf(__l('Minimum Amount: %s <br/> Maximum Amount: %s'),$this->Html->siteCurrencyFormat(Configure::read('wallet.min_wallet_amount')), $max_amount)?>  </span>
	<?php
		$is_show_credit_card = 0;
		if (empty($gateway_options['Paymentprofiles'])):
			$is_show_credit_card = 1;
		endif;
	?>
	<?php echo $this->Form->input('User.payment_gateway_id', array('legend' => false, 'before' => '<span class="payment-type">'.__l('Payment Type').'</span>',  'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type {"is_show_credit_card":"' . $is_show_credit_card . '"}')); ?>
	<div class="user-payment-profile js-show-payment-profile <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])) ? '' : 'hide'; ?>">
		<?php 
			if (!empty($gateway_options['Paymentprofiles'])):
				echo $this->Form->input('payment_profile_id', array('legend' => __l('Pay with this card(s)'), 'type' => 'radio', 'options' => $gateway_options['Paymentprofiles'])); ?>
				<div><?php echo $this->Html->link(__l('Add new card'), '#', array('class' => 'js-add-new-card add')); ?> </div>
			<?php  endif;
		?>
	</div>
	<?php $get_conversion_currency = $this->Html->getConversionCurrency();?>
	<?php //if(isset($get_conversion_currency['supported_currency']) && empty($get_conversion_currency['supported_currency'])):?>
	<?php //endif;?>
	<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::CreditCard]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
		<div class="clearfix js-credit-payment login-left-block credit-payment-block <?php echo ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::CreditCard || (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $is_show_credit_card)) ? '' : 'hide' ?>">
		  <div class="billing-left grid_9">
		    <h3><?php echo __l('Billing Information'); ?></h3>
			<?php
				echo $this->Form->input('User.firstName', array('label' => __l('First Name')));
				echo $this->Form->input('User.lastName', array('label' => __l('Last Name')));
				echo $this->Form->input('User.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $gateway_options['creditCardTypes']));
				echo $this->Form->input('User.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number'))); ?>
				<div class="input date">
    				<label><?php echo __l('Expiration Date'); ?> </label>
    				<?php echo $this->Form->month('User.expDateMonth', array('value' => date('m'),'empty'=>'Please Select'));
    			     echo $this->Form->year('User.expDateYear', date('Y'), date('Y')+25, array('value' => date('Y')+2,'empty'=>'Please Select'));?>
				</div>
				<?php echo $this->Form->input('User.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number:')));
			?>
		  </div>
		  <div class="billing-right grid_9">
			<h3><?php echo __l('Billing Address'); ?></h3>
			<?php
				echo $this->Form->input('User.address', array('label' => __l('Address')));
				echo $this->Form->input('User.city', array('label' => __l('City')));
				echo $this->Form->input('User.state', array('label' => __l('State')));
				echo $this->Form->input('User.zip', array('label' => __l('Zip code')));
				echo $this->Form->input('User.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $gateway_options['countries'], 'empty' => __l('Please Select')));
				echo $this->Form->input('User.is_show_new_card', array('type' => 'hidden'));
			 ?>   
			 </div>
		</div>
	<?php endif; ?>  
    <div class="submit-block clearfix">
    	<?php echo $this->Form->submit(__l('Add to Wallet')); ?>
	</div>
    <?php echo $this->Form->end(); ?>