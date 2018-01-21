<?php

namespace Zing\Core\PageBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class PageAdminController extends AdminController
{

    public function indexAction()
    {
        $page_manager = $this->get('zing.core.page.page');

        /** Use the table action */
        $page_manager->multiplyTableAction((array) $this->postZingRequest());

        return $this->renderAdmin('ZingCorePageBundle:Default:index.html.twig',
            array('pages' => $page_manager->getAllPages())
        );
    }

    public function editAction($page_id)
    {
        $page_manager = $this->get('zing.core.page.page');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $page_id);

        /** Get requested pages */
        $page = $page_manager->getPage($page_id);

        if($page != null) {
            $response['zing_page_name'] = $page->getName();
            $response['zing_page_url'] = $page->getUrl();
            $response['zing_page_status'] = $page->getStatus();
        }

        return $this->renderAdmin('ZingCorePageBundle:Default:form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors,
                'page'             => $page,
                'post_request'     => $post_request
            ),
            $response
        ));
    }

    public function createAction() {

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingCorePageBundle:Default:form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors,
                'post_request'     => $post_request
            ),
            $post_request
        ));
    }

    /** Remove a page
     * @param int $page_id Id of the layout that we want to remove
     */
    public function removeAction($page_id)
    {
        $this->get('zing.core.page.page')->removePage($page_id);
        $this->zingRedirect('/admincp/pages');
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $page_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $page_id = null)
    {
        $page_manager = $this->get('zing.core.page.page');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $page_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($page_id != null) {
                    /** Set the new layout */
                    $page_manager->updatePage($post_request, $page_id);
                } else {
                    /** Set the new layout */
                    $page_manager->setPage($post_request);
                }

                $this->zingRedirect('/admincp/pages');
            }
        }
        return $errors;
    }

}