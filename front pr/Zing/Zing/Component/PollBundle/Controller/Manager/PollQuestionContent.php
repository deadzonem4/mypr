<?php
namespace Zing\Component\PollBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\PollBundle\Entity\QuestionsContent as Entity;

/** Poll Question crud manager */
class PollQuestionContent extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Questions entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentPollBundle:QuestionsContent';
    /** @var object $repository PollQuestion content repository */
    private $repository;

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

    /** Prepare the PollQuestion content object
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function preparePollQuestionContent($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());
    }

    /** Set a new PollQuestion content
     * @param array $request The form request for question
     * @return object PollQuestion
     */
    public function setPollQuestionContent($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->preparePollQuestionContent($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update an already created PollQuestion content
     * @param array $request The form request
     * @param int $question_id The id of the question that we want to update
     * @return object PollQuestion
     */
    public function updatePollQuestionContent($request, $question_id)
    {
        $this->updatePollQuestionObject($this->preparePollQuestionContent($request, $this->getQuestion($question_id)));
        return $this;
    }

    /** Update an PollQuestion object directly
     * @param $object Custom modified object
     * @return object PollQuestion
     */
    public function updatePollQuestionContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an PollQuestion object directly
     * @param $object Custom modified object
     * @return object PollQuestion
     */
    public function insertPollQuestionContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an PollQuestion
     * @param $question_id The id of the question that we want to remove
     * @return object PollQuestion
     */
    public function removePollQuestionContent($question_id)
    {
        $question = $this->getPollQuestionContent($question_id);

        /** If no question is found */
        if($question == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($question);
        $manager->flush();
        return $this;
    }

    public function removePollQuestionContentObject($object)
    {
        /** If no PollQuestion is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an PollQuestion
     * @param int $question_id The id of the question that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested question else null if is not found
     */
    public function getPollQuestionContent($question_id, $array = false)
    {
        $question_id = (int)$question_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :question_id')
                ->setParameter('question_id', $question_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $question = $this->repository->findOneBy(array('id' => $question_id));
        if ($question) {
            /** Return last build in json format */
            return $question;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllPollQuestionContents($by = array(), $order = array('id' => 'asc'))
    {

        $questions = $this->repository->findBy($by, $order);
        if ($questions) {
            /** Return last build in json format */
            return $questions;
        }

        return array();
    }

    public function getPollQuestionBy($by)
    {
        $question = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($question) {
            return $question;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object PollQuestion
     */
    public function updateObjectFromTable($object) {
        return $this->updatePollQuestionObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object PollQuestion
     */
    public function removeObjectFromTable($object) {
        return $this->removePollQuestionObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getQuestion($object_id);
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