<?php

namespace Zing\Component\SimpleStoreBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Zing\Core\AdminBundle\Controller\AdminController;

class SimpleStoreAdminController extends AdminController
{
    public function indexAction()
    {
        $this->_addStorePages();

        $orders = $this->requestService('zing.component.simplestore.product_order')->getAllProductOrders();

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:index.html.twig', array(
                'orders' => $orders
            )
        );
    }

    public function orderAction($order_id)
    {
        $order = $this->requestService('zing.component.simplestore.product_order')->getProductOrder($order_id);

        if(!$order) {
            throw new Exception('Requested order dose not exists');
        }

        $this->_handleOrderRequest($order);

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:orders/view.html.twig', array(
                'order' => $order
            )
        );
    }

    public function removeAction($order_id)
    {
        /** Orders cannot be deleted, so do a redirect to orders */
        $this->zingRedirect('/admincp/store');exit;

        $order = $this->requestService('zing.component.simplestore.product_order')->getProductOrder($order_id);

        if(!$order) {
            throw new Exception('Requested order dose not exists');
        }

        $order_manager = $this->requestService('zing.component.simplestore.product_order');

        $order_manager->removeProductOrderObject($order);
        $this->zingRedirect('/admincp/store');
    }

    private function _handleOrderRequest($order)
    {
        $request = $this->postZingRequest();

        if(isset($request['order_unsuccess'])) {
            $order_manager = $this->requestService('zing.component.simplestore.product_order');
            $order_manager->updateProductOrderObject($order->setStatus('rejected'));

            /** Send email for current order */
            $this->zing_mail(
                $order->getUserData()['user_email'],
                'Статус на поръчка с номер '.$order->getId().' в '.$this->currentHttpHost(),
                array(
                    'domein'    => $this->currentProtocol().'://'.$this->currentHttpHost(),
                    'order' => $order,
                    'status' => 'отказана'
                ),
                'ZingComponentSimpleStoreBundle:Default/mail:order_mail.html.twig'
            );

            $this->zingRedirect('/admincp/store');
        } elseif(isset($request['order_success'])) {
            $order_manager = $this->requestService('zing.component.simplestore.product_order');
            $order_manager->updateProductOrderObject($order->setStatus('done'));

            /** Send email for current order */
            $this->zing_mail(
                $order->getUserData()['user_email'],
                'Статус на поръчка с номер '.$order->getId().' в '.$this->currentHttpHost(),
                array(
                    'domein'    => $this->currentProtocol().'://'.$this->currentHttpHost(),
                    'order' => $order,
                    'status' => 'одобрена'
                ),
                'ZingComponentSimpleStoreBundle:Default/mail:order_mail.html.twig'
            );

            $this->zingRedirect('/admincp/store');

        }
        return true;
    }

    private function _addStorePages()
    {

        if($this->requestService('zing.core.page.page')->getPageBy(array('url' => '/store')) == null) {
            $this->_storePage('Store', '/store');
        }

        if($this->requestService('zing.core.page.page')->getPageBy(array('url' => '/store/product')) == null) {
            $this->_storePage('Store - Product', '/store/product');
        }

        if($this->requestService('zing.core.page.page')->getPageBy(array('url' => '/store/checkout')) == null) {
            $this->_storePage('Store - checkout', '/store/checkout');
        }

        if($this->requestService('zing.core.page.page')->getPageBy(array('url' => '/store/cart')) == null) {
            $this->_storePage('Store - cart', '/store/cart');
        }

        return true;
    }

    private function _storePage($name, $url)
    {
        $this->requestService('zing.core.page.page')->setPage(
            array(
                'zing_page_name'    => $name,
                'zing_page_url'     => $url,
                'zing_page_status'  => 1
            ), true
        );
        return true;
    }

}
