<?php

namespace Zing\Core\PageBundle\Controller;

use Zing\Core\AdminBundle\Controller\AdminController;

class BlockApiAdminController extends AdminController
{
    private $layout_manager;
    private $block_position_manager;
    private $block_content_manager;
    private $block_type_manager;
    private $page_layout_manager;
    private $block_manager;
    private $page_manager;
    private $page_block_manager;
    private $unwanted_block_types = array(
        'image_info'
    );

    public function blockAddContentApiAction()
    {
        /** Get post request */
        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        /** Initilize managers */
        $this->_initManagers();

        /** Api method logic */

        $block_id = (int)$request->get('block');

        /** Block object */
        $block = $this->block_manager->getBlock($block_id);

        /** Check if requested block exists */
        if($block == null) {
            $api_manager->apiResponse(array('error' => 'The requested block was not found'));
        }

        /** Block submited form */
        $block_content_form = $request->get('form');

        /** Parse the form content to array */
        $prepared_form = json_decode($block_content_form, true);

        /** Loop in the form fields */
        foreach($prepared_form as $type => $block_content) {

            if(in_array($type, $this->unwanted_block_types)) {
                continue;
            }

            $block_content_old = $this->block_content_manager->getOneBlockContentBy(array('block' => $block_id, 'lang' => $type), 'desc');

            if($block_content_old == null) {

                $prepare = new \Zing\Core\PageBundle\Entity\BlockContent();
                $prepare_block_content = $prepare   ->setBlock($block)
                    ->setContent(json_encode($block_content, JSON_UNESCAPED_UNICODE))
                    ->setLang($type)
                    ->setStatus(1)
                    ->setDateModified(time())
                    ->setDateAdded(time());

            } else {

                /** Assign the found block content to the prepared block content */
                $prepare_block_content = $block_content_old;

                /** To the prepared(old block content) switch the content with the new one */
                $prepare_block_content->setContent(json_encode($block_content, JSON_UNESCAPED_UNICODE));
            }

            /** Assign to the requested block to the specific content type the prepared content */
            $block->setBlockContent($prepare_block_content);
        }

        /** Merge block content changes */
        $this->block_manager->updateBlockObject($block);
        /** End api method logic */

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $api_manager->apiResponse(array('user_key' => $user_api_key));
    }

    /** Api order blocks
     * @return string Json response
     */
    public function blockOrderApiAction() {
        /** Get post request */
        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        /** Initilize managers */
        $this->_initManagers();

        /** Api method logic */

        $blocks_order = $request->get('blocks_order');

        foreach($blocks_order as $blocks) {
            foreach($blocks as $block) {

                $block_order = (int)$block['order'];
                $block_id = (int)$block['block'];

                $block_position = $this->block_position_manager->getOneBlockPositionBy(array('block' => $block_id));

                /** Check if requested block exists */
                if($block_position == null) {
                    $api_manager->apiResponse(array('error' => 'The requested block was not found'));
                }

                $block_position->setBlockOrder($block_order);
                $this->block_position_manager->updateBlockPositionObject($block_position->setDateModified(time()));
            }
        }

        /** End api method logic */

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $api_manager->apiResponse(array('user_key' => $user_api_key));
    }

    /** Api sort block for current page
     * @return string Json response
     */
    public function blockSortApiAction()
    {
        /** Get post request */
        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        /** Initilize managers */
        $this->_initManagers();

        /** Api method logic */
        $page_id = (int)$request->get('page');
        $block_id = (int)$request->get('block');
        $layout_position = (int)$request->get('position');
        $layout_id = (int)$request->get('layout');

        /** Layout as object */
        $layout = $this->layout_manager->getLayout($layout_id);

        /** Page as object */
        $page = $this->page_manager->getPage($page_id);

        /** Block as object */
        $block = $this->block_manager->getBlock($block_id);

        /** Get current block position */
        $block_position = $this->block_position_manager->getOneBlockPositionBy(array('block' => $block_id), 'desc');

        /** Get a page layout */
        $page_layout = $this->page_layout_manager->getOnePageLayoutBy(array('page' => $page_id, 'layout' => $layout_id), 'desc', 1);

        if($page_layout == null) {

            /** In no page layout relation is found, create a new object */
            $prepared_page_layout = $this->page_layout_manager->preparePageLayout(
                array(
                    'zing_page_layout' => $layout,
                    'zing_page_page' => $page,
                    'zing_page_page_layout_status' => 1
                )
            );

            /** Insert the object */
            $this->page_layout_manager->setPageLayoutObject($prepared_page_layout);

            /** Get the page layout object */
            $page_layout = $this->page_layout_manager->getOnePageLayoutBy(array('page' => $page_id, 'layout' => $layout_id), 'desc', 1);

        }

        if($block_position == null) {

            /** Prepare the block position object */
            $prepared_block_position = $this->block_position_manager->prepareBlockPosition(
                array(
                    'zing_block_block'              => $block,
                    'zing_layout_position'          => $layout_position,
                    'zing_page_layout'              => $page_layout,
                    'zing_block_order'              => 1,
                    'zing_block_position_status'    => 1
                )
            );

            /** If a block is not set on this position */
            $this->block_position_manager->insertBlockPositionObject($prepared_block_position);
        } else {

            /** If block is set on this position update the block position */
            $this->block_position_manager->updateBlockPositionObject($block_position
                    ->setBlockOrder(1)
                    ->setPageLayout($page_layout)
                    ->setLayoutPosition($layout_position)
            );

        }

        /** End api method logic */

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $api_manager->apiResponse(array('user_key' => $user_api_key));
    }

    /** Api add block for current page
     * @return string Json response
     */
    public function blockAddApiAction()
    {
        /** Get post request */
        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        /** Initilize managers */
        $this->_initManagers();

        /** Api method logic */
        $page_id = (int)$request->get('page');
        $block_id = (int)$request->get('block');

        /** Page object */
        $page = $this->page_manager->getPage($page_id);

        /** Block object */
        $block = $this->block_type_manager->getBlockType($block_id);

        /** Prepare a new block object */
        $prepared_block = $this->block_manager->prepareBlock(
            array(
                'zing_block_type' => $block,
                'zing_block_status' => 1
            )
        );

        /** Prepare a new page block relation */
        $page_block = $this->page_block_manager->preparePageBlock(
            array(
                'zing_page_page'            => $page,
                'zing_block_block'          => $prepared_block,
                'zing_page_block_status'    => 1
            )
        );

        /** Set to the block object the page block relation */
        $prepared_block->setBlockRel($page_block->setDateAdded(time()));

        /** Persist the new block and its relation */
        $this->block_manager->setBlockObject($prepared_block);

        /** Get all page block relations by the requested page */
        $rel = $this->page_block_manager->getAllPageBlocksBy(array('page' => $page_id), 'desc', 1);

        /** Render thumb blocks */
        $thumb_block = $this->renderAdmin('ZingCorePageBundle:Default:Layout/thumb_block.html.twig', array(
                'template_file_path'    => $this->block_type_manager->getTemplateFilePath(),
                'page_block'            => $rel
            ), true
        );

        /** End api method logic */

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $api_manager->apiResponse(array('user_key' => $user_api_key, 'thumb_block' => $thumb_block));
    }

    /** Api remove block from current page
     * @return string Json response
     */
    public function blockRemoveApiAction()
    {
        /** Get post request */
        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        /** Initilize managers */
        $this->_initManagers();

        /** Api method logic */
        $page_id = (int)$request->get('page');
        $block_id = (int)$request->get('block');

        /** Check if a requested page block relation exists */
        if($this->page_block_manager->getOnePageBlockBy(array('page' => $page_id, 'block' => $block_id), 'desc') != null) {
            /** If exists remove the requested block */
            $this->block_manager->removeBlock($block_id);
        }

        /** End api method logic */

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $api_manager->apiResponse(array('user_key' => $user_api_key, 'block' => $block_id));
    }

    private function _initManagers() {
        $this->layout_manager           = $this->requestService('zing.core.page.layout');
        $this->block_position_manager   = $this->requestService('zing.core.page.block_position');
        $this->block_content_manager    = $this->requestService('zing.core.page.block_content');
        $this->block_type_manager       = $this->requestService('zing.core.page.block_type');
        $this->page_layout_manager      = $this->requestService('zing.core.page.page_layout');
        $this->block_manager            = $this->requestService('zing.core.page.block');
        $this->page_manager             = $this->requestService('zing.core.page.page');
        $this->page_block_manager       = $this->requestService('zing.core.page.page_block');
    }

    /** Initilize the api manager
     * @param object Post request in object format
     * @return object Api manager
     */
    private function _initilizeApi($request) {

        //$this->dump($this->container->get('request')->request->all());exit;

        /** Get api manager */
        $api_manager = $this->get('zing.core.api.api');

        /** If an user key is not send */
        if(!$request->get('user_key')) {
            $api_manager->apiResponse(array('error' => 'You have no access to this content'));
        }

        /** Get user key */
        $user_api_key = $request->get('user_key');

        /** Return false if key is not correct else return the user object from fos manager */
        $user = $api_manager->authUserByApiKey($user_api_key);

        /** Check if user has access by roles to this content */
        if(!$api_manager->hasUserPermission($user, array('ROLE_ADMIN', 'ROLE_SUPER_ADMIN'))) {
            $api_manager->apiResponse(array('error' => 'You have no access to this content'));
        }

        $api_manager->setUserRuntimeKey($user_api_key);
        $api_manager->setUserRuntimeObject($user);

        return $api_manager;
    }

}