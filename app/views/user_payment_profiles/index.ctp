<?php /* SVN: $Id: admin_index.ctp 5508 2010-05-25 11:48:42Z senthilkumar_017ac09 $ */ ?>
<div class="userPaymentProfiles index clearfix  js-responses js-response">
<?php 
	if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
    
	<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Credit Cards');?></span></span></span></h2>
	<div class="clearfix add-block1">
		<?php echo $this->Html->link(__l('Add'), array('controller' => 'user_payment_profiles', 'action' => 'add'), array('class' => "js-toggle-show add {'container':'js-credit-card-form'}", 'title' => __l('Add'))); ?>
	</div>
	<div class="js-credit-card-form hide" >
		<?php echo $this->element('user_payment_profiles-add', array('cache' => array('config' => 'site_element_cache'), 'plugin' => 'site_tracker')); ?>
	</div>
	<?php echo $this->element('paging_counter');?>
	<table class="list">
		<tr>
			<th class="dl"><?php echo __l('Actions');?></th>
			<th class="dl"><?php echo __l('Credit Card');?></th>
			<th class="dc"><?php echo __l('Default');?></th>
		</tr>
	<?php
		if (!empty($userPaymentProfiles)):
			$i = 0;
			foreach ($userPaymentProfiles as $userPaymentProfile):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
		<tr<?php echo $class;?>>
			<td class="actions">
			  <div class="action-block">
				<span class="action-information-block">
					<span class="action-left-block">&nbsp;
					</span>
						<span class="action-center-block">
							<span class="action-info">
								<?php echo __l('Action');?>
							 </span>
						</span>
					</span>
					<div class="action-inner-block">
					<div class="action-inner-left-block">
						<ul class="action-link clearfix">
							<li><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $userPaymentProfile['UserPaymentProfile']['id']), array('class' => 'edit js-inline-edit', 'title' => __l('Edit')));?></span></li>
							<li><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userPaymentProfile['UserPaymentProfile']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
							<?php if (empty($userPaymentProfile['UserPaymentProfile']['is_default'])): ?>
								<li><span><?php echo $this->Html->link(__l('Set as default'), array('action' => 'update', $userPaymentProfile['UserPaymentProfile']['id']), array('class' => 'update', 'title' => __l('Set as default')));?></span></li>
							<?php endif; ?>
						</ul>
					   </div>
						<div class="action-bottom-block"></div>
					  </div>
				 </div>
			</td>
			<td class="dl"><?php echo $this->Html->cText($userPaymentProfile['UserPaymentProfile']['masked_cc']);?></td>
			<td class="dc"><?php echo $this->Html->cBool($userPaymentProfile['UserPaymentProfile']['is_default']);?></td>
		</tr>
	<?php
			endforeach;
		else:
	?>
		<tr>
        <td colspan="6" class="notice"><?php echo __l('No credit cards available');?></td>
		</tr>
	<?php
		endif;
	?>
	</table>
	<?php
		if (!empty($businessSuggestions)) {
			echo $this->element('paging_links');
		}
	?>
</div>