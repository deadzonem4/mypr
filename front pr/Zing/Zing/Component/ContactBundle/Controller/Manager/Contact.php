<?php
namespace Zing\Component\ContactBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\ContactBundle\Entity\Contact as Entity;

/** Contact crud manager */
class Contact extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentContactBundle:Contact';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $contactper Map form fields for validation */
    protected $mapper = array(
        'zing_contact_name' => array(
            'label'       => 'name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
//        'zing_contact_email' => array(
//            'label'       => 'Email',
//            'validation'  => 'а-яА-Яa-zA-Z0-9_\s@.\-',
//            'not_blank'   => true
//        ),
        'zing_contact_subject' => array(
            'label'       => 'subject',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s.\-',
            'not_blank'   => true
        ),
        'zing_contact_phone' => array(
            'label'       => 'phone',
            'validation'  => 'a-zA-Z0-9+',
            'not_blank'   => true
        )
//        'zing_contact_message' => array(
//            'label'       => 'Subject',
//            'validation'  => 'а-яА-Яa-zA-Z0-9_\s!@#$\^&*\(\)\n',
//            'not_blank'   => true
//        )
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

    /** Prepare the contact object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareContact($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare ->setEmail($request['zing_contact_email'])
                        ->setName($request['zing_contact_name'])
                        ->setSubject($request['zing_contact_subject'])
                        ->setMessage($request['zing_contact_message'])
                        ->setPhone($request['zing_contact_phone'])
                        ->setAffiliate($this->getFromCookie())
                        ->setStatus(0)
                        ->setDateModified(time());
    }

    public function save($request)
    {
        $error = $this->validateRequest($request);

       /** User email match */
        if(!preg_match('/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/', $request['zing_contact_email'])) {
            $error['zing_contact_email'] = $this->translate('validation_incorrect_field', array($this->translate('email')));
        }

        if(count($error) > 0) {
            return $error;
        }

        $this->setContact($request);
        return array();
    }

    /** Set a new contact
     * @param array $request The form request for contact
     * @return object Contact
     */
    public function setContact($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareContact($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created contact
     * @param array $request The form request
     * @param int $contact_id The id of the contact that we want to update
     * @return object Contact
     */
    public function updateContact($request, $contact_id)
    {
        $this->updateContactObject($this->prepareContact($request, $this->getGoogleMap($contact_id)));
        return $this;
    }

    /** Update an contact object directly
     * @param $object Custom modified object
     * @return object Contact
     */
    public function updateContactObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an contact object directly
     * @param $object Custom modified object
     * @return object Contact
     */
    public function setContactObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an contact
     * @param $contact_id The id of the contact that we want to remove
     * @return object Contact
     */
    public function removeGoogleMap($contact_id)
    {
        $contact = $this->getGoogleMap($contact_id);

        /** If no contact is found */
        if($contact == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($contact);
        $manager->flush();
        return $this;
    }

    public function removeContactObject($object) {
        /** If no contact is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an contact
     * @param int $contact_id The id of the contact that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested contact else null if is not found
     */
    public function getContact($contact_id, $array = false)
    {
        $contact_id = (int)$contact_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :contact_id')
                ->setParameter('contact_id', $contact_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $contact = $this->repository->findOneBy(array('id' => $contact_id));
        if ($contact) {
            /** Return last build in json format */
            return $contact;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllContact()
    {
        $contact = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($contact) {
            /** Return last build in json format */
            return $contact;
        }

        return array();
    }

    public function getContactBy($by, $order = array('id' => 'desc'), $limit=null)
    {
        if($limit != null) {
            $contact = $this->repository->findBy($by, $order, $limit);
        } else {
            $contact = $this->repository->findBy($by, $order);
        }
        
        if ($contact) {
            return $contact;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Contact
     */
    public function updateObjectFromTable($object) {
        return $this->updateContactObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Contact
     */
    public function removeObjectFromTable($object) {
        return $this->removeContactObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getContact($object_id);
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