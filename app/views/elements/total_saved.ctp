<?php $total_array = $this->Html->total_saved(); ?>
<dt><?php echo __l('Total Bought: '); ?></dt>
    <dd><?php echo $this->Html->cInt($total_array['total_bought']); ?></dd>