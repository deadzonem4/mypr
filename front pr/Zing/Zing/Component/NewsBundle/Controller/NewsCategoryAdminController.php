<?php
namespace Zing\Component\NewsBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Zing\Core\AdminBundle\Controller\AdminController;

class NewsCategoryAdminController extends AdminController
{
    public function indexAction()
    {
        $category_manager = $this->requestService('zing.component.news.category');
        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentNewsBundle:Default:category/index.html.twig', array(
            'categories'        => $category_manager->getAllCategories(),
            'user_key'          => $api_manager->createUserApiKey()
        ));
    }

    public function editAction($category_id)
    {
        $category_manager = $this->requestService('zing.component.news.category');

        $category = $category_manager->getCategory($category_id);

        if($category == null) {
            throw new Exception('Requested category dose not exists');
        }

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $category_id);

        $post_request = array(
            'zing_category_display_name' => $category->getName(),
            'zing_category_status'       => $category->getStatus(),
            'category'                   => $category
        );

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentNewsBundle:Default:category/form.html.twig', array_merge(array(
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

        return $this->renderAdmin('ZingComponentNewsBundle:Default:category/form.html.twig', array_merge(array_merge(array(
                'zing_form_action'  => 'create',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),
            array('post_request' => $post_request)
        ), $post_request));
    }

    public function reorderAction()
    {
        $category_manager = $this->requestService('zing.component.news.category');
        $api_manager = $this->get('zing.core.api.api');

        /** Create a user api key */
        $user_api_key = $api_manager->createUserApiKey();

        return $this->renderAdmin('ZingComponentNewsBundle:Default/category:category_reorder.html.twig', array(
            'categories'    => $category_manager->getAllCategories(array(), array('category_order' => 'asc')),
            'user_key'      => $user_api_key
        ));
    }

    /** Remove a category
     * @param int $category_id Id of the layout that we want to remove
     */
    public function removeAction($category_id)
    {
        $this->requestService('zing.component.news.category')->removeCategory($category_id);
        $this->zingRedirect('/admincp/news/category');
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $category_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/store/category
     */
    private function _handleRequest($post_request, $category_id = null)
    {

        $category_manager = $this->requestService('zing.component.news.category');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $category_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($category_id != null){
                    $category_manager->updateCategory($post_request, $category_id);
                } else {
                    //$this->dump($post_request);exit;
                    $category_manager->setCategory($post_request);
                }

                $this->zingRedirect('/admincp/news/category');
            }
        }
        return $errors;
    }
}
