<div>
   <fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Item Information'); ?></legend>
		<dl class="list">
			<dt><?php echo __l('Item');?></dt>
				<dd>
					<?php echo $this->Html->cText($item['Item']['name'],false);?>
				</dd>
			<dt><?php echo __l('Current Item Status');?></dt>
				<dd>
					<?php echo $this->Html->cText($item['ItemStatus']['name']);?>
				</dd>
			<?php if(!empty($item['City'])):?>
			<dt><?php echo __l('Locations');?></dt>
				<dd>
					<?php 
						foreach($item['City'] as $cities):
    						?>
    						<p>
    						<?php
    							echo $cities['name'];
                            ?>
                            </p>
                            <?php
						endforeach;
					?>
				</dd>	
			<?php endif;?>
			<dt><?php echo __l('Item Lifetime');?></dt>
				<dd>
                    <p><?php echo __l('Created On').' '.$this->Html->cDateTime($item['Item']['created']);?></p>
                </dd>
	</fieldset>
	<fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Item Sales/Purchase Information'); ?></legend>
		<dl class="list">
			<dt><?php echo __l('Pass Expires On');?></dt>
				<dd>
					<?php echo $this->Html->cDateTime($item['Item']['event_date']);?>
				</dd>
			<dt><?php echo __l('Total Purchases');?></dt>
				<dd>
					<?php echo $this->Html->cInt($item['Item']['item_user_count']);?>
			    </dd>
		</dl>
	</fieldset>
</div>