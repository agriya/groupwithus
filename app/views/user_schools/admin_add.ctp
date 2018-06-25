<?php /* SVN: $Id: $ */ ?>
<div class="userSchools form">
<?php echo $this->Form->create('UserSchool', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('user_school_degree_id');
		echo $this->Form->autocomplete('College.name', array('label' => __l('College'), 'acFieldKey' => 'College.id', 'acFields' => array('College.name'), 'acSearchFieldNames' => array('College.name'), 'maxlength' => '255'));
		//echo $this->Form->input('college');
		?>
		<div class="input select">
		<label><?php echo __l('Year'); ?></label>
		<?php echo $this->Form->year('UserSchool',1970, date('Y')); ?>
		</div>
    <?php
		echo $this->Form->input('major1');
		echo $this->Form->input('major2');
		echo $this->Form->input('major3');
	?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
