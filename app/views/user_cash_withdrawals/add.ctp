<?php /* SVN: $Id: add.ctp 71289 2011-11-14 12:28:02Z anandam_023ac09 $ */ ?>
<div class="userCashWithdrawals form js-ajax-form-container js-responses">
	<div class="page-info">
    	<?php echo __l('The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your wallet.'); ?>
    </div>
    <?php echo $this->Form->create('UserCashWithdrawal', array('action' => 'add','class' => "normal js-ajax-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
    <div class="clearfix affiliatecashwithdrawal-block">
    <div class="grid_left">
	<?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'between';
		else:
			$currecncy_place = 'after';
		endif;	
	?>	
	<?php
		if($this->Auth->user('user_type_id') == ConstUserTypes::User){
			$min = Configure::read('user.minimum_withdraw_amount');
			$max = Configure::read('user.maximum_withdraw_amount');	
		}else if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant){
			$min = Configure::read('merchant.minimum_withdraw_amount');
			$max = Configure::read('merchant.maximum_withdraw_amount');
		}
		echo $this->Form->input('amount',array($currecncy_place => '<span class="currency">'.Configure::read('site.currency').'</span>' ));
		?>
		<span class="info"> <?php echo sprintf(__l('Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s'),$this->Html->siteCurrencyFormat($min), $this->Html->siteCurrencyFormat($max)); ?> </span>
		<?php
		echo $this->Form->input('user_id',array('type' => 'hidden'));
		echo $this->Form->input('user_type_id',array('type' => 'hidden','value'=>$this->Auth->user('user_type_id')));
	?>
    </div>
        <div class="grid_left submit-block">
        <?php
        	echo $this->Form->submit(__l('Request Withdraw'));
        ?>
        </div>
        </div>
        <?php
        	echo $this->Form->end();
        ?>
</div>
