<?php /* SVN: $Id: admin_index.ctp 71606 2011-11-15 20:43:00Z josephine_065at09 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<?php 
$debit_total_amt = $credit_total_amt = $gateway_total_fee = 0;
$credit = $debit = 1;
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes :: AddedToWallet) && !empty($this->request->params['named']['stat'])) {
    $debit = 0;
}
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes::ReferralAmountPaid || $this->request->params['named']['type'] == ConstTransactionTypes::AcceptCashWithdrawRequest || $this->request->params['named']['type'] == ConstTransactionTypes::PaidItemAmountToMerchant) && !empty($this->request->params['named']['stat'])) {
    $credit = 0;
}
?>	
<div class="transactions index js-response js-responses">
	<div class="clearfix">
             <ul class="filter-list-block clearfix">
            	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
            	<li class="green <?php echo $class; ?>"><?php echo $this->Html->link('<span>'.__l('Admin').'</span>', array('controller' => 'transactions', 'action' => 'index'), array('title' => __l('Admin'), 'escape' => false)); ?>
               </li>
               	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
            	<li class="black <?php echo $class; ?>"><?php echo $this->Html->link('<span>'.__l('All').'</span>', array('controller' => 'transactions', 'action' => 'index', 'filter' => 'all'), array('title' => __l('All'), 'escape' => false)); ?>
               </li>

            </ul>
	</div>
    <div class="page-count-block clearfix">
    <div class="grid_left">
    <?php echo $this->element('paging_counter');?>
    </div>
   <div class="grid_left">
		<?php echo $this->Form->create('Transaction' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form')); ?>
		
			<?php echo $this->Form->autocomplete('User.username', array('label' => __l('User'), 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255')); ?>
		
		
		<div class="mapblock-info">
		<div class="input text">
			<?php echo $this->Form->autocomplete('Item.name', array('label' => __l('Item'), 'div'=>false, 'acFieldKey' => 'Transaction.item_id', 'acFields' => array('Item.name'), 'acSearchFieldNames' => array('Item.name'), 'maxlength' => '255')); ?>
			</div>
			<div class="autocompleteblock">
			</div>
		</div>
		<?php
		if(!empty($this->request->data['Transaction']['user_id'])) {
			echo $this->Form->input('user_hidden_id',array('type' => 'hidden', 'value' => $this->request->data['Transaction']['user_id']));
		}
		?>
		<?php echo $this->Form->input('filter', array('type' => 'hidden', 'value' => (!empty($this->request->params['named']['filter']) ? $this->request->params['named']['filter'] : ''))); ?>
			<div class="clearfix date-time-block">
				<div class="input date-time clearfix">
					<div class="js-datetime">
						<?php echo $this->Form->input('from_date', array('label' => __l('From'), 'type' => 'date', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'), 'orderYear' => 'asc')); ?>
					</div>
				</div>
            </div>
			<div class="clearfix date-time-block">
				<div class="input date-time end-date-time-block clearfix">
					<div class="js-datetime">
						<?php echo $this->Form->input('to_date', array('label' => __l('To '),  'type' => 'date', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'), 'orderYear' => 'asc')); ?>
					</div>
				</div>
			</div>  
			<?php
			echo $this->Form->submit(__l('Filter'));
			 ?>
		<?php echo $this->Form->end(); ?>
	</div>
	<div class="add-block1 grid_right">
    	<?php if(!empty($transactions)) { ?>
    	<?php echo $this->Html->link(__l('CSV'), array('controller' => 'transactions', 'action' => 'index', 'city' => $city_slug, 'hash' => $export_hash, 'ext' => 'csv', 'admin' => true), array('class' => 'export', 'title' => __l('CSV'), 'escape' => false)); ?>
    	<?php } ?>
	</div>
	</div>

	<div class="">

	<?php 
		$get_conversion_currency = $this->Html->getConversionCurrency();
		$conv_var = '';
	?>
	<?php if(isset($get_conversion_currency['supported_currency']) && empty($get_conversion_currency['supported_currency'])):?>
		<?php $conv_var = ' ['.$get_conversion_currency['conv_currency_symbol'].']';?>
	<?php endif;?>
    <table class="list">
        <tr>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Date'), 'Transaction.created');?></div></th>
            <?php if(empty($this->request->params['named']['user_id'])):	 ?>
                <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></div></th>
            <?php endif; ?>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Description'),'TransactionType.name');?></div></th>
            <?php if(!empty($credit)){ ?>
                <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Credit'), 'Transaction.amount').' ('.Configure::read('site.currency').')'.$conv_var;?></div></th>
            <?php } ?>
            <?php if(!empty($debit)){?>
                <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Debit'), 'Transaction.amount').' ('.Configure::read('site.currency').')'.$conv_var;?></div></th>
            <?php } ?>
            <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Gateway Fees'), 'Transaction.gateway_fees').' ('.Configure::read('site.currency').')';?></div></th>
        </tr>
    <?php
    if (!empty($transactions)):
    $i = 0;
    foreach ($transactions as $transaction):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
                <td><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']);?></td>
				<?php if(empty($this->request->params['named']['user_id'])):	?>
                    <td class="dl">
						<?php echo $this->Html->getUserAvatarLink($transaction['User'], 'micro_thumb', false); ?>
						<?php echo $this->Html->getUserLink($transaction['User']); ?>
					</td>
	            <?php endif; ?>
                <td class="dl">
                	<?php if($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::DeductedAmountForOfflineMerchant):?>
						<?php echo $this->Html->cText($transaction['Transaction']['description']); ?>					
					<?php else:?>
						<?php echo $this->Html->transactionDescription($transaction);?>
					<?php endif;?>
                </td>
                <?php if(!empty($credit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo $this->Html->cCurrency($transaction['Transaction']['amount']);
								$credit_total_amt = $credit_total_amt + $transaction['Transaction']['amount']; 
								if(!empty($transaction['Transaction']['converted_amount']) && $transaction['Transaction']['converted_amount'] != '0.00'):
									echo '['.$this->Html->cCurrency($transaction['Transaction']['converted_amount']).']';
								endif;
                            else:
                                echo '--';
                            endif;
                         ?>
                    </td>
                <?php } ?>
                <?php if(!empty($debit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo '--';
                            else:
                                echo $this->Html->cCurrency($transaction['Transaction']['amount']);
							    $debit_total_amt = $debit_total_amt + $transaction['Transaction']['amount'];
								if(!empty($transaction['Transaction']['converted_amount']) && $transaction['Transaction']['converted_amount'] != '0.00' && $transaction['Transaction']['payment_gateway_id'] != 1):
									echo '['.$this->Html->cCurrency($transaction['Transaction']['converted_amount']).']';
								endif;
                            endif;
                         ?>
                    </td>
                <?php } ?>
                <td class="dr">
					<?php echo $this->Html->cFloat($transaction['Transaction']['gateway_fees']);
						 $gateway_total_fee = $gateway_total_fee + $transaction['Transaction']['gateway_fees']; ?>
			    </td>
            </tr>
    <?php
        endforeach; ?>

		<tr class="total-block">
            <td colspan="<?php echo (!empty($this->request->params['named']['user_id'])) ? 2 : 3;?>" class="dr"><?php echo __l('Total'). ' ('.Configure::read('site.currency').')';?></td>
             <?php if(!empty($credit)) {?>
            <td class="dr"><?php echo $this->Html->cCurrency($credit_total_amt);?></td>
			 <?php } if(!empty($debit)) {?>
			<td class="dr"><?php echo $this->Html->cCurrency($debit_total_amt);?></td> 
			<?php } ?>
			<td class="dr"><?php echo $this->Html->cCurrency($gateway_total_fee);?></td>
        </tr>
   <?php else:
    ?>
        <tr>
            <td colspan="11" class="notice"><?php echo __l('No Transactions available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table> 
    <?php
    if (!empty($transactions)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
	<?php if(empty($this->request->params['named']['stat'])):?>
      <table class="list">
		<tr>
				<th colspan='5' class="dr"> <?php echo __l('Filter Summary');?></th> 
		</tr>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Credit');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($total_credit_amount);?></td>
        </tr>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Debit');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($total_debit_amount);?></td>
        </tr>
        <tr class="total-block">
            <td colspan="4" class="dr"><?php echo __l('Transaction Summary (Credit - Debit)');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($total_credit_amount - $total_debit_amount);?></td>
        </tr>
    </table>
	<?php endif;?>

	   <?php if(!empty($this->request->params['named']['user_id'])): ?>
		   <table class="list">
		   <tr>
				<th colspan='5' class="dr"> <?php echo __l('User Summary') .$selected_user_info;?></th> 
		   </tr>
			<tr>
				<td colspan="4" class="dr"><?php echo __l('Credit');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($credit_total_amt);?></td>
			</tr>
			<tr>
				<td colspan="4" class="dr"><?php echo __l('Debit');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($debit_total_amt);?></td>
			</tr>
			<tr>
				<td colspan="4" class="dr"><?php echo __l('Withdraw Request');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($user['User']['blocked_amount']);?></td>
			</tr>
			<tr class="total-block">
				<td colspan="4" class="dr"><?php echo __l('Transaction Summary (Cr - Db - Withdraw Request)');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($credit_total_amt - ($debit_total_amt + $user['User']['blocked_amount']));?></td>
			</tr>
			<tr class="total-block">
				<td colspan="4" class="dr"><?php echo $selected_user_info.'  '.__l('Account Balance');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $this->Html->cCurrency($user['User']['available_balance_amount']);?></td>
			</tr>
		</table>
	 <?php endif; ?>
	<?php if(isset($get_conversion_currency['supported_currency']) && empty($get_conversion_currency['supported_currency'])):?>
		<div class="page-info"><?php echo __l('All the amount in the transactions are listed in').' '.$get_conversion_currency['currency_code'].', '.__l('Where the processed gateway amount is in').' '.$get_conversion_currency['conv_currency_code'].' '.__l('(Showed in bracket).'); ?></div>
	<?php endif;?>
</div>
</div>
