<?php /* SVN: $Id: edit.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="ItemComments form">
<?php echo $this->Form->create('ItemComment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit item Comment');?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('item_id');
		echo $this->Form->input('posted_user_id');
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>