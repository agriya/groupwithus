<?php /* SVN: $Id: index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="ItemComments index js-response">
<h2><?php echo __l('Comments');?></h2>

<ol class="commment-list clearfix js-comment-responses" >
<?php
if (!empty($ItemComments)):
    foreach($ItemComments as $ItemComment):
?>
    <li class="list-row clearfix"  >
	<div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
	    <div class="member-img">
			<?php echo $this->Html->getUserAvatarLink($ItemComment['PostedUser'], 'comment_thumb');?>
			<span class="comment-arrow"></span>
        </div>
		<div class="member-des">
		  <p class="clearfix"> 
			<?php echo $this->Html->getUserLink($ItemComment['PostedUser']);
            $date=$this->Time->timeAgoInWords($ItemComment['ItemComment']['created']);?>
			<span class="posted-date round-5"><?php echo $this->Html->cDateTime1($ItemComment['ItemComment']['created'],$date);?></span>
		  </p>
		  <p>
		  <?php echo $this->Html->cText(nl2br($ItemComment['ItemComment']['comment']));?>
		  </p>

<?php  if ((!empty($user['User']['id']) &&($user['User']['id'] == $this->Auth->user('id'))) or $ItemComment['PostedUser']['id'] == $this->Auth->user('id')) { ?>
        <div class="actions">
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
</div>
</div>