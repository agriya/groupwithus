<?php
echo $this->requestAction(array('controller' => 'items', 'action' => 'index','limit'=>7), array('type' => 'past_item','return'));
?>