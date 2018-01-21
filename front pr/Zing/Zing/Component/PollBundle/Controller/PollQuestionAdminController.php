<?php

namespace Zing\Component\PollBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Zing\Core\AdminBundle\Controller\AdminController;

class PollQuestionAdminController extends AdminController
{
    public function indexAction()
    {
        $poll_question_manager = $this->requestService('zing.component.poll.question');

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentPollBundle:Default:question/index.html.twig', array(
            'poll_questions'        => $poll_question_manager->getAllQuestions(),
            'user_key'          => $api_manager->createUserApiKey()
        ));
    }

    public function editAction($poll_question_id)
    {
        $poll_question_manager = $this->requestService('zing.component.poll.question');

        $poll_question = $poll_question_manager->getQuestion($poll_question_id);

        if($poll_question == null) {
            throw new Exception('Requested question does not exist');
        }

        $api_manager = $this->get('zing.core.api.api');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $poll_question_id);

        $post_request = array(
            'zing_poll_question_question' => $poll_question->getQuestion(),
            'zing_poll_question_status'       => $poll_question->getStatus(),
            'poll_question'                   => $poll_question
        );

        return $this->renderAdmin('ZingComponentPollBundle:Default:question/form.html.twig', array_merge(array(
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

        return $this->renderAdmin('ZingComponentPollBundle:Default:question/form.html.twig', array_merge(array_merge(array(
            'zing_form_action'  => 'create',
            'zing_form_errors'  => $errors,
            'user_key'          => $api_manager->createUserApiKey()
        ),
            array('post_request' => $post_request)
        ), $post_request));
    }

    /** Remove a question
     * @param int $poll_question_id Id of the layout that we want to remove
     */
    public function removeAction($poll_question_id)
    {
        $this->requestService('zing.component.poll.question')->removeQuestion($poll_question_id);
        $this->zingRedirect('/admincp/poll/question');
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $poll_question_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/store/question
     */
    private function _handleRequest($post_request, $poll_question_id = null)
    {

        $poll_question_manager = $this->requestService('zing.component.poll.question');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $poll_question_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($poll_question_id != null){
                    $poll_question_manager->updateQuestion($post_request, $poll_question_id);
                } else {
                    //$this->dump($post_request);exit;
                    $poll_question_manager->setQuestion($post_request);
                }

                $this->zingRedirect('/admincp/poll/question');
            }
        }
        return $errors;
    }
}
