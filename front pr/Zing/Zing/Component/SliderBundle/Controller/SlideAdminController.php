<?php

namespace Zing\Component\SliderBundle\Controller;

use Zing\Component\SliderBundle\Entity\SlideContent;
use Zing\Core\AdminBundle\Controller\AdminController;

class SlideAdminController extends AdminController
{
    public function slideAction($slider_id)
    {
        $slider_manager = $this->get('zing.component.slider.slide');

        /** Use the table action */
        $slider_manager->multiplyTableAction((array) $this->postZingRequest());

        return $this->renderAdmin('ZingComponentSliderBundle:Default:slide_index.html.twig',
            array(
                'slides'   => $slider_manager->getAllSlides(),
                'slider_id' => $slider_id,
                'default_language'  => $this->defaultLanguage()
            )
        );
    }

    public function editAction($slider_id, $slide_id)
    {
        $slider_manager = $this->get('zing.component.slider.slide');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $slider_id, $slide_id);

        /** Get requested slide */
        $slide = $slider_manager->getSlide($slide_id);

        $api_manager = $this->get('zing.core.api.api');

        /** Create a user api key */
        $user_api_key = $api_manager->createUserApiKey();

        return $this->renderAdmin('ZingComponentSliderBundle:Default:slide_form.html.twig', array(
                'user_key'          => $user_api_key,
                'zing_form_action'  => 'Edit',
                'zing_form_errors'  => $errors,
                'response'          => $slide,
                'sliderw'           => $slide->getSlider()->getSizeW(),
                'sliderh'           => $slide->getSlider()->getSizeH()
            )
        );
    }
    
    /** Remove a page
     * @param int $slider_id Id of the layout that we want to remove
     */
    public function removeAction($slider_id, $slide_id)
    {
        $this->get('zing.component.slider.slide')->removeSlide($slide_id);
        $this->zingRedirect('/admincp/slider/view/'.$slider_id);
    }

    public function addAction($slider_id)
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $slider_id);

        $api_manager = $this->get('zing.core.api.api');
        $slider_manager = $this->get('zing.component.slider.slider');

        $api_manager = $this->get('zing.core.api.api');

        /** Create a user api key */
        $user_api_key = $api_manager->createUserApiKey();

        return $this->renderAdmin('ZingComponentSliderBundle:Default:slide_form.html.twig', array_merge(
            array(
                'user_key'          => $user_api_key,
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors,
                'user_key'         => $api_manager->createUserApiKey(),
                'sliderw'           => $slider_manager->getSlider($slider_id)->getSizeW(),
                'sliderh'           => $slider_manager->getSlider($slider_id)->getSizeH()
            ),
            $post_request
        ));

    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $page_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $slider_id, $slide_id = null)
    {

        $slider_manager = $this->get('zing.component.slider.slider');
        $slide_manager = $this->get('zing.component.slider.slide');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $slide_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                $slider = $slider_manager->getSlider($slider_id);


                $get_slider = $slide_manager->getSlide($slide_id);
                if($get_slider == null) {
                    $slide = $slide_manager->prepareSlide();
                } else {
                    $slide = $get_slider;
                }

                $slide->setSlider($slider);
                $slide->setName($post_request['zing_slide_name']);

                unset($post_request['image_info']);
                unset($post_request['zing_slide_name']);

                foreach($post_request as $type => $value) {
                    if($get_slider != null) {
                        $slide_content = $get_slider->getContentByType($type, false);
                        if($slide_content == null) {
                            $slide_content = new SlideContent();
                        }
                    } else {
                        $slide_content = new SlideContent();
                    }
                    $slide_content->setLang($type);
                    $slide_content->setContent(json_encode($value, JSON_UNESCAPED_UNICODE));
                    $slide_content->setDateModified(time());
                    $slide_content->setDateAdded(time());
                    $slide_content->setSlide($slide);
                    $slide->setContent($slide_content);
                }

                $slide->setStatus((int)$post_request['zing_slide_status']);
                $slider->setSlide($slide->setDateAdded(time()));

                if($get_slider != null){
                    $slide_manager->updateSlideObject($slide);
                } else {
                    $slider_manager->setSliderObject($slider);
                }

                $this->zingRedirect('/admincp/slider/view/'.$slider_id);
            }
        }
        return $errors;
    }

}