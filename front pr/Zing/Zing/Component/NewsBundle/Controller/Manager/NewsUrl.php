<?php
namespace Zing\Component\NewsBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\NewsBundle\Entity\NewsUrl as Entity;

/** News product crud manager */
class NewsUrl extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity News product entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentNewsBundle:NewsUrl';
    /** @var object $repository News product url repository */
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

    /** Prepare the News product url object
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareNewsUrl($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());
    }

    /** Set a new News product url
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setNewsUrl($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareNewsUrl($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created News product url
     * @param array $request The form request
     * @param int $product_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateNewsUrl($request, $product_id)
    {
        $this->updateMenuObject($this->prepareNewsUrl($request, $this->getMenu($product_id)));
        return $this;
    }

    /** Update an News product object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateNewsUrlObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an product object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertNewsUrlObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an News product
     * @param $product_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeNewsUrl($product_id)
    {
        $product = $this->getNewsUrl($product_id);

        /** If no menu is found */
        if($product == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($product);
        $manager->flush();
        return $this;
    }

    public function removeNewsUrlObject($object)
    {
        /** If no News product is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an News product
     * @param int $product_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getNewsUrl($product_id, $array = false)
    {
        $product_id = (int)$product_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :product_id')
                ->setParameter('product_id', $product_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $product = $this->repository->findOneBy(array('id' => $product_id));
        if ($product) {
            /** Return last build in json format */
            return $product;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllNewss($by = array(), $order = array('id' => 'asc'))
    {

        $menus = $this->repository->findBy($by, $order);
        if ($menus) {
            /** Return last build in json format */
            return $menus;
        }

        return array();
    }

    public function getNewsUrlBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object News product
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object News product
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