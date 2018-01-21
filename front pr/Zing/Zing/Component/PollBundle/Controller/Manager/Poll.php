<?php
namespace Zing\Component\PollBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\PollBundle\Entity\Poll as Entity;

/** Poll crud manager */
class Poll extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentPollBundle:Poll';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $poll per Map form fields for validation */
    protected $mapper = array(
        'zing_poll_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
        'zing_poll_email' => array(
            'label'       => 'Email',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s@.\-',
            'not_blank'   => true
        ),
        'zing_poll_birth_year' => array(
            'label'       => 'Birth year',
            'validation'  => '0-9\s.\-',
            'not_blank'   => true
        ),
        'zing_poll_city' => array(
            'label'       => 'City',
            'validation'  => 'а-яА-Яa-zA-Z\s.\-',
            'not_blank'   => true
        ),
        'zing_poll_phone' => array(
            'label'       => 'Phone',
            'validation'  => 'a-zA-Z0-9+',
            'not_blank'   => true
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
    }

    /** Prepare the poll object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function preparePoll($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare ->setEmail($request['zing_poll_email'])
                        ->setName($request['zing_poll_name'])
                        ->setCity($request['zing_poll_city'])
                        ->setBirthYear($request['zing_poll_birth_year'])
                        ->setPhone($request['zing_poll_phone'])
                        ->setPositiveAnswers($request['zing_poll_positive_answers'])
                        ->setWebsite($request['zing_poll_website'])
                        ->setStatus(1)
                        ->setDateModified(time());
    }

    public function save($request)
    {
        $error = $this->validateRequest($request);

       /** User email match */
        if(!preg_match('/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/', $request['zing_poll_email'])) {
            $error['zing_poll_email'] = $this->translate('validation_incorrect_field', array($this->translate('email')));
        }

        if(count($error) > 0) {
            return $error;
        }

        $this->setPoll($request);
        return array();
    }

    /** Set a new poll
     * @param array $request The form request for poll
     * @return object Poll
     */
    public function setPoll($request)
    {
        $manager = $this->_doctrineManager();
        $poll = $this->preparePoll($request)->setDateAdded(time());
        $manager->persist($poll);
        $manager->flush();
        return $poll;
    }

    /** Update a already created poll
     * @param array $request The form request
     * @param int $poll_id The id of the poll that we want to update
     * @return object Poll
     */
    public function updatePoll($request, $poll_id)
    {
        $this->updatePollObject($this->preparePoll($request, $this->getPoll($poll_id)));
        return $this;
    }

    /** Update an poll object directly
     * @param $object Custom modified object
     * @return object Poll
     */
    public function updatePollObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an poll object directly
     * @param $object Custom modified object
     * @return object Poll
     */
    public function setPollObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an poll
     * @param $poll_id The id of the poll that we want to remove
     * @return object Poll
     */
    public function removeGoogleMap($poll_id)
    {
        $poll = $this->getGoogleMap($poll_id);

        /** If no poll is found */
        if($poll == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($poll);
        $manager->flush();
        return $this;
    }

    public function removePollObject($object) {
        /** If no poll is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an poll
     * @param int $poll_id The id of the poll that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested poll else null if is not found
     */
    public function getPoll($poll_id, $array = false)
    {
        $poll_id = (int)$poll_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :poll_id')
                ->setParameter('poll_id', $poll_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $poll = $this->repository->findOneBy(array('id' => $poll_id));
        if ($poll) {
            /** Return last build in json format */
            return $poll;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllPoll()
    {
        $poll = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($poll) {
            /** Return last build in json format */
            return $poll;
        }

        return array();
    }

    public function getPollBy($by, $order = array('id' => 'desc'), $limit=null)
    {
        if($limit != null) {
            $poll = $this->repository->findBy($by, $order, $limit);
        } else {
            $poll = $this->repository->findBy($by, $order);
        }
        
        if ($poll) {
            return $poll;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Poll
     */
    public function updateObjectFromTable($object) {
        return $this->updatePollObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Poll
     */
    public function removeObjectFromTable($object) {
        return $this->removePollObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getPoll($object_id);
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