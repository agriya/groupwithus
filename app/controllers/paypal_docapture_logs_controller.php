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
class PaypalDocaptureLogsController extends AppController
{
    public $name = 'PaypalDocaptureLogs';
    public function admin_index()
    {
        $this->pageTitle = __l('Paypal Docapture Logs');
        $this->PaypalDocaptureLog->recursive = 0;
        $this->set('paypalDocaptureLogs', $this->paginate());
    }
    public function admin_view($id = null)
    {
        $this->pageTitle = __l('Paypal Docapture Log');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paypalDocaptureLog = $this->PaypalDocaptureLog->find('first', array(
            'conditions' => array(
                'PaypalDocaptureLog.id = ' => $id
            ) ,
            'recursive' => 0,
        ));
        if (empty($paypalDocaptureLog)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $paypalDocaptureLog['PaypalDocaptureLog']['id'];
        $this->set('paypalDocaptureLog', $paypalDocaptureLog);
    }
}
?>