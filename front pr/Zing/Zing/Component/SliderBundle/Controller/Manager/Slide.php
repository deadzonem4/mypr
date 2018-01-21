<?php
namespace Zing\Component\SliderBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SliderBundle\Entity\Slide as Entity;

/** Menu crud manager */
class Slide extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSliderBundle:Slide';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_slide_status' => array(
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
        $this->_map();
    }

    private function _map()
    {
        foreach($this->activeLanguages() as $lang) {
            $lang = $lang['language'];

            $this->mapper[$lang]['title'] = array(
                'label'       => 'Title '.strtoupper($lang),
                'validation'  => false,
                'not_blank'   => false
            );
            $this->mapper[$lang]['description'] = array(
                'label'             => 'Description '.strtoupper($lang),
                'validation'        => false,
                'not_blank'         => false
            );
        }
    }

    /** Prepare the menu object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareSlide($object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setDateModified(time());

    }

    /** Set a new menu
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setSlider($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareSlider($request)->setDateAdded(time()));
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
    public function updateSlideObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an slide object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertSlideObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an menu
     * @param $menu_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeSlide($slide_id)
    {
        $slide = $this->getSlide($slide_id);

        /** If no menu is found */
        if($slide == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($slide);
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
    public function getSlide($slide_id, $array = false)
    {
        $slide_id = (int)$slide_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :slide_id')
                ->setParameter('slide_id', $slide_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $slide = $this->repository->findOneBy(array('id' => $slide_id));
        if ($slide) {
            /** Return last build in json format */
            return $slide;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllSlides($by = array(), $order = array('id' => 'asc'))
    {

        $menus = $this->repository->findBy($by, $order);
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