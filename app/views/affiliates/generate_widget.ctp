<div class="affiliates index">
    <h2><?php echo __l('Daily Items Widget');?></h2>
     <div class="affiliate-information">
	<div class="add-block">
       <?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array( 'class' => 'affiliate-application','title' => __l('Affiliates'))); ?>
     <?php echo $this->Html->link(__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('class' => 'widthdraw', 'title' => __l('Affiliate Cash Withdrawal Requests'))); ?>
	</div>
    </div>
	<?php echo $this->Form->create('Affiliate', array('class' => 'normal js-ajax-form', 'action' => 'preview'));?>
    <div class="clearfix">
		<h3><?php echo __l('1. Customize your widget');?></h3>
		<p><?php echo __l('Make your widget fit right in on your site with custom sizes, colors and relevant items.');?></p>
		<div class="clearfix affiliate-customize-block">
		   <?php 
		   echo $this->Form->input('default_color', array('type' => 'hidden', 'value' => $this->request->data['Affiliate']['color']));
		   echo $this->Form->input('affiliate_widget_size_id', array('label' => __l('Choose an ad size')));
		   echo $this->Form->input('color', array('label' => __l('Customize your ad accent color'), 'class'=>'js_colorpick', 'style' => 'background:#'.$this->request->data['Affiliate']['color'],'after'=>'<a href="#" class="js-set-default-affiliate-ad-color">Set to default</a>')); 
		   echo $this->Form->input('city_id',array('label' =>__l('Choose a city'))); ?>
		</div>
	</div>
	<div class="clearfix">
		<h3><?php echo __l('2. Generate your widget');?></h3>
		<p><?php echo __l('Just click the "Generate widget" button below to preview and generate your widget code. Simply paste the generated code into your webpage and start making money.');?></p>
		
		<div class="affiliates-submit-block clearfix">
		   <?php echo $this->Form->submit(__l('Generate Widget')); ?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
	<div class="clearfix js-preview-responses">
		<?php
        echo $this->element('../affiliates/preview');?>
	</div>
</div>