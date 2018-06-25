<div class="users stats js-response js-responses clearfix">
	<div class="grid_19 omega alpha">
		<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/charts/chart_stats/cache:0', 'data_load':'js-cache-load-admin-charts'}">
			<?php echo $this->element('admin-charts-stats', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
		</div>
	</div>
	<div class="grid_5 dashboard-side2 omega alpha grid_right">
		<div class="main-tl">
			<div class="main-tr">
				<div class="main-tm"> </div>
			</div>
		</div>
		<div class="main-left-shadow">
			<div class="main-right-shadow">
				<div class="main-inner clearfix">
					<h2 class="ribbon-title clearfix"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Timings'); ?></span></span></h2>
					<ul class="admin-dashboard-links">
						<li>
							<?php $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime('now')) . ' ' . Configure::read('site.timezone_offset') . '"'; ?>
							<?php echo __l('Current time: '); ?><span <?php echo $title; ?>><?php echo strftime(Configure::read('site.datetime.format')); ?></span>
						</li>
						<li>
							<?php echo __l('Last login: '); ?><?php echo $this->Html->cDateTimeHighlight($this->Auth->user('last_logged_in_time')); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-bl">
			<div class="main-br">
				<div class="main-bm"> </div>
			</div>
		</div>
		<div class="js-cache-load js-cache-load-recent-users {'data_url':'admin/users/recent_users', 'data_load':'js-cache-load-recent-users'}">
			<?php echo $this->element('users-admin_recent_users', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
		</div>
		<div class="js-cache-load js-cache-load-online-users {'data_url':'admin/users/online_users', 'data_load':'js-cache-load-online-users'}">
			<?php echo $this->element('users-admin_online_users', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
		</div>
		<div class="main-left-shadow">
			<div class="main-right-shadow">
				<div class="main-inner clearfix">
					<h2 class="ribbon-title clearfix"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('GroupWithUs'); ?></span></span></h2>
					<ul class="admin-dashboard-links">
						<li class="version-info"><?php echo __l('Version').' ' ?><span><?php echo Configure::read('site.version'); ?></span></li>
						<li><?php echo $this->Html->link(__l('Product Support'), 'http://customers.agriya.com/', array('target' => '_blank', 'title' => __l('Product Support'))); ?></li>
						<li><?php echo $this->Html->link(__l('Product Manual'), 'http://dev1products.dev.agriya.com/doku.php?id=groupwithus' ,array('target' => '_blank','title' => __l('Product Manual'))); ?></li>
						<li><?php echo $this->Html->link(__l('CSSilize'), 'http://www.cssilize.com/', array('target' => '_blank', 'title' => __l('CSSilize'))); ?><small>PSD to XHTML Conversion and GroupWithUs theming</small></li>
						<li><?php echo $this->Html->link(__l('Agriya Blog'), 'http://blogs.agriya.com/' ,array('target' => '_blank','title' => __l('Agriya Blog'))); ?><small>Follow Agriya news</small></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-bl">
			<div class="main-br">
				<div class="main-bm"> </div>
			</div>
		</div>
	</div>
</div>