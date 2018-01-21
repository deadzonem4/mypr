<?php

namespace Zing\Core\PageBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class LayoutAdminController extends AdminController
{

    /** Drag and drop block action
     * @param int $page_id Id of the page
     * @return response Template
     */
    public function blockAction($page_id)
    {
        /** Call the necessary manager */
        $layout_manager = $this->get('zing.core.page.layout');
        $page_manager = $this->get('zing.core.page.page');
        $block_type_manager = $this->get('zing.core.page.block_type');
        $page_block_manager = $this->requestService('zing.core.page.page_block');
        $api_manager = $this->get('zing.core.api.api');

        /** Create a user api key */
        $user_api_key = $api_manager->createUserApiKey();

        /** Cast the id to integer */
        $page_id = (int)$page_id;

        /** Get current page */
        $current_page = $page_manager->getPage($page_id);

        /** If you are requested page that dose not exists */
        if($current_page == null) {
            $this->zingRedirect('/admincp/pages');
        }

        /** Get page layout relation */
        $page_layout_rel = $current_page->getPageLayout();

        /** Check if current page has layout */
        if($page_layout_rel == null) {
            $this->zingRedirect('/admincp/pages/layout/page/'.$page_id);
        }

        /** Get page layout */
        $page_layout = $current_page->getPageLayout()->getLayout();

        if(!$page_layout->getStatus()) {
            $this->zingRedirect('/admincp/pages/layout/page/'.$page_id);
        }

        /** Get blocks with position non */
        $rel = $page_block_manager->getOnlyActiveBlocksWithNonPositionByPage($page_id);

        $thumb_block = $this->renderAdmin('ZingCorePageBundle:Default:Layout/thumb_block.html.twig', array(
                'template_file_path'    => $block_type_manager->getTemplateFilePath(),
                'page_block'            => $rel,
            ), true
        );

        $blocks_by_positions = $page_manager->getPage($page_id)->getPageLayout()->getActiveBlockPositionByLayoutPositionAsKey();

//        $this->debug(
//            $this   ->get('zing.component.media.image')
//                    ->getPreviewImages($page_block_manager
//                    ->getAllPageBlocksBy(array('page' => $page_id))[11]
//                    ->getBlock()
//                    ->getContentByType('static')['image'])
//        );

        return $this->renderAdmin('ZingCorePageBundle:Default:Layout/drag_drop.html.twig', array(
            'thumb_block_position_non'  => $thumb_block,
            'page'                      => $page_id,
            'layout'                    => $page_layout,
            'layout_id'                 => $page_layout->getId(),
            'layout_file_path'          => $layout_manager->getLayoutFilePath(),
            'template_file_path'        => $block_type_manager->getTemplateFilePath(),
            'page_block'                => $page_block_manager->getAllPageBlocksBy(array('page' => $page_id)),
            'block_types'               => $block_type_manager->getAllActiveBlockTypes(),
            'user_key'                  => $user_api_key,
            'thumb_blocks_by_positions' => $blocks_by_positions
        ));
    }

    /** Page layout chooser action
     * @param int $page_id Id of the page
     * @return response Template
     */
    public function layoutAction($page_id)
    {
        /** Call the necessary manager */
        $layout_manager = $this->get('zing.core.page.layout');
        $page_manager = $this->get('zing.core.page.page');

        /** Cast the id to integer */
        $page_id = (int)$page_id;

        /** If you are requested page that dose not exists */
        if($page_manager->getPage($page_id) == null) {
            $this->zingRedirect('/admincp/pages');
        }

        $post_request = (array) $this->postZingRequest();
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingCorePageBundle:Default:Layout/index.html.twig', array(
            'page'                  => $page_id,
            'zing_form_errors'      => $errors,
            'layouts'               => $layout_manager->getAllActiveLayouts(),
            'layout_file_path'      => $layout_manager->getLayoutFilePath()
        ));
    }

    /** Handle page layout chooser request
     * @param array $post_request Zing post request
     * @return array If it has caught errors
     */
    private function _handleRequest($post_request)
    {
        /** Call the necessary manager */
        $layout_manager = $this->get('zing.core.page.layout');
        $page_manager = $this->get('zing.core.page.page');
        $page_layout_manager = $this->get('zing.core.page.page_layout');

        $errors = array();


        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {

            if(!isset($post_request['layout'])) {
                $errors[] = 'No layout is choosen';
            }

            if(!isset($post_request['page'])) {
                $errors[] = 'No page is choosen';
            }


            /** If no errors are caught  */
            if(!count($errors) > 0) {

                $layout_id = (int)$post_request['layout'];
                $page_id = (int)$post_request['page'];

                /** If the requested ids are incorrect */
                if($layout_id == 0 || $page_id == 0) {
                    return array_merge($errors, array('Incorrect requested layout'));
                }


                if($layout_manager->getLayout($layout_id) == null) {
                    return array_merge($errors, array('Incorrect requested layout'));
                }

                $page   = $page_manager->getPage($page_id);
                $layout = $layout_manager->getLayout($layout_id);


                /** Remove page layout relation */
                $page_layout = $page_layout_manager->getOnePageLayoutBy(array('page' => $page_id));
                if($page_layout != null) {
                    $page_layout_manager->removePageLayoutObject($page_layout);
                }

                /** Create a new relation */
                $page_layout = $page_layout_manager->preparePageLayout(
                    array(
                        'zing_page_layout'              => $layout,
                        'zing_page_page'                => $page,
                        'zing_page_page_layout_status'  => 1
                    )
                );

                /** Set the new relation from the page manager */
                if($page_manager->setPageLayout($page, $page_layout)) {
                    $this->zingRedirect('/admincp/pages/layout/page/'.$page_id.'/block');
                }


                $this->zingRedirect('/admincp/pages');
            }
        }
        return $errors;
    }

}