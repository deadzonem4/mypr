<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\PageLayout as Entity;
use Symfony\Component\Finder\Finder;

/** PageLayout crud manager */
class PageLayout extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:PageLayout';
    /** @var object $repository Setting */
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

    /** Prepare the layout position object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function preparePageLayout($request, $object = null)
    {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setLayout($request['zing_page_layout'])
                       ->setPage($request['zing_page_page'])
                       ->setStatus($request['zing_page_page_layout_status'])
                       ->setDateModified(time())
                       ->setDateAdded(time());

    }

    /** Set a new layout position
     * @param array $object The object for persists
     * @return object PageLayout
     */
    public function setPageLayoutObject($object)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($object->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Set a new layout position
     * @param array $request The form request for layout_position
     * @return object PageLayout
     */
    public function setLayoutP($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->preparePageLayout($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created layout_position
     * @param array $request The form request
     * @param int $layout_position_id The id of the layout_position that we want to update
     * @return object PageLayout
     */
    public function updatePageLayout($request, $layout_position_id)
    {
        $this->updatePageLayoutObject($this->preparePageLayout($request, $this->getPageLayout($layout_position_id)));
        return $this;
    }

    /** Update an layout_position object directly
     * @param object $object Custom modified object
     * @return object PageLayout
     */
    public function updatePageLayoutObject($object)
    {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an layout_position
     * @param int $layout_position_id The id of the layout_position that we want to remove
     * @return object PageLayout
     */
    public function removePageLayout($layout_position_id)
    {
        $layout_position = $this->getPageLayout($layout_position_id);

        /** If no layout_position is found */
        if($layout_position == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($layout_position);
        $manager->flush();
        return $this;
    }

    public function removePageLayoutObject($object)
    {
        /** If no layout_position is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an layout_position
     * @param int $layout_position_id The id of the layout_position that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested layout_position else null if is not found
     */
    public function getPageLayout($layout_position_id, $array = false)
    {
        $layout_position_id = (int)$layout_position_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :layout_position_id')
                ->setParameter('layout_position_id', $layout_position_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $layout_positions = $this->repository->findOneBy(array('id' => $layout_position_id));
        if ($layout_positions) {
            /** Return last build in json format */
            return $layout_positions;
        }
        return null;
    }

    public function getOnePageLayoutBy($by, $order = 'asc')
    {
        $layout_positions = $this->repository->findOneBy($by, array('id' => $order));

        if ($layout_positions) {
            return $layout_positions;
        }

        return null;
    }

    public function getPageLayoutBy($by, $order = 'asc', $limit = 0)
    {
        if($limit > 0) {
            $layout_positions = $this->repository->findBy($by, array('id' => $order), $limit);
        } else {
            $layout_positions = $this->repository->findBy($by, array('id' => $order));
        }

        if ($layout_positions) {

            return $layout_positions;
        }
        return array();
    }

    public function getAllActivePageLayouts()
    {
        return $this->getAllPageLayouts(true);
    }

    /** Get all saved layout_positions
     * @param bool $only_active
     * @return array The found layout_positions else an empty array
     */
    public function getAllPageLayouts($only_active = false)
    {
        $where = array();

        if($only_active) {
            $where['status'] = 1;
        }

        $layout_positions = $this->repository->findBy($where, array('id' => 'asc'));
        if ($layout_positions) {
            /** Return last build in json format */
            return $layout_positions;
        }

        return array();
    }

    public function getPageLayoutFilePath()
    {
        return (dirname(dirname(__DIR__)).DS.'Resources'.DS.'views'.DS.'Default'.DS.'Available'.DS.'Layout'.DS);
    }

    public function isPageLayoutExists($file, $type)
    {

        /** Normalize input data */
        $type = strtolower($type);

        if(!in_array($type, array('admin', 'front', 'preview'))) {
            throw new \Exception('Incorrect layout_position type');
        }

        if(!file_exists($this->getPageLayoutFilePath().ucfirst($type).DS.$file)) {
            return false;
        }

        return true;
    }

    /** Get all available layout_positions
     * @return array Of found layout_positions
     */
    public function getPageLayoutAdminFiles()
    {
        return $this->getPageLayoutFiles($this->getPageLayoutFilePath().'Admin');
    }

    /** Get all available layout_positions
     * @return array Of found layout_positions
     */
    public function getPageLayoutFrontFiles()
    {
        return $this->getPageLayoutFiles($this->getPageLayoutFilePath().'Front');
    }

    /** Get all available layout_positions
     * @return array Of found layout_positions
     */
    public function getPageLayoutPreviewFiles()
    {
        return $this->getPageLayoutFiles($this->getPageLayoutFilePath().'Preview');
    }

    private function getPageLayoutFiles($dir)
    {
        $finder = new Finder();
        $layout_positions = array();

        /** Loop setting files */
        foreach($finder->name('*.html.twig')->in($dir) as $file) {
            $layout_positions[] = $file->getFileName();
        }
        return $layout_positions;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object PageLayout
     */
    public function updateObjectFromTable($object)
    {
        return $this->updatePageLayoutObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object PageLayout
     */
    public function removeObjectFromTable($object)
    {
       return $this->removePageLayoutObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id)
    {
        return $this->getPageLayout($object_id);
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