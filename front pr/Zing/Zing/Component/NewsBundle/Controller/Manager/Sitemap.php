<?php
namespace Zing\Component\NewsBundle\Controller\Manager;

use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SitemapBundle\SitemapInterface\SitemapInterface;

class Sitemap extends CoreManager implements SitemapInterface
{

    private $prefix = '/news';

    /**
     * @param object $service_container. Service container
     */
    public function __construct($service_container)
    {
        $this->container = $service_container;
    }

    public function getSitemap()
    {
        /** Get top parent categories */
        $categories = $this->requestService('zing.component.news.category')->getAllCategories(array('parent' => null));

        /** If no categories are found */
        if(!count($categories) > 0) {
            return array();
        }

        $multilanguage = $this->container->getParameter('zing_settings')['sitemap']['multilanguage'];

        $category_url_manager = $this->requestService('zing.component.news.category_url');

        $sitemap = array();
        foreach($this->_language() as $language) {
            $this->_sitemap($categories, $language['language'], $multilanguage, $category_url_manager, $sitemap[$language['language']]);
        }

        return $sitemap;
    }

    private function _sitemap($categories, $language, $multilanguage, $category_url_manager, &$sitemap)
    {
           foreach($categories as $category) {

                    if(!$category->getUrlByType($language)) {
                        continue;
                    }

                   /** Get full path */
                   $path = $category_url_manager->fullCategoryPath($category->getUrlByType($language));

                   /** Hold parent url */
                   $url = '/'.$language.$this->prefix.$path;

                   /** If multilanguage is requested */
                   if(!$multilanguage) {
                       $url = $this->prefix.$path;
                   }

                   /** Save url to the sitemap holder */
                   $sitemap[$url] = array('lang' => $language);

                   /** If category has child */
                   if(count($category->getChild()) > 0) {

                       /** Assign to the url its childs urls */
                       array_merge($sitemap[$url], $this->_sitemap($category->getChild(), $language, $multilanguage, $category_url_manager, $sitemap));
                   }

                   $this->_sitemapCategoryProduct($category, $language, $multilanguage, $category_url_manager, $sitemap);
           }

        return $sitemap;
    }


    private function _sitemapCategoryProduct($category, $language, $multilanguage, $category_url_manager, &$sitemap)
    {
        foreach($category->getNews() as $product) {

            if(!$product->getUrlByType($language)) {
                continue;
            }

            /** Get full path */
            $path = $category_url_manager->fullCategoryPath($category->getUrlByType($language)).$product->getUrlByType($language);

            /** Hold parent url */
            $url = '/'.$language.$this->prefix.$path;

            /** If multilanguage is requested */
            if(!$multilanguage) {
                $url = $this->prefix.$path;
            }

            /** Save url to the sitemap holder */
            $sitemap[$url] = array('lang' => $language);

        }

        return $sitemap;
    }


    private function _language()
    {
        return $this->activeLanguages();
    }

}