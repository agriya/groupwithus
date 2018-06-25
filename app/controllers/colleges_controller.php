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
class CollegesController extends AppController
{
    public $name = 'Colleges';
    public function admin_index() 
    {
        $this->pageTitle = __l('Collages');
        $this->College->recursive = 0;
        $this->set('colleges', $this->paginate());
        $moreActions = $this->College->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add College');
        if ($this->College->validates()) {
        if ($this->request->is('post')) {
            $this->College->create();
            if ($this->College->save($this->request->data)) {
                $this->Session->setFlash(__l('college has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('college could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit College');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->College->id = $id;
        if (!$this->College->exists()) {
            throw new NotFoundException(__l('Invalid college'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->College->save($this->request->data)) {
                $this->Session->setFlash(__l('college has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('college could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->College->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['College']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->College->delete($id)) {
            $this->Session->setFlash(__l('College  deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        }else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
