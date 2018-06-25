<div class="clearfix">
	<table class="list">
		<tr>        
			<th class="dc"></th>
			<th class="dr"><?php echo __l('Min');?></th> 
			<th class="dr"><?php echo __l('Max');?></th>
			<th class="dr"><?php echo __l('Sum');?></th>
		</tr>
		<tr>
			<td class="dr"><?php echo __l('Offered Price').' ('.Configure::read('site.currency').')';?></td>
			<td class="dr"><?php echo $this->Html->cCurrency($items_stats['price']['min']);?></td>
			<td class="dr"><?php echo $this->Html->cCurrency($items_stats['price']['max']);?></td>	
			<td class="dr"></td>
		</tr>
		<tr>			
			<td class="dr"><?php echo __l('Quantities Sold');?></td>
			<td class="dr"><?php echo $this->Html->cInt($items_stats['sold_quantity']['min']);?></td>
			<td class="dr"><?php echo $this->Html->cInt($items_stats['sold_quantity']['max']);?></td>	
			<td class="dr"><?php echo $this->Html->cInt($items_stats['sold_quantity']['sum']);?></td>	
		</tr>
		<tr class="total-block">			
			<td class="dr"><?php echo __l('Total Revenue').' ('.Configure::read('site.currency').')';?></td>
			<td class="dr"><?php echo $this->Html->cCurrency($items_stats['total_revenue']['min']);?></td>
			<td class="dr"><?php echo $this->Html->cCurrency($items_stats['total_revenue']['max']);?></td>	
			<td class="dr"><?php echo $this->Html->cCurrency($items_stats['total_revenue']['sum']);?></td>	
		</tr>
		<tr>			
			<td class="dr"><?php echo __l('Average Sold Price');?></td>
			<td class="dr" colspan="3"><?php echo $this->Html->cFloat(!empty($items_stats['sold_quantity']['sum']) ? ($items_stats['total_revenue']['sum']/$items_stats['sold_quantity']['sum']): 0);?></td>			
		</tr>
	</table>				
</div>