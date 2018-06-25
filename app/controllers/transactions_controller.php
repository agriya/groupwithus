<?php
/**
 * GroupWithUs
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    groupwithus
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class TransactionsController extends AppController
{
    public $name = 'Transactions';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Transaction.from_date',
            'Transaction.user_id',
            'Transaction.item_id',
            'Transaction.to_date',
            'User.username',
            'Item.name'
        );
        parent::beforeFilter();
    }
    public function index()
    {
        $this->disableCache();
        $this->pageTitle = __l('Transactions');
        $conditions['Transaction.user_id'] = $this->Auth->user('id');
        $blocked_conditions['UserCashWithdrawal.user_id'] = $this->Auth->user('id');
        $blocked_conditions['UserCashWithdrawal.withdrawal_status_id'] = array(
            ConstWithdrawalStatus::Pending,
            ConstWithdrawalStatus::Approved,
        );
        if (isset($this->request->data['Transaction']['from_date']) and isset($this->request->data['Transaction']['to_date'])) {
            $from_date = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
            $to_date = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->request->data)) {
            if ($from_date < $to_date) {
                $blocked_conditions['UserCashWithdrawal.created >='] = $conditions['Transaction.created >='] = _formatDate('Y-m-d H:i:s', $from_date, true);
                $blocked_conditions['UserCashWithdrawal.created <='] = $conditions['Transaction.created <='] = _formatDate('Y-m-d H:i:s', $to_date, true);
            } else {
                $this->Transaction->validationErrors['to_date'] = __l("'To date' should be greater than 'From date'.");
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <= '] = 0;
            $blocked_conditions['TO_DAYS(NOW()) - TO_DAYS(UserCashWithdrawal.created) <= '] = 0;
            $this->pageTitle.= __l(' - Amount Earned today');
            $this->request->data['Transaction']['from_date'] = array(
                'year' => date('Y', strtotime('today')) ,
                'month' => date('m', strtotime('today')) ,
                'day' => date('d', strtotime('today'))
            );
            $this->request->data['Transaction']['to_date'] = array(
                'year' => date('Y', strtotime('today')) ,
                'month' => date('m', strtotime('today')) ,
                'day' => date('d', strtotime('today'))
            );
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <= '] = 7;
            $blocked_conditions['TO_DAYS(NOW()) - TO_DAYS(UserCashWithdrawal.created) <= '] = 7;
            $this->pageTitle.= __l(' - Amount Earned in this week');
            $this->request->data['Transaction']['from_date'] = array(
                'year' => date('Y', strtotime('last week')) ,
                'month' => date('m', strtotime('last week')) ,
                'day' => date('d', strtotime('last week'))
            );
            $this->request->data['Transaction']['to_date'] = array(
                'year' => date('Y', strtotime('this week')) ,
                'month' => date('m', strtotime('this week')) ,
                'day' => date('d', strtotime('this week'))
            );
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <= '] = 30;
            $blocked_conditions['TO_DAYS(NOW()) - TO_DAYS(UserCashWithdrawal.created) <= '] = 30;
            $this->pageTitle.= __l(' - Amount Earned in this month');
            $this->request->data['Transaction']['from_date'] = array(
                'year' => date('Y', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'month' => date('m', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'day' => date('d', (strtotime('this month', strtotime(date('m/01/y')))))
            );
            $this->request->data['Transaction']['to_date'] = array(
                'year' => date('Y', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'month' => date('m', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'day' => date('t', (strtotime('this month', strtotime(date('m/01/y')))))
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'TransactionType',
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.user_type_id',
                        'User.fb_user_id',
                    )
                ) ,
                'ItemUser' => array(
                    'Item' => array(
                        'fields' => array(
                            'Item.id',
                            'Item.name',
                            'Item.slug'
                        )
                    ) ,
                    'fields' => array(
                        'ItemUser.id',
                        'ItemUser.gift_email'
                    )
                ) ,
                'SecondUser',
                'Currency' => array(
                    'fields' => array(
                        'Currency.id',
                        'Currency.name',
                        'Currency.code',
                        'Currency.symbol',
                    ) ,
                ) ,
                'ConvertedCurrency' => array(
                    'fields' => array(
                        'ConvertedCurrency.id',
                        'ConvertedCurrency.name',
                        'ConvertedCurrency.code',
                        'ConvertedCurrency.symbol',
                    ) ,
                ) ,
                'Item' => array(
                    'fields' => array(
                        'Item.id',
                        'Item.name',
                        'Item.slug'
                    )
                )
            ) ,
            'order' => array(
                'Transaction.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $this->set('transactions', $this->paginate());
        $credit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                'TransactionType.is_credit' => 1
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'group' => array(
                'Transaction.user_id'
            ) ,
            'recursive' => 0
        ));
        $this->set('total_credit_amount', !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0);
        $debit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                'TransactionType.is_credit' => 0
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'group' => array(
                'Transaction.user_id'
            ) ,
            'recursive' => 0
        ));
        $this->set('total_debit_amount', !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0);
        if ((Configure::read('merchant.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User)) {
            $blocked_amount = $this->Transaction->User->UserCashWithdrawal->find('first', array(
                'conditions' => $blocked_conditions,
                'fields' => array(
                    'SUM(UserCashWithdrawal.amount) as total_amount'
                ) ,
                'group' => array(
                    'UserCashWithdrawal.user_id'
                ) ,
                'recursive' => 0
            ));
        }
        $this->set('blocked_amount', !empty($blocked_amount[0]['total_amount']) ? $blocked_amount[0]['total_amount'] : 0);
        if (empty($this->request->data)) {
            if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
                $this->request->data['Transaction']['from_date'] = array(
                    'year' => date('Y', strtotime("-7 days")) ,
                    'month' => date('m', strtotime("-7 days")) ,
                    'day' => date('d', strtotime("-7 days"))
                );
            } else if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
                $this->request->data['Transaction']['from_date'] = array(
                    'year' => date('Y', strtotime('-30 days')) ,
                    'month' => date('m', strtotime('-30 days')) ,
                    'day' => date('d', strtotime('-30 days'))
                );
            } else {
                $this->request->data['Transaction']['from_date'] = array(
                    'year' => date('Y', strtotime('-90 days')) ,
                    'month' => date('m', strtotime('-90 days')) ,
                    'day' => date('d', strtotime('-90 days'))
                );
            }
            $this->request->data['Transaction']['to_date'] = array(
                'year' => date('Y', strtotime('today')) ,
                'month' => date('m', strtotime('today')) ,
                'day' => date('d', strtotime('today'))
            );
        }
    }
    public function admin_index()
    {
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $conditions = array();
            if (!empty($this->request->params['named']['hash'])) {
                $hash = $this->request->params['named']['hash'];
            }
            if (!empty($hash) && isset($_SESSION['export_transactions'][$hash])) {
                $ids = implode(',', $_SESSION['export_transactions'][$hash]);
                if ($this->Transaction->isValidIdHash($ids, $hash)) {
                    $conditions['Transaction.id'] = $_SESSION['export_transactions'][$hash];
                } else {
                    throw new NotFoundException(__l('Invalid request'));
                }
            }
            $this->set('TransactionObj', $this);
            $this->set('conditions', $conditions);
        } else {
            $this->pageTitle = __l('Transactions');
            if (!empty($this->request->params['named']['user_id'])) {
                $this->request->data['Transaction']['user_id'] = $this->request->params['named']['user_id'];
            }
            $conditions = array();
            if (empty($this->request->data['Transaction']['user_id']) && !empty($this->request->data['User']['username'])) {
                $user = $this->Transaction->User->find('first', array(
                    'conditions' => array(
                        'User.username' => $this->request->data['User']['username']
                    ) ,
                    'fields' => array(
                        'User.id'
                    ) ,
                    'recursive' => - 1
                ));
                if (!empty($user)) {
                    $this->request->data['Transaction']['user_id'] = $user['User']['id'];
                } else {
                    $this->request->data['Transaction']['user_id'] = null;
                }
            }
            if (!empty($this->request->data['Transaction']['user_id'])) {
                $this->request->params['named']['user_id'] = $this->request->data['Transaction']['user_id'];
                $users_info = $this->Transaction->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->request->data['Transaction']['user_id']
                    ) ,
                    'fields' => array(
                        'User.username'
                    ) ,
                    'recursive' => - 1
                ));
                $this->request->data['Transaction']['user_id'] = $this->request->data['Transaction']['user_id'];
                $this->set('selected_user_info', !empty($users_info['User']['username']) ? ' - ' . $users_info['User']['username'] : '');
            }
            if (!empty($this->request->data['Transaction']['from_date']['year']) && !empty($this->request->data['Transaction']['from_date']['month']) && !empty($this->request->data['Transaction']['from_date']['day'])) {
                $this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
            }
            if (!empty($this->request->data['Transaction']['to_date']['year']) && !empty($this->request->data['Transaction']['to_date']['month']) && !empty($this->request->data['Transaction']['to_date']['day'])) {
                $this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
            }
			if (empty($this->request->data['Transaction']['filter']) && (empty($this->request->params['named']['filter']) || (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] != 'all'))) {
				$conditions['Transaction.user_id'] = ConstUserIds::Admin;
			}
            $param_string = '';
            $param_string.= !empty($this->request->params['named']['user_id']) ? '/user_id:' . $this->request->params['named']['user_id'] : $param_string;
            $param_string.= !empty($this->request->params['named']['from_date']) ? '/from_date:' . $this->request->params['named']['from_date'] : $param_string;
            $param_string.= !empty($this->request->params['named']['to_date']) ? '/to_date:' . $this->request->params['named']['to_date'] : $param_string;
            if (!empty($this->request->params['named']['user_id'])) {
                $conditions['Transaction.user_id'] = $this->request->params['named']['user_id'];
                $this->request->data['Transaction']['user_id'] = $this->request->params['named']['user_id'];
            }
            if (!empty($this->request->params['named']['type'])) {
                $conditions['Transaction.transaction_type_id'] = $this->request->params['named']['type'];
                $transaction_type = $this->Transaction->TransactionType->find('first', array(
                    'conditions' => array(
                        'TransactionType.id' => $this->request->params['named']['type']
                    ) ,
                    'fields' => array(
                        'TransactionType.name'
                    ) ,
                    'recursive' => - 1
                ));
                $this->pageTitle.= ' - ' . $transaction_type['TransactionType']['name'];
            }
            if (!empty($this->request->params['named']['stat'])) {
                if (!empty($this->request->params['named']['stat'])) {
                    if ($this->request->params['named']['stat'] == 'day') {
                        $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <='] = 0;
                        $this->pageTitle.= __l(' - Today');
                        $this->set('transaction_filter', __l('- Today'));
                        $days = 0;
                    } else if ($this->request->params['named']['stat'] == 'week') {
                        $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <='] = 7;
                        $this->pageTitle.= __l(' - This Week');
                        $this->set('transaction_filter', __l('- This Week'));
                        $days = 7;
                    } else if ($this->request->params['named']['stat'] == 'month') {
                        $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <='] = 30;
                        $this->pageTitle.= __l(' - This Month');
                        $this->set('transaction_filter', __l('- This Month'));
                        $days = 30;
                    } else {
                        $this->pageTitle.= __l(' - Total');
                        $this->set('transaction_filter', __l('- Total'));
                    }
                }
            }
            if (empty($this->request->data)) {
                if (isset($days)) {
                    $this->request->data['Transaction']['from_date'] = array(
                        'year' => date('Y', strtotime("-$days days")) ,
                        'month' => date('m', strtotime("-$days days")) ,
                        'day' => date('d', strtotime("-$days days"))
                    );
                } else {
                    $this->request->data['Transaction']['from_date'] = array(
                        'year' => date('Y', strtotime('-90 days')) ,
                        'month' => date('m', strtotime('-90 days')) ,
                        'day' => date('d', strtotime('-90 days'))
                    );
                }
                $this->request->data['Transaction']['to_date'] = array(
                    'year' => date('Y', strtotime('today')) ,
                    'month' => date('m', strtotime('today')) ,
                    'day' => date('d', strtotime('today'))
                );
            }
            if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
                if ($this->request->params['named']['from_date'] < $this->request->params['named']['to_date']) {
                    $conditions['Transaction.created >='] = _formatDate('Y-m-d H:i:s', $this->request->params['named']['from_date'], true);
                    $conditions['Transaction.created <='] = _formatDate('Y-m-d H:i:s', $this->request->params['named']['to_date'], true);
                } else {
                    $this->Session->setFlash(__l('From date should greater than To date. Please, try again.') , 'default', null, 'error');
                }
            }
            $payment_options = $this->Transaction->getGatewayTypes('is_enable_for_add_to_wallet');
            if (empty($payment_options[ConstPaymentGateways::Wallet])) {
                $conditions['NOT']['Transaction.transaction_type_id'] = array(
                    ConstTransactionTypes::AddedToWallet,
                    ConstTransactionTypes::AddFundToWallet,
                    ConstTransactionTypes::DeductFundFromWallet,
                    ConstTransactionTypes::UserCashWithdrawalAmount,
                    ConstTransactionTypes::AcceptCashWithdrawRequest,
                    ConstTransactionTypes::UserWithdrawalRequest,
                    ConstTransactionTypes::AdminApprovedWithdrawalRequest,
                    ConstTransactionTypes::AdminRejecetedWithdrawalRequest,
                    ConstTransactionTypes::FailedWithdrawalRequest,
                    ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest,
                    ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest,
                    ConstTransactionTypes::FailedWithdrawalRequestRefundToUser
                );
            }
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'TransactionType',
                    'PaymentGateway',
                    'User' => array(
                        'UserAvatar',
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.user_type_id',
                            'User.fb_user_id',
                        )
                    ) ,
                    'ItemUser' => array(
                        'Item' => array(
                            'fields' => array(
                                'Item.id',
                                'Item.name',
                                'Item.slug'
                            )
                        ) ,
                        'fields' => array(
                            'ItemUser.id',
                            'ItemUser.gift_email'
                        )
                    ) ,
                    'Item' => array(
                        'fields' => array(
                            'Item.id',
                            'Item.name',
                            'Item.slug'
                        ) ,
                        'Merchant' => array(
                            'fields' => array(
                                'Merchant.name',
                                'Merchant.slug'
                            )
                        )
                    )
                ) ,
                'order' => array(
                    'Transaction.id' => 'desc'
                ) ,
                'recursive' => 2
            );
                $users = $this->Transaction->User->find('list', array(
                'conditions' => array(
                    'User.user_type_id !=' => ConstUserTypes::Admin,
                    'User.username !=' => ''
                ) ,
                'order' => array(
                    'User.username' => 'asc'
                )
            ));
            $export_transactions = $this->Transaction->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'Transaction.id'
                ) ,
                'recursive' => - 1
            ));
            if (!empty($export_transactions)) {
                $ids = array();
                foreach($export_transactions as $export_transaction) {
                    $ids[] = $export_transaction['Transaction']['id'];
                }
                $hash = $this->Transaction->getIdHash(implode(',', $ids));
                $_SESSION['export_transactions'][$hash] = $ids;
                $this->set('export_hash', $hash);
            }
            $credit = $this->Transaction->find('first', array(
                'conditions' => array_merge($conditions, array(
                    'TransactionType.is_credit' => 1
                )) ,
                'fields' => array(
                    'SUM(Transaction.amount) as total_amount'
                ) ,
                'recursive' => 0
            ));
            $this->set('total_credit_amount', !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0);
            $debit = $this->Transaction->find('first', array(
                'conditions' => array_merge($conditions, array(
                    'TransactionType.is_credit' => 0
                )) ,
                'fields' => array(
                    'SUM(Transaction.amount) as total_amount'
                ) ,
                'recursive' => 0
            ));
            if (!empty($this->request->params['named']['user_id'])) {
                $user = $this->Transaction->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->request->params['named']['user_id']
                    ) ,
                    'recursive' => - 1
                ));
                $this->set('user', $user);
            }
            $this->set('total_debit_amount', !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0);
            $this->set('users', $users);
            $this->set('transactions', $this->paginate());
            $this->set('param_string', $param_string);
            $this->set('pageTitle', $this->pageTitle);
            $this->Transaction->User->validate = array();
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Transaction->delete($id)) {
            $this->Session->setFlash(__l('Transaction deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>