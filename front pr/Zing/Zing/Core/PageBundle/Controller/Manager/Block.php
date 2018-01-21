<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\Block as Entity;

/** Block crud manager */
class Block extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:Block';
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

    /** Prepare the block object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareBlock($request, $object = null)
    {
        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setBlockType($request['zing_block_type'])
                       ->setStatus($request['zing_block_status'])
                       ->setDateModified(time());
    }

    /** Set a new block
     * @param array $request The form request for block
     * @return object Block
     */
    public function setBlock($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareBlock($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Set a new block from object
     * @param object $object The block object
     * @return object Block manager object
     */
    public function setBlockObject($object)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($object->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a block object directly
     * @param object $object Custom modified object
     * @return object Block
     */
    public function updateBlockObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove a block from requested block id
     * @param int $block_id The id of the block that we want to remove
     * @return object Block
     */
    public function removeBlock($block_id)
    {
        $block = $this->getBlock($block_id);

        /** If no block is found */
        if($block == null) {
            return false;
        }

        return $this->removeBlockObject($block);
    }

    /** Remove a block from requested block object */
    public function removeBlockObject($object)
    {
        /** If no block is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an block
     * @param int $block_id The id of the block that we want to get
     * @return mixed The requested block else null if is not found
     */
    public function getBlock($block_id)
    {
        $block_id = (int)$block_id;

        $block = $this->repository->findOneBy(array('id' => $block_id));
        if ($block) {
            /** Return last build in json format */
            return $block;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllBlocks()
    {
        $blocks = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($blocks) {
            /** Return last build in json format */
            return $blocks;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Block
     */
    public function updateObjectFromTable($object) {
        return true;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Block
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