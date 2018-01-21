<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\PageContent as Entity;

/** PageContent crud manager */
class PageContent extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:PageContent';
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

    /** Prepare the page_content object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function preparePageContent($request, $object = null)
    {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setPage($request['zing_page_page'])
                       ->setContent($request['zing_page_content'])
                       ->setLang($request['zing_page_content_lang'])
                       ->setStatus($request['zing_page_content_status'])
                       ->setDateModified(time());

    }

    /** Set a new page_content
     * @param array $request The form request for page_content
     * @return object PageContent
     */
    public function setPageContent($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->preparePageContent($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created page_content
     * @param array $request The form request
     * @param int $page_content_id The id of the page content that we want to update
     * @return object PageContent
     */
    public function updatePageContent($request, $page_content_id)
    {
        $this->updatePageContentObject($this->preparePageContent($request, $this->getPageContent($page_content_id)));
        return $this;
    }

    /** Update an page_content object directly
     * @param $object Custom modified object
     * @return object PageContent
     */
    public function updatePageContentObject($object)
    {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove a page content
     * @param $page_content_id The id of the page_content that we want to remove
     * @return object PageContent
     */
    public function removePageContent($page_content_id)
    {
        $page_content = $this->getPageContent($page_content_id);

        /** If no page_content is found */
        if($page_content == null) {
            return false;
        }

        return $this->removePageContentObject($page_content);
    }

    public function removePageContentObject($object)
    {
        /** If no page_content is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an page_content
     * @param int $page_content_id The id of the page_content that we want to get
     * @return mixed The requested page_content else null if is not found
     */
    public function getPageContent($page_content_id)
    {
        $page_content_id = (int)$page_content_id;

        $page_content = $this->repository->findOneBy(array('id' => $page_content_id));
        if ($page_content) {
            return $page_content;
        }
        return null;
    }

    /** Get a page content by requested arguments
     * @param array $by Requested arguments in array
     * @param string $order In what order to return the found page contents
     * @return mixed If nothing is found return null else return the page content in object
     */
    public function getOnePageContentBy($by, $order = 'asc')
    {
        $page_content = $this->repository->findOneBy($by, array('id' => $order));
        if(!$page_content) {
            return null;
        }
        return $page_content;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllPageContents()
    {
        $page_contents = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($page_contents) {
            /** Return last build in json format */
            return $page_contents;
        }

        return array();
    }

    /** Get al page contents by requested arguments
     * @param array $by Requested arguments in array
     * @param string $order In what order to return the found page contents
     * @param int $limit Set limit on the result
     * @return array If nothing is found return empty array else return the page content in array with objects
     */
    public function getAllPageContentsBy($by, $order = 'asc', $limit = 0)
    {
        if($limit > 0) {
            $page_contents = $this->repository->findBy($by, array('id' => $order), $limit);
        } else {
            $page_contents = $this->repository->findBy($by, array('id' => $order));
        }

        if ($page_contents) {
            /** Return last build in json format */
            return $page_contents;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object PageContent
     */
    public function updateObjectFromTable($object)
    {
        return true;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object PageContent
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