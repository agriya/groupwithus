<div class="page-block pages">
<h2 class="ribbon-title clearfix">
		<span class="ribbon-left">
			<span class="ribbon-right">
				<span class="ribbon-inner">
					<?php echo __l('Forgot your password?');?>
				</span>
			</span>
		</span>
	</h2>
<div class="static-content-block">
<div class="forgot-info">
	<?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
</div>
<div class="form-block">
<?php
	echo $this->Form->create('User', array('action' => 'forgot_password', 'class' => 'normal'));
	echo $this->Form->input('email', array('type' => 'text','label' => __l('Email'))); ?>

<div class="submit-block clearfix">
<?php
	echo $this->Form->submit(__l('Send'));
?>
</div>
<?php
	echo $this->Form->end();
?>
</div>
</div>
</div>