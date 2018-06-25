<?php /* SVN: $Id: $ */ ?>
<div class="userInterests form">
<h3> <?php echo __l('Add User Interest');?></h3>
<?php echo $this->Form->create('UserInterest', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('User');
	?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>