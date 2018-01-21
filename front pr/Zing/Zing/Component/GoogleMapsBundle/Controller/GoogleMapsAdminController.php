<?php

namespace Zing\Component\GoogleMapsBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class GoogleMapsAdminController extends AdminController
{
    public function indexAction()
    {
        $google_maps_manager = $this->get('zing.component.googlemaps.googlemaps');

        return $this->renderAdmin('ZingComponentGoogleMapsBundle:Default:index.html.twig', array(
            'google_maps' => $google_maps_manager->getAllGoogleMaps()
        ));
    }

    public function addAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingComponentGoogleMapsBundle:Default:form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors
            ),
            $post_request
        ));

    }

    public function editAction($map_id)
    {
        $google_maps_manager = $this->get('zing.component.googlemaps.googlemaps');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $map_id);

        /** Get requested pages */
        $map = $google_maps_manager->getGoogleMap($map_id, true);

        if($map != null) {
            $response['zing_map_name'] = $map['name'];
            $response['zing_map_width'] = $map['width'];
            $response['zing_map_height'] = $map['height'];
            $response['zing_map_type'] = $map['map_type'];
            $response['zing_map_addresses'] = json_decode($map['addresses'], true);
            $response['zing_map_default_zoom'] = $map['default_zoom'];
            $response['zing_map_max_zoom'] = $map['max_zoom'];
            $response['zing_map_min_zoom'] = $map['min_zoom'];
            $response['zing_map_status'] = $map['status'];
        }

        return $this->renderAdmin('ZingComponentGoogleMapsBundle:Default:form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Edit',
                'zing_form_errors' => $errors
            ),
            $response
        ));
    }

    public function removeAction($map_id)
    {
        $this->get('zing.component.googlemaps.googlemaps')->removeGoogleMap($map_id);
        $this->zingRedirect('/admincp/googlemaps');
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $page_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $page_id = null)
    {
        $google_maps_manager = $this->get('zing.component.googlemaps.googlemaps');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $google_maps_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                /** Get cords for each selected address */
                foreach($post_request['zing_map_addresses'] as $k => $address) {
                    $post_request['zing_map_addresses'][$k] =
                        array(
                            'address' => $address,
                            'cords'   => $google_maps_manager->getAddressCords($address)
                        );
                }

                $post_request['zing_map_addresses'] = json_encode($post_request['zing_map_addresses']);

                if($page_id != null) {
                    /** Set the new layout */
                    $google_maps_manager->updateGoogleMaps($post_request, $page_id);
                } else {
                    /** Set the new layout */
                    $google_maps_manager->setGoogleMaps($post_request);
                }

                $this->zingRedirect('/admincp/googlemaps');
            }
        }
        return $errors;
    }
}
