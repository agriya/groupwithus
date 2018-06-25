<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('Money Transfer Accounts'); ?></span>
</span>
</span>
</h2>
<div class="page-info master-page-info">
	<?php echo __l("In order to withdrawal cash/amount from your account balance in the site, You first need to create a 'Money tranfer account'. You can also add multiple transfer accounts with different gateways and mark any one of them as 'Primary'. The approved withdrawal amount from your account balance will be credited to the 'Primary' marked transfer account.");?>
</div>

<div class="clearfix">
    <?php echo $this->element('money_transfer_accounts-add'); ?>
</div>

<div class="moneyTransferAccounts index">
<?php
?>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
		<th class="dl actions"><?php echo __l('Action');?></div></th>
		<th class="dl"><?php echo __l('Account');?></div></th>
        <th><?php echo $this->Paginator->sort(__l('Payment Gateway'), 'PaymentGateway.name');?></th>
        <th><?php echo $this->Paginator->sort(__l('Primary'),'is_default');?></th>
    </tr>
<?php
if (!empty($moneyTransferAccounts)):
$i = 0;
foreach ($moneyTransferAccounts as $moneyTransferAccount):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="dl actions">
		 <div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        <?php echo __l('Action');?>
                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                    <li>
                                       <span><?php echo $this->Html->link(__l('Delete'), array('controller' => 'money_transfer_accounts', 'action' => 'delete', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'delete', 'title' => 'delete')); ?></span>
                                    </li>
									<?php if (empty($moneyTransferAccount['MoneyTransferAccount']['is_default'])): ?>
										<li>
                                       <span><?php echo $this->Html->link(__l('Make as primary'), array('controller' => 'money_transfer_accounts', 'action' => 'update_status', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'widthdraw', 'title' => 'Make as primary')); ?></span>
                                    </li>
									<?php endif; ?>
                                   </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
			
		</td>
		<td class="dl"><?php echo $this->Html->cText($moneyTransferAccount['MoneyTransferAccount']['account']);?></td>
    	<td class="dc"><?php echo $this->Html->cText($moneyTransferAccount['PaymentGateway']['name']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($moneyTransferAccount['MoneyTransferAccount']['is_default']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8" class="notice"><?php echo __l('No money transfer account available');?></td>
	</tr>
<?php
endif;
?>
</table>
<?php if (!empty($moneyTransferAccounts)):?>
	<?php echo $this->element('paging_links'); ?>
<?php endif;?>
</div>