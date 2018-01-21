<?php

namespace Zing\Core\MenuBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zing\Component\MediaBundle\Exceptions\HBimagesException as HBimagesException;
use Zing\Core\CoreBundle\Controller\CoreController;

class MenuApiAdminController extends CoreController
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
        foreach($reorder as $order => $menu) {
            if(!isset($menu['id'])) {
                return false;
            }
            $id = (int)$menu['id'];

            $menu_manager = $this->get('zing.core.menu.menu');
            $menu_obj = $menu_manager->getMenu($id);

            if($menu == null) {
                return false;
            }

            $menu_obj->setOrder($order);
            if($parent != null) {
                $menu_obj->setParent($parent);
            } else {
                $menu_obj->setParent(null);
            }

            $menu_manager->updateMenuObject($menu_obj);

            if(isset($menu['children'])) {
                $this->_setOrder($menu['children'], $menu_obj);
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