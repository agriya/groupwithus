<?php /* SVN: $Id: edit.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="charityCashWithdrawals form">
<?php echo $this->Form->create('CharityCashWithdrawal', array('action' => 'admin_manual_payment', 'class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('description',array('type' => 'textarea', 'label' => __l('Description')));		
	?>
	</fieldset>
	<div class="submit-block">
        <?php echo $this->Form->end(__l('Pay'));?>
    </div>
</div>
