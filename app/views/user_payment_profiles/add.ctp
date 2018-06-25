<?php /* SVN: $Id: authorize_net.ctp 8007 2010-06-12 12:09:11Z shankari_062at09 $ */ ?>
<div class="UserPaymentProfile  form clearfix">
	<h2><?php echo __l('Add New Credit Card'); ?></h2>
	<?php echo $this->Form->create('UserPaymentProfile', array('action' => 'add', 'class' => 'normal user-payment-form js-ajax-form')); ?>
	<div class="clearfix login-left-block">
	<div class="billing-left grid_9 alpha omega">
	<h3><?php echo __l('Billing Information'); ?></h3>
	<?php		
		echo $this->Form->input('UserPaymentProfile.user_id', array('type' => 'hidden','value' => $user_id));
		echo $this->Form->input('UserPaymentProfile.firstName', array('label' => __l('First name')));
		echo $this->Form->input('UserPaymentProfile.lastName', array('label' => __l('Last name')));
		echo $this->Form->input('UserPaymentProfile.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $credit_card_types));
		echo $this->Form->input('UserPaymentProfile.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number')));
	?>
	<div class="input date">
		<label><?php echo __l('Expiration Date'); ?> </label>
		<?php 
			echo $this->Form->month('UserPaymentProfile.expDateMonth', array('value' => date('m')));
			echo $this->Form->year('UserPaymentProfile.expDateYear', date('Y'), date('Y')+25, array('value' => date('Y')+2));
		?>
	</div>
	<?php echo $this->Form->input('UserPaymentProfile.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number')));
	?>
	</div>
	<div class="billing-right grid_9 alpha omega">
    <h3><?php echo __l('Billing Address'); ?></h3>
	<?php
		
		echo $this->Form->input('UserPaymentProfile.address', array('label' => __l('Address')));
		echo $this->Form->input('UserPaymentProfile.city', array('label' => __l('City')));
		echo $this->Form->input('UserPaymentProfile.state', array('label' => __l('State'), 'type' => 'select', 'options' => $states, 'empty' => __l('-- Please Select --')));
		echo $this->Form->input('UserPaymentProfile.zip', array('label' => __l('ZIP')));
		echo $this->Form->input('UserPaymentProfile.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $countries, 'empty' => __l('-- Please Select --')));
	?>
	</div>
	</div>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add')); ?>
	</div>
	<?php echo $this->Form->end();?>
</div>