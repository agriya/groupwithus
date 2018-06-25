<div class="clearfix js-responses">
	<?php
		$chart_title = __l('Purchased Users');
		$chart_y_title = __l('Users');
		$user_type_id = 1; // for unique id
	?>
	<div class="main-tl">
		<div class="main-tr">
			<div class="main-tm"> </div>
		</div>
	</div>
	<div class="main-left-shadow">
		<div class="main-right-shadow">
			<div class="main-inner clearfix">
				<h2 class="chart-dashboard-title ribbon-title clearfix"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Purchased User'); ?></span></span><span class="js-chart-showhide up-arrow {'chart_block':'merchant-dashboard-user'}">&nbsp;</span></h2>
				<div class="admin-center-block dashboard-center-block" id="merchant-dashboard-user">
					<h3 class="sub-header"><?php echo __l('Demographics'); ?></h3>
					<?php if(!empty($chart_pie_data)): ?>
                        <div class="clearfix">
                        <div class="js-load-pie-chart chart-half-section {'data_container':'user_pie_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo $chart_title;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
							<div class="dashboard-tl">
								<div class="dashboard-tr">
									<div class="dashboard-tc"></div>
								</div>
							</div>
							<div class="dashboard-cl">
								<div class="dashboard-cr">
									<div class="dashboard-cc clearfix">
										<div id="user_pie_chart<?php echo $user_type_id; ?>" class="merchant-dashboard-user-chart"></div>
										<div class="hide">
											<table id="user_pie_data<?php echo $user_type_id; ?>" class="list">
												<tbody>
													<?php foreach($chart_pie_data as $display_name => $val): ?>
														<tr>
															<th><?php echo $display_name; ?></th>
															<td><?php echo $val; ?></td>
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
				    <?php endif; ?>
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