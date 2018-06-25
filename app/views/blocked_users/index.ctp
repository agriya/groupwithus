<div class="js-responses">
<div class="main-content-block js-corner round-5">
<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="blockedUsers index">
<h2><?php echo __l('Blocked Users');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="friends-list clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($blockedUsers)):

$i = 0;
foreach ($blockedUsers as $blockedUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li id="block-<?php echo $blockedUser['BlockedUser']['id']; ?>" class="list-row clearfix ">
		<?php echo $this->Html->getUserAvatarLink($blockedUser['Blocked'], 'medium_thumb');?>
        <p>
           <span class="meta-row author">
		        <cite><span title="<?php echo $blockedUser['Blocked']['username'];?>"><?php echo $this->Html->getUserLink($blockedUser['Blocked']);?></span></cite>
		    </span>
		    </p>
         	<?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $blockedUser['BlockedUser']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>

	</li>
<?php
    endforeach;
else:
?>
	<li class="friends-list-notice">
		<p class="notice"><?php echo __l('No blocked users available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($blockedUsers)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
</div>