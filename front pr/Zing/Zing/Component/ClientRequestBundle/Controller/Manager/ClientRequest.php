<?php
namespace Zing\Component\ClientRequestBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\ClientRequestBundle\Entity\ClientRequest as Entity;

/** ClientRequest crud manager */
class ClientRequest extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentClientRequestBundle:ClientRequest';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $client_requestper Map form fields for validation */
    protected $mapper = array(
        'zing_client_request_title_name' => array(
            'label'       => 'Title Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
        'zing_client_request_first_name' => array(
            'label'       => 'first name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
        'zing_client_request_last_name' => array(
            'label'       => 'last name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
        'zing_client_request_city' => array(
            'label'       => 'city',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
        'zing_client_request_phone' => array(
            'label'       => 'phone',
            'validation'  => 'a-zA-Z0-9+',
            'not_blank'   => true
        )
        // 'zing_client_request_subscribe' => array(
        //     'label'       => 'Subscribe',
        //     'validation'  => '0-9',
        //     'not_blank'   => false
        // )
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

    /** Prepare the client_request object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareClientRequest($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        $zing_client_request_subscribe_value = 1;
        if(!isset($request['zing_client_request_subscribe'])) {
            $zing_client_request_subscribe_value = 0;
        }
        
        return $prepare ->setTitleName($request['zing_client_request_title_name'])
                        ->setFirstName($request['zing_client_request_first_name'])
                        ->setLastName($request['zing_client_request_last_name'])
                        ->setCity($request['zing_client_request_city'])
                        ->setPhone($request['zing_client_request_phone'])
                        ->setEmail($request['zing_client_request_email'])
                        ->setSubscribe($zing_client_request_subscribe_value)
                        ->setAffiliate($this->getFromCookie())
                        ->setStatus(0)
                        ->setDateModified(time());
    }

    public function save($request)
    {
        $error = $this->validateRequest($request);

        /** User email match */
        if(!preg_match('/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/', $request['zing_client_request_email'])) {
            $error['zing_client_request_email'] = $this->translate('validation_incorrect_field', array($this->translate('email')));
        }

        if(count($error) > 0) {
            return $error;
        }

        $this->setClientRequest($request);
        return array();
    }

    /** Set a new client_request
     * @param array $request The form request for client_request
     * @return object ClientRequest
     */
    public function setClientRequest($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareClientRequest($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created client_request
     * @param array $request The form request
     * @param int $client_request_id The id of the client_request that we want to update
     * @return object ClientRequest
     */
    public function updateClientRequest($request, $client_request_id)
    {
        $this->updateClientRequestObject($this->prepareClientRequest($request, $this->getGoogleMap($client_request_id)));
        return $this;
    }

    /** Update an client_request object directly
     * @param $object Custom modified object
     * @return object ClientRequest
     */
    public function updateClientRequestObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an client_request object directly
     * @param $object Custom modified object
     * @return object ClientRequest
     */
    public function setClientRequestObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    public function removeClientRequestObject($object) {
        /** If no client_request is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an client_request
     * @param int $client_request_id The id of the client_request that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested client_request else null if is not found
     */
    public function getClientRequest($client_request_id, $array = false)
    {
        $client_request_id = (int)$client_request_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :client_request_id')
                ->setParameter('client_request_id', $client_request_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $client_request = $this->repository->findOneBy(array('id' => $client_request_id));
        if ($client_request) {
            /** Return last build in json format */
            return $client_request;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllClientRequest()
    {
        $client_request = $this->repository->findBy(array(), array('id' => 'desc')); /* MODIFICATION: 'asc' => 'desc' */
        if ($client_request) {
            /** Return last build in json format */
            return $client_request;
        }

        return array();
    }

    public function getClientRequestBy($by, $order = array('id' => 'desc'), $limit=null)
    {
        if($limit != null) {
            $client_request = $this->repository->findBy($by, $order, $limit);
        } else {
            $client_request = $this->repository->findBy($by, $order);
        }
        
        if ($client_request) {
            return $client_request;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object ClientRequest
     */
    public function updateObjectFromTable($object) {
        return $this->updateClientRequestObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object ClientRequest
     */
    public function removeObjectFromTable($object) {
        return $this->removeClientRequestObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getClientRequest($object_id);
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