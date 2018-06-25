<div class="overflow-block">
	<table class="list">
		<tr>
			<th class="dl"><div class="js-pagination"><?php echo __l('User Interests');?></div></th>
		</tr>
		<?php
			if (!empty($userInterests)):
				$i = 0;
				foreach ($userInterests as $userInterest):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		?>
		<tr<?php echo $class;?>>
			<td class="dl"><span><?php echo $this->Html->link($this->Html->cText($userInterest['UserInterest']['name'], false), array('controller' => 'users', 'action' => 'index','tag_id'=>$userInterest['UserInterest']['id'], 'admin' => false), array('title' => $this->Html->cText($userInterest['UserInterest']['name'], false)));?></span></td>
		</tr>
		<?php
				endforeach;
			else:
		?>
		<tr>
			<td colspan="7" class="notice"><?php echo __l('No User Interest available');?></td>
		</tr>
		<?php
			endif;
		?>
	</table>
</div>