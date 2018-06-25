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
class CronsController extends AppController
{
    public $name = 'Crons';
	public $components = array(
        'Cron',
    );
    public function main()
    {
        $this->autoRender = false;
        $this->Cron->main();
    }
	public function currency_conversion()
    {
        $this->autoRender = false;
        $this->Cron->currency_conversion();
    }
}
?>