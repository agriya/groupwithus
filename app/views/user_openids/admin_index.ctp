<?php /* SVN: $Id: admin_index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="userOpenids index js-response">
    <h2><?php echo __l('User Openids');?></h2>
   	<div><?php echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add')));?></div>
    <?php echo $this->Form->create('UserOpenid' , array('type' => 'get', 'class' => 'normal','action' => 'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
		</div>
		<div>
			<?php echo $this->Form->submit(__l('Search'));?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
    <?php echo $this->Form->create('UserOpenid' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th class="select"><?php echo __l('Select'); ?></th>
			 <th class="actions"><?php echo __l('actions'); ?></th>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Username'), 'User.username');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('OpenID'), 'UserOpenid.openid');?></div></th>
        </tr>
        <?php
        if (!empty($userOpenids)):
            $i = 0;
            foreach ($userOpenids as $userOpenid):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
			        <td class="select">
		
					<?php echo $this->Form->input('UserOpenid.'.$userOpenid['UserOpenid']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userOpenid['UserOpenid']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
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
                                    <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userOpenid['UserOpenid']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                                    </li>
                                  
        							 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 </div>
		</td>
            
                    <td class="dl"><?php echo $this->Html->getUserLink($userOpenid['User']);?></td>
                    <td class="dl"><?php echo $this->Html->cText($userOpenid['UserOpenid']['openid']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4" class="notice"><?php echo __l('No User Openids available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    <?php
    if (!empty($userOpenids)) :
        ?>
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all')); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none')); ?>
        </div>
        <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        <div class=hide>
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>