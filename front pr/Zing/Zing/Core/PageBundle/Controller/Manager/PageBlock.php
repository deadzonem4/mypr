<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\PageBlock as Entity;

/** PageBlock crud manager */
class PageBlock extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:PageBlock';
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


    /** Prepare the block_type object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function preparePageBlock($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setPage($request['zing_page_page'])
                       ->setBlock($request['zing_block_block'])
                       ->setStatus($request['zing_page_block_status'])
                       ->setDateModified(time());
    }

    /** Set a new block_type
     * @param array $request The form request for block_type
     * @return object PageBlock
     */
    public function setPageBlock($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->preparePageBlock($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created block_type
     * @param array $request The form request
     * @param int $block_type_id The id of the block_type that we want to update
     * @return object PageBlock
     */
    public function updatePageBlock($request, $block_type_id)
    {
        $this->updatePageBlockObject($this->preparePageBlock($request, $this->getPageBlock($block_type_id)));
        return $this;
    }


    /** Update an block_type object directly
     * @param $object Custom modified object
     * @return object PageBlock
     */
    public function updatePageBlockObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an page block relation
     * @param $block_type_id The id of the block_type that we want to remove
     * @return object PageBlock
     */
    public function removePageBlock($block_type_id)
    {
        $block_type = $this->getPageBlock($block_type_id);

        /** If no block_type is found */
        if($block_type == null) {
            return false;
        }

        return $this->removePageBlockObject($block_type);
    }

    public function removePageBlockObject($object) {
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
     * @param int $page_block_id The id of the page block that we want to get
     * @return mixed The requested block_type else null if is not found
     */
    public function getPageBlock($page_block_id)
    {
        $page_block_id = (int)$page_block_id;

        $page_block = $this->repository->findOneBy(array('id' => $page_block_id));
        if ($page_block) {
            return $page_block;
        }
        return null;
    }

    /** Get all page block relations
     * @return array The found layouts else an empty array
     */
    public function getAllPageBlocks()
    {
        $block_types = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($block_types) {
            /** Return last build in json format */
            return $block_types;
        }

        return array();
    }

    /** Get one page block relation by given arguments */
    public function getOnePageBlockBy($by, $order)
    {
        $page_block = $this->repository->findOneBy($by, array('id' => $order));
        if(!$page_block) {
           return null;
        }
        return $page_block;
    }

    /** Get page block relations
     * @param array $by Field => value
     * @param string $order Order by asc or desc
     * @param int $limit Limit on result
     * @return array The found layouts else an empty array
     */
    public function getAllPageBlocksBy($by, $order = 'asc', $limit = 0)
    {
        /** If limit is requested */
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

    /** Get blocks with position non by page id
     * @param int $page_id Id of the page that we want to get blocks
     * @return array Blocks
     */
    public function getOnlyBlocksWithNonPositionByPage($page_id)
    {
        $rel = $this->getAllPageBlocksBy(array('page' => $page_id), 'asc');

        $blocks = array();
        foreach($rel as $page_block) {
            $block_position = $page_block->getBlock()->getBlockPosition();
            if($block_position == null) {
                $blocks[] = $page_block;
            } else {
                if($block_position->getLayoutPosition() == 0) {
                    $blocks[] = $page_block;
                }
            }

        }
        return $blocks;
    }

    /** Get blocks with position non by page id
     * @param int $page_id Id of the page that we want to get blocks
     * @return array Blocks
     */
    public function getOnlyActiveBlocksWithNonPositionByPage($page_id)
    {
        $rel = $this->getAllPageBlocksBy(array('page' => $page_id), 'asc');

        $blocks = array();
        foreach($rel as $page_block) {
            $block_position = $page_block->getBlock()->getBlockPosition();

            if($page_block->getBlock()->getBlockType()->getStatus()) {

                if($block_position == null) {
                    $blocks[] = $page_block;
                } else {
                    if($block_position->getLayoutPosition() == 0) {
                        $blocks[] = $page_block;
                    }
                }
            }

        }
        return $blocks;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object PageBlock
     */
    public function updateObjectFromTable($object) {
        return true;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object PageBlock
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