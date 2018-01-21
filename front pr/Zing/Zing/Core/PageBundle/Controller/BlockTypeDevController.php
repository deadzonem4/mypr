<?php
namespace Zing\Core\PageBundle\Controller;

use Zing\Core\AdminBundle\Controller\DevAdminController;

/** Zing
 * BlockType development controller
 */
class BlockTypeDevController extends DevAdminController {

    /** Render all saved block_types */
    public function blockTypeAction()
    {
       $block_type_manager = $this->get('zing.core.page.block_type');

       /** Use the table action */
        $block_type_manager->multiplyTableAction((array) $this->postZingRequest());

       return $this->renderAdmin('ZingCorePageBundle:Default:Dev/BlockType/index.html.twig',
           array('block_types' => $block_type_manager->getAllBlockTypes())
       );
    }

    /** Edit an block_type
     * @param int $block_type_id. BlockType for updating
     * @return response Render form for updateing a block_type
     */
    public function editAction($block_type_id)
    {
        $block_type_manager = $this->get('zing.core.page.block_type');

        $post_request = (array) $this->postZingRequest();
        $errors = $this->_handleRequest($post_request, $block_type_id);

        $response = array();

        /** Get requested block_type */
        $block_type = $block_type_manager->getBlockType($block_type_id);

        if($block_type != null) {
            $response['zing_block_type_name'] = $block_type->getName();
            $response['zing_block_type_template_name'] = $block_type->getTemplateName();
            $response['zing_block_type_status'] = $block_type->getStatus();
        }

        return $this->renderAdmin('ZingCorePageBundle:Default:Dev/BlockType/form.html.twig',
            array_merge(
                array(
                    'zing_form_action' => 'Edit',
                    'zing_form_errors' => $errors,
                    'zing_supported_blocks_templates' => $block_type_manager->getSupportedBlockTypes(),
                ),
                $response));
    }

    /** Create a new block_type and save it
     * @return response Form for creating a new block_type
     */
    public function createAction()
    {
        $block_type_manager = $this->get('zing.core.page.block_type');

        /** Capture zing form request */
        $post_request = (array) $this->postZingRequest();

        /** Handle the request */
        $errors = $this->_handleRequest($post_request);

        return $this->renderAdmin('ZingCorePageBundle:Default:Dev/BlockType/form.html.twig', array_merge(
            array(
                'zing_form_action' => 'Create',
                'zing_form_errors' => $errors,
                'zing_supported_blocks_templates' => $block_type_manager->getSupportedBlockTypes(),
            ),
            $post_request
        ));
    }

    /** Remove a block_type
     * @param int $block_type_id Id of the block_type that we want to remove
     */
    public function removeAction($block_type_id)
    {
        $this->get('zing.core.page.block_type')->removeBlockType($block_type_id);
        $this->zingRedirect('/admincp/dev/blocktype');
    }

    /** Handle the form request, ADD and EDIT request
     * @param array $post_request Form submission request
     * @param int $block_type_id If you want to update an block_type, set the id of the block_type
     * @return Errors if are caught from the form validation else on success redirects to the /admincp/dev/block_type
     */
    private function _handleRequest($post_request, $block_type_id = null)
    {
        $block_type_manager = $this->get('zing.core.page.block_type');

        $errors = array();

        /** If request if zing request is submitted */
        if(count($post_request) > 0 ) {
            $errors = $block_type_manager->validateRequest($post_request);

            /** If no errors are caught  */
            if(!count($errors) > 0) {

                /** Check if requested template exists in admin */
                if(!$block_type_manager->isTemplateExists($post_request['zing_block_type_template_name'], 'admin')) {
                    $errors = array_merge($errors, array('The file dose not exists in Template/Admin folder'));
                }

                /** Check if requested template exists in front */
                if(!$block_type_manager->isTemplateExists($post_request['zing_block_type_template_name'], 'front')) {
                    $errors = array_merge($errors, array('The file dose not exists in Template/Front folder'));
                }

                if(count($errors) > 0) {
                    return $errors;
                }

                if($block_type_id != null) {
                    /** Set the new block_type */
                    $block_type_manager->updateBlockType($post_request, $block_type_id);
                } else {
                    /** Set the new block_type */
                    $block_type_manager->setBlockType($post_request);
                }

                $this->zingRedirect('/admincp/dev/blocktype');
            }
        }
        return $errors;
    }
} 