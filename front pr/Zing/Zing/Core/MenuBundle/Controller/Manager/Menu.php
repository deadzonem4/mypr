<?php
namespace Zing\Core\MenuBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\MenuBundle\Entity\Menu as Entity;

/** Menu crud manager */
class Menu extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCoreMenuBundle:Menu';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_menu_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_:?\-\s',
            'not_blank'   => true
        ),
        'zing_menu_url' => array(
            'label'       => 'Url',
            'validation'  => 'a-zA-Z0-9\/\-_',
            'not_blank'   => true
        ),
        'zing_menu_status' => array(
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
            ->where('c.url LIKE :word')
            ->orWhere('c.name LIKE :word')
            ->setParameter('word', '%'.$request.'%')
            ->getQuery();
        $result = $result->getResult();

        if(!count($result) > 0) {
            return array();
        }

        foreach($result as $k => $item) {

            $result[$k] = array(
                'url'           => $item->getUrl(),
                'title'         => $item->getName(),
                'description'   => ''
            );
        }

        return $result;
    }

    /** Prepare the menu object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareMenu($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setName($request['zing_menu_name'])
                       ->setUrl($request['zing_menu_url'])
                       ->setCategory($request['zing_menu_category'])
                       ->setStatus($request['zing_menu_status'])
                       ->setDateModified(time());
    }

    /** Set a new menu
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setMenu($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareMenu($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created menu
     * @param array $request The form request
     * @param int $menu_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateMenu($request, $menu_id)
    {
        $this->updateMenuObject($this->prepareMenu($request, $this->getMenu($menu_id)));
        return $this;
    }

    /** Update an menu object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateMenuObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an menu
     * @param $menu_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeMenu($menu_id)
    {
        $menu = $this->getMenu($menu_id);

        /** If no menu is found */
        if($menu == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($menu);
        $manager->flush();
        return $this;
    }

    public function removeMenuObject($object) {
        /** If no menu is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an menu
     * @param int $menu_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getMenu($menu_id, $array = false)
    {
        $menu_id = (int)$menu_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :menu_id')
                ->setParameter('menu_id', $menu_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $menus = $this->repository->findOneBy(array('id' => $menu_id));
        if ($menus) {
            /** Return last build in json format */
            return $menus;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllMenus($by = array(), $order = array('menu_order' => 'asc'))
    {

        $menus = $this->repository->findBy($by, $order);
        if ($menus) {
            /** Return last build in json format */
            return $menus;
        }

        return array();
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllMenusByCategoryId($id, $order = array('menu_order' => 'asc'))
    {

        $menus = $this->repository->findBy(array('category' => $id), $order);
        if ($menus) {
            /** Return last build in json format */
            return $menus;
        }

        return array();
    }

    public function getMenuBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Menu
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Menu
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