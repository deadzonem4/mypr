<?php
namespace Zing\Core\MenuBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\MenuBundle\Entity\Category as Entity;

/** Category crud manager */
class Category extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCoreMenuBundle:Category';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_category_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_:\-\s',
            'not_blank'   => true
        ),
        'zing_category_status' => array(
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
    }

    /** Prepare the category object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareCategory($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setName($request['zing_category_name'])
                       ->setStatus($request['zing_category_status'])
                       ->setDateModified(time());

    }

    public function setLayout($category, $layout) {
        $this->updateCategoryObject($category->setLayout($layout));
        return true;
    }

    public function setCategoryLayout($category, $category_layout) {
        $this->updateCategoryObject($category->setCategoryLayout($category_layout));
        return true;
    }

    /** Set a new category
     * @param array $request The form request for category
     * @return object Category
     */
    public function setCategory($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareCategory($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created category
     * @param array $request The form request
     * @param int $category_id The id of the category that we want to update
     * @return object Category
     */
    public function updateCategory($request, $category_id)
    {
        $this->updateCategoryObject($this->prepareCategory($request, $this->getCategory($category_id)));
        return $this;
    }

    /** Update an category object directly
     * @param $object Custom modified object
     * @return object Category
     */
    public function updateCategoryObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an category
     * @param $category_id The id of the category that we want to remove
     * @return object Category
     */
    public function removeCategory($category_id)
    {
        $category = $this->getCategory($category_id);

        /** If no category is found */
        if($category == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($category);
        $manager->flush();
        return $this;
    }

    public function removeCategoryObject($object) {
        /** If no category is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an category
     * @param int $category_id The id of the category that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested category else null if is not found
     */
    public function getCategory($category_id, $array = false)
    {
        $category_id = (int)$category_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :category_id')
                ->setParameter('category_id', $category_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $categorys = $this->repository->findOneBy(array('id' => $category_id));
        if ($categorys) {
            /** Return last build in json format */
            return $categorys;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllCategories()
    {
        $categorys = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($categorys) {
            /** Return last build in json format */
            return $categorys;
        }

        return array();
    }

    public function getCategoryBy($by)
    {
        $category = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($category) {
            return $category;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Category
     */
    public function updateObjectFromTable($object) {
        return $this->updateCategoryObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Category
     */
    public function removeObjectFromTable($object) {
       return $this->removeCategoryObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getCategory($object_id);
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