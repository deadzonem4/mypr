<?php

namespace Zing\Core\AnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZingCoreAnalyticsBundle:Default:index.html.twig', array('name' => $name));
    }
}
