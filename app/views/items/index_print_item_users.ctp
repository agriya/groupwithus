<script>
	window.print();
</script>
    <h2><?php echo $this->Html->cText($item_list['item_name']);?> </h2>
    <p><?php echo __l('Total Quantities Sold').': '.$this->Html->cInt($item_list['item_user_count']);?> </p>
    <p><?php echo __l('Event Date').': '.$this->Html->cDateTime($item_list['event_date']);?> </p>
    <p><?php echo __l('Item Status').': '.$this->Html->cText($item_list['item_status']);?> </p>
    <table border="1">
        <tr>
            <th><?php echo __l('Username'); ?></th>
            <th><?php echo __l('Quantity'); ?></th>
            <th><?php echo __l('Amount'); ?></th>
            <th><?php echo __l('Pass Code'); ?></th>
            <th><?php echo __l('Status'); ?></th>
        </tr>
    <?php if(!empty($items)): ?>
    
    <?php foreach($items as $item): ?>
        <tr>
            <td><?php echo $this->Html->cText($item['Item']['username']);?></td>
            <td><?php echo $this->Html->cInt($item['Item']['quantity']); ?></td>
            <td><?php echo $this->Html->siteCurrencyFormat($item['Item']['discount_amount']); ?></td>
            <td>
				<ul>
				<?php 
					foreach($item['Item']['pass_code'] as $item_user_pass){
						echo '<li>#'.$this->Html->cText($item_user_pass['pass_code']).'</li>';
					}
				?>
				</ul>
			</td>
			<td>
				<ul>
				<?php 
					foreach($item['Item']['pass_code'] as $item_user_pass){
						echo '<li>'.(!empty($item_user_pass['is_used']) ? __l('Used') : __l('Not used')).'</li>';
					}
				?>
				</ul>
			</td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="11"><?php echo __l('No Items available');?></td></tr>
    <?php endif; ?>
    </table>