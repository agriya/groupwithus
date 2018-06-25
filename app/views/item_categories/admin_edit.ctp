<?php /* SVN: $Id: $ */ ?>
<div class="itemCategories form">
<?php echo $this->Form->create('ItemCategory', array('class' => 'normal'));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
<?php echo $this->Form->end(__l('Update'));?>
</div>