<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\BlockPosition as Entity;

/** BlockPosition crud manager */
class BlockPosition extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:BlockPosition';
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

    /** Prepare the block position object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareBlockPosition($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setBlock($request['zing_block_block'])
                       ->setBlockOrder($request['zing_block_order'])
                       ->setPageLayout($request['zing_page_layout'])
                       ->setLayoutPosition($request['zing_layout_position'])
                       ->setStatus($request['zing_block_position_status'])
                       ->setDateModified(time());

    }

    /** Set a new block_type
     * @param array $request The form request for block_type
     * @return object BlockPosition
     */
    public function setBlockPosition($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareBlockPosition($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created block_type
     * @param array $request The form request
     * @param int $block_type_id The id of the block_type that we want to update
     * @return object BlockPosition
     */
    public function updateBlockPosition($request, $block_type_id)
    {
        $this->updateBlockPositionObject($this->prepareBlockPosition($request, $this->getBlockPosition($block_type_id)));
        return $this;
    }


    /** Update an block_type object directly
     * @param $object Custom modified object
     * @return object BlockPosition
     */
    public function updateBlockPositionObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an block_type object directly
     * @param $object Custom modified object
     * @return object BlockPosition
     */
    public function insertBlockPositionObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Remove an block_type
     * @param $block_position_id The id of the block_type that we want to remove
     * @return object BlockPosition
     */
    public function removeBlockPosition($block_position_id)
    {
        $block_position = $this->getBlockPosition($block_position_id);

        /** If no block_type is found */
        if($block_position == null) {
            return false;
        }
        return $this->removeBlockPositionObject($block_position);
    }

    /** Remove a block position from object
     * @param object $object The block position object
     * @return mixed False if is not removed or BlockPosition manager object
     */
    public function removeBlockPositionObject($object)
    {
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
     * @param int $block_position_id The id of the block_type that we want to get
     * @return mixed The requested block_type else null if is not found
     */
    public function getBlockPosition($block_position_id)
    {
        $block_position_id = (int)$block_position_id;

        $block_position = $this->repository->findOneBy(array('id' => $block_position_id));
        if ($block_position) {
            /** Return last build in json format */
            return $block_position;
        }
        return null;
    }

    /** Get one block position by requested arguments */
    public function getOneBlockPositionBy($by, $order = 'asc')
    {
        $block_position = $this->repository->findOneBy($by, array('id' => $order));
        if(!$block_position) {
            return null;
        }
        return $block_position;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllBlockPositions()
    {
        $block_types = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($block_types) {
            /** Return last build in json format */
            return $block_types;
        }

        return array();
    }

    /** Get all block positions by requested arguments */
    public function getAllBlockPositionsBy($by, $order = 'asc', $limit = 0)
    {
        if($limit > 0) {
            $block_types = $this->repository->findBy($by, array('id' => $order), $limit);
        } else {
            $block_types = $this->repository->findBy($by, array('id' => $order));
        }

        if ($block_types) {
            /** Return last build in json format */
            return $block_types;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object BlockPosition
     */
    public function updateObjectFromTable($object) {
        return true;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object BlockPosition
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