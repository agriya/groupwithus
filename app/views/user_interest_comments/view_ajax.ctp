 <li class="list-row clearfix" id="comment-<?php echo $userInterestComment['UserInterestComment']['id']; ?>" >
	    <div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
	    <div class="member-img">
			<?php echo $this->Html->getUserAvatarLink($userInterestComment['PostedUser'], 'medium_thumb');?>        
			<span class="comment-arrow"></span>
        </div>
		<div class="member-des">
            <p class="clearfix">
				<?php
					echo $this->Html->getUserLink($userInterestComment['PostedUser']);
					$date = $this->Time->timeAgoInWords($userInterestComment['UserInterestComment']['created']);
				?>
				<span class="posted-date round-5"><?php echo $this->Html->cDateTime1($userInterestComment['UserInterestComment']['created'], $date);?></span>
			</p>
			<p>
				<?php echo $this->Html->cText(nl2br($userInterestComment['UserInterestComment']['comment']));?>
			</p>
		  <?php if ($userInterestComment['UserInterestComment']['posted_user_id'] == $this->Auth->user('id')) { ?>
        <div class="actions">
        	<?php echo $this->Html->link(__l('Delete'), array('controller' => 'user_comments', 'action' => 'delete', $userInterestComment['UserInterestComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
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
