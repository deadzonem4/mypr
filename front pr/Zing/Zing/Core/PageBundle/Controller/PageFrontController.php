<?php

namespace Zing\Core\PageBundle\Controller;

use Zing\Core\FrontBundle\Controller\FrontController;
use Zing\Core\CoreBundle\Plugin\CryptIT;

class PageFrontController extends FrontController
{
    public function callPageByIdAction($page_id = null)
    {
        if(SITE_STATUS == 'offline') {
            return $this->render('ZingCoreFrontBundle::layout_offline.html.twig');exit;
        }

        $page_id = (int)$page_id;
        return $this->_callPage($page_id);
    }

    public function callPageByUrlAction($page_url = null, $custom_meta = null, $custom_breadcrumb = null, $has_pagination = false, $last_pagination_page = false)
    {

        if(SITE_STATUS == 'offline') {
            return $this->render('ZingCoreFrontBundle::layout_offline.html.twig');exit;
        }

        if($page_url == null) {
            $page_url = '/';
        } else {
            $page_url = '/'.$page_url;
        }

        if($this->_urlRequestedRedirect()) {
            $page_url = $this->_urlRequestedRedirect();
        }

        $page_id = (int)$this->getPageIdByUrl($page_url);

        if(in_array($page_url, array('/store', '/news'))) {
            $has_pagination = true;

            if($page_url == '/store') {

                $pagination_per_page = 12;
                $pagination_range = 3;

                $blocks = $page = $this->getPageById($page_id)->getPageRel();
                foreach($blocks as $block) {
                   $contents = $block->getBlock()->getContentByType('static');
                    if(isset($contents['per_page'])) {
                        $pagination_per_page = (int)$contents['per_page'];
                        $pagination_range = (int)$contents['pagination_range'];
                    }
                }

                $this->requestService('zing.component.simplestore.product')->setPaginationPerPageDefault($pagination_per_page);
                $pagination = $this->requestService('zing.component.simplestore.product')->pagination($pagination_per_page, $pagination_range);

                $last_pagination_page = false;
                if(isset($pagination['pagination']) &&
                    isset($pagination['pagination']['pagination_links']) &&
                    isset($pagination['pagination']['pagination_links']['last_page']) &&
                    isset($pagination['pagination']['pagination_links']['last_page']['link'])
                ) {
                    $last_pagination_page = $pagination['pagination']['pagination_links']['last_page']['link'];
                }

                if(isset($pagination['pagination']) &&
                    isset($pagination['pagination']['pagination_links']) &&
                    isset($pagination['pagination']['pagination_links']['frw']) &&
                    isset($pagination['pagination']['pagination_links']['frw']['link'])
                ) {
                    $last_pagination_page = $pagination['pagination']['pagination_links']['frw']['link'];
                }

            } elseif($page_url == '/news') {

                $pagination_per_page = 12;
                $pagination_range = 3;

                $blocks = $page = $this->getPageById($page_id)->getPageRel();
                foreach($blocks as $block) {
                    $contents = $block->getBlock()->getContentByType('static');
                    if(isset($contents['per_page'])) {
                        $pagination_per_page = (int)$contents['per_page'];
                        $pagination_range = (int)$contents['pagination_range'];
                    }
                }

                $this->requestService('zing.component.news.news')->setPaginationPerPageDefault($pagination_per_page);
                $pagination = $this->requestService('zing.component.news.news')->pagination($pagination_per_page, $pagination_range);

                $last_pagination_page = false;
                if(isset($pagination['pagination']) &&
                    isset($pagination['pagination']['pagination_links']) &&
                    isset($pagination['pagination']['pagination_links']['last_page']) &&
                    isset($pagination['pagination']['pagination_links']['last_page']['link'])
                ) {
                    $last_pagination_page = $pagination['pagination']['pagination_links']['last_page']['link'];
                }

                if(isset($pagination['pagination']) &&
                    isset($pagination['pagination']['pagination_links']) &&
                    isset($pagination['pagination']['pagination_links']['frw']) &&
                    isset($pagination['pagination']['pagination_links']['frw']['link'])
                ) {
                    $last_pagination_page = $pagination['pagination']['pagination_links']['frw']['link'];
                }

            }


        }

        return $this->_callPage($page_id, $custom_meta, $custom_breadcrumb, $has_pagination, $last_pagination_page);
    }

    private function _callPage($page_id, $custom_meta = null, $custom_breadcrumb = null, $has_pagination = false, $last_pagination_page = false)
    {

        /** Get the layout object */
        $page_layout = $this->getLayout($page_id);

        /** Get all blocks related to this page */
        $page_blocks = $this->getPageBlocks($page_id);

        /** Check and get the front layout related to this page */
        $front_layout_file = $this->getFrontLayoutFile($page_layout);

        $page = $this->getPageById($page_id);
        $index_page = $this->getPageById($this->getPageIdByUrl('/'));
        $breadcrumb = array();

        /** Home */
        $breadcrumb[$index_page->getName()] = $index_page->getUrl();

        $page_url_pieces = array_values(array_filter(explode('/', $page->getUrl())));

        $breadcrumb_pices = array();
        foreach($page_url_pieces as $part) {
          array_pop($page_url_pieces);

          if(!count($page_url_pieces) > 0) {
            continue;
          }

          $part_page = $this->getPageById($this->getPageIdByUrl('/'.implode('/', $page_url_pieces)));
          $breadcrumb_pices[$part_page->getName()] = $part_page->getUrl();
        }

        /** Pieces */
        $breadcrumb = array_merge($breadcrumb, array_reverse($breadcrumb_pices));

        if($custom_breadcrumb != null) {
            $breadcrumb = array_merge($breadcrumb, $custom_breadcrumb);
        } else {

            /** Current page */
            $breadcrumb[$page->getName()] = $page->getUrl();
        }

        $meta = $this->getMetaData($page_id, 'zing.core.page.page');

        if($custom_meta != null) {$meta = $custom_meta;}

        $valid_meta = true;

        if(!is_array($meta)) {
            $valid_meta = false;
        } else {
            foreach($meta as $name => $value) {
                if($value == null) {
                    $valid_meta = false;
                }
            }
        }

        if($valid_meta == false) {
            $settings = $this->requestService('zing.core.setting.setting');
            $last_build = $settings->bundle('SettingBundle');
            if($last_build) {
                if(isset($last_build['zing_setting_seo'][$this->defaultLanguage()['language']])) {
                    $defult_seo = $last_build['zing_setting_seo'][$this->defaultLanguage()['language']];
                    $meta = array(
                        'title'         => $defult_seo['title'],
                        'keywords'      => $defult_seo['keywords'],
                        'description'   => $defult_seo['description']
                    );
                }
            }
        }

        $settings = $this->requestService('zing.core.setting.setting');
        $last_build = $settings->bundle('SettingBundle');
        $google_analytics = $last_build['zing_setting_google_analytics'];

        return $this->renderFront('ZingCorePageBundle:Default:Available/Layout/Front/'.$front_layout_file,
            array(
                'blocks'            => $page_blocks,
                'meta'              => $meta,
                'breadcrumb'        => $breadcrumb,
                'google_analytics'  => $google_analytics,
                'has_pagination'    => $has_pagination,
                'last_pagination_page'  => $last_pagination_page
            ));

    }

    private function _urlRequestedRedirect()
    {
        $crypt_it = new CryptIT();
        if(isset($_GET['r'])) {return $crypt_it->decodeUrl($_GET['r']);}
        return false;
    }

}
