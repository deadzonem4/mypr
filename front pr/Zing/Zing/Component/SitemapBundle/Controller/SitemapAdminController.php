<?php
namespace Zing\Component\SitemapBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class SitemapAdminController extends AdminController
{
    public function indexAction()
    {

        $news = $this->requestService('zing.component.news.sitemap')->getSitemap();
        $store = $this->requestService('zing.component.simplestore.sitemap')->getSitemap();
        $cms = $this->requestService('zing.core.page.sitemap')->getSitemap();

        $this->dump($news);
        $this->dump($store);
        $this->dump($cms);

        $sitemap = $this->requestService('zing.component.sitemap.sitemap');

        return $this->renderAdmin('ZingComponentSitemapBundle:Default:index.html.twig', array(
            'sitemap'  => $sitemap->getSitemap(1)
        ));
    }
}
