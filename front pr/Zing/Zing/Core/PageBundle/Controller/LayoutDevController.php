<?php
namespace Zing\Core\PageBundle\Controller;

use Zing\Core\AdminBundle\Controller\DevAdminController;

/** Zing
 * Layout development controller
 */
class LayoutDevController extends DevAdminController {

    /** Render all saved layouts */
    public function layoutAction()
    {
       $layout_manager = $this->get('zing.core.page.layout');

       /** Use the table action */
       $layout_manager->multiplyTableAction((array) $this->postZingRequest());

       return $this->renderAdmin('ZingCorePageBundle:Default:Dev/Layout/index.html.twig',
           array('layouts' => $layout_manager->getAllLayouts())
       );
    }

    /** Edit an layout
     * @param int $layout_id. Layout for updating
     * @return response Render form for updateing a layout
     */
    public function editAction($layout_id)
    {
        $layout_manager = $this->get('zing.core.page.layout');
        $post_request = (array) $this->postZingRequest();
        $errors = $this->_handleRequest($post_request, $layout_id);

        $response = array();

        /** Get requested layout */
        $layout = $layout_manager->getLayout($layout_id, true);

        if($layout != null) {
            $response['zing_dev_layout_name'] = $layout['name'];
            $response['zing_dev_layout_file'] = $layout['layout_file'];
            $response['zing_dev_layout_status'] = $layout['status'];
        }

        return $this->renderAdmin('ZingCorePageBundle:Default:Dev/Layout/form.html.twig',
            array_merge(
                array(
                    'zing_form_action' => 'Edit',
                    'zing_form_errors' => $errors,
                    'zing_dev_layouts' => $layout_manager->getLayoutPreviewFiles(),
                ),
                $response));
    }

    /** Create a new layout and save it
     * @return response Form for creating a new layout
     */
    public function createAction()
    {
        $layout_manager = $this->get('zing.core.page.layout');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingCorePageBundle:Default:Dev/Layout/form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors,
                'zing_dev_layouts' => $layout_manager->getLayoutPreviewFiles(),
            ),
            $post_request
        ));
    }

    /** Remove a layout
     * @param int $layout_id Id of the layout that we want to remove
     */
    public function removeAction($layout_id)
    {
        $this->get('zing.core.page.layout')->removeLayout($layout_id);
        $this->zingRedirect('/admincp/dev/layout');
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $layout_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $layout_id = null)
    {
        $layout_manager = $this->get('zing.core.page.layout');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $layout_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                /** Check if requested layout exists in admin folder */
                if(!$layout_manager->isLayoutExists($post_request['zing_dev_layout_file'], 'admin')) {
                    $errors = array_merge($errors, array('The file dose not exists in Layout/Admin folder'));
                }

                /** Check if requested layout exists in front folder */
                if(!$layout_manager->isLayoutExists($post_request['zing_dev_layout_file'], 'front')) {
                    $errors = array_merge($errors, array('The file dose not exists in Layout/Front folder'));
                }

                /** Check if requested layout exists in preview folder */
                if(!$layout_manager->isLayoutExists($post_request['zing_dev_layout_file'], 'preview')) {
                    $errors = array_merge($errors, array('The file dose not exists in Layout/Preview folder'));
                }

                if(count($errors) > 0) {
                    return $errors;
                }

                if($layout_id != null) {
                    /** Set the new layout */
                    $layout_manager->updateLayout($post_request, $layout_id);
                } else {
                    /** Set the new layout */
                    $layout_manager->setLayout($post_request);
                }

                $this->zingRedirect('/admincp/dev/layout');
            }
        }
        return $errors;
    }
} 