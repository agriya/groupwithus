<div class="member-block">
	<div class="members-tl">
		<div class="members-tr">
			<div class="members-tm">
				<h3><?php echo __l('What group members are saying about one another!'); ?></h3>
			</div>
		</div>
	</div>
	<div class="members-middle js-jcarousellite1">
	<ul class="slider-member-list">
		<?php foreach($userComments as $userComment): ?>
		<li class="clearfix">
			<h4><?php echo $userComment['PostedUser']['username']; ?></h4>
			<div class="member-img"> 
			        <?php echo $this->Html->showImage('UserAvatar', $userComment['PostedUser']['UserAvatar'], array('dimension' => 'small_medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($userComment['PostedUser']['username'], false)), 'title' => $this->Html->cText($userComment['PostedUser']['username'], false)));?>
			</div>
			<div class="grid_9 member-des">
				<p>		  
					<?php echo $this->Html->cText(nl2br($userComment['UserComment']['comment']));?>
				 </p>
			</div>
		</li>
	<?php endforeach; ?>

	</ul>
			<a href="#" title="next-icon2" class="next-icon2 next1">Next</a>

	</div>
	<div class="members-bl">
		<div class="members-br">
			<div class="members-bm"> </div>
		</div>
	</div>
</div>