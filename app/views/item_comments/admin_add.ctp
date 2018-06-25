<?php /* SVN: $Id: admin_add.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="ItemComments form">
<?php echo $this->Form->create('ItemComment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add item Comment');?></h2>
	<?php
		echo $this->Form->input('item_id',array('label' => __l('User')));
		echo $this->Form->input('posted_user_id',array('label' => __l('Posted User')));
		echo $this->Form->input('comment',array('label' => __l('Comment')));
	?>
	</fieldset>
    <div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>