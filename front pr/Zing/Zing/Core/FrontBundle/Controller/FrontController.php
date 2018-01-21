<?php

namespace Zing\Core\FrontBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zing\Core\CoreBundle\Controller\CoreController;

class FrontController extends CoreController
{

    /** Render front templates
     * @param string $template Path to template
     * @param array $data Data to be send for the template
     * @return response Render requested template
     */
    public function renderFront($template, $data = array())
    {
        $post_success = false;
        $post_error = false;
        $request = array();

        if($this->getPostRequest()->get('t') != null) {
            $request = $this->postZingRequest();
            if($request) {

                if( isset($request['t']) &&
                    isset($request['b']) &&
                    isset($request['c']) &&
                    isset($request['m']) &&
                    $this->regexMatch('a-zA-Z0-9', $request['t']) &&
                    $this->regexMatch('a-zA-Z0-9_', $request['b']) &&
                    $this->regexMatch('a-zA-Z0-9_', $request['c']) &&
                    $this->regexMatch('a-zA-Z0-9', $request['m'])
                ) {
                 if(!isset($request['non_automatic_submission'])) {

                        $errors = $this->submission($request, $request['t'], $request['b'], $request['c'], $request['m']);

                        if(count($errors) > 0) {
                            $post_error = $errors;
                        } else {
                            $post_success = true;
                        }
                    }
                }
            }
        }

        if($post_success) {
            $request = array();
        }


        $canonical = false;
        $path = $this->currentPath();
        $noindex = (in_array($path, array('/login', '/registration', '/store/checkout')));
        $rel_prev = false;
        $rel_next = false;
        $page = false;
        if(isset($_GET['page'])) {
            $page = (int)$_GET['page'];

            if($page < 1) {
                $page = 1;
            }

            if($page > 1) {
                $rel_prev = $page-1;
            }

            if(isset($data['last_pagination_page']) && $data['last_pagination_page'] > $page) {
                $rel_next = $page+1;
            }

        } elseif(isset($data['has_pagination']) && $data['has_pagination'] == true) {
            $page = 1;

            if(isset($data['last_pagination_page']) && $data['last_pagination_page'] > $page) {
                $rel_next = $page+1;
            }
        }

        if($path && !$noindex) {

            $canonical = $this->currentProtocolHttpHost();
            if($path != '/') {
                $canonical .= $path;
            }

            if($page && $page > 1) {
                $canonical .= '?page='.$page;
            }
        }

        $default_data = array(
            'default_language' => $this->defaultLanguage(),
            'active_languages' => $this->activeLanguages(),
            'post_success'     => $post_success,
            'post_error'       => $post_error,
            'request'          => $request,
            'canonical'        => $canonical,
            'noindex'          => $noindex,
            'rel_prev'         => $rel_prev,
            'rel_next'         => $rel_next,
            'current_year'     => date('Y') // CWS: For use in the copyright text
        );

        //$this->debug(array_merge($default_data, $data));

        return $this->defaultRender($template, array_merge($default_data, $data));
    }

    public function getPageIdByUrl($url)
    {
        $page = $this->requestService('zing.core.page.page')->getPageBy(array('url' => $url));
        if($page == null) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }
        return $page->getId();
    }

    /** Get page by id
     * @param int $page_id Id of the page
     * @return object Page object
     * @throws Exception if page dose not exists
     */
    public function getPageById($page_id)
    {
        $page_id = (int)$page_id;
        $page = $this->requestService('zing.core.page.page')->getPage($page_id);
        if($page == null) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }
        return $page;
    }

    /** Get layout of page by page id
     * @param int $page_id Id of the page that we want to get layout
     * @return object Layout object
     */
    public function getLayout($page_id)
    {
        return $this->getPageLayout($this->getPageById($page_id))->getLayout();
    }

    /** Get all blocks related to a page as keys equals to the layout position
     * @param int $page_id Id of the page that we want to get the related blocks
     * @return array Array of objects with blocks with keys set for layout position
     */
    public function getPageBlocks($page_id)
    {
        return $this->getPageLayout($this->getPageById($page_id))->getActiveBlockPositionByLayoutPositionAsKey();
    }

    /** Check and get front layout file of a page
     * @param object $page_layout object
     * @return string layout file name
     * @throws Exception if layout dose not exists
     */
    public function getFrontLayoutFile($page_layout)
    {
        /** Get page layout manager */
        $page_layout_manager = $this->requestService('zing.core.page.page_layout');

        /** Construct a front layout path */
        $skeleton = $page_layout_manager->getPageLayoutFilePath().'Front/'.$page_layout->getLayoutFile();

        /** If file dose not exists */
        if(!file_exists($skeleton)) {
           throw new NotFoundHttpException('Front page layout dose not exists');
        }

        /** If file is not a file */
        if(!is_file($skeleton)) {
            throw new NotFoundHttpException('Front page layout is not a file');
        }

        /** Return the layout file name */
        return $page_layout->getLayoutFile();
    }

    /** Get page layout relation from page object
     * @param object $page Object
     * @return object page layout relation object
     * @throws Exception if a page layout relation is not found
     */
    public function getPageLayout($page)
    {
        $page_layout = $page->getPageLayout();

        if($page_layout == null) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }

        return $page_layout;
    }

    public function submission($request, $type, $bundle, $manager, $method)
    {
        $manager = $this->requestService('zing.'.$type.'.'.$bundle.'.'.$manager);

        if(!$manager) {
            throw new NotFoundHttpException('Requested manager dose not exists');
        }

        if(!method_exists($manager, $method)) {
            throw new NotFoundHttpException('Requested method in manager dose not exists');
        }

        return $manager->$method($request);
    }

    protected function getMetaData($page_id, $manager)
    {
        if(!$this->requestService($manager)) {
            throw new NotFoundHttpException('Requested manager dose not exists');
        }

        if(!method_exists($this->requestService($manager), 'getMetaData')) {
            throw new NotFoundHttpException('Requested getMetaData method dose not exists in requested manager');
        }

        return $this->requestService($manager)->getMetaData($page_id);
    }

}
