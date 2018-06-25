<?php /* SVN: $Id: $ */ ?>
<div class="userSchools form js-responses">
<h2 class="ribbon-title clearfix">
    <span class="ribbon-left">
        <span class="ribbon-right">
            <span class="ribbon-inner">
                <?php echo __l('Add User School');?>
              </span>
        </span>
    </span>
</h2>
<?php echo $this->Form->create('UserSchool', array('class' => 'normal js-ajax-form'));?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id', array('type' => 'hidden','value'=>$this->Auth->user('id')));
		echo $this->Form->input('user_school_degree_id', array('empty' => __l('Please Select')));
		echo $this->Form->autocomplete('College.name', array('label' => __l('College'), 'acFieldKey' => 'College.id', 'acFields' => array('College.name'), 'acSearchFieldNames' => array('College.name'), 'maxlength' => '255'));?>
		<div class="input select">
			<label><?php echo __l('Year'); ?></label>
			<?php echo $this->Form->year('passout', 1970, date('Y')); ?>
		</div>
		<?php echo $this->Form->input('major1');
		echo $this->Form->input('major2');
		echo $this->Form->input('major3');
	?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>