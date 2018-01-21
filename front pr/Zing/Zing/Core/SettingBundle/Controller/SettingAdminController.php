<?php

namespace Zing\Core\SettingBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;


class SettingAdminController extends AdminController
{

    public function indexAction()
    {

        /** Get setting manager */
        $setting_manager = $this->get('zing.core.setting.setting');

        $post_request = (array) $this->postZingRequest();
        if(count($post_request) > 0) {
            $setting_manager->build(array('SettingBundle' => $post_request));
        }

        /** Roll back settings for specific bundle */
        //$setting_manager->rollBackBundleSetting('Component', 'LanguageBundle');

        /** Get bunddle settings */
        //print_r($setting_manager->bundle('SettingBundle'));

        //print_r($setting_manager->lastBuilt());

        /** Roll back a built */
        //$setting_manager->rollBackBuilt(5);

        //print_r($this->postZingRequest());

        /** Setting bundle built */
        $setting_bundle_built = $setting_manager->bundle('SettingBundle');

        /** If no built is found for this bundle */
        if($setting_bundle_built == false || $setting_bundle_built == null) {
            $setting_bundle_built = array();
        }

        return $this->renderAdmin('ZingCoreSettingBundle:Default:index.html.twig', array_merge(array('buildings' => $setting_manager->allBuildings()), $setting_bundle_built));
    }
    
    public function generalAction()
    {
        /** Get setting manager */
        $setting_manager = $this->get('zing.core.setting.setting');

        $post_request = (array) $this->postZingRequest();
        if(count($post_request) > 0) {
            $this->modifyLocale($post_request['zing_setting_default_language'], false);
            $setting_manager->build(array('SettingBundle' => $post_request));
        }
        /** Setting bundle built */
        $setting_bundle_built = $setting_manager->bundle('SettingBundle');

        /** If no built is found for this bundle */
        if($setting_bundle_built == false || $setting_bundle_built == null) {
            $setting_bundle_built = array();
        }

        return $this->renderAdmin('ZingCoreSettingBundle:Default:Setting/index.html.twig', array_merge(array(), $setting_bundle_built));
    }
}