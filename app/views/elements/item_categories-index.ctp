<?php
$type=!empty($this->request->params['named']['type']) ? $this->request->params['named']['type'] : 'all';
if(empty($interest_id)){
echo $this->requestAction(array('controller' => 'item_categories', 'action' => 'index'), array('named' => array('admin' => false,'category'=>$category,'type'=>$type), 'return'));
}else{
echo $this->requestAction(array('controller' => 'item_categories', 'action' => 'index'), array('named' => array('admin' => false,'category'=>$category,'type'=>$type,'interest_id'=>$interest_id), 'return'));
}
?>