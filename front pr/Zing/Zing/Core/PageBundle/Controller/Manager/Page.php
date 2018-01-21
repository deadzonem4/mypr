<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\PageBundle\Entity\Page as Entity;
use Zing\Core\PageBundle\Entity\PageContent as PageContent;

/** Page crud manager */
class Page extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCorePageBundle:Page';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_page_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_?\s',
            'not_blank'   => true
        ),
        'zing_page_url' => array(
            'label'       => 'Path',
            'validation'  => 'a-zA-Z0-9_\-.:?&#%\/',
            'not_blank'   => true
        ),
        'zing_page_status' => array(
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

            $this->mapper[$lang]['meta_title'] = array(
                'label'             => 'Meta title '.strtoupper($lang),
                'validation'        => 'а-яА-Яa-zA-Z0-9_|`&\-\s:.',
                'not_blank'         => true
            );
            $this->mapper[$lang]['meta_keywords'] = array(
                'label'             => 'Meta keywords '.strtoupper($lang),
                'validation'        => 'а-яА-Яa-zA-Z0-9_|,&\-\s:.',
                'not_blank'         => true
            );
            $this->mapper[$lang]['meta_description'] = array(
                'label'             => 'Meta description '.strtoupper($lang),
                'validation'        => false,
                'not_blank'         => true
            );
        }
    }

    /** Prepare the page object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function preparePage($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        $content = new PageContent();
        $content->setDateModified(time());
        $content->setDateAdded(time());

        $page_content_manager = $this->requestService('zing.core.page.page_content');

        /** Loop in the active languages */
        foreach($this->activeLanguages() as $lang) {

            /** Get current language */
            $lang = strtolower($lang['language']);

            /** If we got request with this language */
            if(isset($request[$lang])) {

                if($prepare->getId() != null) {
                    $content = $page_content_manager->getOnePageContentBy(array(
                        'lang'    => $lang,
                        'page' => $prepare->getId()
                    ));
                    if(!$content) {
                        $content = new PageContent();
                        $content->setDateModified(time());
                        $content->setDateAdded(time());
                    }
                }

                $content->setContent(json_encode($request[$lang], JSON_UNESCAPED_UNICODE));
                $content->setLang($lang);
                $content->setStatus(1);
                $content->setPage($prepare);
                $prepare->setPageContent($content);
            }
        }

        return $prepare->setName($request['zing_page_name'])
                       ->setUrl($request['zing_page_url'])
                       ->setStatus($request['zing_page_status'])
                       ->setDateModified(time());

    }

    public function getMetaData($page_id)
    {
        $page = $this->getPage($page_id);

        if(!$page) {return null;}

        $content = $page->getContentByType($this->defaultLanguage()['language']);

        return array(
            'title'         => $content['meta_title'],
            'keywords'      => $content['meta_keywords'],
            'description'   => $content['meta_description']
        );
    }

    public function setLayout($page, $layout) {
        $this->updatePageObject($page->setLayout($layout));
        return true;
    }

    public function setPageLayout($page, $page_layout) {
        $this->updatePageObject($page->setPageLayout($page_layout));
        return true;
    }

    /** Set a new page
     * @param array $request The form request for page
     * @return object Page
     */
    public function setPage($request, $clear = false)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->preparePage($request)->setDateAdded(time()));
        $manager->flush();
        if($clear) {
            $manager->clear();
        }
        return $this;
    }

    /** Update a already created page
     * @param array $request The form request
     * @param int $page_id The id of the page that we want to update
     * @return object Page
     */
    public function updatePage($request, $page_id)
    {
        $this->updatePageObject($this->preparePage($request, $this->getPage($page_id)));
        return $this;
    }

    /** Update an page object directly
     * @param $object Custom modified object
     * @return object Page
     */
    public function updatePageObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Remove an page
     * @param $page_id The id of the page that we want to remove
     * @return object Page
     */
    public function removePage($page_id)
    {
        $page = $this->getPage($page_id);

        /** If no page is found */
        if($page == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($page);
        $manager->flush();
        return $this;
    }

    public function removePageObject($object) {
        /** If no page is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an page
     * @param int $page_id The id of the page that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested page else null if is not found
     */
    public function getPage($page_id, $array = false)
    {
        $page_id = (int)$page_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :page_id')
                ->setParameter('page_id', $page_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $pages = $this->repository->findOneBy(array('id' => $page_id));
        if ($pages) {
            /** Return last build in json format */
            return $pages;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllPages()
    {
        $pages = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($pages) {
            /** Return last build in json format */
            return $pages;
        }

        return array();
    }

    public function getPageBy($by)
    {
        $page = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($page) {
            return $page;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Page
     */
    public function updateObjectFromTable($object) {
        return $this->updatePageObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Page
     */
    public function removeObjectFromTable($object) {
       return $this->removePageObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getPage($object_id);
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