<?php
namespace Zing\Component\ClientRequestBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class ClientRequestAdminController extends AdminController
{
    public function indexAction()
    {
        $client_request_manager = $this->get('zing.component.client_request.client_request');

        return $this->renderAdmin('ZingComponentClientRequestBundle:Default:index.html.twig', array(
            'client_requests'  => $client_request_manager->getAllClientRequest()
        ));
    }

    public function viewAction($client_request_id)
    {
        $client_request = $this->requestService('zing.component.client_request.client_request')->getClientRequest($client_request_id);
        if(!$client_request) {
            throw new Exception('Requested client request dose not exists');
        }
        $this->_handleRequest($client_request);
        return $this->renderAdmin('ZingComponentClientRequestBundle:Default:view.html.twig', array(
                'client_request' => $client_request
            )
        );
    }

    public function removeAction($client_request_id)
    {
        $client_request = $this->requestService('zing.component.client_request.client_request')->getClientRequest($client_request_id);
        if(!$client_request) {
            throw new Exception('Requested client request dose not exists');
        }
        $this->requestService('zing.component.client_request.client_request')->removeClientRequestObject($client_request);
        $this->zingRedirect('/admincp/client/request');
    }

    private function _handleRequest($client_request)
    {
        $request = $this->postZingRequest();

        if(isset($request['readed'])) {
            $client_request_manager = $this->get('zing.component.client_request.client_request');
            $client_request_manager->updateClientRequestObject($client_request->setStatus(1));
            $this->zingRedirect('/admincp/client/request');
        }

        return true;
    }

}
