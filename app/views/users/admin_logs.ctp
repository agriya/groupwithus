<div class="sub-menu-block clearfix">
</div>
<div class="admin-inner-block">
<div class="round-5 admin-inner-section">
<div class="users stats">
    <div class="admin-top-inner-block clearfix">
    </div>
	<div class="admin-top-inner-block clearfix">
        <h2><?php echo __l('Memory Status'); ?></h2>
            <dl class="list clearfix">
                <dt class="altrow"><?php echo __l('Used Cache Memory');?></dt>
		  			<dd class="altrow"><?php echo $tmpCacheFileSize; ?></dd>
                <dt><?php echo __l('Used Log Memory');?></dt>
		  			<dd><?php echo $tmpLogsFileSize; ?></dd>
            </dl>
	</div>
	<div class="admin-top-inner-block clearfix">
		<h2><?php echo __l('Recent Errors & Logs'); ?></h2>
		<div>
			<h3><?php echo __l('Error Log')?></h3>
			<?php
				echo $this->Html->link(__l('Clear Error Log'), array('controller' => 'users', 'action' => 'admin_clear_logs', 'type' => 'error_log'));
			?>
			<div><textarea rows="15" cols="80"><?php echo $error_log;?></textarea></div>
			<h3><?php echo __l('Debug Log')?></h3>
			<?php
			echo $this->Html->link(__l('Clear Debug Log'), array('controller' => 'users', 'action' => 'admin_clear_logs', 'type' => 'debug_log'));
			?>
			<div><textarea rows="15" cols="80"><?php echo $debug_log;?></textarea></div>		</div>
	</div>
</div>
</div>
</div>