<?php

namespace Zing\Component\SliderBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class SliderAdminController extends AdminController
{
    public function indexAction()
    {
        $slider_manager = $this->get('zing.component.slider.slider');

        /** Use the table action */
        $slider_manager->multiplyTableAction((array) $this->postZingRequest());

        return $this->renderAdmin('ZingComponentSliderBundle:Default:index.html.twig',
            array('sliders' => $slider_manager->getAllSliders())
        );
    }

    public function editAction($slider_id)
    {
        $slider_manager = $this->get('zing.component.slider.slider');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $slider_id);

        /** Get requested pages */
        $slider = $slider_manager->getSlider($slider_id, true);

        if($slider != null) {
            $response['zing_slider_name'] = $slider['name'];
            $response['zing_slider_width'] = $slider['size_w'];
            $response['zing_slider_height'] = $slider['size_h'];
            $response['zing_slider_status'] = $slider['status'];
        }

        return $this->renderAdmin('ZingComponentSliderBundle:Default:slider_form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Edit',
                'zing_form_errors' => $errors
            ),
            $response
        ));
    }

    /** Remove a page
     * @param int $slider_id Id of the layout that we want to remove
     */
    public function removeAction($slider_id)
    {
        $this->get('zing.component.slider.slider')->removeSlider($slider_id);
        $this->zingRedirect('/admincp/slider');
    }

    public function addAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingComponentSliderBundle:Default:slider_form.html.twig', array_merge(
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
        $slider_manager = $this->get('zing.component.slider.slider');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $slider_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($page_id != null) {
                    /** Set the new layout */
                    $slider_manager->updateSlider($post_request, $page_id);
                } else {
                    /** Set the new layout */
                    $slider_manager->setSlider($post_request);
                }

                $this->zingRedirect('/admincp/slider');
            }
        }
        return $errors;
    }

}