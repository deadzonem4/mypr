<?php

namespace Zing\Component\NewsBundle\Controller;

class NewsAdminController extends NewsArticleAdminController
{

    public function indexAction()
    {
        $this->_addStorePages();

        return parent::indexAction();
    }

    private function _addStorePages()
    {

        if($this->requestService('zing.core.page.page')->getPageBy(array('url' => '/news')) == null) {
            $this->_storePage('News', '/news');
        }

        if($this->requestService('zing.core.page.page')->getPageBy(array('url' => '/news/article')) == null) {
            $this->_storePage('News - Article', '/news/article');
        }

        return true;
    }

    private function _storePage($name, $url)
    {
        $this->requestService('zing.core.page.page')->setPage(
            array(
                'zing_page_name'    => $name,
                'zing_page_url'     => $url,
                'zing_page_status'  => 1
            ), true
        );
        return true;
    }
}
