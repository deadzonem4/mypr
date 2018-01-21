<?php

namespace Zing\Core\UserBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class UserAdminController extends AdminController
{
    public function indexAction()
    {
        // $this->modifyLocale('en');
        // $this->debug($this->translate('Username'));
        // $this->debug($this->myLocale());

        $user_manager = $this->get('zing.core.user.user');

        return $this->renderAdmin('ZingCoreUserBundle:Default:index.html.twig', array(
            'users' => $user_manager->getAllUsers()
        ));
    }

    public function addAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingCoreUserBundle:Default:edit.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors
            ),
            $post_request
        ));
    }

    public function editAction($user_id = null)
    {
        if($user_id == null) {
           return $this->redirect('/admincp/users');
        }

        $user_manager = $this->get('zing.core.user.user');

        $user = $user_manager->getFosUser($user_id);

        $response = array(
            'zing_user_name' => $user->getUserName(),
            'zing_user_email' => $user->getEmail(),
            'zing_user_role' => $user->getRoles(),
            'zing_user_gravatar' => $user->getGravatar(),
            'zing_user_language' => $user->getLanguage(),
            'zing_user_theme' => $user->getTheme(),
        );

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $user_id);

        return $this->renderAdmin('ZingCoreUserBundle:Default:edit.html.twig', array_merge(
            array(
                'zing_form_action' => 'Edit',
                'zing_form_errors' => $errors
            ),
            $response
        ));
    }

    public function removeAction($user_id)
    {
        $user_manager = $this->get('zing.core.user.user');
        $user = $user_manager->getFosUserBy(array('id' => $user_id));

        if($user) {
            $user_manager->removeUserObject($user);
        }
        $this->zingRedirect('/admincp/users');exit;
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $page_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/layout
     */
    private function _handleRequest($post_request, $user_id = null)
    {
        $user_manager = $this->get('zing.core.user.user');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $user_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($user_id != null) {

                    if($user_manager->getFosUserBy(array('username' => $post_request['zing_user_name'])) != null) {
                        return array('username' => $this->translate('validation_username_exists', array($this->translate('Current username is already registered'))));
                    }

                    if($user_manager->getFosUserBy(array('email' => $post_request['zing_user_email'])) != null) {
                        return array('email' => $this->translate('validation_email_exists', array($this->translate('Current email is already registered'))));
                    }

                    /** Set the new layout */
                    $user_manager->updateUser($post_request, $user_id);
                } else {

                    if($user_manager->getFosUserBy(array('username' => $post_request['zing_user_name'])) != null) {
                        return array('username' => $this->translate('validation_username_exists', array($this->translate('Current username is already registered'))));
                    }

                    if($user_manager->getFosUserBy(array('email' => $post_request['zing_user_email'])) != null) {
                        return array('email' => $this->translate('validation_email_exists', array($this->translate('Current email is already registered'))));
                    }

                    /** Set the new layout */
                    $user_manager->setUser($post_request);
                }

                $this->zingRedirect('/admincp/users');
            }
        }
        return $errors;
    }
}
