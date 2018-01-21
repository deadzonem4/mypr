<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\ManufactureContent as Entity;

/** SimpleStore manufacture crud manager */
class ManufactureContent extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity SimpleStore manufacture entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSimpleStoreBundle:ManufactureContent';
    /** @var object $repository SimpleStore manufacture content repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */
//    protected $mapper = array(
//        'zing_menu_name' => array(
//            'label'       => 'Name',
//            'validation'  => 'a-zA-Z0-9_\s',
//            'not_blank'   => true
//        ),
//        'zing_menu_url' => array(
//            'label'       => 'Url',
//            'validation'  => 'a-zA-Z0-9\/\-_',
//            'not_blank'   => true
//        ),
//        'zing_menu_status' => array(
//            'label'       => 'Status',
//            'validation'  => '0-9',
//            'not_blank'   => false
//        )
//    );

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
        //$this->_map();
    }

    /** Prepare the SimpleStore manufacture content object
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareManufactureContent($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());
    }

    /** Set a new SimpleStore manufacture content
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setManufactureContent($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareManufactureContent($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created SimpleStore manufacture content
     * @param array $request The form request
     * @param int $manufacture_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateManufactureContent($request, $manufacture_id)
    {
        $this->updateMenuObject($this->prepareManufactureContent($request, $this->getMenu($manufacture_id)));
        return $this;
    }

    /** Update an SimpleStore manufacture object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateManufactureContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an manufacture object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertManufactureContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an SimpleStore manufacture
     * @param $manufacture_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeManufactureContent($manufacture_id)
    {
        $manufacture = $this->getManufactureContent($manufacture_id);

        /** If no menu is found */
        if($manufacture == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($manufacture);
        $manager->flush();
        return $this;
    }

    public function removeManufactureContentObject($object)
    {
        /** If no SimpleStore manufacture is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an SimpleStore manufacture
     * @param int $manufacture_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getManufactureContent($manufacture_id, $array = false)
    {
        $manufacture_id = (int)$manufacture_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :manufacture_id')
                ->setParameter('manufacture_id', $manufacture_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $manufacture = $this->repository->findOneBy(array('id' => $manufacture_id));
        if ($manufacture) {
            /** Return last build in json format */
            return $manufacture;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllCategories($by = array(), $order = array('id' => 'asc'))
    {

        $menus = $this->repository->findBy($by, $order);
        if ($menus) {
            /** Return last build in json format */
            return $menus;
        }

        return array();
    }

    public function getManufactureBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object SimpleStore manufacture
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object SimpleStore manufacture
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