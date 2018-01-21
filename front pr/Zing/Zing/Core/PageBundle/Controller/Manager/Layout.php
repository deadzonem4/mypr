<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Symfony\Component\Config\Definition\Exception\Exception;
use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\Layout as Entity;
use Symfony\Component\Finder\Finder;

/** Layout crud manager */
class Layout extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:Layout';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_dev_layout_name' => array(
            'label'       => 'Name',
            'validation'  => 'a-zA-Z0-9:_&,\-\s',
            'not_blank'   => true
        ),
        'zing_dev_layout_file' => array(
            'label'       => 'Layout',
            'validation'  => 'a-zA-Z0-9_.\/',
            'not_blank'   => true
        ),
        'zing_dev_layout_status' => array(
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

    /** Prepare the layout object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareLayout($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setName($request['zing_dev_layout_name'])
                       ->setLayoutFile($request['zing_dev_layout_file'])
                       ->setStatus($request['zing_dev_layout_status'])
                       ->setDateModified(time());

    }

    /** Set a new layout
     * @param array $request The form request for layout
     * @return object Layout
     */
    public function setLayout($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareLayout($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created layout
     * @param array $request The form request
     * @param int $layout_id The id of the layout that we want to update
     * @return object Layout
     */
    public function updateLayout($request, $layout_id)
    {
        $this->updateLayoutObject($this->prepareLayout($request, $this->getLayout($layout_id)));
        return $this;
    }

    /** Update an layout object directly
     * @param object $object Custom modified object
     * @return object Layout
     */
    public function updateLayoutObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an layout
     * @param int $layout_id The id of the layout that we want to remove
     * @return object Layout
     */
    public function removeLayout($layout_id)
    {
        $layout = $this->getLayout($layout_id);

        /** If no layout is found */
        if($layout == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($layout);
        $manager->flush();
        return $this;
    }

    public function removeLayoutObject($object) {
        /** If no layout is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an layout
     * @param int $layout_id The id of the layout that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested layout else null if is not found
     */
    public function getLayout($layout_id, $array = false)
    {
        $layout_id = (int)$layout_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :layout_id')
                ->setParameter('layout_id', $layout_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $layouts = $this->repository->findOneBy(array('id' => $layout_id));
        if ($layouts) {
            /** Return last build in json format */
            return $layouts;
        }
        return null;
    }

    public function getAllActiveLayouts() {
        return $this->getAllLayouts(true);
    }

    /** Get all saved layouts
     * @param bool $only_active
     * @return array The found layouts else an empty array
     */
    public function getAllLayouts($only_active = false)
    {
        $where = array();

        if($only_active) {
            $where['status'] = 1;
        }

        $layouts = $this->repository->findBy($where, array('id' => 'asc'));
        if ($layouts) {
            /** Return last build in json format */
            return $layouts;
        }

        return array();
    }

    public function getLayoutFilePath() {
        return (dirname(dirname(__DIR__)).DS.'Resources'.DS.'views'.DS.'Default'.DS.'Available'.DS.'Layout'.DS);
    }

    public function isLayoutExists($file, $type) {

        /** Normalize input data */
        $type = strtolower($type);

        if(!in_array($type, array('admin', 'front', 'preview'))) {
            throw new \Exception('Incorrect layout type');
        }

        if(!file_exists($this->getLayoutFilePath().ucfirst($type).DS.$file)) {
            return false;
        }

        return true;
    }

    /** Get all available layouts
     * @return array Of found layouts
     */
    public function getLayoutAdminFiles() {
        return $this->getLayoutFiles($this->getLayoutFilePath().'Admin');
    }

    /** Get all available layouts
     * @return array Of found layouts
     */
    public function getLayoutFrontFiles() {
        return $this->getLayoutFiles($this->getLayoutFilePath().'Front');
    }

    /** Get all available layouts
     * @return array Of found layouts
     */
    public function getLayoutPreviewFiles() {
        return $this->getLayoutFiles($this->getLayoutFilePath().'Preview');
    }

    private function getLayoutFiles($dir) {
        $finder = new Finder();
        $layouts = array();

        /** Loop setting files */
        foreach($finder->name('*.html.twig')->in($dir) as $file) {
            $layouts[] = $file->getFileName();
        }
        return $layouts;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Layout
     */
    public function updateObjectFromTable($object) {
        return $this->updateLayoutObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Layout
     */
    public function removeObjectFromTable($object) {
       return $this->removeLayoutObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getLayout($object_id);
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