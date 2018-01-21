<?php

namespace Zing\Component\MediaBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class MediaAdminController extends AdminController
{
    public function indexAction()
    {
        return $this->renderAdmin('ZingComponentMediaBundle:Default:index.html.twig');
    }
}
