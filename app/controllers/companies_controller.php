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
class CompaniesController extends AppController
{
    public $name = 'Companies';
    public function admin_index() 
    {
        $this->pageTitle = __l('Companies');
        $this->Company->recursive = 0;
        $this->set('companies', $this->paginate());
        $moreActions = $this->Company->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Company');
        if ($this->Company->validates()) {
        if ($this->request->is('post')) {
            $this->Company->create();
            if ($this->Company->save($this->request->data)) {
                $this->Session->setFlash(__l('company has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('company could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Company');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->Company->id = $id;
        if (!$this->Company->exists()) {
            throw new NotFoundException(__l('Invalid company'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Company->save($this->request->data)) {
                $this->Session->setFlash(__l('company has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('company could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->Company->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Company']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Company->delete($id)) {
            $this->Session->setFlash(__l('Company  deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        }else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
