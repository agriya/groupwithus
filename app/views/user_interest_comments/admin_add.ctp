<?php /* SVN: $Id: admin_add.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="userComments form">
<?php echo $this->Form->create('UserInterestComment', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id',array('label' => __l('User')));
		echo $this->Form->input('posted_user_id',array('label' => __l('Posted User')));
		echo $this->Form->input('comment',array('label' => __l('Comment')));
	?>
	</fieldset>
    <div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
