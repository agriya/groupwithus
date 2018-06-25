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
class ItemCategoriesController extends AppController
{
    public $name = 'ItemCategories';
	function index()
	{
        $this->paginate = array(
            'order' => array(
                'ItemCategory.name' => 'asc'
            ) ,
            'recursive' => - 1
        );
        $this->set('item_categories', $this->paginate());
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Item Categories');
        $this->ItemCategory->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['ItemCategory']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->paginate = array(
            'order' => array(
                'ItemCategory.id' => 'desc'
            ) ,
        );
        if (isset($this->request->data['ItemCategory']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->set('itemCategories', $this->paginate());
        $moreActions = $this->ItemCategory->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Item   Category');
        if (!empty($this->request->data)) {
            $this->ItemCategory->create();
            if ($this->ItemCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Item category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Item category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }

    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Item Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->ItemCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Item category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Item category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ItemCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['ItemCategory']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ItemCategory->delete($id)) {
            $this->Session->setFlash(__l('Item category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>