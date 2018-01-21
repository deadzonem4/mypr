<?php

namespace Zing\Component\SimpleStoreBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class SimpleStoreProductAdminController extends AdminController
{
    public function indexAction()
    {
        $products_manager = $this->requestService('zing.component.simplestore.product');
        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:product/index.html.twig', array(
            'products'          => $products_manager->getAllProducts(),
            'user_key'          => $api_manager->createUserApiKey()
        ));
    }

    public function editAction($product_id)
    {

        $product_manager = $this->requestService('zing.component.simplestore.product');

        $product = $product_manager->getProduct($product_id);

        if($product == null) {
            throw new \Exception('Requested product dose not exists');
        }

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $product_id);

        $post_request = array(
            'zing_product_display_name'     => $product->getName(),
            'zing_product_status'           => $product->getStatus(),
            'product'                       => $product
        );

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:product/form.html.twig', array_merge(array_merge(array(
                'zing_form_action'  => 'edit',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),
            array('post_request' => $post_request)
        ), $post_request));
    }

    public function createAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:product/form.html.twig', array_merge(array_merge(array(
                'zing_form_action'  => 'create',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),
            array('post_request' => $post_request)
        ), $post_request));
    }

    /** Remove a category
     * @param int $category_id Id of the layout that we want to remove
     */
    public function removeAction($product_id)
    {
        $this->requestService('zing.component.simplestore.product')->removeProduct($product_id);
        $this->zingRedirect('/admincp/store/product');
    }


    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $category_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/store/category
     */
    private function _handleRequest($post_request, $product_id = null)
    {

        $product_manager = $this->requestService('zing.component.simplestore.product');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {

            $errors = $product_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($product_id != null){
                    $product_manager->updateProduct($post_request, $product_id);
                } else {
                    //$this->dump($post_request);exit;
                    $product_manager->setProduct($post_request);
                }

                $this->zingRedirect('/admincp/store/product');
            }
        }
        return $errors;
    }








}
