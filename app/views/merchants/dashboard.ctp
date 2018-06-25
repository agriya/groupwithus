<div class="users stats">
		<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Dashboard'); ?></span></span></span></h2>
		<div class="grid_18 omega alpha1">
			<div class="side1-tl">
				<div class="side1-tr">
					<div class="side1-tm"> </div>
				</div>
			</div>
			<div class="side1-cl">
				<div class="side1-cr">
					<div class="block1-inner">
						<div class="admin-stats-block clearfix">
							<?php echo $this->element('chart-chart_merchant_transactions', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id')))); ?>
						</div>
						<div class="admin-stats-block clearfix">
							<?php echo $this->element('chart-chart_items', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id')))); ?>
						</div>
						<div class="admin-stats-block clearfix">
							<?php echo $this->element('chart-chart_merchant_users', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id')))); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="side1-bl">
				<div class="side1-br">
					<div class="side1-bm"> </div>
				</div>
			</div>
		</div>
</div>