<?php /* SVN: $Id: admin_index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div>
<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('My Subscriptions'); ?></span>
</span>
</span>
</h2>
	<table class="list">
		<tr>
			<th class="actions"><?php echo __l('Actions');?></th>
			<th><div class="js-pagination"><?php echo __l('Subscribed On'); ?></div></th>
			<th class="dl"><div class="js-pagination"><?php echo __l('City'); ?></div></th>
		</tr>
		<?php
			if (!empty($subscriptions)):
				$i = 0;
				foreach ($subscriptions as $subscription):
					$class = null;
					if ($i++ % 2 == 0):
						$class = ' class="altrow"';
					endif;
		?>
		<tr<?php echo $class;?>>
			<td>
			 <div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        <?php echo __l('Action');?>
                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                    <li>
                                       <span><?php echo $this->Html->link(__l('Unsubscribe'), array('controller' => 'subscriptions', 'action' => 'unsubscribe', $subscription['Subscription']['id']), array('class' => 'delete js-delete', 'title' => __l('Unsubscribe'))); ?></span>
                                    </li>
                                   </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
				
			</td>
			<td><?php echo $this->Html->cDateTime($subscription['Subscription']['created']);?></td>
			<td class="dl"><?php echo $this->Html->cText($subscription['City']['name']);?></td>
		</tr>
		<?php
				endforeach;
			else:
		?>
		<tr>
			<td colspan="14" class="notice"><?php echo __l('No Subscriptions available');?></td>
		</tr>
		<?php
			endif;
		?>
	</table>
	<?php if (!empty($cities)): ?>
		<div>
			<?php
				echo $this->Form->create('Subscription', array('class' => 'normal', 'action' => 'add', 'id' => 'SubscriptionIndexForm'));
				echo $this->Form->input('email',array('id' => 'SubscriptionIndexEmail', 'type' => 'hidden', 'value' => $this->Auth->user('email'), 'label' => false));
				echo $this->Form->input('city_id',array('id' => 'SubscriptionIndexCityId', 'label' => __l('Choose your city:'), 'options' => $cities));
				echo $this->Form->input('is_from_manage_subscriptions', array('type' => 'hidden', 'value' => 1));
			?>
			<div class="submit-block clearfix"><?php echo $this->Form->submit(__l('Subscribe'));?></div>
			<?php echo $this->Form->end(); ?>
		</div>
	<?php endif; ?>
</div>