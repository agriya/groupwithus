<?php /* SVN: $Id: v.ctp 13680 2011-01-12 13:17:40Z kanagavel_113at09 $ */ ?>
<div class="messages view">
<div class="main-content-block js-corner round-5">
<div class="mail-side-two">
	<?php
        echo $this->Form->create('Message', array('action' => 'move_to','class' => 'normal'));
        echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
        echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
        echo $this->Form->hidden('label_slug', array('value' => $label_slug,'name' => 'data[Message][label_slug]'));
        echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
    ?>
    <div class="mail-main-curve">
			<h2>
			<?php
                if (!empty($label_slug) && $label_slug != 'null') :
                    echo $this->Html->link(__l('Back to Label') , array('controller' => 'messages','action' => 'label',$label_slug));
                elseif (!empty($is_starred)) :
                    echo $this->Html->link(__l('Back to Starred') , array('controller' => 'messages','action' => 'starred'));
                else :
                    echo $this->Html->link(sprintf(__l('Back to %s'), $back_link_msg), array('controller' => 'messages','action' => $folder_type));
                endif;
            ?>
			</h2>
			<div class="message-block clearfix">
				<div class="message-block-left"  >
			<?php echo $this->Form->input('more_action_1', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action'));?>
			</div>
			<div class="message-block-right">
    			<?php
                    echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
                    echo $this->Form->submit(__l('Spam'), array('name' => 'data[Message][ReportSpam]'));
                    echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
                ?>
			</div>
        </div>
              <div class="mail-body js-corner round-5">
					<?php if (!empty($message['Message']['project_id'])) :?>
						<span class="project-message"><?php echo __l('Project').':'.' '.$this->Html->link($message['Project']['name'], array('controller' => 'projects', 'action' => 'view', $message['Project']['slug']), array('title' => $message['Project']['slug']));?></span>
					<?php endif;?>
                    <?php
                    if (!empty($all_parents)) :
                        foreach($all_parents as $parent_message) : ?>
                        <div class="clearfix send-info-block">
                        <div class="mail-sender-name">
                            <div class="view-star">
                            <?php
                                if ($parent_message['Message']['is_starred']) :
                                    $is_starred_class = "star";
                                else :
                                    $is_starred_class = "star-select";
                                endif;
                            ?>
                            <span class="<?php echo $is_starred_class; ?>">
                                <?php
                                if ($parent_message['Message']['is_starred']) :
                                    echo $this->Html->link(__l('Star') , array('controller' => 'messages','action' => 'star', $parent_message['Message']['id'],'star - select'
									) , array('class' => "change-star-unstar {'message':'Message has been starred'}"));
                                else :
                                    echo $this->Html->link(__l('star-select') , array('controller' => 'messages','action' => 'star',$parent_message['Message']['id'],'star') , array('class' => "change-star-unstar {'message':'Message has been starred'}"));
                                endif; ?>
            				</span>
    					 </div>

                        <span class="sender-name"><?php if ($parent_message['OtherUser']['email'] == $user_email) :
                                echo __l('me');
                            else :
                                echo $this->Html->cText($parent_message['OtherUser']['email']);
                            endif; ?>
                        </span>
                        to
                        <?php
                            if ($parent_message['User']['email'] == $user_email) :
                                echo __l('me');
                            else :
                                echo $this->Html->cText($parent_message['User']['email']);
                            endif; ?>
                        </div>
                        <div class="mail-date-time clearfix">
                        <span class="sender-info"> <?php echo $this->Html->cDateTimeHighlight($parent_message['Message']['created']);?> (<?php echo $this->Time->timeAgoInWords($parent_message['Message']['created']); ?>)</span></p>
                        </div>
                        </div>
                        <div class="js-show-mail-detail-div">
                            <p><span class="show-details-left"><?php
                                echo __l('from').': '; ?></span> <?php
                                echo $parent_message['OtherUser']['username']; ?> 
                            </p>
    						<p><span class="show-details-left">
                            <?php
                                echo __l('to').': '; ?></span> <?php
                                echo $parent_message['User']['username']; ?> < <?php
                                echo $parent_message['User']['email']; ?> >
                            </p>
                            <p><span class="show-details-left">
                            <?php
                                echo __l('date').': '; ?></span> <?php
                                echo $this->Html->cDateTimeHighlight($parent_message['Message']['created']);
                                echo __l('at').': ' . $this->Html->cDateTimeHighlight($parent_message['Message']['created']); ?>
                            </p>
    						<p><span class="show-details-left">
                            <?php
                                echo __l('subject').': '; ?> </span><?php
                                echo $this->Html->cText($parent_message['MessageContent']['subject']); ?>
                            </p>
                        </div>
                        <p>
						<?php if (!empty($parent_message['Message']['project_id'])) :?>
							<span class="project-message"><?php echo __l('Project').':'.' '.$this->Html->link($parent_message['Project']['name'], array('controller' => 'projects', 'action' => 'view', $message['Project']['slug']), array('title' => $message['Project']['slug']));?></span>
						<?php endif;?>
						<?php if (!empty($backerReward)) :?>
							<dl>
								<dt><?php echo __l('Pledge'); ?></dt>
								</dd><?php echo $backerReward['ProjectFund']['amount']; ?></dd>
								<dt><?php echo __l('Reward'); ?></dt>
								</dd><?php echo $backerReward['ProjectReward']['reward']?$backerReward['ProjectReward']['reward']:__l('No reward'); ?></dd>
							</dl>
						<?php endif;?>
						<span class="c"><?php echo $this->Html->cHtml($parent_message['MessageContent']['message']); ?></span>
						</p>
                    <?php
                        endforeach;
                    endif; ?>
                    <div class="clearfix send-info-block">
                    <div class="mail-sender-name">
                    <div class="view-star">
                    <?php
                        $is_starred_class = "star";
                        if ($message['Message']['is_starred']) :
                            $is_starred_class = "star-select";
                        endif;
                        ?>
                        <span class="<?php echo $is_starred_class; ?>">
                            <?php
                                echo $this->Html->link(__l('Star') , array('controller' => 'messages','action' => 'star',$message['Message']['id'],$is_starred_class) , array('class' => "change-star-unstar {'message':'Message has been starred'}"));
                            ?>
    					</span>
                    </div>

				<?php if (($message['Message']['is_sender'] == 1) || ($message['Message']['is_sender'] == 2)) : ?>
                   <span class="sender-name"> <?php echo $message['User']['username']; ?> </span>
						<?php if (!empty($receiverNames)) :
                                echo __l('to'); ?> <?php echo $receiverNames;
                             endif; ?>
    					<?php
                        else :
                        ?>
                      <span class="sender-name">  <?php echo $message['OtherUser']['username']; ?></span>
    						<?php echo __l('to'); ?> <?php echo __l('me'); ?>, <?php echo $receiverNames; ?>
						<?php
                        endif; ?>
				</div>
                <div class="mail-date-time">
                    <p class="<?php echo $message['Message']['id'] ?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<?php echo $this->Time->timeAgoInWords($message['Message']['created']); ?>)</span></p>
                </div>
                </div>
                <div class="mail-content-curve-middle">
			   <div class="js-show-mail-detail-div show-mail">
				<?php
                    if ($message['Message']['is_sender'] == 0) : ?>
                    	<p><span class="show-details-left"><?php echo __l('from').': ';  ?></span> <?php echo $message['OtherUser']['username']; ?></p>
                    <?php
                    else : ?>
                    	<p><span class="show-details-left"><?php echo __l('from').': ';  ?></span> <?php echo $message['User']['username']; ?> </p>
        			<?php
                    endif; ?>
    				<p><span class="show-details-left"><?php echo __l('to').': ';  ?></span><?php echo $show_detail_to; ?></p>
					<p><span class="show-details-left"><?php echo __l('date').': ';  ?></span><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); echo __l('at') . $this->Html->cDateTimeHighlight($message['Message']['created']); ?> </p>
					<p><span class="show-details-left"><?php echo __l('subject').': ';  ?></span><?php echo $this->Html->cText($message['MessageContent']['subject']); ?> </p>
				</div>
                <p>
				<?php if (!empty($message['Message']['project_id'])) :?>
					<span class="project-message"><?php echo __l('Project').':'.' '.$this->Html->link($message['Project']['name'], array('controller' => 'projects', 'action' => 'view', $message['Project']['slug']), array('title' => $message['Project']['slug']));?></span>
				<?php endif;?>
				<?php  echo $this->Html->cHtml($message['MessageContent']['message']); ?></p>
				<p class="replay-forward-links">
				<?php
                    echo $this->Html->link(__l("Reply") , array('controller' => 'messages','action' => 'compose',$message['Message']['id'],'reply') , null, null, false);
                    echo $this->Html->link(__l("Forward") , array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'],'forword') , null, null, true);
                ?>
				</p>
                <div class="download-block">
                <?php
                if (!empty($message['MessageContent']['Attachment'])) :
					?>
					<h4><?php echo count($message['MessageContent']['Attachment']).' '. __l('attachments');?></h4>
					<ul>
					<?php
                    foreach($message['MessageContent']['Attachment'] as $attachment) :
                ?>
					<li>
                	<span class="attachement"><?php echo $attachment['filename']; ?></span>
                	<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
                    <span><?php echo $this->Html->link(__l('Download') , array( 'action' => 'download', $message['Message']['id'], $attachment['id'])); ?></span>
					</li>
                <?php
                    endforeach;
				?>
				</ul>
				<?php
                endif;
                ?>
                </div>
            </div>
       </div>
        <div class="message-block clearfix">
        <div class="message-block-left" >
			<?php
            echo $this->Form->input('more_action_2', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action2' ));
            ?>
			</div>

        <div class="message-block-right">
        <?php
            echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
            echo $this->Form->submit(__l('Spam'), array( 'name' => 'data[Message][ReportSpam]'));
            echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
        ?>
        </div>
        </div>
<p class="back-to-inbox">
    <?php
    if (!empty($label_slug) && $label_slug != 'null') :
        echo $this->Html->link('Back to Label', array( 'controller' => 'messages','action' => 'label', $label_slug));
    elseif (!empty($is_starred)) :
        echo $this->Html->link('Back to Starred', array('controller' => 'messages','action' => 'starred'));
    else :
        echo $this->Html->link(sprintf(__l('Back to %s'), $back_link_msg), array(
            'controller' => 'messages',
            'action' => $folder_type
        ));
    endif;
    ?>
</p>
     </div>
	<?php echo $this->Form->end();
?>
</div>
</div>
</div>
