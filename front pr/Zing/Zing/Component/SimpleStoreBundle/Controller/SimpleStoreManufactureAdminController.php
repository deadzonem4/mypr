<?php

namespace Zing\Component\SimpleStoreBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Zing\Core\AdminBundle\Controller\AdminController;

class SimpleStoreManufactureAdminController extends AdminController
{
    public function indexAction()
    {
        $manufacture_manager = $this->requestService('zing.component.simplestore.manufacture');
        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:manufacture/index.html.twig', array(
            'manufactures'              => $manufacture_manager->getAllManufactures(),
            'user_key'                  => $api_manager->createUserApiKey()
        ));
    }

    public function editAction($manufacture_id)
    {

        $manufacture_manager = $this->requestService('zing.component.simplestore.manufacture');

        $manufacture = $manufacture_manager->getManufacture($manufacture_id);

        if($manufacture == null) {
            throw new Exception('Requested manufacture dose not exists');
        }

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $manufacture_id);

        $post_request = array(
            'zing_manufacture_display_name' => $manufacture->getName(),
            'zing_manufacture_status'       => $manufacture->getStatus(),
            'manufacture'                   => $manufacture
        );

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:manufacture/form.html.twig', array_merge(array(
                'zing_form_action'  => 'edit',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),  $post_request
        ));
    }

    public function createAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentSimpleStoreBundle:Default:manufacture/form.html.twig', array_merge(array_merge(array(
                'zing_form_action'  => 'create',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),
            array('post_request' => $post_request)
        ), $post_request));
    }

    /** Remove a manufacture
     * @param int $manufacture_id Id of the layout that we want to remove
     */
    public function removeAction($manufacture_id)
    {
        $this->requestService('zing.component.simplestore.manufacture')->removeManufacture($manufacture_id);
        $this->zingRedirect('/admincp/store/manufacture');
    }


    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $category_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/store/category
     */
    private function _handleRequest($post_request, $manufacture_id = null)
    {

        $manufacture_manager = $this->requestService('zing.component.simplestore.manufacture');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $manufacture_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($manufacture_id != null){
                    $manufacture_manager->updateManufacture($post_request, $manufacture_id);
                } else {
                    $manufacture_manager->setManufacture($post_request);
                }

                $this->zingRedirect('/admincp/store/manufacture');
            }
        }
        return $errors;
    }
}
