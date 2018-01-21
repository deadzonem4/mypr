<?php
namespace Zing\Component\PollBundle\Controller\Manager;

use Zing\Component\PollBundle\Entity\QuestionsContent;
use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\PollBundle\Entity\Questions as Entity;

/** Poll question crud manager */
class PollQuestion extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Poll poll question entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentPollBundle:Questions';
    /** @var object $repository Poll question repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_poll_question_question' => array(
            'label'       => 'Question',
            'validation'  => 'а-яА-Яa-zA-Z0-9_,|`&\-\s\?',
            'not_blank'   => true
        ),
        'zing_poll_question_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        )
    );

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
//        $this->_map();
    }

    private function _map()
    {
        foreach($this->activeLanguages() as $lang) {
            $lang = $lang['language'];

            $this->mapper[$lang]['question'] = array(
                'label'       => 'Question '.strtoupper($lang),
                'validation'  => 'а-яА-Яa-zA-Z0-9_,|`&\-\s\?',
                'not_blank'   => true
            );
        }
    }

    /** Prepare the Poll question object
     * @param object $question_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareQuestion($request, $question_object = null) {

        /** Assign question object */
        $question = $this->entity;

        /** If we have choosen question object */
        if($question_object != null) {

            /** Assign the choosen question object */
            $question = $question_object;
        }

        /** Call question content manager */
        $question_content_manager    = $this->requestService('zing.component.poll.question_content');

        /** Try to select an question content */
        $question_static_content = $question_content_manager->getPollQuestionBy(array(
            'question'   => $question->getId(),
            'lang'      => 'static'
        ));

        /** If no question content is found assign a new question content object */
        if($question_static_content == null) {
            $question_static_content = new QuestionsContent();
            $question_static_content = $question_static_content->setDateAdded(time());
        }

        /** Set to question content object a lang */
        $question_static_content->setLang('static');

        /** Set to question content object a content */
        $question_static_content->setContent(json_encode($request['static'], JSON_UNESCAPED_UNICODE));
        $question->setContent($question_static_content->setQuestion($question)->setDateModified(time()));
        /** Assign the non lang question fields */
        $question
            ->setQuestion($request['zing_poll_question_question'])
            ->setStatus($request['zing_poll_question_status'])
            ->setDateModified(time());

        return $question;
    }

    /** Set a new Poll question
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setQuestion($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareQuestion($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created Poll question
     * @param array $request The form request
     * @param int $poll_question_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateQuestion($request, $poll_question_id)
    {
        $this->updateQuestionObject($this->prepareQuestion($request, $this->getQuestion($poll_question_id)));
        return $this;
    }

    /** Update an Poll poll_question object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateQuestionObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an poll question object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertQuestionObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an Poll poll question
     * @param $poll_question_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeQuestion($poll_question_id)
    {
        $poll_question = $this->getQuestion($poll_question_id);

        /** If no menu is found */
        if($poll_question == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($poll_question);
        $manager->flush();
        return $this;
    }

    public function removeQuestionObject($object)
    {
        /** If no Poll poll question is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an Poll poll question
     * @param int $poll_question_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getQuestion($poll_question_id, $array = false)
    {
        $poll_question_id = (int)$poll_question_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :poll_question_id')
                ->setParameter('poll_question_id', $poll_question_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $poll_question = $this->repository->findOneBy(array('id' => $poll_question_id));
        if ($poll_question) {

            /** Return last build in json format */
            return $poll_question;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllQuestions($by = array(), $order = array('id' => 'asc'))
    {
        $questions = $this->repository->findBy($by, $order);
        if ($questions) {
            /** Get found questions */
            return $questions;
        }
        return array();
    }
    public function getQuestionBy($by)
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
     * @return object Poll poll question
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Poll poll question
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