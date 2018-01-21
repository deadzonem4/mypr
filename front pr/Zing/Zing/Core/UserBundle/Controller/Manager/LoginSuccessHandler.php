<?php
namespace Zing\Core\UserBundle\Controller\Manager;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Zing\Core\CoreBundle\Plugin\CryptIT;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if($this->_urlRequestedRedirect()) {
            $response = new RedirectResponse($this->_urlRequestedRedirect());
        }
        elseif ($this->security->isGranted('ROLE_SUPER_ADMIN'))
        {
            $response = new RedirectResponse('/admincp');
        }
        elseif ($this->security->isGranted('ROLE_ADMIN'))
        {
            $response = new RedirectResponse('/admincp');
        }
        elseif ($this->security->isGranted('ROLE_USER'))
        {
            $response = new RedirectResponse('/');
        }
        else {
            $response = new RedirectResponse('/login');
        }
        return $response;
    }

    private function _urlRequestedRedirect()
    {
        $crypt_it = new CryptIT();
        if(isset($_GET['r'])) {return $crypt_it->decodeUrl($_GET['r']);}
        return false;
    }

}