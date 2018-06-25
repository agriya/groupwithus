<?php
	echo $this->requestAction(array('controller' => 'items', 'action' => 'purchased_user'), array('named' => array('admin' => false, 'item_id' => $item_id,'type'=>$type,'merchant_id'=>$merchant_id), 'return'));
?>