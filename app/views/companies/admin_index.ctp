<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php
	if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
<div class="companies index js-response">

<div class="clearfix page-count-block">
<div class="grid_left">
    <?php echo $this->element('paging_counter');?>
</div>
<div class="grid_left">
   <?php
	echo $this->Form->create('Company' , array('action' => 'admin_index', 'type' => 'get', 'class' => 'normal search-form clearfix ')); //js-ajax-form
	echo $this->Form->input('Company.q', array('label' => __l('Keyword')));
	echo $this->Form->submit(__l('Search'));
	echo $this->Form->end(); ?>
</div>
<div class="clearfix grid_right add-block1">
	<?php echo $this->Html->link(__l('Add'),array('controller'=>'companies','action'=>'add'),array('title' => __l('Add '),	'class' =>'add admin-add'));?>
</div>
</div>

 <div class="admin-inner-block">
  <div class="round-5 admin-inner-section">
<?php echo $this->Form->create('Company' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th class="select"><?php echo __l('Select');?></th>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Company'), 'Company.name');?></div></th>
    </tr>
<?php
if (!empty($companies)):

$i = 0;
foreach ($companies as $company):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="select">
			<?php echo $this->Form->input('Company.'.$company['Company']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$company['Company']['id'], 'class' => ' js-checkbox-list', 'label' => false)); ?>
		</td>
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
                                    <li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $company['Company']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
									<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $company['Company']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                                  </ul>
      							</div>
        						<div class="action-bottom-block"></div>
							  </div>
					 </div>
           
		</td>
        <td class="dl"><?php echo $this->Html->cText($company['Company']['name']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Companies available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
	<?php if (!empty($companies)) {?>
        <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
        </div>
		<div class="js-pagination">
			<?php echo $this->element('paging_links');?>
		</div>
		<div class="hide">
			<?php echo $this->Form->submit(__l('Submit'));  ?>
		</div>
		<?php echo $this->Form->end(); ?>
	<?php }?>
</div>
</div>
</div>