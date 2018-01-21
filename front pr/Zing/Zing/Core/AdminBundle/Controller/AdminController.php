<?php

namespace Zing\Core\AdminBundle\Controller;

use Zing\Core\CoreBundle\Controller\CoreController;

class AdminController extends CoreController
{

    public function indexAction()
    {
        return $this->renderAdmin('ZingCoreAdminBundle:Default:Dashboard/index.html.twig');
    }

    public function renderAdmin($template, $data = array(), $response = false) {

        $default_data = array(
            'default_language' => $this->defaultLanguage(),
            'active_languages'  => $this->activeLanguages(),
            'components' => $this->get('zing.core.setting.setting')->getComponentsFromLastBuilt()
        );
        if($response == true) {
            return $this->renderView($template, array_merge($default_data, $data));
        }
        return $this->defaultRender($template, array_merge($default_data, $data));
    }


}

