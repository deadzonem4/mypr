<?php
namespace Zing\Component\PollBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\PollBundle\Entity\VotedQuestions as Entity;

/** Poll VotedQuestion crud manager */
class PollVotedQuestion extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Poll poll voted question entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentPollBundle:VotedQuestions';
    /** @var object $repository Poll voted question repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array();

    /**
     * @param object $doctrine. Doctrine object
     * @param object $service_container. Service container
     */
    public function __construct($doctrine, $service_container)
    {
        $this->doctrine = $doctrine;
        $this->entity = $this->_entity();
        $this->repository = $this->_repository();
        $this->container = $service_container;
    }

    /** Prepare the Poll VotedQuestion object
     * @param object $voted_question_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareVotedQuestion($request, $voted_question_object = null) {

        /** Assign voted_question object */
        $voted_question = $this->_entity();

        /** If we have choosen voted_question object */
        if($voted_question_object != null) {

            /** Assign the choosen voted_question object */
            $voted_question = $voted_question_object;
        }

        /** Assign the non lang voted_question fields */
        $voted_question
            ->setQuestion($request['zing_poll_question'])
            ->setPoll($request['zing_poll'])
            ->setAnswer($request['zing_poll_answer'] == 'yes' ? 1 : 0)
            ->setStatus(1)
            ->setDateModified(time());

        return $voted_question;
    }

    public function save($request)
    {
        $error = $this->validateRequest($request);

        if(count($error) > 0) {
            return $error;
        }

        $this->setVotedQuestion($request);
        return array();
    }

    /** Set a new Poll voted_question
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setVotedQuestion($request)
    {
        $manager = $this->_doctrineManager();
        $voted_question = $this->prepareVotedQuestion($request)->setDateAdded(time());
        $manager->persist($voted_question);
        $manager->flush();
        return $voted_question;
    }

    /** Update a already created Poll VotedQuestion
     * @param array $request The form request
     * @param int $poll_voted_question_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateVotedQuestion($request, $poll_voted_question_id)
    {
        $this->updateVotedQuestionObject($this->prepareVotedQuestion($request, $this->getVotedQuestion($poll_voted_question_id)));
        return $this;
    }

    /** Update an Poll poll_voted_question object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateVotedQuestionObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an poll voted question object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertVotedQuestionObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an Poll poll voted question
     * @param $poll_voted_question_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeVotedQuestion($poll_voted_question_id)
    {
        $poll_voted_question = $this->getQuestion($poll_voted_question_id);

        /** If no menu is found */
        if($poll_voted_question == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($poll_voted_question);
        $manager->flush();
        return $this;
    }

    public function removeVotedQuestionObject($object)
    {
        /** If no Poll poll voted question is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an Poll poll voted question
     * @param int $poll_voted_question_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getVotedQuestion($poll_voted_question_id, $array = false)
    {
        $poll_voted_question_id = (int)$poll_voted_question_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :poll_voted_question_id')
                ->setParameter('poll_voted_question_id', $poll_voted_question_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $poll_voted_question = $this->repository->findOneBy(array('id' => $poll_voted_question_id));
        if ($poll_voted_question) {

            /** Return last build in json format */
            return $poll_voted_question;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllVotedQuestions($by = array(), $order = array('id' => 'asc'))
    {
        $questions = $this->repository->findBy($by, $order);
        if ($questions) {
            /** Get found questions */
            return $questions;
        }
        return array();
    }
    public function getVotedQuestionBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }
        return null;
    }

    public function getMenuBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Poll poll voted Question
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Poll poll voted Question
     */
    public function removeObjectFromTable($object) {
        return $this->removeMenuObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getMenu($object_id);
    }

    /** Call current manager entity.
     * @return object. Doctrine entity.
     */
    private function _entity()
    {
        return new Entity();
    }

    /** Get repository of setting manager.
     * @return object. Doctrine entity repository.
     */
    private function _repository()
    {
        return $this->doctrine->getRepository($this->repository_name);
    }

    /** Get doctrine manager,
     * @return object. Doctrine entity manager
     */
    private function _doctrineManager()
    {
        return $this->doctrine->getManager();
    }

}