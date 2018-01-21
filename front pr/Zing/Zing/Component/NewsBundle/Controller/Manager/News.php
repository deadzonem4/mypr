<?php
namespace Zing\Component\NewsBundle\Controller\Manager;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\NewsBundle\Entity\News as Entity;
use Zing\Component\NewsBundle\Entity\NewsContent as NewsContent;
use Zing\Component\NewsBundle\Entity\NewsUrl as NewsUrl;

/** news news crud manager */
class News extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    protected $doctrine;
    /** @var object $entity news news entity */
    protected  $entity;
    /** @var string $repository_name Repository name */
    protected $repository_name = 'ZingComponentNewsBundle:News';
    /** @var object $repository news news repository */
    protected $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_news_article_display_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
            'not_blank'   => true
        ),
        'zing_news_article_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_news_article_category' => array(
            'label'       => 'Category',
            'validation'  => '0-9',
            'not_blank'   => true
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

            $this->mapper[$lang]['title'] = array(
                'label'       => 'title '.strtoupper($lang),
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
                'not_blank'         => true
            );
            $this->mapper[$lang]['meta_keywords'] = array(
                'label'             => 'Meta keywords '.strtoupper($lang),
                'validation'        => 'а-яА-Яa-zA-Z0-9_|,&\-\s',
                'not_blank'         => true
            );
            $this->mapper[$lang]['meta_description'] = array(
                'label'             => 'Meta description '.strtoupper($lang),
                'validation'        => false,
                'not_blank'         => true
            );
        }
    }

    public function getMetaData($news_id)
    {
        $news = $this->getNews($news_id);

        if(!$news) {return null;}

        $content = $news->getContentByType($this->defaultLanguage()['language']);

        return array(
            'title'         => $content['meta_title'],
            'keywords'      => $content['meta_keywords'],
            'description'   => $content['meta_description']
        );
    }

    public function getNewsUrl()
    {
        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $category_from_url = end($category_from_url);
        $url = str_replace('/news', '', '/'.$category_from_url);
        return $url;
    }

    public function getNewsByUrl($url)
    {
        $news = $this    ->requestService('zing.component.news.news_url')
            ->getNewsUrlBy(array('url' => str_replace('/news', '', $url)));

        if($news != null) {
            return $news->getNews();
        }

        return null;
    }

    public function getMeCurrentPath()
    {
        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $category_from_url = end($category_from_url);
        $url = str_replace('/news', '', '/'.$category_from_url);
        return $url;
    }

    /** Get all news related to a given category by url */
    public function getNewsByCategoryUrl($last_news = false)
    {
        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $category_from_url = end($category_from_url);

        $url = str_replace('/news', '', '/'.$category_from_url);

        if(empty($url)) {
            return $this->getNewsBy(array());
        }

        $category_url = $this   ->requestService('zing.component.news.category_url')
                                ->getCategoryUrlBy(array('url' => $url));

        if($category_url == null) {
            throw new NotFoundHttpException('Requested category dose not exists');
        }

        if($last_news) {
            return $this->getNewsBy(array('category' => $category_url->getCategory()->getId()));
        }

        return $category_url->getCategory()->getNews();
    }

    public function countProducts()
    {
        return $this->countNews();
    }

    public function countNews()
    {
        $categories_id = array();

        $url = array_filter(explode("/", $this->currentPath()));
        $url = '/'.end($url);

        if($url != '/news') {
            $categories_id = $this ->requestService('zing.component.news.category_url')
                ->getChildCategoriesIdsByUrl($url);
        }

        $m = $this->doctrine->getManager()->createQueryBuilder();
        $m->select('COUNT(c.id)');

        if(count($categories_id) > 0) {
            $custom_where = 'c.category ='.implode(' OR c.category = ', $categories_id);
            $m->where($custom_where);
        }

        $m->from($this->repository_name, 'c');
        $result = $m->getQuery();

        return $result->getSingleScalarResult();
    }

    public function getNewsFromPagination($offset, $limit)
    {
        $offset = (int)$offset;
        $limit  = (int)$limit;

        $order_type = $this->getPaginationOrderFromGet();

        $query_select = array();
        $query_order = array('c.id', 'DESC'); // was ASC

        if($order_type == 'newest') {
            $query_order = array('c.id', 'DESC');
        }


        /** If we got a query select implode array */
        if(count($query_select) > 0) {
            $query_select = ', '.implode(', ', array_filter($query_select));
        } else {
            /** If we dont got a query select set the query select to an empty string */
            $query_select = '';
        }

        $categories_id = array();

        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $url = '/'.end($category_from_url);

        //$url = str_replace('/news', '', '/'.$category_from_url);

        if($url != '/news') {
            $categories_id = $this ->requestService('zing.component.news.category_url')
                                   ->getChildCategoriesIdsByUrl($url);
        }

        if(count($categories_id) > 0) {
            $custom_where = 'AND (c.category ='.implode(' OR c.category = ', $categories_id).')';
        } else {
            $custom_where = '';
        }

        $result = $this ->_doctrineManager()
                        ->createQueryBuilder()
                        ->select('c'.$query_select)
                        ->from($this->repository_name, 'c')
                        ->where('c.status = 1'.$custom_where)
                        ->orderBy($query_order[0], $query_order[1])
                        ->setFirstResult($offset)
                        ->setMaxResults($limit)
                        ->getQuery();

        return $result->getResult();
    }

    /** Prepare the news news object
     * @param object $news_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareNews($request, $news_object = null)
    {

        /** Assign news object */
        $news = $this->entity;

        /** If we have choosen news object */
        if($news_object != null) {

            /** Assign the choosen news object */
            $news = $news_object;
        }

        /** Loop in the active languages */
        foreach($this->activeLanguages() as $lang) {

            /** Get current language */
            $lang = strtolower($lang['language']);

            /** If we got request with this language */
            if(isset($request[$lang])) {

                /** Call news content manager */
                $news_content_manager    = $this->requestService('zing.component.news.news_content');

                /** Call category url manager */
                $news_url_manager       = $this->requestService('zing.component.news.news_url');

                /** Try to select an news content */
                $news_content = $news_content_manager->getNewsBy(array(
                    'news' => $news->getId(),
                    'lang'     => $lang
                ));

                /** Try to select an category url */
                $news_url  = $news_url_manager->getNewsUrlBy(array(
                    'news' => $news->getId(),
                    'lang'     => $lang
                ));

                /** If no news content is found assign a new news content object */
                if($news_content == null) {
                    $news_content = new NewsContent();
                    $news_content = $news_content->setDateAdded(time());
                }

                /** If no category url is found assign a new category url object */
                if($news_url == null) {
                    $news_url = new NewsUrl();
                    $news_url = $news_url->setDateAdded(time());
                }

                /** Set to current category url object a lang */
                $news_url->setLang($lang);

                /** Set to category url object a url */
                $news_url->setUrl($request[$lang]['url']);

                /** Unset the url from request, we dont need it in the content */
                unset($request[$lang]['url']);

                /** Set to news content object a lang */
                $news_content->setLang($lang);

                /** Set to news contetnt object a content */
                $news_content->setContent(json_encode($request[$lang], JSON_UNESCAPED_UNICODE));

                /** Set to news object the news content object */
                $news->setContent($news_content->setNews($news)->setDateModified(time()));

                /** Set to category object the category url object */
                $news->setUrl($news_url->setNews($news)->setDateModified(time()));
            }
        }

        /** Call news content manager */
        $news_content_manager    = $this->requestService('zing.component.news.news_content');

        /** Try to select an news content */
        $news_static_content = $news_content_manager->getNewsBy(array(
            'news'   => $news->getId(),
            'lang'      => 'static'
        ));

        /** If no news content is found assign a new news content object */
        if($news_static_content == null) {
            $news_static_content = new NewsContent();
            $news_static_content = $news_static_content->setDateAdded(time());
        }

        /** Set to news content object a lang */
        $news_static_content->setLang('static');

        /** Set to news contetnt object a content */
        $news_static_content->setContent(json_encode($request['static'], JSON_UNESCAPED_UNICODE));
        $news->setContent($news_static_content->setNews($news)->setDateModified(time()));

        $category = $this->requestService('zing.component.news.category')->getCategory($request['zing_news_article_category']);

        $news->setCategory($category);

        /** Assign the non lang news fields */
        $news       ->setName($request['zing_news_article_display_name'])
                    ->setAuthor($request['zing_news_article_author'])
                    ->setStatus($request['zing_news_article_status'])
                    ->setDateModified(time());

        return $news;
    }

    /** Set a new news news
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setNews($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareNews($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created news news
     * @param array $request The form request
     * @param int $news_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateNews($request, $news_id)
    {
        $this->updateNewsObject($this->prepareNews($request, $this->getNews($news_id)));
        return $this;
    }

    /** Update an news news object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateNewsObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an news object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertNewsObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an news news
     * @param $news_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeNews($news_id)
    {
        $news = $this->getNews($news_id);

        /** If no menu is found */
        if($news == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($news);
        $manager->flush();
        return $this;
    }

    public function removeNewsObject($object)
    {
        /** If no news news is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an news news
     * @param int $news_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getNews($news_id, $array = false)
    {
        $news_id = (int)$news_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :news_id')
                ->setParameter('news_id', $news_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $news = $this->repository->findOneBy(array('id' => $news_id));
        if ($news) {
            /** Return last build in json format */
            return $news;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllNews($by = array(), $order = array('id' => 'asc'))
    {
        $categories = $this->repository->findBy($by, $order);
        if ($categories) {
            /** Get found categories */
            return $categories;
        }
        return array();
    }

    public function getNewsBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    public function getLastNewsBy($by, $limit = 5)
    {
        $news = $this->repository->findBy($by, array('id' => 'desc'), $limit);
        if ($news) {
            return $news;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object news news
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object news news
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