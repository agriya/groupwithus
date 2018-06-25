<ol class="comment-list clearfix">
							<?php foreach ($purchasedUsers as $purchasedUser){?>
								<li class="grid_4">
									<div class="comment-tl">
										<div class="comment-tr">
											<div class="comment-tm"> </div>
										</div>
									</div>
									<div class="comment-cl">
										<div class="comment-cr">
											<div class="comment-cc clearfix">
												<div class="user-thumb-img"> <?php echo $this->Html->getUserAvatarLink($purchasedUser['User'], 'medium_thumb',true);?></div>
												<div class="user-detail">
													<h4><?php echo $this->Html->link($purchasedUser['User']['username'], array('controller'=>'users','action'=>'view',$purchasedUser['User']['username']), array('title' => $purchasedUser['User']['username']));?></h4>
													<p><?php if(empty($purchasedUser['User']['UserProfile']['City']['name'])){
                                                        $purchasedUser['User']['UserProfile']['City']['name']=Configure::read('site.city');
                                                    } echo $purchasedUser['User']['UserProfile']['City']['name'];?></p>
													<span><?php echo $purchasedUser['User']['user_friend_count'];?></span> </div>
											</div>
										</div>
									</div>
									<div class="comment-bl">
										<div class="comment-br">
											<div class="comment-bm"></div>
										</div>
									</div>
								</li>
								 <?php } ?>
</ol>