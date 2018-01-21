<?php

namespace Zing\Core\SettingBundle\Controller;

use Zing\Core\CoreBundle\Controller\CoreController;


class SettingController extends CoreController
{

    /** Roll back a bundle to default built
     * @param string $type Type of the bundle (Core or Component)
     * @param string $bundle_name Name of the bundle that we want to roll back
     */
    public function rollBackBundleAction($type, $bundle_name)
    {
        /** Get setting manager */
        $setting_manager = $this->get('zing.core.setting.setting');

        /** Roll back settings for specific bundle */
        $setting_manager->rollBackBundleSetting($type, $bundle_name);

        $this->zingRedirect('/admincp/settings');
    }

    public function rollBackBuiltAction($built_id) {
                /** Get setting manager */
        $setting_manager = $this->get('zing.core.setting.setting');
        
        $setting_manager->rollBackBuilt($built_id);
        
        $this->zingRedirect('/admincp/settings');
    }
    
}