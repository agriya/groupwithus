<?php
echo $this->requestAction(array('controller' => 'items', 'action' => 'index'), array('type' => 'near', 'view' => 'simple','item_id' => $item_id, 'return'));
?>