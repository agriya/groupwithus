<?php /* SVN: $Id: admin_index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="sub-menu-block clearfix">
</div>
 <div class="admin-inner-block">
 <div class="round-5 admin-inner-section">
<div class="userComments index js-responses">

    <?php echo $this->Form->create('UserComment' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">

<?php echo $this->element('paging_counter');?>
<table class="list">
	<tr>
		<th><?php echo __l('Select'); ?></th>
		<th><?php echo __l('Actions'); ?></th>
		<th><?php echo __l('User'); ?></th>
		<th><?php echo __l('Commented User'); ?></th>
		<th><?php echo __l('Comments'); ?></th>
		<th><?php echo __l('Date'); ?></th>
		<th><?php echo __l('IP'); ?></th>
	</tr>
<?php
if (!empty($userComments)):

$i = 0;
foreach ($userComments as $userComment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td class="select">
		<?php echo $this->Form->input('UserComment.' . $userComment['UserComment']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $userComment['UserComment']['id'], 'class' => 'js-checkbox-list', 'label' => false)); ?>		
		</td>
		<td class="actions">
			<div class="action-block">
				<span class="action-information-block">
					<span class="action-left-block">&nbsp;&nbsp;</span>
					<span class="action-center-block">
						<span class="action-info"><?php echo __l('Action');?></span>
					</span>
				</span>
				<div class="action-inner-block">
					<div class="action-inner-left-block">
						<ul class="action-link clearfix">
							<li><span><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $userComment['UserComment']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span></li>
							<li><span><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $userComment['UserComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
							<?php if(!empty($userComment['Ip']['ip'])):?>
								<li><span><?php echo $this->Html->link(__l('Ban User IP'), array('controller'=> 'banned_ips', 'action' => 'add', $userComment['Ip']['ip']), array('class' => 'network-ip','title'=>__l('Ban User IP'), 'escape' => false));?></span></li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="action-bottom-block"></div>
				</div>
			</div>
		</td>
		<td>
			<?php 
			echo $this->Html->getUserAvatarLink($userComment['User'], 'micro_thumb',false);?>
			<?php echo $this->Html->getUserLink($userComment['User']);?>
		</td>
		<td>
			<?php echo $this->Html->getUserAvatarLink($userComment['PostedUser'], 'micro_thumb',false);?>
			<?php echo $this->Html->getUserLink($userComment['PostedUser']);?>
        </td>
		<td class=""><?php echo $this->Html->cText($userComment['UserComment']['comment']);?></td>
		<td><?php echo $this->Html->cDateTime($userComment['UserComment']['created']);?></td>
        <td class="dl">
                        <?php if(!empty($userComment['Ip']['ip'])): ?>							  
                            <?php echo  $this->Html->link($userComment['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userComment['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => 'whois '.$userComment['Ip']['host'], 'escape' => false));								
							?>
							<p>
							<?php 					
                            if(!empty($userComment['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($userComment['Ip']['Country']['iso2']); ?>" title ="<?php echo $userComment['Ip']['Country']['name']; ?>">
									<?php echo $userComment['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif; 
							 if(!empty($userComment['Ip']['City'])):
                            ?>             
                            <span> 	<?php echo $userComment['Ip']['City']['name']; ?>    </span>
                            <?php endif; ?>
                            </p>
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>    
						</td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td class="notice" colspan="9"><?php echo __l('No User Comments available');?></td>
	</tr>
<?php endif; ?>
</table>
</div>
<?php
if (!empty($userComments)) { ?>
          <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit('Submit'); ?>
        </div>
		<div class="js-pagination">
			<?php echo $this->element('paging_links');?>
		</div>
		<?php } ?>
<?php echo $this->Form->end(); ?>
</div>
</div>
</div>                       