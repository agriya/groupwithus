<?php
echo $this->requestAction(array('controller' => 'items', 'action' => 'view',$item_slug,$count), array('return'));
?>