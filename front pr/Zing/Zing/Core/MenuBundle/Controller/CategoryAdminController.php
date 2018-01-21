<?php

namespace Zing\Core\MenuBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;


class CategoryAdminController extends AdminController
{

    public function indexAction()
    {
        $category_manager = $this->get('zing.core.menu.category');

        /** Use the table action */
        $category_manager->multiplyTableAction((array) $this->postZingRequest());

        return $this->renderAdmin('ZingCoreMenuBundle:Default:index.html.twig',
            array('categories' => $category_manager->getAllCategories())
        );
    }

    public function editAction($category_id)
    {
        $category_manager = $this->get('zing.core.menu.category');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $category_id);

        /** Get requested pages */
        $category = $category_manager->getCategory($category_id, true);

        if($category != null) {
            $response['zing_category_name'] = $category['name'];
            $response['zing_category_status'] = $category['status'];
        }

        return $this->renderAdmin('ZingCoreMenuBundle:Default:category_form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Edit',
                'zing_form_errors' => $errors
            ),
            $response
        ));
    }

    /** Remove a page
     * @param int $category_id Id of the layout that we want to remove
     */
    public function removeAction($category_id)
    {
        $this->get('zing.core.menu.category')->removeCategory($category_id);
        $this->zingRedirect('/admincp/menus');
    }

    public function categoryAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingCoreMenuBundle:Default:category_form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors
            ),
            $post_request
        ));

    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $page_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $page_id = null)
    {
        $page_manager = $this->get('zing.core.menu.category');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $page_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($page_id != null) {
                    /** Set the new layout */
                    $page_manager->updateCategory($post_request, $page_id);
                } else {
                    /** Set the new layout */
                    $page_manager->setCategory($post_request);
                }

                $this->zingRedirect('/admincp/menus');
            }
        }
        return $errors;
    }

}