<?php /* SVN: $Id: index.ctp 54832 2011-05-27 11:08:38Z aravindan_111act10 $ */ ?>
<?php if(empty($this->request->params['named']['stat']) && !isset($this->request->data['Transaction']['tab_check'])): ?>
	<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Transactions'); ?></span></span></span></h2>
    <div class="js-tabs">
        <ul class="clearfix">
            <li><?php echo $this->Html->link(__l('Today'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'day'), array('title' => 'Day Transactions')); ?></li>
            <li><?php echo $this->Html->link(__l('This Week'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'week'), array('title' => 'This Week Transactions')); ?></li>
            <li><?php echo $this->Html->link(__l('This Month'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'month'), array('title' => 'This Month Transactions')); ?></li>
            <li><?php echo $this->Html->link(__l('All'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'all'), array('title' => 'All Transactions')); ?></li>
        </ul>
    </div>
<?php else: ?>
    <div class="transactions index js-response js-responses">
    <?php
        echo $this->Form->create('Transaction', array('action' => 'index' ,'class' => 'normal js-ajax-form'));
     ?>
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
        echo $this->Form->input('tab_check', array('type' => 'hidden','value' => 'tab_check')); ?>
       	  <div class="submit-block clearfix">
            <?php
            	echo $this->Form->submit(__l('Filter'));
            ?>
            </div>
            <?php
            	echo $this->Form->end();
            ?>
    <?php echo $this->element('paging_counter');?>
	<?php
		$get_conversion_currency = $this->Html->getConversionCurrency();
		$conv_var = '';
	?>
	<?php if(isset($get_conversion_currency['supported_currency']) && empty($get_conversion_currency['supported_currency'])):?>
		<?php $conv_var = ' ['.$get_conversion_currency['conv_currency_symbol'].']';?>
	<?php endif;?>
    <table class="list">
        <tr>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Date'), 'created');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Description'),'transaction_type_id');?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Credit'), 'amount');?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Debit'), 'amount');?></div></th>
        </tr>
    <?php
		if (!empty($transactions)):
			$i = 0;
			$j = 1;
			foreach ($transactions as $transaction):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
        <tr<?php echo $class;?>>
            <td><?php echo $this->Html->cDateTime($transaction['Transaction']['created']);?></td>
            <td class="dl">
				<?php if(!empty($transaction['Transaction']['description'])):?>
					<?php echo $this->Html->cText($transaction['Transaction']['description']); ?>
				<?php else:?>
					<?php echo $this->Html->transactionDescription($transaction);?>
				<?php endif;?>
            </td>
            <td class="dr">
                <?php
                    if($transaction['TransactionType']['is_credit']):
						echo $this->Html->siteCurrencyFormat($transaction['Transaction']['amount']);
						if(!empty($transaction['Transaction']['converted_amount']) && $transaction['Transaction']['converted_amount'] != '0.00' && !empty($transaction['Transaction']['converted_currency_id'])):
							if($transaction['Transaction']['converted_currency_id'] != $transaction['Transaction']['currency_id']):
							echo $this->Html->pCurrency($transaction['Transaction']['converted_amount']);
								echo '['.$this->Html->siteCurrencyFormat($this->Html->pCurrency($transaction['Transaction']['converted_amount']), $transaction['ConvertedCurrency']['symbol']).']';
							endif;
						endif;
                    else:
                        echo '--';
                    endif;
                 ?>
            </td>
            <td class="dr">
                <?php
                    if($transaction['TransactionType']['is_credit']):
                        echo '--';
                    else:
						echo $this->Html->siteCurrencyFormat($transaction['Transaction']['amount']);
						if(!empty($transaction['Transaction']['converted_amount']) && $transaction['Transaction']['converted_amount'] != '0.00' && !empty($transaction['Transaction']['converted_currency_id'])):
							if($transaction['Transaction']['converted_currency_id'] != $transaction['Transaction']['currency_id']):
								echo '['.$this->Html->siteCurrencyFormat($this->Html->pCurrency($transaction['Transaction']['converted_amount']), $transaction['ConvertedCurrency']['symbol']).']';
							endif;
						endif;
                    endif;
                 ?>
            </td>
        </tr>
    <?php
        $j++;
        endforeach;
    ?>
    <?php
    else:
    ?>
        <tr>
            <td colspan="11" class="notice"><?php echo __l('No Transactions available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    <table class="list">
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Credit');?></td>
            <td class="dr"><?php echo  $this->Html->siteCurrencyFormat($total_credit_amount);?></td>
        </tr>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Debit');?></td>
            <td class="dr"><?php echo  $this->Html->siteCurrencyFormat($total_debit_amount);?></td>
        </tr>
		<?php if ((Configure::read('merchant.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User)): ?>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Withdraw Request');?></td>
            <td class="dr"><?php echo  $this->Html->siteCurrencyFormat($blocked_amount);?></td>
        </tr>
		<?php endif;?>
        <tr class="total-block">
            <td colspan="4" class="dr">
			<?php if ((Configure::read('merchant.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User)): ?>
				<?php echo __l('Transaction Summary (Cr - Db - Withdraw Request)');?>
			<?php else:?>
				<?php echo __l('Transaction Summary (Cr - Db)');?>
			<?php endif;?>
			</td>
            <td class="dr"><?php echo  $this->Html->siteCurrencyFormat($total_credit_amount - ($total_debit_amount + $blocked_amount));?></td>
        </tr>
        <tr class="total-block">
            <td colspan="4" class="dr"><?php echo __l('Account Balance');?></td>
            <td class="dr"><?php echo  $this->Html->siteCurrencyFormat($user_available_balance);?></td>
        </tr>
    </table>
	<?php if(isset($get_conversion_currency['supported_currency']) && empty($get_conversion_currency['supported_currency'])):?>
		<div class="page-info"><?php echo __l('The amount in [] is the original converted amount processed by Payment Gateways. And the other amount in the actual amount taken from the site.'); ?></div>
	<?php endif;?>
    <?php
    if (!empty($transactions)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
    </div>
<?php endif; ?>