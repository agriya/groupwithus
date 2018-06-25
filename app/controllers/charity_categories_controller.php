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
class CharityCategoriesController extends AppController
{
    public $name = 'CharityCategories';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q',
        ));
        $this->pageTitle = __l('Charity Categories');
        $this->CharityCategory->recursive = 0;
        if (isset($this->request->params['named']['q']) && !empty($this->request->params['named']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
            $this->request->data['CharityCategory']['q'] = $this->request->params['named']['q'];
        }
        $moreActions = $this->CharityCategory->moreActions;
        $this->set(compact('moreActions'));
        $this->set('charityCategories', $this->paginate());
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Charity Category');
        $this->CharityCategory->create();
        if (!empty($this->request->data)) {
            if ($this->CharityCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Charity Category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Charity Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Charity Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->CharityCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Charity Category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Charity Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->CharityCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['CharityCategory']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->CharityCategory->delete($id)) {
            $this->Session->setFlash(__l('Charity Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>