<?php /* SVN: $Id: unsubscribe.ctp 32532 2010-11-08 14:57:19Z saranya_127act10 $ */ ?>
<div class="js-responses">
<?php if(!empty($cities)): ?>
<?php echo $this->Form->create('Subscription', array('url'=>array('action'=>'subscribes'),'class' => 'normal unsubscribe-form js-ajax-form'));?>
	<fieldset>
		<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('Manage Your Subscriptions'); ?></span>
</span>
</span>
</h2>
        <div class="subscription-group-block clearfix">
			<?php 
					echo $this->Form->input('City',array('label' =>false,'multiple'=>'checkbox', 'options' => $cities)); 
			?>            
        </div>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Subscribe'), array('title' => __l('Subscribe'))); ?>
        <div class="cancel-block">
            <?php echo $this->Html->link(__l('Oops, i changed my mind'), array('controller'=>'items','action' => 'index'), array('class' => 'cancel-button', 'title' => __l('Oops, i changed my mind'))); ?>
        </div>
    </div>
    <?php echo $this->Form->end();?>
	</fieldset>
<?php endif;?>    
</div>
   