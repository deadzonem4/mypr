<?php
namespace Zing\Component\SitemapBundle\Controller\Manager;

use Zing\Core\CoreBundle\Controller\CoreManager;


class BuildSitemap extends CoreManager
{

    private $sitemap = array();
    private $max_urls_per_xml = 45000;

    /**
     * @param object $service_container. Service container
     */
    public function __construct($service_container)
    {
        $this->container = $service_container;
    }

    public function ping($output = false)
    {
        $domain = $this->currentHttpHost();
        $protocol = $this->currentProtocol();

        $google_url = 'http://www.google.com/ping?sitemap='.$protocol.'://'.$domain.'/sitemap.xml';
        $google = @get_headers($google_url);

        $bing_url = 'http://www.bing.com/ping?sitemap='.$protocol.'://'.$domain.'/sitemap.xml';
        $bing = @get_headers($bing_url);

        if($output) {

            echo "\r\n";
            echo "\r\n";
            echo "Ping: ";
            echo "\r\n";

            echo "==============================";
            echo "\r\n";
            echo $google_url;
            echo "\r\n";
            echo "==============================";
            echo "\r\n";
            echo "Google sitemap response headers";
            echo "\r\n";
            echo "==============================";
            echo "\r\n";

            foreach($google as $header) {
                echo $header."\r\n";
            }

            echo "\r\n";
            echo "==============================";
            echo "\r\n";
            echo "\r\n";
            echo "\r\n";
            echo "\r\n";
            echo "\r\n";
            echo "\r\n";
            echo "Ping: ";
            echo "\r\n";

            echo "==============================";
            echo "\r\n";
            echo $bing_url;
            echo "\r\n";
            echo "==============================";
            echo "\r\n";
            echo "Bing sitemap response headers";
            echo "\r\n";
            echo "==============================";
            echo "\r\n";

            foreach($bing as $header) {
                echo $header."\r\n";
            }

            echo "\r\n";
            echo "==============================";
            echo "\r\n";
            echo "\r\n";
        }
    }

    public function sitemap()
    {
        /** Set no time limit for script */
        ini_set('max_execution_time', 0);

        $this->_initSitemap();
        $this->_build();
        $this->ping();

        exit("\r\nSuccess sitemap build\r\n");
    }

    public function sitemapDebug()
    {
        $this->_initSitemap();

        echo "\r\nTOTAL: ".count($this->sitemap)."\r\n";
        echo "==============================";
        echo "\r\n\r\n";

        foreach($this->sitemap as $url => $map) {

            if(!isset($map['lang'])) {
                continue;
            }

            echo "Language: ".$map['lang']."\r\n";
            echo $url."\r\n\r\n";
        }

        echo "\r\n\r\n";
        echo "TOTAL: ".count($this->sitemap);
        exit("\r\n=========================\r\nZing\r\n=========================\r\n");
    }

    private function _initSitemap()
    {
        $managers = $this->container->getParameter('zing_settings')['sitemap']['manager'];

        foreach($managers as $manager) {

            /** Get every manager holding a sitemap relation */
            $sitemap_manager = $this->requestService($manager);

            /** If a manager dose not exists */
            if(!$sitemap_manager) {
                continue;
            }

            $this->_mergeSitemap($sitemap_manager->getSitemap());
        }

        return $this->sitemap;
    }

    private function _mergeSitemap($sitemap)
    {
        foreach($sitemap as $lang => $map) {

            if($map == null) {
                continue;
            }

            $this->sitemap = array_merge($this->sitemap, $map);
        }

        return true;
    }

    private function _xmlFile($sitemap, $part = '')
    {
        $web_dir = $this->container->get('kernel')->getRootDir()."/../web/";
        $handle = fopen($web_dir.'sitemap'.$part.'.xml', "w+");
                  fwrite($handle, $sitemap, strlen($sitemap));
                  fclose($handle);
    }

    private function _build()
    {
        $domain = $this->currentHttpHost();
        $protocol = $this->currentProtocol();
        $last_part = 0;

        /** Split a map on pices by the max urls per xml file */
        $pices = array_chunk($this->sitemap, $this->max_urls_per_xml, true);

        /** Loop in sitemap from language */
        foreach($pices as $k => $url_map) {

          /** Clean xml url loc */
          $xml_url_loc = array();

          foreach($url_map as $url => $map) {

                if(!isset($map['lang'])) {
                    continue;
                }

                $xml_url_loc[] = $this->renderView('ZingComponentSitemapBundle:Default:Sitemap/url_loc.html.twig', array(
                    'url'      => $url,
                    'uri'      => $protocol.'://'.$domain
                ));

            }

            if(count($pices) == 1) {
                /** Assign that no parts are created */
                $k = '';
                $last_part = 'none';
            } else {
                $last_part = $k;
            }

            /** Generate an xml sitemap */
            $this->_xmlFile($this->renderView('ZingComponentSitemapBundle:Default:Sitemap/index.html.twig', array(
                'url_loc'  => $xml_url_loc,
            )), $k);

        }

        /** If we got 2 or more map pices, connect them in one sitemap */
        if($last_part != 'none') {

            /** Generate xml sitemap */
            $this->_xmlFile($this->renderView('ZingComponentSitemapBundle:Default:Sitemap/connect.html.twig', array(
                'last_part' => $last_part,
                'uri'       => $protocol.'://'.$domain
            )));
        }

        return true;
    }

}