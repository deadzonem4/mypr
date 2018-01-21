<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\BlockContent as Entity;

/** BlockContent crud manager */
class BlockContent extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:BlockContent';
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
            ->where('c.content LIKE :word')
            ->andWhere('c.lang LIKE :lang')
            ->setParameter('word', '%'.$request.'%')
            ->setParameter('lang', $this->myLocale())
            ->getQuery();
        $result = $result->getResult();

        if(!count($result) > 0) {
            return array();
        }

        $new_result = array();
        foreach($result as $k => $item) {
            $parsed_content = json_decode($item->getContent(), true);

        
            $description = '';


            if(isset($parsed_content['description'])) {
                $description = $parsed_content['description'];
            }

            $rel = $item->getBlock()->getBlockRel();
            foreach($rel as $block_page) {

                $new_result[] = array(
                    'url'           => $block_page->getPage()->getUrl(),
                    'title'         => $block_page->getPage()->getName(),
                    'description'   => $description
                );

            }
        }

        return $new_result;
    }

    /** Prepare the block_content object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareBlockContent($request, $object = null)
    {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setBlock($request['zing_block_block'])
                       ->setContent($request['zing_block_content'])
                       ->setLang($request['zing_block_content_lang'])
                       ->setStatus($request['zing_block_content_status'])
                       ->setDateModified(time());

    }

    /** Set a new block_content
     * @param array $request The form request for block_content
     * @return object BlockContent
     */
    public function setBlockContent($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareBlockContent($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created block_content
     * @param array $request The form request
     * @param int $block_content_id The id of the block content that we want to update
     * @return object BlockContent
     */
    public function updateBlockContent($request, $block_content_id)
    {
        $this->updateBlockContentObject($this->prepareBlockContent($request, $this->getBlockContent($block_content_id)));
        return $this;
    }

    /** Update an block_content object directly
     * @param $object Custom modified object
     * @return object BlockContent
     */
    public function updateBlockContentObject($object)
    {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove a block content
     * @param $block_content_id The id of the block_content that we want to remove
     * @return object BlockContent
     */
    public function removeBlockContent($block_content_id)
    {
        $block_content = $this->getBlockContent($block_content_id);

        /** If no block_content is found */
        if($block_content == null) {
            return false;
        }

        return $this->removeBlockContentObject($block_content);
    }

    public function removeBlockContentObject($object)
    {
        /** If no block_content is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an block_content
     * @param int $block_content_id The id of the block_content that we want to get
     * @return mixed The requested block_content else null if is not found
     */
    public function getBlockContent($block_content_id)
    {
        $block_content_id = (int)$block_content_id;

        $block_content = $this->repository->findOneBy(array('id' => $block_content_id));
        if ($block_content) {
            return $block_content;
        }
        return null;
    }

    /** Get a block content by requested arguments
     * @param array $by Requested arguments in array
     * @param string $order In what order to return the found block contents
     * @return mixed If nothing is found return null else return the block content in object
     */
    public function getOneBlockContentBy($by, $order = 'asc')
    {
        $block_content = $this->repository->findOneBy($by, array('id' => $order));
        if(!$block_content) {
            return null;
        }
        return $block_content;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllBlockContents()
    {
        $block_contents = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($block_contents) {
            /** Return last build in json format */
            return $block_contents;
        }

        return array();
    }

    /** Get al block contents by requested arguments
     * @param array $by Requested arguments in array
     * @param string $order In what order to return the found block contents
     * @param int $limit Set limit on the result
     * @return array If nothing is found return empty array else return the block content in array with objects
     */
    public function getAllBlockContentsBy($by, $order = 'asc', $limit = 0)
    {
        if($limit > 0) {
            $block_contents = $this->repository->findBy($by, array('id' => $order), $limit);
        } else {
            $block_contents = $this->repository->findBy($by, array('id' => $order));
        }

        if ($block_contents) {
            /** Return last build in json format */
            return $block_contents;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object BlockContent
     */
    public function updateObjectFromTable($object)
    {
        return true;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object BlockContent
     */
    public function removeObjectFromTable($object)
    {
        return true;
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id)
    {
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