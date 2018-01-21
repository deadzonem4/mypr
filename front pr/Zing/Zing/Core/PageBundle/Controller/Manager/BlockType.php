<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\BlockType as Entity;

/** BlockType crud manager */
class BlockType extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:BlockType';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_block_type_name' => array(
            'label'       => 'Name',
            'validation'  => 'a-zA-Z0-9:_&,\-\s',
            'not_blank'   => true
        ),
        'zing_block_type_template_name' => array(
            'label'       => 'Path',
            'validation'  => 'a-zA-Z0-9_.\/',
            'not_blank'   => true
        ),
        'zing_block_type_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        )
    );

    private $supported_block_types = null;

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

    /** Check if requested block_type is supported
     * @param string $block_type_name Name of the block_type
     * @return bool
     */
    public function isBlockTypeSupported($block_type_name) {

        /** If supported block type is empty or is not an array call getSupportedBlockTypes */
        if($this->supported_block_types == null || !is_array($this->supported_block_types)) {
            $this->supported_block_types = $this->getSupportedBlockTypes();
        }

        /** Check the block_type */
        if(!in_array($block_type_name, $this->supported_block_types)) {
            return false;
        }
        return true;
    }

    /** Get dependencies for all block_types from config
     * @return array BlockType dependencies
     */
    public function getBlockTypeDependencies() {
        return $this->container->getParameter('zing_core_page');
    }

    /** Get supported block_types
     * @return array Supported BlockTypes
     */
    public function getSupportedBlockTypes() {
        /** Get mapped block_types and theyre dependencies*/
        $block_types = $this->getBlockTypeDependencies();

        /** Supported block_type handler */
        $supported_block_types = array();

        /** Loop in block_types */
        foreach($block_types as $block_type => $config) {

            /** Available services handled */
            $available_services = array();

            /** Loop in block_type dependency */
            foreach($config['dependency'] as $dep) {

                /** If a service dependency is available */
                if($this->isServiceAvailable($dep)) {
                    $available_services[] = $dep;
                }
            }

            /** If available services for the block_type equals the config dependencies  */
            if(count($available_services) == count($config['dependency'])) {
                $supported_block_types[] = $block_type;
            }

        }
        $this->supported_block_types = $supported_block_types;
        return $supported_block_types;
    }

    /** Prepare the block_type object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareBlockType($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setName($request['zing_block_type_name'])
            ->setTemplateName($request['zing_block_type_template_name'])
            ->setStatus($request['zing_block_type_status'])
            ->setDateModified(time());

    }

    /** Set a new block_type
     * @param array $request The form request for block_type
     * @return object BlockType
     */
    public function setBlockType($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareBlockType($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created block_type
     * @param array $request The form request
     * @param int $block_type_id The id of the block_type that we want to update
     * @return object BlockType
     */
    public function updateBlockType($request, $block_type_id)
    {
        $this->updateBlockTypeObject($this->prepareBlockType($request, $this->getBlockType($block_type_id)));
        return $this;
    }

    /** Check if template exists
     * @param string $file File name
     * @param string $type Type of the file - admin or front
     * @return bool
     * @throws \Exception If file type is incorrect
     */
    public function isTemplateExists($file, $type) {

        /** Normalize input data */
        $type = strtolower($type);

        if(!in_array($type, array('admin', 'front'))) {
            throw new \Exception('Incorrect template type');
        }

        if(!file_exists($this->getTemplateFilePath().ucfirst($type).DS.$file)) {
            return false;
        }

        return true;
    }

    public function getTemplateFilePath() {
        return (dirname(dirname(__DIR__)).DS.'Resources'.DS.'views'.DS.'Default'.DS.'Available'.DS.'Template'.DS);
    }

    /** Update an block_type object directly
     * @param $object Custom modified object
     * @return object BlockType
     */
    public function updateBlockTypeObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an block_type
     * @param $block_type_id The id of the block_type that we want to remove
     * @return object BlockType
     */
    public function removeBlockType($block_type_id)
    {
        $block_type = $this->getBlockType($block_type_id);

        /** If no block_type is found */
        if($block_type == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($block_type);
        $manager->flush();
        return $this;
    }

    public function removeBlockTypeObject($object) {
        /** If no block_type is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an block_type
     * @param int $block_type_id The id of the block_type that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested block_type else null if is not found
     */
    public function getBlockType($block_type_id, $array = false)
    {
        $block_type_id = (int)$block_type_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :block_type_id')
                ->setParameter('block_type_id', $block_type_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $block_types = $this->repository->findOneBy(array('id' => $block_type_id));
        if ($block_types) {
            /** Return last build in json format */
            return $block_types;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllBlockTypes()
    {
        $block_types = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($block_types) {
            /** Return last build in json format */
            return $block_types;
        }

        return array();
    }

    public function getAllActiveBlockTypes()
    {
        $block_types = $this->repository->findBy(array('status' => 1), array('id' => 'asc'));
        if ($block_types) {
            /** Return last build in json format */
            return $block_types;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object BlockType
     */
    public function updateObjectFromTable($object) {
        return $this->updateBlockTypeObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object BlockType
     */
    public function removeObjectFromTable($object) {
        return $this->removeBlockTypeObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getBlockType($object_id);
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