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
class ItemPassesController extends AppController
{
    public $name = 'ItemPasses';
    function index()
    {
        $this->pageTitle = __l('Item Orders/Passes');
        $this->ItemPass->recursive = 0;
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $conditions['Item.id'] = $this->request->params['named']['item_id'];
        } else {
            $merchant = $this->ItemPass->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => - 1
            ));
            if (empty($merchant)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Item.merchant_id'] = $merchant['Merchant']['id'];
        }
        $item = $this->ItemPass->Item->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Item.id',
                'Item.name',
            ) ,
            'recursive' => - 1
        ));
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->paginate = array(
            'conditions' => array(
                'ItemPass.item_id' => $this->request->params['named']['item_id']
            ) ,
            'recursive' => - 1
        );
        $this->set('item', $item);
        $this->set('itemPasses', $this->paginate());
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ItemPass->delete($id)) {
            $this->Session->setFlash(__l('Unused Pass deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'items',
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_index()
    {
        $this->setAction('index');
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ItemPass->delete($id)) {
            $this->Session->setFlash(__l('Unused Pass deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'items',
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>