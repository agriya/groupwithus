<?php /* SVN: $Id: $ */ ?>
<div class="userJobs form js-responses">
<h2> <?php echo __l('Add UserJob');?></h2>
<?php echo $this->Form->create('UserJob', array('class' => 'normal js-ajax-form'));?>
	<fieldset>
	<?php
        echo $this->Form->input('user_id', array('type' => 'hidden','value'=>$this->Auth->user('id')));
        echo $this->Form->autocomplete('Company.name', array('label' => __l('Company Name'), 'acFieldKey' => 'Company.id', 'acFields' => array('Company.name'), 'acSearchFieldNames' => array('Company.name'), 'maxlength' => '255'));
		//echo $this->Form->input('company_name');
		echo $this->Form->input('position');
	?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>