<?php
namespace Zing\Component\NewsBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\NewsBundle\Entity\Category as Entity;
use Zing\Component\NewsBundle\Entity\CategoryContent as CategoryContent;

/** News category crud manager */
class Category extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity News category entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentNewsBundle:Category';
    /** @var object $repository News category repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_category_display_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
            'not_blank'   => true
        ),
        'zing_category_status' => array(
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

            $this->mapper[$lang]['name'] = array(
                'label'       => 'Name '.strtoupper($lang),
                'validation'  => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
                'not_blank'   => true
            );
            $this->mapper[$lang]['description'] = array(
                'label'             => 'Description '.strtoupper($lang),
                'validation'        => false,
                'not_blank'         => true
            );
            $this->mapper[$lang]['url'] = array(
                'label'             => 'Url '.strtoupper($lang),
                'validation'        => 'a-zA-Z0-9-\/',
                'not_blank'         => true
            );
            $this->mapper[$lang]['meta_title'] = array(
                'label'             => 'Meta title '.strtoupper($lang),
                'validation'        => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
                'not_blank'         => false
            );
            $this->mapper[$lang]['meta_keywords'] = array(
                'label'             => 'Meta keywords '.strtoupper($lang),
                'validation'        => 'а-яА-Яa-zA-Z0-9_|,&\-\s',
                'not_blank'         => false
            );
            $this->mapper[$lang]['meta_description'] = array(
                'label'             => 'Meta description '.strtoupper($lang),
                'validation'        => false,
                'not_blank'         => false
            );
        }
    }

    public function getMetaData($category_id)
    {
        $category = $this->getCategory($category_id);

        if(!$category) {return null;}

        $content = $category->getContentByType($this->defaultLanguage()['language']);

        return array(
            'title'         => $content['meta_title'],
            'keywords'      => $content['meta_keywords'],
            'description'   => $content['meta_description']
        );
    }

    /** Prepare the News category object
     * @param object $category_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareCategory($request, $category_object = null) {

        /** Assign category object */
        $category = $this->entity;

        /** If we have choosen category object */
        if($category_object != null) {

            /** Assign the choosen category object */
            $category = $category_object;
        }

        /** Loop in the active languages */
        foreach($this->activeLanguages() as $lang) {

            /** Get current language */
            $lang = strtolower($lang['language']);

            /** If we got request with this language */
            if(isset($request[$lang])) {

                /** Call category content manager */
                $category_content_manager = $this->requestService('zing.component.news.category_content');

                /** Call category url manager */
                $category_url_manager     = $this->requestService('zing.component.news.category_url');

                /** Try to select an category content */
                $category_content = $category_content_manager->getCategoryBy(array(
                    'category' => $category->getId(),
                    'lang'     => $lang
                ));

                /** Try to select an category url */
                $category_url  = $category_url_manager->getCategoryUrlBy(array(
                    'category' => $category->getId(),
                    'lang'     => $lang
                ));

                /** If no category content is found assign a new category content object */
                if($category_content == null) {
                    $category_content = new CategoryContent();
                    $category_content = $category_content->setDateAdded(time());
                }

                /** If no category url is found assign a new category url object */
                if($category_url == null) {
                    $category_url = new \Zing\Component\NewsBundle\Entity\CategoryUrl();
                    $category_url = $category_url->setDateAdded(time());
                }

                /** Set to current category url object a lang */
                $category_url->setLang($lang);

                /** Set to category url object a url */
                $category_url->setUrl($request[$lang]['url']);

                /** Unset the url from request, we dont need it in the content */
                unset($request[$lang]['url']);

                /** Set to category content object a lang */
                $category_content->setLang($lang);

                /** Set to category contetnt object a content */
                $category_content->setContent(json_encode($request[$lang], JSON_UNESCAPED_UNICODE));

                /** Set to category object the category url object */
                $category->setUrl($category_url->setCategory($category)->setDateModified(time()));

                /** Set to category object the category content object */
                $category->setContent($category_content->setCategory($category)->setDateModified(time()));
            }
        }

        /** Assign the non lang category fields */
        $category   ->setName($request['zing_category_display_name'])
                    ->setStatus($request['zing_category_status'])
                    ->setDateModified(time());

        return $category;
    }

    public function getCategoryByUrl($url)
    {
        $category = $this    ->requestService('zing.component.news.category_url')
            ->getCategoryUrlBy(array('url' => str_replace('/news', '', $url)));


        if($category != null) {
            return $category->getCategory();
        }

        return null;
    }

    /** Set a new News category
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setCategory($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareCategory($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created News category
     * @param array $request The form request
     * @param int $category_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateCategory($request, $category_id)
    {
        $this->updateCategoryObject($this->prepareCategory($request, $this->getCategory($category_id)));
        return $this;
    }

    /** Update an News category object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateCategoryObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an category object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertCategoryObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an News category
     * @param $category_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeCategory($category_id)
    {
        $category = $this->getCategory($category_id);

        /** If no menu is found */
        if($category == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($category);
        $manager->flush();
        return $this;
    }

    public function removeCategoryObject($object)
    {
        /** If no News category is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an News category
     * @param int $category_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getCategory($category_id, $array = false)
    {
        $category_id = (int)$category_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :category_id')
                ->setParameter('category_id', $category_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $category = $this->repository->findOneBy(array('id' => $category_id));
        if ($category) {
            /** Return last build in json format */
            return $category;
        }
        return null;
    }

    public function getAllCategoriesByCategoryOrderAndStatus($status = 1)
    {
        return $this->getAllCategories(array('status' => 1), array('category_order' => 'asc'));
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllCategories($by = array(), $order = array('id' => 'asc'))
    {
        $categories = $this->repository->findBy($by, $order);
        if ($categories) {
            /** Get found categories */
            return $categories;
        }
        return array();
    }

    public function getCategoryBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }
        return null;
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
     * @return object News category
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object News category
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