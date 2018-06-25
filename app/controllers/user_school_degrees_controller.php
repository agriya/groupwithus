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
class UserSchoolDegreesController extends AppController
{
    public $name = 'UserSchoolDegrees';
    public function admin_index()
    {
        $this->pageTitle = __l('School Degrees');
        $this->UserSchoolDegree->recursive = 0;
        $this->set('userSchoolDegrees', $this->paginate());
        $moreActions = $this->UserSchoolDegree->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add School Degree');
        if ($this->UserSchoolDegree->validates()) {
            if ($this->request->is('post')) {
                $this->UserSchoolDegree->create();
                if ($this->UserSchoolDegree->save($this->request->data)) {
                    $this->Session->setFlash(__l('User school degree has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('User school degree could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit School Degree');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserSchoolDegree->id = $id;
        if (!$this->UserSchoolDegree->exists()) {
            throw new NotFoundException(__l('Invalid user school degree'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->UserSchoolDegree->save($this->request->data)) {
                $this->Session->setFlash(__l('User school degree has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User school degree could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserSchoolDegree->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserSchoolDegree']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserSchoolDegree->delete($id)) {
            $this->Session->setFlash(__l('User school degree  deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
