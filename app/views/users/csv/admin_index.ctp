<?php
$i = 0;
do {
    $user->paginate = array(
        'conditions' => $conditions,
        'offset' => $i,
		'order' => array(
			'User.id' => 'desc'
		) ,
        'recursive' => 1
    );
    if(!empty($q)){
        $user->paginate['search'] = $q;
    }
    $Users = $user->paginate();
    if (!empty($Users)) {
        $data = array();
        foreach($Users as $User) {
	        $data[]['User'] = array(
            __l('Username') => $User['User']['username'],
            __l('Email') => $User['User']['email'],
            __l('Referred User') => !empty($User['RefferalUser']['username']) ? $User['RefferalUser']['username'] : '-',
            __l('Email Confirmed') => $this->Html->cBool($User['User']['is_email_confirmed'],false),
            __l('Login count') => $User['User']['user_login_count'],
            __l('Signup IP') => $User['User']['signup_ip'],
            __l('Created on') => $User['User']['created'],
            __l('Available balance amount') => $User['User']['available_balance_amount'],
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
while (!empty($Users));
echo $this->Csv->render(true);
?>