<?php /* SVN: $Id: admin_deduct_amount.ctp 3 2010-04-07 06:03:46Z siva_063at09 $ */ ?>
<div class="transactions form js-response js-responses">
<?php echo $this->Form->create('Merchant', array('action' => 'deductamount', 'admin' => true, 	'class' => 'normal'));?>
	<fieldset>
	<?php
		foreach($merchants as  $merchant)
		{
			?>
			<h3><?php echo $this->Html->cText($merchant['Merchant']['name']); ?></h3>
			<?php echo __l('Available Balance: ').$this->Html->siteCurrencyFormat($merchant['User']['available_balance_amount']);?>
            <?php if($merchant['User']['available_balance_amount'] > 0): ?>
				<?php
					if(Configure::read('site.currency_symbol_place') == 'left'):
						$currecncy_place = 'between';
					else:
						$currecncy_place = 'after';
					endif;	
				?>
				<div class="required "><?php echo $this->Form->input('Merchant.'.$merchant['Merchant']['id'].'.amount', array($currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>', 'label' => __l('Amount')));?>
				</div>
                <?php echo $this->Form->input('Merchant.'.$merchant['Merchant']['id'].'.user_id', array('type' => 'hidden', 'value' => $merchant['Merchant']['user_id']));?>
                <?php echo $this->Form->input('Merchant.'.$merchant['Merchant']['id'].'.description', array('type' => 'textarea', 'label' => __l('Description')));?>
             <?php endif; ?>
            <?php
		}
	?>
	</fieldset> 
		<div class="submit-block clearfix">
<?php
	if(!empty($merchant['User']['available_balance_amount']) && $merchant['User']['available_balance_amount'] != '0.00'):
	 echo $this->Form->submit(__l('Update'));?>
	
<div class="cancel-block">
	<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'merchants', 'action' => 'index'), array('class' => 'js-deduct-disable', 'title' => __l('Cancel'), 'escape' => false));?>
</div>
<?php endif; ?>
</div>
<?php echo $this->Form->end();?>
</div>
