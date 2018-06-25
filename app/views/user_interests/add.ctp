<?php /* SVN: $Id: $ */ ?>
<div class="userInterests form js-responses">
<div class='pages-info'><?php echo __l('Search for an interest and follow it to get notified when items are available for that interest. ');?></div>
<?php echo $this->Form->create('UserInterest', array('class' => 'normal js-ajax-form clearfix'));?>
	<?php
		echo $this->Form->input('name',array('label'=>false));
		echo $this->Form->input('User', array('type' => 'hidden','value' => $this->Auth->user('id')));
	?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Follow'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>