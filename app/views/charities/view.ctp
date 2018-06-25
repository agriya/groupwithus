<?php /* SVN: $Id: $ */ ?>
<div class="charities view">
<h2><?php echo __l('Charities');?></h2>
        <div>
           <?php
                 echo $this->Html->link($charity['Charity']['name'], array('controller' => 'charities', 'action' => 'view', $charity['Charity']['slug']),array('title' =>sprintf(__l('%s'),$charity['Charity']['name'])));
            ?>
               <dl>
                  <dt> <?php echo $charity['Charity']['description'];  ?> </dt>
                  <dt> <?php echo $this->Html->link($this->Html->cText($charity['Charity']['url'], false), $charity['Charity']['url'] ,array('target' => '_blank'));?> </dt>
               </dl>
        </div>
</div>