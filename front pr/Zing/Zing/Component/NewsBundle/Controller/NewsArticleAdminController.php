<?php

namespace Zing\Component\NewsBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class NewsArticleAdminController extends AdminController
{
    public function indexAction()
    {
        $news_manager = $this->requestService('zing.component.news.news');
        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentNewsBundle:Default:news/index.html.twig', array(
            'articles'          => $news_manager->getAllNews(),
            'user_key'          => $api_manager->createUserApiKey()
        ));
    }

    public function createAction()
    {
        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentNewsBundle:Default:news/form.html.twig', array_merge(array_merge(array(
                'zing_form_action'  => 'create',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),
            array('post_request' => $post_request)
        ), $post_request));
    }

    public function editAction($article_id)
    {

        $news_manager = $this->requestService('zing.component.news.news');

        $article = $news_manager->getNews($article_id);

        if($article == null) {
            throw new Exception('Requested category dose not exists');
        }

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request, $article_id);

        $post_request = array('article'  => $article);

        $api_manager = $this->get('zing.core.api.api');

        return $this->renderAdmin('ZingComponentNewsBundle:Default:news/form.html.twig', array_merge(array(
                'zing_form_action'  => 'edit',
                'zing_form_errors'  => $errors,
                'user_key'          => $api_manager->createUserApiKey()
            ),  $post_request
        ));
    }

    public function removeAction($article_id)
    {
        $article = $this->requestService('zing.component.news.news')->getNews($article_id);
        if(!$article) {
            throw new Exception('Requested news dose not exists');
        }
        $this->requestService('zing.component.news.news')->removeNewsObject($article);
        $this->zingRedirect('/admincp/news');exit;
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $category_id If you want to update an layout, set the id of the layout
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/store/category
     */
    private function _handleRequest($post_request, $product_id = null)
    {

        $news_manager = $this->requestService('zing.component.news.news');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {

            $errors = $news_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                if($product_id != null){
                    $news_manager->updateNews($post_request, $product_id);
                } else {
                    $news_manager->setNews($post_request);
                }

                $this->zingRedirect('/admincp/news/article');
            }
        }
        return $errors;
    }

}
