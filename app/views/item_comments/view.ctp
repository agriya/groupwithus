<?php /* SVN: $Id: view.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="ItemComments view">
<h2><?php echo __l('item Comment');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($ItemComment['ItemComment']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($ItemComment['ItemComment']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($ItemComment['ItemComment']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->getUserLink($ItemComment['item']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Posted User Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($ItemComment['ItemComment']['posted_user_id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Comment');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($ItemComment['ItemComment']['comment']);?></dd>
	</dl>
</div>