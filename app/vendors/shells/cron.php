<?php

/**
 *
 * @version $Id: cron.php 54711 2011-05-26 11:14:18Z anandam_023ac09 $
 * @copyright 2009
 */
class CronShell extends Shell {
    function main()
    {
        // site settings are set in config
        App::import('Model', 'Setting');
        $setting_model_obj = new Setting();
        $settings = $setting_model_obj->getKeyValuePairs();
        Configure::write($settings);
		App::import('Core', 'ComponentCollection');
		$collection = new ComponentCollection();
		App::import('Component', 'Cron');
        $this->Cron = new CronComponent($collection);
        $option = !empty($this->args[0]) ? $this->args[0] : '';
        $this->log('Cron started without any issue.', LOG_DEBUG);
        switch ($option) {
            case 'main':
                $this->Cron->main();
                break;
            case 'currency_conversion':
                $this->Cron->currency_conversion();
                break;
            default: ;
        } // switch
    }
}

?>