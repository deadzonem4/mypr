<?php

namespace Zing\Core\ComponentBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;


class ComponentAdminController extends AdminController
{

    public function indexAction()
    {
        return $this->renderAdmin('ZingCoreComponentBundle:Default:index.html.twig', array());
    }

}