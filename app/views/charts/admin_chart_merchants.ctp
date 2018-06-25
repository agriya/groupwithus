<div class="clearfix">
	<div class="clearfix">
		<h3><?php echo __l('Top 10 Merchants'); ?></h3>
		<table class="list">
			<tr>        
				<th class="dl" rowspan="2"><?php echo __l('Merchant');?></th>   
				<th class="dc" colspan="3"><?php echo __l('Total');?></th> 
				<th class="dc" colspan="3"><?php echo __l('Average');?></th>
				<th class="dc" colspan="2"><?php echo __l('Max').'/'.__l('Item');?></th>
			</tr>
			<tr>
				<th class="dr"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')';?></th>
				<th class="dc"><?php echo __l('# Items');?></th>
				<th class="dc"><?php echo __l('# Pass');?></th>
				<th class="dc"><?php echo __l('Pass').'/'.__l('Item');?></th>
				<th class="dr"><?php echo __l('Revenue').'/'.__l('Item').' ('.Configure::read('site.currency').')';?></th>
				<th class="dr"><?php echo __l('Offered Price'). '('.Configure::read('site.currency').')';?></th>
				<th class="dc"><?php echo __l('# Pass');?></th>
				<th class="dr"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')';?></th>
			</tr>
			<?php
				if (!empty($merchants)):
					$i = 0;
					$total_revenue = 0;
					$total_pass = 0;
					foreach ($merchants as $merchant):
						$total_revenue += $merchant['Merchant']['total_site_revenue_amount'];
						$total_pass += $merchant['Merchant']['pass_count'];
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}			
			?>
			<tr<?php echo $class;?>>       
				<td class="dl"><?php echo $this->Html->cText($merchant['Merchant']['name']);?></td>
				<td class="dr"><?php echo $this->Html->cCurrency($merchant['Merchant']['total_site_revenue_amount']);?></td>
				<td class="dc"><?php echo $this->Html->cInt($merchant['Merchant']['items_count']);?></td>
				<td class="dc"><?php echo $this->Html->cInt($merchant['Merchant']['pass_count']);?></td>
				<td class="dc"><?php echo $this->Html->cInt($merchant['Merchant']['average_pass_item_count']);?></td>
				<td class="dr"><?php echo $this->Html->cCurrency($merchant['Merchant']['average_revenue_item_amoumt']);?></td>
				<td class="dr"><?php echo $this->Html->cCurrency($merchant['Merchant']['average_offered_price']);?></td>
				<td class="dc"><?php echo $this->Html->cInt($merchant['Merchant']['max_pass_per_item']);?></td>
				<td class="dr"><?php echo $this->Html->cCurrency($merchant['Merchant']['max_revenue_per_item']);?></td>
			</tr>
			<?php
					endforeach;
				else:
			?>
			<tr>
				<td colspan="11" class="notice"><?php echo __l('No stats available');?></td>
			</tr>
			<?php
				endif;
			?>
		</table>
	</div>
	<div class="clearfix">	    
		<?php if(!empty($merchants)): ?>
			<div class="js-load-pie-chart chart-half-section {'data_container':'merchant_pie_revenue_data', 'chart_container':'merchant_pie_revenue_chart', 'chart_title':'<?php echo __l('Merchant by Total Revenue');?>', 'chart_y_title': '<?php echo __l('Merchant by Total Revenue');?>'}">
				<div class="dashboard-tl">
					<div class="dashboard-tr">
						<div class="dashboard-tc"></div>
					</div>
				</div>
				<div class="dashboard-cl">
					<div class="dashboard-cr">
						<div class="dashboard-cc clearfix">
							<div id="merchant_pie_revenue_chart" class="merchant-chart"></div>
							<div class="hide">
								<table id="merchant_pie_revenue_data" class="list">								
									<tbody>
										<?php foreach($merchants as $merchant): ?>
											<tr>
											   <th><?php echo $merchant['Merchant']['name']; ?></th>
											   <td><?php echo ($merchant['Merchant']['total_site_revenue_amount']/$total_revenue)*100; ?></td>
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
		<?php endif; ?>
		<?php if(!empty($merchants)): ?>
			<div class="js-load-pie-chart chart-half-section {'data_container':'merchant_pie_pass_data', 'chart_container':'merchant_pie_pass_chart', 'chart_title':'<?php echo __l('Merchant by # Pass Sold');?>', 'chart_y_title': '<?php echo __l('Merchant by # Pass Sold');?>'}">
				<div class="dashboard-tl">
					<div class="dashboard-tr">
						<div class="dashboard-tc"></div>
					</div>
				</div>
				<div class="dashboard-cl">
					<div class="dashboard-cr">
						<div class="dashboard-cc clearfix">
							<div id="merchant_pie_pass_chart" class="merchant-chart"></div>
							<div class="hide">
								<table id="merchant_pie_pass_data" class="list">								
									<tbody>
										<?php foreach($merchants as $merchant): ?>
											<tr>
											   <th><?php echo $merchant['Merchant']['name']; ?></th>
											   <td><?php echo ($merchant['Merchant']['pass_count']/$total_pass)*100; ?></td>
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
		<?php endif; ?>
	</div>
</div>