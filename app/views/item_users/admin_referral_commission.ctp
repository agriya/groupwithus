<?php /* SVN: $Id: $ */ ?>
<div class="page-info">
	<?php echo __l('Referral module is currently enabled. You can disable or configure it from').' '.$this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 10), array('target' => '_blank')). __l(' page');?>
</div>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th><?php echo $this->Paginator->sort(__l('Created'), 'created');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Referred User'), 'User.username');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Item'), 'Item.name');?></th>
        <th class="dr"><?php echo __l('Commission Earned');?></th>
        <th class="dl"><?php echo __l('Commission Earned type');?></th>
    </tr>
<?php
if (!empty($referred_users_earned)):

$i = 0;
foreach ($referred_users_earned as $referred_user_earned):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <td> <?php echo $this->Html->cDateTimeHighlight($referred_user_earned['ItemUser']['created']);?></td>
		<td class="dl"> <?php echo $this->Html->link($this->Html->cText($referred_user_earned['User']['username']), array('controller'=> 'users', 'action'=>'view', $referred_user_earned['User']['username'], 'admin' => false), array('escape' => false));?></td>
        <td class="dl"> <?php echo $this->Html->link($this->Html->cText($this->Html->getReferredUsername($referred_user_earned['ItemUser']['referred_by_user_id'])), array('controller'=> 'users', 'action'=>'view', $this->Html->getReferredUsername($referred_user_earned['ItemUser']['referred_by_user_id']), 'admin' => false), array('escape' => false));?></td>
        <td class="dl"> <?php echo $this->Html->link($this->Html->cText($referred_user_earned['Item']['name']), array('controller' => 'items', 'action' => 'view', $referred_user_earned['Item']['slug'], 'admin' => false), array('title'=>$this->Html->cText($referred_user_earned['Item']['name'],false),'escape' => false));?> </td>
        <td class="dr"> <?php echo $this->Html->cFloat($referred_user_earned['ItemUser']['referral_commission_amount']);?> </td>
        <td class="dl"> <?php  if($referred_user_earned['ItemUser']['referral_commission_type'] == ConstReferralCommissionType::GrouponLikeRefer):
						echo $this->Html->cText(ConstReferralOption::GrouponLikeRefer);	
					elseif($referred_user_earned['ItemUser']['referral_commission_type'] == ConstReferralCommissionType::XRefer):
						echo $this->Html->cText(ConstReferralOption::XRefer);	
					endif;	
			?> 
        </td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11" class="notice"><?php echo __l('No Referred Users Earning Available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($referred_users_earned)) {
    echo $this->element('paging_links');
}
?>

