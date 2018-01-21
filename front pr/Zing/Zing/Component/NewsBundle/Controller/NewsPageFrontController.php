<?php
namespace Zing\Component\NewsBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zing\Core\PageBundle\Controller\PageFrontController;

class NewsPageFrontController extends PageFrontController
{

    public function validateCategorySeoRoute($seo_route)
    {
        $routes = array_filter(explode('/', $seo_route));
        $childs = $this->requestService('zing.component.news.category_url')->getParentCategoriesIdsByUrl('/'.end($routes));

        $url = '';
        foreach($childs as $id) {
            $category = $this->requestService('zing.component.news.category')->getCategoryBy(array(
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

        $product_obj = $this->requestService('zing.component.news.news')->getNewsByUrl('/'.$product);
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

        if($this->requestService('zing.component.news.category')
                ->getCategoryByUrl(array('url' => '/'.$last)) != null) {

            $seo_route = $this->validateCategorySeoRoute($seo_route);

            /** Get requested category */
            $category = $this->requestService('zing.component.news.category')
                ->getCategoryByUrl(array('url' => '/'.$seo_route));

            /** Get meta data for requested category */
            $meta = $this->getMetaData($category->getId(), 'zing.component.news.category');

            $breadcrumb = array();
            $temp_url = '/news/';
            $breadcrumb[$this->getPageById($this->getPageIdByUrl('/news'))->getName()] = '/news';
            foreach($frr as $k => $b) {
                $category = $this->requestService('zing.component.news.category')->getCategoryByUrl('/'.$b);
                if($category != null) {
                    if(!isset($frr[$k+1])) {
                        $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b;
                    } else {
                        $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b.'/';
                    }

                }
            }

            $meta['title'] = implode(' | ', array_values(array_filter(array_keys(array_reverse(array_merge(array($this->requestService('zing.core.setting.setting')->bundle('SettingBundle')['zing_setting_seo'][$this->defaultLanguage()['language']]['title'] => '/'), $breadcrumb))))));

            return $this->callPageByUrlAction('news', $meta, $breadcrumb);
        }

        if($this->requestService('zing.component.news.news')
                ->getNewsByUrl(array('url' => '/'.$last)) != null) {

            $seo_route = $this->validateProductSeoRoute($seo_route);

            /** Get requested news */
            $news = $this->requestService('zing.component.news.news')
                ->getNewsByUrl(array('url' => '/'.$seo_route));

            /** Get meta data for requested news */
            $meta = $this->getMetaData($news->getId(), 'zing.component.news.news');

            $breadcrumb = array();
            $temp_url = '/news/';
            $breadcrumb[$this->getPageById($this->getPageIdByUrl('/news'))->getName()] = '/news';
            foreach($frr as $k => $b) {
                $category = $this->requestService('zing.component.news.category')->getCategoryByUrl('/'.$b);
                if($category != null) {
                  if(!isset($frr[$k+1])) {
                    $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b;
                  } else {
                    $breadcrumb[$category->getContentByType('bg')['name']] = $temp_url .= $b.'/';
                  }
                }
            }

            $breadcrumb[$news->getContentByType('bg')['title']] = $temp_url.$news->getUrlByType('bg');

            $meta['title'] = implode(' | ', array_values(array_filter(array_keys(array_reverse(array_merge(array($this->requestService('zing.core.setting.setting')->bundle('SettingBundle')['zing_setting_seo'][$this->defaultLanguage()['language']]['title'] => '/'), $breadcrumb))))));

            return $this->callPageByUrlAction('news/article', $meta, $breadcrumb);
        }

        throw new NotFoundHttpException('Requested page dose not exists');
    }

}
