<?php /* SVN: $Id: $ */ ?>
<div class="itemCategories form">
<?php echo $this->Form->create('ItemCategory', array('class' => 'normal'));?>
	<?php echo $this->Form->input('name'); ?>
	<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Add'));?>
</div>
<?php echo $this->Form->end();?>
</div>