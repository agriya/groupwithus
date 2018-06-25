<?php
	echo $this->requestAction(array('controller' => 'items', 'action' => 'stats'), array('named' => array('admin' => false, 'item_id' => $item_id), 'return'));
?>