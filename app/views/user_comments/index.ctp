<?php /* SVN: $Id: index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="userComments index js-response">
<h2>
<?php
if($username == $this->Auth->user('username')):
   echo __l('Comments');
else:
   echo __l('Comments on '). ucfirst($this->Html->cText($user['User']['username'], false));
endif;
?>
</h2>
<?php echo $this->element('paging_counter'); ?>
<ol class="commment-list clearfix js-comment-responses" start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
<?php
if (!empty($userComments)):
    foreach($userComments as $userComment):
    if(empty($class)){
        $class='';
    }
?>
    <li class="list-row clearfix <?php echo $class;?>" id="comment-<?php echo $userComment['UserComment']['id']; ?>" >
	<div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
	    <div class="member-img">
			<?php echo $this->Html->getUserAvatarLink($userComment['PostedUser'], 'comment_thumb');?>
			<span class="comment-arrow"></span>
        </div>
		<div class="member-des">
            <p class="clearfix"> 
				<?php echo $this->Html->getUserLink($userComment['PostedUser']);
				  $date=$this->Time->timeAgoInWords($userComment['UserComment']['created']);?>
				<span class="posted-date round-5"><?php echo $this->Html->cDateTime1($userComment['UserComment']['created'],$date);?></span>
			</p>
			<p>
				<?php echo $this->Html->cText(nl2br($userComment['UserComment']['comment']));?>
			</p>
		  <?php if ($user['User']['id'] == $this->Auth->user('id') or $userComment['PostedUser']['id'] == $this->Auth->user('id')) { ?>
        <div class="comment-actions">
        	<?php echo $this->Html->link(__l('Delete'), array('controller' => 'user_comments', 'action' => 'delete', $userComment['UserComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
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
if (!empty($userComments)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>