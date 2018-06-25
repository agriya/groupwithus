<?php /* SVN: $Id: $ */ ?>
<div class="sub-menu-block clearfix">
</div>
<div class="admin-inner-block">
<div class="round-5 admin-inner-section">
<div class="authorizenetDocaptureLogs index">
<div class="clearfix page-count-block">
    <div class="grid_left">
         <?php echo $this->element('paging_counter');?>
    </div>
</div>
<table class="list">
    <tr>	
	    <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort(__l('Created'),'created');?></th>
        <th><?php echo $this->Paginator->sort(__l('Transaction Id'), 'transactionid');?></th>
        <th><?php echo $this->Paginator->sort('payment_status');?></th>
        <th class="dr"><?php echo $this->Paginator->sort(__l('Authorize amt'), 'authorize_amt');?></th>
        <th class="dr"><?php echo $this->Paginator->sort(__l('Authorize avscode'),'authorize_avscode');?></th>
        <th><?php echo $this->Paginator->sort(__l('Authorize Authorization Code'), 'authorize_authorization_code');?></th>
        <th><?php echo $this->Paginator->sort(__l('Authorize Response Text'), 'authorize_response_text');?></th>
        <th><?php echo $this->Paginator->sort(__l('Authorize Response'), 'authorize_response');?></th>
    </tr>
<?php
if (!empty($authorizenetDocaptureLogs)):

$i = 0;
foreach ($authorizenetDocaptureLogs as $authorizenetDocaptureLog):
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
                                    <li>
										<?php echo $this->Html->link(__l('View'), array('controller' => 'authorizenet_docapture_logs', 'action' => 'view', $authorizenetDocaptureLog['AuthorizenetDocaptureLog']['id']), array('class' => 'view', 'title' => __l('View')));?>
									</li>
                                 </ul>
      							</div>
        						<div class="action-bottom-block"></div>
							  </div>
					 </div>
  
        </td>
		<td>
			
			<?php echo $this->Html->cDateTime($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['created']);?>
		</td>
		<td><?php echo $this->Html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['transactionid']);?></td>
		<td><?php echo $this->Html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['payment_status']);?></td>
		<td class="dr"><?php echo $this->Html->cFloat($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_amt']);?></td>
		<td class="dr"><?php echo $this->Html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_avscode']);?></td>
		<td><?php echo $this->Html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_authorization_code']);?></td>
		<td><?php echo $this->Html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_response_text']);?></td>
		<td><?php echo $this->Html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_response']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="14" class="notice"><?php echo __l('No Authorizenet Docapture Logs available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($authorizenetDocaptureLogs)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
</div>