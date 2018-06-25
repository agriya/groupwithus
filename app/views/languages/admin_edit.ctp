<?php /* SVN: $Id: admin_edit.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="languages form">
	<?php echo $this->Form->create('Language', array('class' => 'normal'));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label' => __l('Name')));
		echo $this->Form->input('iso2',array('label' => __l('Iso2')));
		echo $this->Form->input('iso3',array('label' => __l('Iso3')));
		echo $this->Form->input('is_active',array('label' => __l('Active')));
	?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Update'));?>
		<div class="cancel-block">
			<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'languages', 'action' => 'index'), array('class' => 'cancel-link', 'title' => __l('Cancel'), 'escape' => false));?>
		</div>
	</div>
		<?php echo $this->Form->end();?>
</div>