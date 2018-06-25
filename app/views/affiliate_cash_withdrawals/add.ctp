<?php /* SVN: $Id: $ */ ?>
<div class="affiliateCashWithdrawals form">
    <div class="clearfix widget-affiliate-information-block">
        <h2 class="grid_left omega alpha"><?php echo __l('Affiliate Cash Withdrawals'); ?></h2>
     	<div class="add-block affiliate-information widget-affiliate-information">
       	    <?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array('class'=>'widthdraw', 'title' => __l('Affiliates'))); ?>
            <?php echo $this->Html->link(__l('Generate Affiliate Widget'), array('controller' => 'affiliates', 'action' => 'generate_widget'),array('class'=>'affiliate-widget', 'title' => __l('Generate Affiliate Widget'))); ?>
       </div>
    </div>
 <div class="affiliate-information">
	<div class="page-info">
    	<?php echo __l('The requested amount will be deducted from your affiliate commission amount and the amount will be blocked until it get approved or rejected by the administrator. Once it\'s approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your affiliate commission amount.'); ?>
    </div>

<div class="user-edit-form-block">
	<?php 		
		if($this->Auth->user('user_type_id') == ConstUserTypes::User){
			$min = Configure::read('affiliate.payment_threshold_for_threshold_limit_reach');	
			$cleared_amount = $user['User']['commission_line_amount'];
			$transaction_fee = Configure::read('affiliate.site_commission_amount');
			$transaction_fee_type = Configure::read('affiliate.site_commission_type');
			if(!empty($transaction_fee)){
				$transactions = ($transaction_fee_type == 'amount') ? $this->Html->siteCurrencyFormat($transaction_fee) : $transaction_fee.'%';
				$transactions = '<br/>'.__l('Transaction Fee').':'. $transactions;
			}
			else{
				$transactions = '';
			}	
		}
	?>

	<?php	echo $this->Form->create('AffiliateCashWithdrawal', array('class' => "normal  js-ajax-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));
			echo $this->Form->input('user_id', array('type' => 'hidden')); ?>
			<div class="clearfix affiliatecashwithdrawal-block">
    			<div class="grid_left">
        			<?php
        			echo $this->Form->input('amount',array('label' => __l('Amount'),'after' => Configure::read('site.currency') . '<span class="info">' . sprintf(__l('Minimum withdraw amount: %s <br/>  Commission amount: %s  %s'),$this->Html->siteCurrencyFormat($min), $this->Html->siteCurrencyFormat($cleared_amount), $transactions . '</span>')));
                	?>
          	    </div>
            	<div class="grid_left submit-block">
                    <?php echo $this->Form->submit(__l('Request Withdraw'));?>
               </div>
           </div>
            <?php echo $this->Form->end();?>
   
</div>
</div>
</div>
