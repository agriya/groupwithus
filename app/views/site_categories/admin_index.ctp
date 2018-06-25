<?php /* SVN: $Id: $ */ ?>
<div class="siteCategories index">
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th><?php echo $this->Paginator->sort('name');?></th>
        <th><?php echo $this->Paginator->sort('slug');?></th>
        <th><?php echo $this->Paginator->sort('is_active');?></th>
    </tr>
<?php
if (!empty($siteCategories)):

$i = 0;
foreach ($siteCategories as $siteCategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
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
                                     <span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $siteCategory['SiteCategory']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> 
                                    </li>
                                   <?php if($user['User']['user_type_id'] != ConstUserTypes::Admin){ ?>
                                         <li>
                                           <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $siteCategory['SiteCategory']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                                        </li>
                                      <?php } ?>
        							 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
		</td>
		<td><?php echo $this->Html->cInt($siteCategory['SiteCategory']['id']);?></td>
		<td><?php echo $this->Html->cDateTime($siteCategory['SiteCategory']['created']);?></td>
		<td><?php echo $this->Html->cDateTime($siteCategory['SiteCategory']['modified']);?></td>
		<td><?php echo $this->Html->cText($siteCategory['SiteCategory']['name']);?></td>
		<td><?php echo $this->Html->cText($siteCategory['SiteCategory']['slug']);?></td>
		<td><?php echo $this->Html->cBool($siteCategory['SiteCategory']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Site Categories available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($siteCategories)) {
    echo $this->element('paging_links');
}
?>
</div>
