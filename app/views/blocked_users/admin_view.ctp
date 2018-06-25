<?php /* SVN: $Id: $ */ ?>
<div class="blockedUsers view">
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($blockedUser['BlockedUser']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($blockedUser['BlockedUser']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($blockedUser['BlockedUser']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->getUserLink($blockedUser['User']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Blocked');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->getUserLink($blockedUser['Blocked']);?></dd>
	</dl>
</div>

