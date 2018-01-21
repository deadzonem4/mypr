<?php

namespace Zing\Component\ContactBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class ContactAdminController extends AdminController
{
    public function indexAction()
    {

        $contact_manager = $this->get('zing.component.contact.contact');

        return $this->renderAdmin('ZingComponentContactBundle:Default:index.html.twig', array(
                'contacts'  => $contact_manager->getAllContact()
        ));
    }

    public function viewAction($contact_id)
    {
        $contact = $this->requestService('zing.component.contact.contact')->getContact($contact_id);
        if(!$contact) {
            throw new Exception('Requested contact dose not exists');
        }
        $this->_handleRequest($contact);
        return $this->renderAdmin('ZingComponentContactBundle:Default:view.html.twig', array(
                'contact' => $contact
            )
        );
    }

    public function removeAction($contact_id)
    {
        $contact = $this->requestService('zing.component.contact.contact')->getContact($contact_id);
        if(!$contact) {
            throw new Exception('Requested contact dose not exists');
        }
        $this->requestService('zing.component.contact.contact')->removeContactObject($contact);
        $this->zingRedirect('/admincp/contact');exit;
    }

    private function _handleRequest($contact)
    {
        $request = $this->postZingRequest();

        if(isset($request['readed'])) {
            $contact_manager = $this->requestService('zing.component.contact.contact');
            $contact_manager->updateContactObject($contact->setStatus(1));
            $this->zingRedirect('/admincp/contact');
        }

        return true;
    }

}
