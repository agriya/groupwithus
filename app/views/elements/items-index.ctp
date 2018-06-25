<?php
echo $this->requestAction(array('controller' => 'items', 'action' => 'index','item_id'=>$item_id,'city'=>$this->params['named']['city']), array('type' => 'all_item','return'));
?>