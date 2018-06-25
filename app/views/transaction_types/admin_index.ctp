<?php /* SVN: $Id: $ */ ?>
<?php 
	if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
<div class="sub-menu-block clearfix">
	</div>
 <div class="admin-inner-block">
  <div class="round-5 admin-inner-section">
<div class="transactionTypes index">
<div class="admin-top-inner-block clearfix">
</div>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Action');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Name'),'name');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Message'),'message');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Credit'),'is_credit');?></th>
     </tr>
<?php
if (!empty($transactionTypes)):

$i = 0;
foreach ($transactionTypes as $transactionType):
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
                                	<li><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $transactionType['TransactionType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span></li>
						       
        						</ul>
        					   </div>
        						<div class="action-bottom-block"></div>
							  </div>
						 </div>
  					</td>

           <td class="dl">
                <?php echo $this->Html->cText($transactionType['TransactionType']['name']);?>
           </td>
          <td class="dl"><?php echo $this->Html->cText($transactionType['TransactionType']['message']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($transactionType['TransactionType']['is_credit']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Transaction Types available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($transactionTypes)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
</div>