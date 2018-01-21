<?php

namespace Zing\Core\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController {

     private $authneticate_session;
     private $authneticate_remembered;

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        $requestAttributes = $this->container->get('request')->attributes;
        $this->authneticate_session = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');
        $this->authneticate_remembered = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED');

        $r = $this->_passRedirectionUrl();

        if($requestAttributes->get('_route') == 'fos_user_security_login_admin') {
            $template = $this->_adminForm($r);
        } elseif($requestAttributes->get('_route') == 'fos_user_security_login_front') {
            $template = $this->_frontForm($r);
        }

        return $this->container->get('templating')->renderResponse($template, array_merge($data, array('r' => $r)));
    }

    /** Render administrator form */
    private function _adminForm($r = '')
    {
        if($this->authneticate_session != false || $this->authneticate_remembered != false) {
            if(!empty($r)) {
                header('Location: /admincp?r='.$r);exit;
            }
            header('Location: /admincp');exit;
        }
        
        return sprintf('ZingCoreAdminBundle:Login:login.html.twig');
    }

    /** Render front form */
    private function _frontForm($r = '')
    {
        if($this->authneticate_session != false || $this->authneticate_remembered != false) {
            if(!empty($r)) {
                header('Location: /?r='.$r);exit;
            }
            header('Location: /');exit;
        }

        return sprintf('ZingCoreFrontBundle:Login:login.html.twig');
    }

    private function _passRedirectionUrl()
    {
        if(isset($_GET['r'])) {return $_GET['r'];}
        return '';
    }

}
