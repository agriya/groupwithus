<?php /* SVN: $Id: index.ctp 12757 2010-07-09 15:01:40Z jayashree_028ac09 $ */ ?>
	<?php
        if(!empty($items)): ?>
            <?php
				foreach($items as $items):
                  $items_image = '';
					if(!empty($items['Attachment'])):
						$items_image = $this->Html->showImage('Item', $items['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($items['Item']['name'], false)), 'title' => $this->Html->cText($items['Item']['name'], false)));
					endif;
					$items_image = (!empty($items_image)) ? '<p>'.$items_image.'</p>':'';

					echo $this->Rss->item(array() , array(
                            'title' => $items['Item']['name'],
                            'link' => array(
                                'controller' => 'items',
                                'action' => 'view',
                                $items['Item']['slug']
                            ) ,
                          'description' => $items_image.'<p>'.$items['Item']['description'].'</p>'
                        ));
            	endforeach;
			?>
    <?php endif; ?>