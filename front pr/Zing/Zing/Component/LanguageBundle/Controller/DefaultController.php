<?php

namespace Zing\Component\LanguageBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class DefaultController extends AdminController
{
    public function indexAction()
    {
        return $this->renderAdmin('ZingComponentLanguageBundle:Default:index.html.twig');
    }
}
