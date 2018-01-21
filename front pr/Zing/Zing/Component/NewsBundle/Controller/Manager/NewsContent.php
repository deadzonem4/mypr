<?php
namespace Zing\Component\NewsBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\NewsBundle\Entity\NewsContent as Entity;

/** News product crud manager */
class NewsContent extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity News product entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentNewsBundle:NewsContent';
    /** @var object $repository News product content repository */
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
                'url'           => '/news'.$this->requestService('zing.component.news.category_url')->fullCategoryPath($item->getNews()->getCategory()->getUrlByType('bg')).$item->getNews()->getUrlByType($item->getLang()),
                'title'         => $parsed_content['title'],
                'description'   => $parsed_content['description']
            );
        }

        return $result;
    }

    /** Prepare the News product content object
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareNewsContent($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());
    }

    /** Set a new News product content
     * @param array $request The form request for product
     * @return object News
     */
    public function setNewsContent($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareNewsContent($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created News product content
     * @param array $request The form request
     * @param int $product_id The id of the product that we want to update
     * @return object News
     */
    public function updateNewsContent($request, $product_id)
    {
        $this->updateNewsObject($this->prepareNewsContent($request, $this->getNews($product_id)));
        return $this;
    }

    /** Update an News product object directly
     * @param $object Custom modified object
     * @return object News
     */
    public function updateNewsContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an product object directly
     * @param $object Custom modified object
     * @return object News
     */
    public function insertNewsContentObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an News product
     * @param $product_id The id of the product that we want to remove
     * @return object News
     */
    public function removeNewsContent($product_id)
    {
        $product = $this->getNewsContent($product_id);

        /** If no product is found */
        if($product == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($product);
        $manager->flush();
        return $this;
    }

    public function removeNewsContentObject($object)
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
     * @param int $product_id The id of the product that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested product else null if is not found
     */
    public function getNewsContent($product_id, $array = false)
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
    public function getAllNewsContents($by = array(), $order = array('id' => 'asc'))
    {

        $products = $this->repository->findBy($by, $order);
        if ($products) {
            /** Return last build in json format */
            return $products;
        }

        return array();
    }

    public function getNewsBy($by)
    {
        $product = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($product) {
            return $product;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object News product
     */
    public function updateObjectFromTable($object) {
        return $this->updateNewsObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object News product
     */
    public function removeObjectFromTable($object) {
        return $this->removeNewsObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getNews($object_id);
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