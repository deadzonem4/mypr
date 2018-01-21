<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\ProductOrder as Entity;

/** SimpleStore product_order crud manager */
class ProductOrder extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity SimpleStore product_order entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSimpleStoreBundle:ProductOrder';
    /** @var object $repository SimpleStore product_order repository */
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

    /** Prepare the SimpleStore product_order object
     * @param object $product_order_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareProductOrder($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        /** Assign the non lang product_order fields */
        $prepare    ->setUser($request['user'])
                    ->setCheckoutCart($request['user_checkout_cart'])
                    ->setUserdata($request['user_data'])
                    ->setUserCalculation($request['user_order_calculation'])
                    ->setStatus('waiting')
                    ->setDateModified(time());

        return $prepare;
    }

    /** Set a new SimpleStore product_order
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setProductOrder($request)
    {
        $manager = $this->_doctrineManager();
        $object = $this->prepareProductOrder($request)->setDateAdded(time());
        $manager->persist($object);
        $manager->flush();
        return $object->getId();
    }

    /** Update a already created SimpleStore product_order
     * @param array $request The form request
     * @param int $product_order_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateProductOrder($request, $product_order_id)
    {
        $this->updateProductOrderObject($this->prepareProductOrder($request, $this->getProductOrder($product_order_id)));
        return $this;
    }

    /** Update an SimpleStore product_order object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateProductOrderObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an product_order object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertProductOrderObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an SimpleStore product_order
     * @param $product_order_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeProductOrder($product_order_id)
    {
        $product_order = $this->getProductOrder((int)$product_order_id);

        /** If no menu is found */
        if($product_order == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($product_order);
        $manager->flush();
        return $this;
    }

    public function removeProductOrderObject($object)
    {
        /** If no SimpleStore product_order is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an SimpleStore product_order
     * @param int $product_order_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getProductOrder($product_order_id, $array = false)
    {
        $product_order_id = (int)$product_order_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :product_order_id')
                ->setParameter('product_order_id', $product_order_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $product_order = $this->repository->findOneBy(array('id' => $product_order_id));
        if ($product_order) {
            /** Return last build in json format */
            return $product_order;
        }
        return null;
    }


    public function getAllOrderedByYear()
    {
//        return $this    ->_doctrineManager()
//                        ->createQueryBuilder()
//                        ->select('c')
//                        ->from($this->repository_name, 'c')
//                        ->where('c.date_added >= :date_added')
//                        ->setParameter('date_added', date(time())
//                        ->getQuery()
//                        ->getResult();
    }

    public function getAllOrderedByMonth()
    {
//        return $this    ->_doctrineManager()
//                        ->createQueryBuilder()
//                        ->select('c')
//                        ->from($this->repository_name, 'c')
//                        ->where('c.date_added >= :date_added')
//                        ->setParameter('date_added', date(time())
//                        ->getQuery()
//                        ->getResult();
    }


    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllProductOrders($by = array(), $order = array('id' => 'desc'), $limit=null)
    {

        if($limit != null) {
            $categories = $this->repository->findBy($by, $order, $limit);
        } else {
            $categories = $this->repository->findBy($by, $order);
        }
        if ($categories) {
            /** Get found categories */
            return $categories;
        }
        return array();
    }

    public function getProductOrderBy($by)
    {
        $product_order = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($product_order) {
            return $product_order;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object SimpleStore product_order
     */
    public function updateObjectFromTable($object) {
        return true;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object SimpleStore product_order
     */
    public function removeObjectFromTable($object) {
        return true;
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return true;
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