				<?php
if (!empty($itemUsers)):
?>
<div class="sliders-block">
<div class ='js-response'>
	   <h3 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Awesome groupers who\'ve reserved'); ?></span></span></span></h3>
	<ol class="users-list-scroller clearfix " id="mycarouse2">
				<?php
$i = 0;
foreach ($itemUsers as $ItemUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<li>
	<div class="groupers-tl">
		<div class="groupers-tr">
			<div class="groupers-tm">
	</div>
	</div>
	</div>
	<div class="groupers-cl">
		<div class="groupers-cr">
			<div class="groupers-inner">
								   <?php  echo $this->Html->link($this->Html->showImage('UserAvatar', $ItemUser['User']['UserAvatar'], array('dimension' => 'item_user_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($ItemUser['User']['username'], false)), 'title' => $this->Html->cText($ItemUser['User']['username'], false))),array('controller' => 'users', 'action' => 'view', $ItemUser['User']['username']),array('title'=>$this->Html->cText($ItemUser['User']['username'], false),'escape' =>false));?>

		<h4> 
		 <?php  echo $this->Html->link($this->Html->cText($ItemUser['User']['username'], false),array('controller' => 'users', 'action' => 'view', $ItemUser['User']['username']),array('title'=>$this->Html->cText($ItemUser['User']['username'], false),'escape' =>false));?>
		</h4>
		<p><?php echo !empty($ItemUser['User']['UserProfile']['about_me'])?$this->Text->truncate($ItemUser['User']['UserProfile']['about_me'], 50, array('ending' => '...')):''; ?></p>

		</div>
		</div>
		</div>
		<div class="groupers-bl">
		<div class="groupers-br">
			<div class="groupers-bm">
		</div>
		</div>
		</div>
						  </li>
					<?php
			endforeach;
		?>
		
                </ol>
</div>
</div>
<?php
		endif;
		?>