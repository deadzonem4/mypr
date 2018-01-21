<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\ProductContent as Entity;

/** SimpleStore product crud manager */
class ProductContent extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity SimpleStore product entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSimpleStoreBundle:ProductContent';
    /** @var object $repository SimpleStore product content repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */
//    protected $mapper = array(
//        'zing_product_name' => array(
//            'label'       => 'Name',
//            'validation'  => 'a-zA-Z0-9_\s',
//            'not_blank'   => true
//        ),
//        'zing_product_url' => array(
//            'label'       => 'Url',
//            'validation'  => 'a-zA-Z0-9\/\-_',
//            'not_blank'   => true
//        ),
//        'zing_product_status' => array(
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


    public function search()
    {
        $request = $this->getGetRequestInArray();
        if(!isset($request['k'])) {
            return array();
        }

        $request = $request['k'];

        if(strlen($request) <= 3) {
            return array();
        }

        $result = $this ->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.content LIKE :word')
                ->andWhere('c.lang LIKE :lang')
                ->setParameter('word', '%'.$request.'%')
                ->setParameter('lang', $this->myLocale())
                ->getQuery();
        $result = $result->getResult();

        if(!count($result) > 0) {
            return array();
        }

        foreach($result as $k => $item) {
            $parsed_content = json_decode($item->getContent(), true);

            $result[$k] = array(
                'url'           => '/store'.$this->requestService('zing.component.simplestore.category_url')->fullCategoryPath($item->getProduct()->getCategory()->getUrlByType('bg')).$item->getProduct()->getUrlByType($item->getLang()),
                'title'         => $parsed_content['title'],
                'description'   => $parsed_content['description']
            );
        }

        return $result;
    }

    /** Prepare the SimpleStore product content object
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareProductContent($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());
    }

    /** Set a new SimpleStore product content
     * @param array $request The form request for product
     * @return object Product
     */
    public function setProductContent($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareProductContent($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created SimpleStore product content
     * @param array $request The form request
     * @param int $product_id The id of the product that we want to update
     * @return object Product
     */
    public function updateProductContent($request, $product_id)
    {
        $this->updateProductObject($this->prepareProductContent($request, $this->getProduct($product_id)));
        return $this;
    }

    /** Update an SimpleStore product object directly
     * @param $object Custom modified object
     * @return object Product
     */
    public function updateProductContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an product object directly
     * @param $object Custom modified object
     * @return object Product
     */
    public function insertProductContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an SimpleStore product
     * @param $product_id The id of the product that we want to remove
     * @return object Product
     */
    public function removeProductContent($product_id)
    {
        $product = $this->getProductContent($product_id);

        /** If no product is found */
        if($product == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($product);
        $manager->flush();
        return $this;
    }

    public function removeProductContentObject($object)
    {
        /** If no SimpleStore product is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an SimpleStore product
     * @param int $product_id The id of the product that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested product else null if is not found
     */
    public function getProductContent($product_id, $array = false)
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
    public function getAllProductContents($by = array(), $order = array('id' => 'asc'))
    {

        $products = $this->repository->findBy($by, $order);
        if ($products) {
            /** Return last build in json format */
            return $products;
        }

        return array();
    }

    public function getProductBy($by)
    {
        $product = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($product) {
            return $product;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object SimpleStore product
     */
    public function updateObjectFromTable($object) {
        return $this->updateProductObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object SimpleStore product
     */
    public function removeObjectFromTable($object) {
        return $this->removeProductObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getProduct($object_id);
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