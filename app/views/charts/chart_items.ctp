<div class="clearfix js-responses js-load-admin-chart-item-ctp">
 <?php
 		$arrow = "down-arrow";
 		if(isset($this->request->params['named']['is_ajax_load'])){
 		$arrow = "up-arrow";
	   }
 ?>
	<?php
		$class = 'admin-dashboard-chart';
		$class_pass = 'admin-dashboard-pass-usage-chart';
		if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant){
			$class = 'merchant-dashboard-chart';
			$class_pass = 'merchant-dashboard-pass-usage-chart';
			$arrow = 'up-arrow';
			$meta_data ="";
		}
		else{
		$meta_data = ", 'dataloading':'div.js-load-admin-chart-item-ctp',  'dataurl':'admin/charts/chart_items/is_ajax_load:1'";
	}
	?>
	<div class="main-tl">
		<div class="main-tr">
			<div class="main-tm"> </div>
		</div>
	</div>
	<div class="main-left-shadow">
		<div class="main-right-shadow">
			<div class="main-inner clearfix">
				<h2 class="chart-dashboard-title ribbon-title clearfix">
                    <span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Items/Passes'); ?></span></span>
                    <span class="js-chart-showhide <?php echo $arrow; ?> {'chart_block':'admin-dashboard-items'<?php echo $meta_data; ?>}">&nbsp;</span>
                </h2>
                <?php if(isset($this->request->params['named']['is_ajax_load']) ||$this->Auth->user('user_type_id') == ConstUserTypes::Merchant){ ?>
				<div class="admin-center-block clearfix dashboard-center-block" id="admin-dashboard-items">
					<div class="clearfix">
						<?php echo $this->Form->create('Chart' , array('class' => 'language-form'.$meta_data, 'action' => 'chart_items'));
							echo $this->Form->input('is_ajax_load', array('type' => 'hidden', 'value' => 1));
                        ?>
						<?php echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range'))); ?>
						<div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
						<?php echo $this->Form->end(); ?>
					</div>
					<div class="clearfix">
					<div class="js-load-line-graph chart-half-section {'data_container':'items_line_data', 'chart_container':'items_line_chart', 'chart_title':'<?php echo __l('Items') ;?>', 'chart_y_title': '<?php echo __l('Items');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="items_line_chart" class="<?php echo $class; ?>"></div>
									<div class="hide">
										<table id="items_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_items_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>              	
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_items_data as $display_name => $chart_data): ?>
													<tr>
														<th><?php echo $display_name; ?></th>
														<?php foreach($chart_data as $val): ?>
															<td><?php echo $val; ?></td>
														<?php endforeach; ?> 
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="dashboard-bl">
							<div class="dashboard-br">
								<div class="dashboard-bc"></div>
							</div>
						</div>
					</div>
					<div class="js-load-line-graph chart-half-section {'data_container':'item_pass_line_data', 'chart_container':'item_pass_line_chart', 'chart_title':'<?php echo __l('Item Orders/Passes') ;?>', 'chart_y_title': '<?php echo __l('Orders/Passes');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="item_pass_line_chart" class="<?php echo $class; ?>"></div>
									<div class="hide">
										<table id="item_pass_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_item_pass_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>              	
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_item_pass_data as $display_name => $chart_data): ?>
													<tr>
														<th><?php echo $display_name; ?></th>
														<?php foreach($chart_data as $val): ?>
															<td><?php echo $val; ?></td>
														<?php endforeach; ?> 
													</tr>
												<?php endforeach; ?>     	        							
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="dashboard-bl">
							<div class="dashboard-br">
								<div class="dashboard-bc"></div>
							</div>
						</div>
					</div>
					<div class="js-load-line-graph chart-half-section {'data_container':'pass_usages_line_data', 'chart_container':'pass_usages_line_chart', 'chart_title':'<?php echo __l('Pass Usages') ;?>', 'chart_y_title': '<?php echo __l('Passes');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="pass_usages_line_chart" class="<?php echo $class_pass; ?>"></div>
									<div class="hide">
										<table id="pass_usages_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_pass_usage_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>              	
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_pass_usage_data as $display_name => $chart_data): ?>
													<tr>
														<th><?php echo $display_name; ?></th>
														<?php foreach($chart_data as $val): ?>
															<td><?php echo $val; ?></td>
														<?php endforeach; ?> 
													</tr>
												<?php endforeach; ?>     	        							
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="dashboard-bl">
							<div class="dashboard-br">
								<div class="dashboard-bc"></div>
							</div>
						</div>
					</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="main-bl">
		<div class="main-br">
			<div class="main-bm"> </div>
		</div>
	</div>
</div>