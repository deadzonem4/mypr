<?php

namespace Zing\Component\NewsBundle\Controller;

use Zing\Core\CoreBundle\Controller\CoreController;

class NewsCategoryApiAdminController extends CoreController
{
    public function reorderAction()
    {
        //$this->dump($this->container->get('request')->request->all());exit;
        $request = $this->getPostRequest();
        $api_manager = $this->_initilizeApi($request);

        /** Api logic method */
        $this->_setOrder($request->get('reorder'));
        /** End of api logic method */

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $api_manager->apiResponse(array('user_key' => $user_api_key));
    }

    private function _setOrder($reorder, $parent = null)
    {
        foreach($reorder as $order => $category) {
            if(!isset($category['id'])) {
                return false;
            }
            $id = (int)$category['id'];

            $category_manager = $this->requestService('zing.component.news.category');
            $category_obj = $category_manager->getCategory($id);

            if($category == null) {
                return false;
            }

            $category_obj->setCategoryOrder($order);
            if($parent != null) {
                $category_obj->setParent($parent);
            } else {
                $category_obj->setParent(null);
            }

            $category_manager->updateCategoryObject($category_obj);

            if(isset($category['children'])) {
                $this->_setOrder($category['children'], $category_obj);
            }

        }

    }

    /** Initilize the api manager
     * @param object Post request in object format
     * @return object Api manager
     */
    private function _initilizeApi($request)
    {

        //$this->dump($this->container->get('request')->request->all());exit;

        /** Get api manager */
        $api_manager = $this->get('zing.core.api.api');

        /** If an user key is not send */
        if(!$request->get('user_key')) {
            $api_manager->apiResponse(array('error' => 'You have no access to this content'));
        }

        /** Get user key */
        $user_api_key = $request->get('user_key');

        /** Return false if key is not correct else return the user object from fos manager */
        $user = $api_manager->authUserByApiKey($user_api_key);

        /** Check if user has access by roles to this content */
        if(!$api_manager->hasUserPermission($user, array('ROLE_ADMIN', 'ROLE_SUPER_ADMIN'))) {
            $api_manager->apiResponse(array('error' => 'You have no access to this content'));
        }

        $api_manager->setUserRuntimeKey($user_api_key);
        $api_manager->setUserRuntimeObject($user);

        return $api_manager;
    }

}