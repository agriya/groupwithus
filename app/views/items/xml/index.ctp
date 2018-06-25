<?php /* SVN: $Id: index.ctp 4098 2010-05-06 08:04:25Z senthilkumar_017ac09 $ */ ?>
<response code="0" message="OK">
  <items>
    <?php 
		foreach($items as $item):
                $image_options = array(
                    'dimension' => 'small_thumb',
                    'class' => '',
                    'alt' => $item['Item']['name'],
                    'title' => $item['Item']['name'],
                    'type' => 'jpg'
                );
                $small_image_url = getImageUrl('Item', $item['Attachment'], $image_options);
                $image_options = array(
                    'dimension' => 'small_big_thumb',
                    'class' => '',
                    'alt' => $item['Item']['name'],
                    'title' => $item['Item']['name'],
                    'type' => 'jpg'
                );
                $medium_image_url = getImageUrl('Item', $item['Attachment'], $image_options);
                $image_options = array(
                    'dimension' => 'medium_big_thumb',
                    'class' => '',
                    'alt' => $item['Item']['name'],
                    'title' => $item['Item']['name'],
                    'type' => 'jpg'
                );
                $large_image_url = getImageUrl('Item', $item['Attachment'], $image_options);
		?>
            <item>
                  <id><?php echo $item['Item']['id'] ?></id>
                  <item_url><?php echo Router::url(array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),true); ?></item_url>
                  <title><?php echo $item['Item']['name'] ?></title>
                  <small_image_url><?php echo $small_image_url; ?></small_image_url>
                  <medium_image_url><?php echo $medium_image_url; ?></medium_image_url>
                  <large_image_url><?php echo $large_image_url; ?></large_image_url>
                  <division_id><?php echo $item['City']['id'] ?></division_id>
                  <division_name><?php echo $item['City']['name'] ?></division_name>
                  <division_lat><?php echo $item['City']['latitude'] ?></division_lat>
                  <division_lng><?php echo $item['City']['longitude'] ?></division_lng>
                  <vendor_id><?php echo $item['Merchant']['id'] ?></vendor_id>
                  <vendor_name><?php echo $item['Merchant']['name'] ?></vendor_name>
                  <vendor_website_url><?php echo $item['Merchant']['url'] ?></vendor_website_url>
                  <status><?php echo $item['ItemStatus']['name'] ?></status>
                  <start_date><?php echo date(Configure::read('site.datetime.format'), strtotime($item['Item']['start_date'])) ?></start_date>
                  <end_date><?php echo date(Configure::read('site.datetime.format'), strtotime($item['Item']['end_date'])) ?></end_date>
                  <tipped><?php echo ($item['Item']['item_status_id'] == ConstItemStatus::Tipped) ? __l('true') : __l('false'); ?></tipped>
                  <tipping_point><?php echo $item['Item']['min_limit'] ?></tipping_point>
                  <tipped_date><?php echo ($item['Item']['item_status_id'] == ConstItemStatus::Tipped) ? date(Configure::read('site.datetime.format'), $item['Item']['item_tipped_time']) : __l('Not Yet Tipped') ?></tipped_date>
                  <quantity_sold><?php echo $item['Item']['item_user_count'] ?></quantity_sold>
                  <price><?php echo $this->Html->siteCurrencyFormat($item['Item']['discounted_price']);?></price>
                  <value><?php echo $this->Html->siteCurrencyFormat($item['Item']['original_price']);?></value>
                  <discount_amount><?php echo $this->Html->siteCurrencyFormat($item['Item']['savings']); ?></discount_amount>
                  <discount_percent><?php echo $this->Html->cInt($item['Item']['discount_percentage'],false) . "%"; ?></discount_percent>
                  <conditions>
                    <limited_quantity><?php echo (!empty($item['Item']['max_limit'])) ? __l('true') : __l('false'); ?></limited_quantity>
                    <initial_quantity><?php echo $item['Item']['min_limit'] ?></initial_quantity>
                    <quantity_remaining><?php echo (empty($item['Item']['max_limit'])) ? __l('No Limit') : ($item['Item']['max_limit'] - $item['Item']['item_user_count']); ?></quantity_remaining>
                    <minimum_purchase><?php echo $item['Item']['buy_min_quantity_per_user'] ?></minimum_purchase>
                    <maximum_purchase><?php echo $item['Item']['buy_max_quantity_per_user'] ?></maximum_purchase>
                  </conditions>
                </item>
       <?php
		endforeach; 
	?>    
  </items>
</response>