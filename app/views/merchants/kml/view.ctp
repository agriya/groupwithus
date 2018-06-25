<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
   <?php if(!empty($merchant['Merchant']['address1'])):?>
    <Placemark>
      <name><?php echo htmlspecialchars($merchant['Merchant']['name']); ?></name>
      <description>
        <![CDATA[
          <address>
          	<?php 
                $address = (!empty($merchant['Merchant']['address1'])) ? $merchant['Merchant']['address1'] : '';
                $address.= (!empty($merchant['Merchant']['address2'])) ? ', ' . $merchant['Merchant']['address2'] : '';
                $address.= (!empty($merchant['Merchant']['City']['name'])) ? ', ' . $merchant['Merchant']['City']['name'] : '';
                $address.= (!empty($merchant['Merchant']['State']['name'])) ? ', ' . $merchant['Merchant']['State']['name'] : '';
                $address.= (!empty($merchant['Merchant']['Country']['name'])) ? ', ' . $merchant['Merchant']['Country']['name'] : '';
                $address.= (!empty($merchant['Merchant']['zip'])) ? ', ' . $merchant['Merchant']['zip'] : '';
                $address.= (!empty($merchant['Merchant']['phone'])) ? ', ' . $merchant['Merchant']['phone'] : '';
				echo htmlspecialchars($address); 
			?>
          </address>
          <p>
			<?php if (!empty($merchant['User']['UserAvatar'])): ?>
				<img title="testingcomp" alt="[Image: <?php echo $merchant['Merchant']['name']; ?>]" class="" src="<?php echo Router::url('/',true).getImageUrl('UserAvatar', $merchant['User']['UserAvatar'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($merchant['User']['username'], false)), 'title' => $this->Html->cText($merchant['Merchant']['name'], true)));?>"/>
			<?php endif; ?>
			<?php echo $this->Html->truncate($merchant['Merchant']['merchant_profile'],20, array('ending' => '...')); ?>
		  </p>
          <?php if(!empty($merchant['Item'])): ?>
              <dl>
                  <?php foreach($merchant['Item'] as $item): ?>
                      <dt>
						<a href="<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'view', $item['slug']),true);?>" title = "<?php echo $item['name'];?>">
							<?php echo  $item['name'];?>
						</a>
                      <dd><?php echo $this->Html->truncate($item['description'],50, array('ending' => '...')); ?></dd>
                  <?php endforeach; ?>
              </dl>
          <?php endif; ?>
        ]]>
      </description>
      <Point>
          <coordinates><?php echo $merchant['Merchant']['longitude']; ?>,<?php echo $merchant['Merchant']['latitude']; ?></coordinates>
      </Point>
    </Placemark>
    <?php endif; ?>
  </Document>
</kml>