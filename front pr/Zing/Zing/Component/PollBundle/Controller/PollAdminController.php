<?php

namespace Zing\Component\PollBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class PollAdminController extends AdminController
{
    public function indexAction()
    {

        $poll_manager = $this->get('zing.component.poll.poll');

        return $this->renderAdmin('ZingComponentPollBundle:Default:index.html.twig', array(
                'polls'  => $poll_manager->getAllPoll()
        ));
    }

    public function viewAction($poll_id)
    {
        $poll = $this->requestService('zing.component.poll.poll')->getPoll($poll_id);
        if(!$poll) {
            throw new Exception('Requested poll does not exist');
        }
        $this->_handleRequest($poll);
        return $this->renderAdmin('ZingComponentPollBundle:Default:view.html.twig', array(
                'poll' => $poll
            )
        );
    }

    public function removeAction($poll_id)
    {
        $poll = $this->requestService('zing.component.poll.poll')->getPoll($poll_id);
        if(!$poll) {
            throw new Exception('Requested poll does not exist');
        }
        $this->requestService('zing.component.poll.poll')->removePollObject($poll);
        $this->zingRedirect('/admincp/poll');exit;
    }

    private function _handleRequest($poll)
    {
        $request = $this->postZingRequest();

        if(isset($request['readed'])) {
            $poll_manager = $this->requestService('zing.component.poll.poll');
            $poll_manager->updatePollObject($poll->setStatus(1));
            $this->zingRedirect('/admincp/poll');
        }

        return true;
    }

}
