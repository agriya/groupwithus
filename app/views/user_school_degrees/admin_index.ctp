<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php
	if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
<div class="userSchoolDegrees index js-response">
<div class="sub-menu-block clearfix">
	</div>
 <div class="admin-inner-block">
    <div class="round-5 admin-inner-section">
           <div class="page-count-block clearfix">
            	<div class="grid_left">
	                <?php echo $this->element('paging_counter'); ?>
	             </div>
            <div class="grid_left">
         <?php
	echo $this->Form->create('UserSchoolDegree' , array('action' => 'admin_index', 'type' => 'get', 'class' => 'normal search-form clearfix ')); //js-ajax-form
	echo $this->Form->input('UserSchoolDegree.q', array('label' => __l('Keyword')));
	echo $this->Form->submit(__l('Search'));
	echo $this->Form->end();
?>
                </div>
                   <div class="clearfix grid_right add-block1">
                 <?php echo $this->Html->link(__l('Add'),array('controller'=>'user_school_degrees','action'=>'add'),array('title' => __l('Add'),	'class' =>'add admin-add'));?>
                  
	              </div>
            </div>
<?php echo $this->Form->create('UserSchoolDegree' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th class="select"><?php echo __l('Select');?></th>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User School Degree'), 'UserSchoolDegree.name');?></div></th>
    </tr>
<?php
if (!empty($userSchoolDegrees)):

$i = 0;
foreach ($userSchoolDegrees as $userSchoolDegree):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Form->input('UserSchoolDegree.'.$userSchoolDegree['UserSchoolDegree']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userSchoolDegree['UserSchoolDegree']['id'], 'class' => ' js-checkbox-list', 'label' => false)); ?>
		</td>

	<td class="actions">
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
                                    <span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $userSchoolDegree['UserSchoolDegree']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
                                    </li>
                                         <li>
                                          <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userSchoolDegree['UserSchoolDegree']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                                        </li>
        							 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 </div>
		</td>


        <td class="dl"><?php echo $this->Html->cText($userSchoolDegree['UserSchoolDegree']['name']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No User School Degrees available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
	<?php if (!empty($userSchoolDegrees)) {?>
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