<?php $this->pageTitle = __l('Tools'); ?>
<div class="page-tools" id="js-confirm-message-block">    
	<div class="info-details"><?php echo __l('When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ').$this->Html->link('product manual','http://dev1products.dev.agriya.com/doku.php?id=groupwithus-install#manual_cron_update_process', array('target'=>'_blank'));?></div>
	<div class="add-block1"><?php echo $this->Html->link(__l('Trigger Cron Manually to update item status'), array('controller' => 'items', 'action' => 'update_status'), array('class' => 'update-status js-confirm-mess', 'title' => __l('Trigger cron functions manually to update item status (If for some reasons, cron is not getting triggered, clicking this link will trigger the functionality)')));?></div>
	<div class="add-block1"><?php echo $this->Html->link(__l('Manually trigger cron to update currency conversion rate'), array('controller' => 'currencies', 'action' => 'update_status'), array('class' => 'js-confirm-mess', 'title' => __l('You can use this to update currency conversion rate. This will be used in the scenario where cron is not working')));?></div>
</div>