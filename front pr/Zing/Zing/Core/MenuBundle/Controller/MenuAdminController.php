<?php

namespace Zing\Core\MenuBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;


class MenuAdminController extends AdminController
{

    public function indexMenuAction($category_id)
    {
        $menu_manager = $this->get('zing.core.menu.menu');

        /** Use the table action */
        $menu_manager->multiplyTableAction((array) $this->postZingRequest());

        return $this->renderAdmin('ZingCoreMenuBundle:Default:index_menu.html.twig',
            array('menus'  => $menu_manager->getAllMenus(array('category' => $category_id)),
                  'category_id' => $category_id
            )
        );
    }

    public function editAction($category_id, $menu_id)
    {
        $menu_manager = $this->get('zing.core.menu.menu');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $category_id, $menu_id);

        /** Get requested pages */
        $menu = $menu_manager->getMenu($menu_id, true);

        if($menu != null) {
            $response['zing_menu_name']         = $menu['name'];
            $response['zing_menu_url']          = $menu['url'];
            $response['zing_menu_status']       = $menu['status'];
            $response['zing_menu_category_id']  = $category_id;
        }

        $page_manager = $this->get('zing.core.page.page');

        return $this->renderAdmin('ZingCoreMenuBundle:Default:menu_form.html.twig', array_merge(
            array(
                'pages'             => $page_manager->getAllPages(),
                'zing_form_action' => 'Edit',
                'zing_form_errors' => $errors
            ),
            $response
        ));
    }

    /** Remove a page
     * @param int $menu_id Id of the layout that we want to remove
     */
    public function removeAction($category_id, $menu_id)
    {
        $this->get('zing.core.menu.menu')->removeMenu($menu_id);
        $this->zingRedirect('/admincp/menus/menu/'.$category_id);
    }

    public function reorderAction($category_id)
    {
        $menu_manager = $this->get('zing.core.menu.menu');
        $api_manager = $this->get('zing.core.api.api');

        /** Create a user api key */
        $user_api_key = $api_manager->createUserApiKey();

        return $this->renderAdmin('ZingCoreMenuBundle:Default:menu_reorder.html.twig', array(
            'menus'             => $menu_manager->getAllMenus(array('category' => $category_id), array('menu_order' => 'asc')),
            'user_key'          => $user_api_key,
            'category_id'       => $category_id
       ));
    }

    public function menuAction($category_id)
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $category_id);

        $page_manager = $this->get('zing.core.page.page');

        return $this->renderAdmin('ZingCoreMenuBundle:Default:menu_form.html.twig', array_merge(
            array(
                'pages'             => $page_manager->getAllPages(),
                'zing_form_action'  => 'Create',
                'zing_form_errors'  => $errors
            ),
            $post_request
        ));

    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $page_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $category_id, $page_id = null)
    {
        $page_manager = $this->get('zing.core.menu.menu');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {

            if(isset($post_request['zing_menu_page'])) {
                if($post_request['zing_menu_page'] != '0') {
                    $post_request['zing_menu_url'] = $post_request['zing_menu_page'];
                }
            }

            $this->dump($post_request);

            $errors = $page_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                $category_manager = $this->get('zing.core.menu.category');
                $category = $category_manager->getCategory($category_id);

                if($page_id != null) {
                    /** Set the new layout */
                    $page_manager->updateMenu(array_merge($post_request, array('zing_menu_category' => $category)), $page_id);
                } else {
                    /** Set the new layout */
                    $page_manager->setMenu(array_merge($post_request, array('zing_menu_category' => $category)));
                }

                $this->zingRedirect('/admincp/menus/menu/'.$category_id);
            }
        }
        return $errors;
    }

}