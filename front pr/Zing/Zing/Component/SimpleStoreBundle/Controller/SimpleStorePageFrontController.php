<?php

namespace Zing\Component\SimpleStoreBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zing\Core\PageBundle\Controller\PageFrontController;

class SimpleStorePageFrontController extends PageFrontController
{

    public function validateCategorySeoRoute($seo_route)
    {
        $routes = array_filter(explode('/', $seo_route));
        $childs = $this->requestService('zing.component.simplestore.category_url')->getParentCategoriesIdsByUrl('/'.end($routes));

        $url = '';
        foreach($childs as $id) {
            $category = $this->requestService('zing.component.simplestore.category')->getCategoryBy(array(
                'id' => $id
            ));

            $url .= $category->getUrlByType($this->myLocale());
        }
        $seo_route = '/'.$seo_route;

        if($url != $seo_route) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }

        return end($routes);
    }

    public function validateProductSeoRoute($seo_route)
    {
        $parsed = array_filter(explode('/', $seo_route));
        $product = array_pop($parsed);

        if(!count($parsed) > 0) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }

        $this->validateCategorySeoRoute(implode('/', $parsed));

        $product_obj = $this->requestService('zing.component.simplestore.product')->getProductByUrl('/'.$product);
        if($product_obj == null) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }

        if($product_obj->getCategory()->getUrlByType('bg') != '/'.end($parsed)) {
            throw new NotFoundHttpException('Requested page dose not exists');
        }

        return $product;
    }

    public function indexAction($seo_route)
    {

        $frr = array_filter(explode('/', $seo_route));
        $parsed = $frr;
        $last = array_pop($parsed);

        if($this->requestService('zing.component.simplestore.category')
                ->getCategoryByUrl(array('url' => '/'.$last)) != null) {

            $seo_route = $this->validateCategorySeoRoute($seo_route);

            /** Get requested category */
            $category = $this->requestService('zing.component.simplestore.category')
                ->getCategoryByUrl(array('url' => '/'.$seo_route));

            /** Get meta data for requested category */
            $meta = $this->getMetaData($category->getId(), 'zing.component.simplestore.category');

            $breadcrumb = array();
            $temp_url = '/store/';
            $breadcrumb[$this->getPageById($this->getPageIdByUrl('/store'))->getName()] = '/store';
            foreach($frr as $k => $b) {
                $category = $this->requestService('zing.component.simplestore.category')->getCategoryByUrl('/'.$b);
                if($category != null) {
                    if(!isset($frr[$k+1])) {
                        $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b;
                    } else {
                        $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b.'/';
                    }

                }
            }

            $meta['title'] = implode(' | ', array_values(array_filter(array_keys(array_reverse(array_merge(array($this->requestService('zing.core.setting.setting')->bundle('SettingBundle')['zing_setting_seo'][$this->defaultLanguage()['language']]['title'] => '/'), $breadcrumb))))));

            return $this->callPageByUrlAction('store', $meta, $breadcrumb, true);
        }

        if($this->requestService('zing.component.simplestore.product')
                ->getProductByUrl(array('url' => '/'.$last)) != null) {

            $seo_route = $this->validateProductSeoRoute($seo_route);

            /** Handle cart request */
            $this->requestService('zing.component.simplestore.product_cart')
                ->handleRequest();

            /** Get requested product */
            $product = $this->requestService('zing.component.simplestore.product')
                ->getProductByUrl(array('url' => '/'.$seo_route));

            if($product->getStatus() != 1) {
                throw new NotFoundHttpException('Requested page dose not exists');
            }

            /** Get meta data for requested product */
            $meta = $this->getMetaData($product->getId(), 'zing.component.simplestore.product');

            $breadcrumb = array();
            $temp_url = '/store/';
            $breadcrumb[$this->getPageById($this->getPageIdByUrl('/store'))->getName()] = '/store';
            foreach($frr as $k => $b) {
                $category = $this->requestService('zing.component.simplestore.category')->getCategoryByUrl('/'.$b);
                if($category != null) {
                    if(!isset($frr[$k+1])) {
                        $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b;
                    } else {
                        $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b.'/';
                    }
                }
            }

            $breadcrumb[$product->getContentByType('bg')['title']] = $temp_url.str_replace('/', '', $product->getUrlByType('bg'));
            $meta['title'] = implode(' | ', array_values(array_filter(array_keys(array_reverse(array_merge(array($this->requestService('zing.core.setting.setting')->bundle('SettingBundle')['zing_setting_seo'][$this->defaultLanguage()['language']]['title'] => '/'), $breadcrumb))))));

            return $this->callPageByUrlAction('store/product', $meta, $breadcrumb);
        }

        if($seo_route == 'checkout') {

            /** Handle cart request */
            $this->requestService('zing.component.simplestore.product_cart')
                 ->handleRequest();

            return $this->callPageByUrlAction('store/checkout');
        }

        /** Used for ajax request */
        if($seo_route == 'product-rate') {

            $response = $this   ->requestService('zing.component.simplestore.product')
                                ->productRate((int)$_POST['idBox'], $_POST['rate']);

            if(!$response) {echo json_encode('false');exit;}

            echo json_encode(array('rate' => $response));exit;
        }

        throw new NotFoundHttpException('Requested page dose not exists');
    }

}
