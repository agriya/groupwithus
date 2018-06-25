 <li class="list-row clearfix" id="comment-<?php echo $ItemComment['ItemComment']['id']; ?>" >

	    <div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
	    <div class="member-img member-img-small">
			<?php echo $this->Html->getUserAvatarLink($ItemComment['PostedUser'], 'comment_thumb');?>
			<span class="comment-arrow"></span>
         </div>
		<div class="member-des">
            <p class="clearfix"> 
				<?php echo $this->Html->getUserLink($ItemComment['PostedUser']); ?>
				<span class="posted-date round-5"><?php echo $this->Time->timeAgoInWords($ItemComment['ItemComment']['created']);?></span>
			</p>
			<p> <?php echo $this->Html->cText(nl2br($ItemComment['ItemComment']['comment']));?></p>
		  <?php if ($ItemComment['ItemComment']['posted_user_id'] == $this->Auth->user('id')) { ?>
			<div class="comment-actions">
				<?php //echo $this->Html->link(__l('Delete'), array('controller' => 'item_comments', 'action' => 'delete', $ItemComment['ItemComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
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