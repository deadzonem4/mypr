<?php

namespace Zing\Core\AdminBundle\Controller;
use Zing\Core\AdminBundle\Controller\AdminController;

class DevAdminController extends AdminController
{

    public function indexAction()
    {
        // $this->debug($this->get('zing.core.page.block_type')->getSupportedBlockTypes());
        return $this->renderAdmin('ZingCoreAdminBundle:Default:Dev/index.html.twig');
    }


}

