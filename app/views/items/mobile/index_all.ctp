<div class="items-list-block">
    <ol class="items-list clearfix">
        <?php if($items){
            foreach($items as $item) {
                if($item_id==$item['Item']['id']){
                    $class="active";
                }
                else{
                    $class="";
                }
            $attachment=$item['Attachment'][0]; ?>
        <li class="<?php echo $class;?>">
            <div class="clearfix"><?php if($item['Item']['item_status_id']==ConstItemStatus::Closed){?>
            <span class="sold-out">&nbsp;</span>
            <?php } ?>
			<?php echo $this->Html->link($this->Html->showImage('Item', $attachment, array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false))),array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title'=>$item['Item']['name'],'escape' =>false));?>
			    <?php echo $this->Html->cdateday($item['Item']['event_date']);?>
                <?php echo $this->Html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$item['Item']['name'])));?>
                <p class="items-add"><?php echo $item['Merchant']['address1'] . "," . $item['Merchant']['address2'];?></p>
            </div>
            <?php echo $this->Html->link(__l('View Item'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('class'=>'view-items','title' =>__l('View Item')));?>
        </li>
        <?php } }
        else{ ?>
            <li>
		<p  class="notice"><?php echo __l('No peoples available'); ?></p>
	</li>
        <?php }?>
    </ol>
	<div class="see-menu-block">
						<a class="see-menu js-description" title="See Menu"><?php echo __l('See Menu'); ?></a></div>
</div>