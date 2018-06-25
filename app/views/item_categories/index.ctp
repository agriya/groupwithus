<ul class="filter-list">
<?php $class=((empty($this->request->params['named']['category'])) ? 'active' : '');?>
<?php if($this->params['named']['type']=='all'):?>
    
    <li class="<?php echo $class;?>"> <?php echo $this->Html->link(__l('All'), array('controller' => 'items', 'action' => 'index','type' => 'all', 'admin' => false), array('title' => __l('All')));?></li>
    <?php elseif($this->params['named']['type']=='interest'):?>
        <li class="<?php echo $class;?>"> <?php echo $this->Html->link(__l('All'), array('controller' => 'items', 'action' => 'index','type' => 'interest','interest_id'=>$this->request->params['named']['interest_id'], 'admin' => false), array('title' => __l('All')));?></li>
   <?php else:?>
    <li class="<?php echo $class;?>"> <?php echo $this->Html->link(__l('All'), array('controller' => 'items', 'action' => 'index','type' => 'past', 'admin' => false), array('title' => __l('All')));?></li>
 <?php endif;?>
    <?php foreach($item_categories as $key=>$item_categorie){ ?>
    <?php $class=($this->request->params['named']['category']==$item_categorie['ItemCategory']['slug'] ? 'active' : '');?>
        <li class="<?php echo $class;?>">
            <?php
                if(empty($this->request->params['named']['interest_id'])){
                echo $this->Html->link($item_categorie['ItemCategory']['name'], array('controller' => 'items', 'action' => 'index', 'category'=>$item_categorie['ItemCategory']['slug'],'type'=>$this->request->params['named']['type'],'admin' => false), array('title' => $item_categorie['ItemCategory']['name']));
                }else{
                echo $this->Html->link($item_categorie['ItemCategory']['name'], array('controller' => 'items', 'action' => 'index', 'category'=>$item_categorie['ItemCategory']['slug'],'type'=>$this->request->params['named']['type'],'interest_id'=>$this->request->params['named']['interest_id'],'admin' => false), array('title' => $item_categorie['ItemCategory']['name']));
                }
                
            ?>
        </li>
    <? }?>
</ul>