<?php
namespace Zing\Core\PageBundle\Controller\Manager;

use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SitemapBundle\SitemapInterface\SitemapInterface;

class Sitemap extends CoreManager implements SitemapInterface
{

    private $prefix = '';

    /**
     * @param object $service_container. Service container
     */
    public function __construct($service_container)
    {
        $this->container = $service_container;
    }

    public function getSitemap()
    {
        $pages = $this->requestService('zing.core.page.page')->getAllPages();

        if(!count($pages) > 0) {
            return array();
        }

        $multilanguage = $this->container->getParameter('zing_settings')['sitemap']['multilanguage'];

        $sitemap = array();
        foreach($this->_language() as $language) {
            $this->_sitemap($pages, $language['language'], $multilanguage, $sitemap[$language['language']]);
        }

        return $sitemap;
    }

    private function _sitemap($pages, $language, $multilanguage, &$sitemap)
    {
           foreach($pages as $page) {

                   /** Get full path */
                   $path = $page->getUrl();

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