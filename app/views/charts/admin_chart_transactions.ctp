<div class="clearfix js-responses js-cache-load-admin-charts-transactions">
	<div class="main-tl">
		<div class="main-tr">
			<div class="main-tm"> </div>
		</div>
	</div>
	<div class="main-left-shadow">
		<div class="main-right-shadow">
			<div class="main-inner clearfix">
				<h2 class="chart-dashboard-title ribbon-title clearfix">
                    <span class="ribbon-right">
                        <span class="ribbon-inner">
                            <?php echo __l('Overview'); ?>
                        </span>
                    </span>
                    <span class="js-chart-showhide up-arrow {'chart_block':'admin-dashboard-overview'}">&nbsp;</span>
                </h2>
				<div class="admin-center-block dashboard-center-block clearfix" id="admin-dashboard-overview">
					<div class="clearfix">
						<?php echo $this->Form->create('Chart' , array('class' => 'language-form', 'action' => 'chart_transactions')); ?>
						<?php echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range'))); ?>
						<div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
						<?php echo $this->Form->end(); ?>
					</div>
					<div class="js-load-line-graph chart-half-section {'data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="transactions_line_chart" class="admin-dashboard-chart"></div>
									<div class="hide">
										<table id="transactions_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_transactions_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>              	
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_transactions_data as $display_name => $chart_data): ?>
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
					<div class="js-load-column-chart chart-half-section {'data_container':'total_orders_column_data', 'chart_container':'total_orders_column_chart', 'chart_title':'<?php echo __l('Total Orders') ;?>', 'chart_y_title': '<?php echo __l('Orders');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="total_orders_column_chart" class="admin-dashboard-chart"></div>
									<div class="hide">
										<table id="total_orders_column_data" class="list">
											<tbody>
												<?php foreach($chart_item_orders_data as $key => $_data): ?>
													<tr>
														<th><?php echo $key; ?></th>
														<td><?php echo $_data[0]; ?></td>
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
		</div>
	</div>
	<div class="main-bl">
		<div class="main-br">
			<div class="main-bm"> </div>
		</div>
	</div>
</div>