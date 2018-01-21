<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\CategoryUrl as Entity;

/** SimpleStore category crud manager */
class CategoryUrl extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity SimpleStore category entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSimpleStoreBundle:CategoryUrl';
    /** @var object $repository SimpleStore category url repository */
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

    public function fullCategoryPath($category_url)
    {
        $url = '';
        foreach($this->getParentCategoriesIdsByUrl($category_url) as $id) {

            $category = $this->requestService('zing.component.simplestore.category')->getCategoryBy(array(
                'id' => $id
            ));

            if($category != null) {
                $url .= $category->getUrlByType($this->myLocale());
            }
        }

        return $url;
    }

    /** Prepare the SimpleStore category url object
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareCategoryUrl($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());
    }

    private function getChildCategoriesIdsByParent($parent)
    {
        /** Hold found urls */
        $ids = array();

        /** If category got child */
        if($parent->getChild() != null) {

            /** Loop in the childs */
            foreach($parent->getChild() as $child) {

                /** Merge the the found child ids */
                $ids = array_merge($ids, $this->getChildCategoriesIdsByParent($child));
            }
        }

        /** If the holder is not an array create a new holder id array */
        if(!is_array($ids)) {
            $ids = array();
        }

        /** Push the parent id to the holder array */
        array_push($ids, $parent->getId());

        /** Return the id holder */
        return $ids;
    }

    public function getChildCategoriesIdsByUrl($url)
    {
        $category_url = $this->getCategoryUrlBy(array('url' => $url))->getCategory();

        return $this->getChildCategoriesIdsByParent($category_url);
    }


    private function getParentCategoriesIdsByParent($parent)
    {
        /** Hold found urls */
        $ids = array();

        /** If category got child */
        if($parent->getParent() != null) {

            /** Merge the the found child ids */
            $ids = array_merge($ids, $this->getParentCategoriesIdsByParent($parent->getParent()));

        }

        /** If the holder is not an array create a new holder id array */
        if(!is_array($ids)) {
            $ids = array();
        }

        /** Push the parent id to the holder array */
        array_push($ids, $parent->getId());

        /** Return the id holder */
        return $ids;
    }

    public function getParentCategoriesIdsByUrl($url)
    {
        $category_url = $this->getCategoryUrlBy(array('url' => $url))->getCategory();

        return $this->getParentCategoriesIdsByParent($category_url);
    }

    /** Set a new SimpleStore category url
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setCategoryUrl($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareCategoryUrl($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created SimpleStore category url
     * @param array $request The form request
     * @param int $category_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateCategoryUrl($request, $category_id)
    {
        $this->updateMenuObject($this->prepareCategoryUrl($request, $this->getMenu($category_id)));
        return $this;
    }

    /** Update an SimpleStore category object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateCategoryUrlObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an category object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertCategoryUrlObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an SimpleStore category
     * @param $category_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeCategoryUrl($category_id)
    {
        $category = $this->getCategoryUrl($category_id);

        /** If no menu is found */
        if($category == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($category);
        $manager->flush();
        return $this;
    }

    public function removeCategoryUrlObject($object)
    {
        /** If no SimpleStore category is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an SimpleStore category
     * @param int $category_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getCategoryUrl($category_id, $array = false)
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

        $category = $this->repository->findOneBy(array('id' => $category_id));
        if ($category) {
            /** Return last build in json format */
            return $category;
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

    public function getCategoryUrlBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }
 
    public function getCategoryByCurrentUrl()
    {
        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $category_from_url = end($category_from_url);

        $url = str_replace('/store', '', '/'.$category_from_url);
        return $this->getCategoryUrlBy(array('url' => $url));
    }
   
    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object SimpleStore category
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object SimpleStore category
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