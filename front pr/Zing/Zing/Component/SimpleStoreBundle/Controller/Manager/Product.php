<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\Product as Entity;
use Zing\Component\SimpleStoreBundle\Entity\ProductContent as ProductContent;
use Zing\Component\SimpleStoreBundle\Entity\ProductUrl as ProductUrl;
use Zing\Core\CoreBundle\Plugin\CryptIT;

/** SimpleStore product crud manager */
class Product extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    protected $doctrine;
    /** @var object $entity SimpleStore product entity */
    protected  $entity;
    /** @var string $repository_name Repository name */
    protected $repository_name = 'ZingComponentSimpleStoreBundle:Product';
    /** @var object $repository SimpleStore product repository */
    protected $repository;
    /** @var Cookie for product rating */
    protected $rate_cookie = 'z_p_rate';
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_product_display_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
            'not_blank'   => true
        ),
        'zing_product_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_product_in_stock' => array(
            'label'       => 'In stock',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_product_code' => array(
            'label'       => 'Product code',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_product_price' => array(
            'label'       => 'Price',
            'validation'  => '0-9.',
            'not_blank'   => true
        ),
        'zing_product_discount' => array(
            'label'       => 'Discount',
            'validation'  => '0-9.',
            'not_blank'   => false
        ),
        'zing_product_discount_type' => array(
            'label'       => 'Discount type',
            'validation'  => 'a-zA-Z0-9',
            'not_blank'   => false
        ),
        'zing_product_category' => array(
            'label'       => 'Category',
            'validation'  => '0-9',
            'not_blank'   => true
        ),
        'zing_product_manufacture' => array(
            'label'       => 'Manufacture',
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

    public function getMetaData($product_id)
    {
        $product = $this->getProduct($product_id);

        if(!$product) {return null;}

        $content = $product->getContentByType($this->defaultLanguage()['language']);

        return array(
            'title'         => $content['meta_title'],
            'keywords'      => $content['meta_keywords'],
            'description'   => $content['meta_description']
        );
    }

    public function productRate($product_id, $rate)
    {

        $product = $this->getProduct($product_id);

        if($this->hasRate($product_id)) {return false;}

        if(!$product) {return false;}
        if(!is_numeric($rate)) {return false;}
        if(!is_numeric($product_id)) {return false;}

        if($rate > 5) {$rate = 5;}

        $encrypt = new CryptIT();

        $rate_cookie = false;
        if(isset($_COOKIE[$this->rate_cookie])) {
            $rate_cookie = $_COOKIE[$this->rate_cookie];
        }

        if($rate_cookie) {
            if(in_array($product->getId(), json_decode($encrypt->decrypt($rate_cookie), true))) {
                return false;
            }
        }

        $product->setRating($product->getRating()+$rate);
        $product->setVotes($product->getVotes()+1);
        $this->updateProductObject($product);

        $rate = array($product->getId());

        if($rate_cookie) {
            $rate = array_merge(json_decode($encrypt->decrypt($rate_cookie), true), $rate);
        }

        $cookie = new Cookie($this->rate_cookie, $encrypt->encrypt(json_encode($rate)), time()+(60*60*24*3), '/', $this->currentHttpHost(), false, true);
        $response = new Response();
        $response->headers->setCookie($cookie);
        $response->send();

        return $product->getAverageRating();
    }

    public function hasRate($product_id)
    {
        if(!isset($_COOKIE[$this->rate_cookie])) {
            return false;
        }

        $product = $this->getProduct($product_id);

        if(!$product) {return false;}

        $encrypt = new CryptIT();

        if(in_array($product->getId(), json_decode($encrypt->decrypt($_COOKIE[$this->rate_cookie]), true))) {
            return true;
        }

        return false;
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
            $this->mapper[$lang]['short_description'] = array(
                'label'             => 'Short description '.strtoupper($lang),
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

    public function getProductUrl()
    {
        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $category_from_url = end($category_from_url);

        $url = str_replace('/store', '', '/'.$category_from_url);
        return $url;
    }

    public function getProductByUrl($url)
    {
        $product = $this    ->requestService('zing.component.simplestore.product_url')
                            ->getProductUrlBy(array('url' => str_replace('/store', '', $url)));


        if($product != null) {
            return $product->getProduct();
        }

        return null;
    }

    /** Get all products related to a given category by url */
    public function getProductsByCategoryUrl()
    {
        $category_from_url = array_filter(explode("/", $this->currentPath()));
        $category_from_url = end($category_from_url);

        $url = str_replace('/store', '', '/'.$category_from_url);

        $category_url = $this   ->requestService('zing.component.simplestore.category_url')
                                ->getCategoryUrlBy(array('url' => $url));

        if($category_url == null) {
            throw new NotFoundHttpException('Requested category dose not exists');
        }

        return $category_url->getCategory()->getProduct();
    }

    public function countProducts()
    {
        $categories_id = array();

        if($this->currentPath() != '/store') {

            $category_from_url = array_filter(explode("/", $this->currentPath()));
            $category_from_url = end($category_from_url);

            $url = str_replace('/store', '', '/'.$category_from_url);

            $categories_id = $this ->requestService('zing.component.simplestore.category_url')
                                   ->getChildCategoriesIdsByUrl($url);
        }

        $m = $this->doctrine->getManager()->createQueryBuilder();
        $m->select('COUNT(c.id)');
        $m->where('c.status = 1');

        if(count($categories_id) > 0) {
            $custom_where = 'c.category ='.implode(' OR c.category = ', $categories_id);
            $m->andWhere($custom_where);
        }

        $m->from($this->repository_name, 'c');
        $result = $m->getQuery();
        return $result->getSingleScalarResult();
    }

    public function getProductsFromPagination($offset, $limit)
    {
        $offset = (int)$offset;
        $limit  = (int)$limit;

        $order_type = $this->getPaginationOrderFromGet();

        $query_select = array();
        $query_order = array('c.id', 'ASC');

        if($order_type == 'newest') {
            $query_order = array('c.id', 'DESC');
        }
        elseif($order_type == 'priceup') {
            $query_select[] = '(c.price - c.discount) as HIDDEN price_sort';
            $query_order = array('price_sort', 'ASC');
        }
        elseif($order_type == 'pricedown') {
            $query_select[] = '(c.price - c.discount) as HIDDEN price_sort';
            $query_order = array('price_sort', 'DESC');
        }
        elseif($order_type == 'promoted') {
            $query_order = array('c.discount', 'DESC');
        }

        /** If we got a query select implode array */
        if(count($query_select) > 0) {
            $query_select = ', '.implode(', ', array_filter($query_select));
        } else {
            /** If we dont got a query select set the query select to an empty string */
            $query_select = '';
        }

        $categories_id = array();

        if($this->currentPath() != '/store') {

            $category_from_url = array_filter(explode("/", $this->currentPath()));
            $category_from_url = end($category_from_url);

            $url = str_replace('/store', '', '/'.$category_from_url);

            $categories_id = $this ->requestService('zing.component.simplestore.category_url')
                ->getChildCategoriesIdsByUrl($url);
        }

        if(count($categories_id) > 0) {
            $custom_where = 'AND (c.category ='.implode(' OR c.category = ', $categories_id).')';
        } else {
            $custom_where = '';
        }

        $result = $this->_doctrineManager()
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

    /** Prepare the SimpleStore product object
     * @param object $product_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareProduct($request, $product_object = null)
    {

        /** Assign product object */
        $product = $this->entity;

        /** If we have choosen product object */
        if($product_object != null) {

            /** Assign the choosen product object */
            $product = $product_object;
        }

        /** Loop in the active languages */
        foreach($this->activeLanguages() as $lang) {

            /** Get current language */
            $lang = strtolower($lang['language']);

            /** If we got request with this language */
            if(isset($request[$lang])) {

                /** Call product content manager */
                $product_content_manager    = $this->requestService('zing.component.simplestore.product_content');

                /** Call category url manager */
                $product_url_manager       = $this->requestService('zing.component.simplestore.product_url');

                /** Try to select an product content */
                $product_content = $product_content_manager->getProductBy(array(
                    'product' => $product->getId(),
                    'lang'     => $lang
                ));

                /** Try to select an category url */
                $product_url  = $product_url_manager->getProductUrlBy(array(
                    'product' => $product->getId(),
                    'lang'     => $lang
                ));

                /** If no product content is found assign a new product content object */
                if($product_content == null) {
                    $product_content = new ProductContent();
                    $product_content = $product_content->setDateAdded(time());
                }

                /** If no category url is found assign a new category url object */
                if($product_url == null) {
                    $product_url = new ProductUrl();
                    $product_url = $product_url->setDateAdded(time());
                }

                /** Set to current category url object a lang */
                $product_url->setLang($lang);

                /** Set to category url object a url */
                $product_url->setUrl($request[$lang]['url']);

                /** Unset the url from request, we dont need it in the content */
                unset($request[$lang]['url']);

                /** Set to product content object a lang */
                $product_content->setLang($lang);

                /** Set to product contetnt object a content */
                $product_content->setContent(json_encode($request[$lang], JSON_UNESCAPED_UNICODE));

                /** Set to product object the product content object */
                $product->setContent($product_content->setProduct($product)->setDateModified(time()));

                /** Set to category object the category url object */
                $product->setUrl($product_url->setProduct($product)->setDateModified(time()));
            }
        }

        /** Call product content manager */
        $product_content_manager    = $this->requestService('zing.component.simplestore.product_content');

        /** Try to select an product content */
        $product_static_content = $product_content_manager->getProductBy(array(
            'product'   => $product->getId(),
            'lang'      => 'static'
        ));

        /** If no product content is found assign a new product content object */
        if($product_static_content == null) {
            $product_static_content = new ProductContent();
            $product_static_content = $product_static_content->setDateAdded(time());
        }

        /** Set to product content object a lang */
        $product_static_content->setLang('static');

        /** Set to product contetnt object a content */
        $product_static_content->setContent(json_encode($request['static'], JSON_UNESCAPED_UNICODE));
        $product->setContent($product_static_content->setProduct($product)->setDateModified(time()));

        $category = $this->requestService('zing.component.simplestore.category')->getCategory($request['zing_product_category']);
        $manufacture = $this->requestService('zing.component.simplestore.manufacture')->getManufacture($request['zing_product_manufacture']);

        $product->setCategory($category);
        $product->setManufacture($manufacture);

        /** Prepare the discount if is requested */
        $discount      = 0;
        $discount_type = 0;
        $discount_used = 0;
        if($request['zing_product_discount_type'] == 'procent')
        {
            $discount = ($request['zing_product_discount']/100)*$request['zing_product_price'];
            $discount_type = 'procent';
            $discount_used = $request['zing_product_discount'];
        }
        elseif($request['zing_product_discount_type'] == 'price')
        {
            $discount = $request['zing_product_discount'];
            $discount_type = 'price';
            $discount_used = $request['zing_product_discount'];
        }

        /** Assign the non lang product fields */
        $product    ->setName($request['zing_product_display_name'])
                    ->setCode($request['zing_product_code'])
                    ->setPrice($request['zing_product_price'])
                    ->setCurrency('лв')
                    ->setDiscount($discount)
                    ->setDiscountUsed($discount_used)
                    ->setDiscountType($discount_type)
                    ->setInStockStatus($request['zing_product_in_stock'])
                    ->setStatus($request['zing_product_status'])
                    ->setDateModified(time());

        return $product;
    }

    /** Set a new SimpleStore product
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setProduct($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareProduct($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created SimpleStore product
     * @param array $request The form request
     * @param int $product_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateProduct($request, $product_id)
    {
        $this->updateProductObject($this->prepareProduct($request, $this->getProduct($product_id)));
        return $this;
    }

    /** Update an SimpleStore product object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateProductObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an product object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertProductObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an SimpleStore product
     * @param $product_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeProduct($product_id)
    {
        $product = $this->getProduct($product_id);

        /** If no menu is found */
        if($product == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($product);
        $manager->flush();
        return $this;
    }

    public function removeProductObject($object)
    {
        /** If no SimpleStore product is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an SimpleStore product
     * @param int $product_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getProduct($product_id, $array = false)
    {
        $product_id = (int)$product_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :product_id')
                ->setParameter('product_id', $product_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $product = $this->repository->findOneBy(array('id' => $product_id));
        if ($product) {
            /** Return last build in json format */
            return $product;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllProducts($by = array(), $order = array('id' => 'desc'))
    {
        $categories = $this->repository->findBy($by, $order);
        if ($categories) {
            /** Get found categories */
            return $categories;
        }
        return array();
    }

    public function getProductBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    public function getLastProductsBy($by, $limit = 5)
    {
        $product = $this->repository->findBy($by, array('id' => 'desc'), $limit);
        if ($product) {
            return $product;
        }

        return array();
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object SimpleStore product
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object SimpleStore product
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