<ol class="commment-list">
<?php
if (!empty($users)):
    foreach($users as $user):
    if(empty($class)){
        $class='';
    }
?>
    <li class="list-row clearfix <?php echo $class;?>" id="comment-<?php echo $user['User']['id']; ?>" >
	<div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
	    <div class="member-img">
			<?php echo $this->Html->getUserAvatarLink($user['User'], 'comment_thumb');?>
			<span class="comment-arrow"></span>
        </div>
		<div class="member-des">
            <p class="clearfix">
				<?php echo $this->Html->getUserLink($user['User']); ?>
			</p>
			<p>
				<p><?php if(empty($user['User']['UserProfile']['City']['name'])){
                                                        $user['User']['UserProfile']['City']['name']=Configure::read('site.city');
                                                    } echo $user['User']['UserProfile']['City']['name'] ;
                                                    if(!empty($user['User']['UserJob'][0])){
                                                        echo " ," . $user['User']['UserJob'][0]['Company']['name'] . " ," . $user['User']['UserJob'][0]['position'];
                                                    }
                                                    ?></p>
			</p>
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