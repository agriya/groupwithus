<div class="clearfix">	 	
	<h2><?php echo __l('Snapshot');?></h2>
	<h3><?php echo $this->Html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', $item['Item']['slug'],'admin'=>false),array('title' =>sprintf(__l('%s'),$item['Item']['name']))); ?></h3>
	<div class="clearfix">
		<table class="list">
			<tr>        
				<th class="dc" colspan="2"><?php echo __l('Purchases');?></th>   			
			</tr>
			<tr>
				<td class="dr"><?php echo __l('Total Sold');?></td>			
				<td class="dr"><?php echo $this->Html->cInt($item_stats['pass']);?></td>
			</tr>
			<tr>
				<td class="dr"><?php echo __l('Total Redeemed');?></td>			
				<td class="dr"><?php echo $this->Html->cInt($item_stats['redeemed']);?></td>
			</tr>
		</table>				
	</div>
	<?php if(!empty($chart_quantity_sold)): ?>
		<h3><?php echo __l('Purchase Demographics'); ?></h3>
		<div class="js-load-column-chart chart-half-section {'data_container':'item_pass_sold_column_data', 'chart_container':'item_pass_sold_column_chart', 'chart_title':'<?php echo __l('Quantities Sold') ;?>', 'chart_y_title': '<?php echo __l('Quantity');?>', 'series_type':'line'}">
			<div class="dashboard-tl">
				<div class="dashboard-tr">
					<div class="dashboard-tc"></div>
				</div>
			</div>
			<div class="dashboard-cl">
				<div class="dashboard-cr">
					<div class="dashboard-cc clearfix">
						<div id="item_pass_sold_column_chart" class="item-stats-user-chart"></div>
						<div class="hide">
							<table id="item_pass_sold_column_data" class="list">
								<tbody>
									<?php foreach($chart_quantity_sold as $data): ?>
										<tr>
											<th><?php echo $data['display']; ?></th>
											<td><?php echo $data['quantity']; ?></td>
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
	
		<div class="clearfix"><?php echo $this->element('chart-user_demographics', array('chart_y_title'=> __l('Purchased Users'), 'user_type_id' => 1)); ?></div>
	<?php endif; ?>
	<?php if(!empty($item['ItemUser'])):?>
		<div class="js-item-purchase-map clearfix">
			<h3><?php echo __l('Purchase Locations'); ?></h3>
			<div id="js-item-purchase-location-map"  class="item-purchased-user-map"></div>		
				<div class="hide">
				<table id="item_sold_location_data" class="list">
					<tbody>
						<?php foreach($item['ItemUser'] as $itemUser):?>
							<tr>
							    <th class="js-search-latitude {'cur_lat':'<?php echo $itemUser['latitude']; ?>'}"><?php echo $itemUser['latitude']; ?></th>
								<td  class="js-search-longitude {'cur_lng':'<?php echo $itemUser['longitude']; ?>'}"><?php echo $itemUser['longitude']; ?></td>
							</tr>	
						<?php endforeach; ?>    
					</tbody>				
				</table>
			</div>
		</div>
	<?php endif; ?>	
</div>