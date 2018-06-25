<?php /* SVN: $Id: index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="userInterestComments index js-response">
<h3>
<?php
   echo __l('Comments on '). ucfirst($this->Html->cText($userInterest['UserInterest']['name'], false));
?>
</h3>
<?php echo $this->element('paging_counter'); ?>
<ol class="commment-list clearfix js-comment-responses" start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
<?php
if (!empty($userInterestComments)):
    foreach($userInterestComments as $userInterestComment):
    if(empty($class)){
        $class='';
    }
?>
    <li class="list-row clearfix <?php echo $class;?>" id="comment-<?php echo $userInterestComment['UserInterestComment']['id']; ?>" >
	<div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
	    <div class="member-img">
			<?php echo $this->Html->getUserAvatarLink($userInterestComment['User'], 'comment_thumb');?>
			<span class="comment-arrow"></span>
        </div>
		<div class="member-des">
            <p class="comment-title clearfix"> 
				<?php echo $this->Html->getUserLink($userInterestComment['User']);
				  $date=$this->Time->timeAgoInWords($userInterestComment['UserInterestComment']['created']);?>
				  <?php echo $this->Html->cDateTime1($userInterestComment['UserInterestComment']['created'],$date);?>
			</p>
			<p class="desc">
				<?php echo $this->Html->cText(nl2br($userInterestComment['UserInterestComment']['comment']));?>
			</p>
		  <?php if ($userInterestComment['User']['id'] == $this->Auth->user('id') or $userInterestComment['User']['id'] == $this->Auth->user('id')) { ?>
        <div class="actions">
        	<?php echo $this->Html->link(__l('Delete'), array('controller' => 'user_interest_comments', 'action' => 'delete', $userInterestComment['UserInterestComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
		</div>
		<?php } ?>
		</div>
		</div>
			</div>
				</div>
				<div class="comment-bl">
					<div class="comment-br">
						<div class="comment-bm"></div>
					</div>
				</div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p  class="notice"><?php echo __l('No comments available'); ?></p>
	</li>
<?php
endif;
?>
</ol>
<div class="js-pagination">
<?php
if (!empty($userInterestComments)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>