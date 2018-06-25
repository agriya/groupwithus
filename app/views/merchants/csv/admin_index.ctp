<?php
$i = 0;
do {
    $merchant->paginate = array(
        'conditions' => $conditions,
        'offset' => $i,
		'order' => array(
			'Merchant.id' => 'desc'
		) ,
        'recursive' => 1
    );
    if(!empty($q)){
        $merchant->paginate['search'] = $q;
    }
    $Merchants = $merchant->paginate();
    if (!empty($Merchants)) {
        $data = array();
        foreach($Merchants as $Merchant) {
			$address = !empty($Merchant['City']['name']) ? $Merchant['City']['name'].', ' : '';
			$address.= !empty($Merchant['State']['name']) ? $Merchant['State']['name'].', ' : '';
			$address.= !empty($Merchant['Country']['name']) ? $Merchant['Country']['name'].', ' : '';
	        $data[]['Merchant'] = array(
				__l('Username') => $Merchant['Merchant']['name'],
				__l('Address') => !empty($address) ? $address: '',
				__l('Email') => $Merchant['User']['email'],
				__l('User') => $Merchant['User']['username'],
				__l('URL') => $Merchant['Merchant']['url'],
				__l('Profile Enabled') => $this->Html->cBool($Merchant['Merchant']['is_merchant_profile_enabled'], false),
				__l('Available Balance Amount') => $Merchant['User']['available_balance_amount'],
          	);
        }
        if (!$i) {
            $this->Csv->addGrid($data);
        } else {
            $this->Csv->addGrid($data, false);
        }
    }
    $i+= 20;
}
while (!empty($Companies));
echo $this->Csv->render(true);
?>