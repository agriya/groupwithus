<?php /* SVN: $Id: $ */ ?>
<div class="colleges form">
<?php echo $this->Form->create('College', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('name', array('label' => __l('Name')));
	?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>