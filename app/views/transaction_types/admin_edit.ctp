<?php /* SVN: $Id: $ */ ?>
<div class="transactionTypes form">
	<?php echo $this->Form->create('TransactionType', array('class' => 'normal'));?>
	<fieldset>
		<?php 
			echo $this->Form->input('id');
			echo $this->Form->input('name', array('label'=>__l('Name')));
			$info = !empty($this->request->data['TransactionType']['transaction_variables']) ? __l('Available Variables: ') . $this->Html->cText($this->request->data['TransactionType']['transaction_variables']) : '';
			echo $this->Form->input('message', array('label'=>__l('Message'), 'info' => $info));
		?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Update')); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>