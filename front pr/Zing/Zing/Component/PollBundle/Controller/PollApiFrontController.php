<?php

namespace Zing\Component\PollBundle\Controller;

use Zing\Core\CoreBundle\Controller\CoreController;

class PollApiFrontController extends CoreController
{
    public function answerAction()
    {
        $request = $this->container->get('request')->request->all();

        $api_manager = $this->get('zing.core.api.api');

        $poll_manager = $this->requestService('zing.component.poll.poll');
        $poll_question_manager = $this->requestService('zing.component.poll.question');
        $poll_voted_question_manager = $this->requestService('zing.component.poll.voted_question');

        $errors = $poll_manager->validateRequest($request);

        /** If no errors are caught  */
        if(!count($errors) > 0) {
            $poll = $poll_manager->setPoll($request);

            $doctrineManager = $this->container->get('doctrine')->getManager();

            /** Loop in the answered questions */
            foreach($request['zing_poll_questions'] as $answer) {

                $poll_voted_question_request = array();

                $question = $poll_question_manager->getQuestion($answer['id']);

                $poll_voted_question_request['zing_poll_question'] = $question;
                $poll_voted_question_request['zing_poll'] = $poll;
                $poll_voted_question_request['zing_poll_answer'] = $answer['answer'];

                $voted_question = $poll_voted_question_manager->prepareVotedQuestion($poll_voted_question_request)->setDateAdded(time());
                $poll->setVotedQuestion($voted_question);
            }

            $doctrineManager->flush();
        }
        else $api_manager->apiResponse(array('error' => $errors));

        $api_manager->apiResponse(array('success' => true,'positive_answers'=>$poll->getPositiveAnswers()));
    }
}