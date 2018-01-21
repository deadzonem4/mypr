<?php

namespace Zing\Component\MediaBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zing\Component\MediaBundle\Exceptions\HBimagesException as HBimagesException;
use Zing\Core\CoreBundle\Controller\CoreController;

/**
 * HBimages v1.0
 * Plugin for proceeding images with PHP - released under MIT License
 * Copyright (c) 2013 Hristo Boyarov
 * https://boyarov.bg/
 *
 *
 * HBimages plugin.
 *  You can find examples and instruction on how to use on web page:
 *  http://boyarov.bg/
 *
 * @author Hristo Boyarov <hristo939393@gmail.com>
 *
 */
class MediaImageApiController extends CoreController
{

    private $base_dir = 'zing_upload/';

    public function __construct($cache = false)
    {
        $this->_noCache($cache);
        return true;
    }


    public function imageRemoveAction($random)
    {

        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        $media_image_manager = $this->requestService('zing.component.media.image');
        $image_info = $media_image_manager->getImageInfo($request->get('image_info'));

        $images = $request->get('image_source');

        foreach($images as $image) {
            /** Remove existing image */
            if(file_exists(WEB_DIR.$image)) {
                @unlink(WEB_DIR.$image);
            }
        }

        if(isset($image_info['uploaded_images'])) {
            $image_info['uploaded_images'] = $image_info['uploaded_images']-1;
        }

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $response = new Response();
        $response->setContent(json_encode(array('user_key' => $user_api_key, 'image_info' => $media_image_manager->createData($image_info))));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function imageCropingAction($random)
    {
        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        $media_image_manager = $this->requestService('zing.component.media.image');
        $image_info = $media_image_manager->getImageInfo($request->get('image_info'));

        if(!isset($image_info['crop_scale'])) {
            throw new Exception('Request cannot be proceded');
        }

        /** Get the requested crop positions */
        $crop_positions = array(
            'image_x' => $request->get('image_x'),
            'image_y' => $request->get('image_y'),
            'image_x2' => $request->get('image_x2'),
            'image_y2' => $request->get('image_y2')
        );

        $errors           = array();
        $imageInformation = array();

        /** Crop the image */
        $imageInformation['croped_image'] = $this->_imageCrop($image_info, $request->get('image_source'), $crop_positions, $image_info['type']);

        /** Get the cropped images path */
        $image_path = $this->currentProtocolHttpHost().'/'.$imageInformation['croped_image']['crop'].$imageInformation['croped_image']['image']['name'];

        /** Scale the cropped image to the requested scale size */
        $imageInformation['scaled_crop'] = $this->_imageScale($image_info, $image_path, $image_info['type'], 'path');

        /** Get what scale to be previewed */
        $preview_scale = array();
        foreach($image_info['scale_size'] as $scale_size) {
            if(isset($scale_size[2])) {
                if($scale_size[2] == 'preview') {
                    $preview_scale = array($scale_size[0] ,$scale_size[1]);
                }
            }
        }

        /** If no scale is marked to be previewed, choose the first scale as default */
        if(!count($preview_scale) > 0) {
            $preview_scale = array($image_info['scale_size'][0][0], $image_info['scale_size'][0][1]);
        }

        $hidden_scales = array();
        $preview_image = array();
        $scale_holder  = array();

            /** Loop in all scales created from the cropped image */
            foreach($imageInformation['scaled_crop'] as $scaled_image) {

                $preview = false;

                /** If the scale size of the current scale equals to the scale that is marked as preview */
                if($scaled_image['scale_size'][0] == $preview_scale[0]) {
                    $preview = true;
                    $preview_image = $scaled_image;
                }

                /** Fill the scale holder of the croped image */
                $scale_holder[] = array(
                    'name'      => $scaled_image['scaled'].$scaled_image['image']['name'],
                    'w'         => $scaled_image['scale_size'][0],
                    'h'         => $scaled_image['scale_size'][1],
                    'preview'   => $preview,
                    'flag'      => 'scale'
                );


             }

            $hidden_scales = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_hidden_scales.html.twig', array(
                'scales'    => array_merge($scale_holder, array(json_decode(base64_decode($request->get('original_image_hidden')), true))),
                'type'      => $image_info['type']
            ));


            /** Get image source template */
            $imageInformation['scaled_crop_source'][] = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_preview.html.twig',
                array(
                     'images'  =>
                          array(
                              array(
                                  'name'          => $preview_image['scaled'].$preview_image['image']['name'],
                                  'preview'       => true,
                                  'type'          => $preview_image['type'],
                                  'hidden_scales' => $hidden_scales
                              )
                          )
                     )
                );

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());

        $response = new Response();
        $response->setContent(json_encode(array('user_key' => $user_api_key, 'image' => $imageInformation, 'errors' => $errors)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * Call object of HBimage plugin and crop the given file by it's cords.
     * @param object $image Instance of HBimage.
     * @param array  $imageFile The post results ($_FILES).
     *
     */
    public function imageUploadAction($random)
    {

        $request = $this->getPostRequest();

        /** Initlize api for this controller */
        $api_manager = $this->_initilizeApi($request);

        $imageInformation = array();
        $errors = array();
        try {

            /** If no files are submited, throw error. */
            if(!isset($_FILES['image'])) {throw new HBimagesException('No file submited');}

            /** Media image manager */
            $media_image_manager = $this->requestService('zing.component.media.image');

            /** Decrypt the requested image info */
            $image_info = $media_image_manager->getImageInfo($request->get('image_info'));

            if(isset($image_info['uploaded_images'])) {
                if($image_info['uploaded_images'] > $image_info['multiply']) {
                    throw new Exception('You have reached maximum limit. Please DELETE existing image first.');
                }
            }

            /** Check some of the required fields */
            if(!isset($image_info['type'])) {
                throw new Exception('Request cannot be proceded');
            }

            if(!isset($image_info['folder'])) {
                throw new Exception('Request cannot be proceded');
            }

            /** Normalize the input images array */
            $normalized_images = $this->normalizedInputFileArray($_FILES['image']);

            foreach($normalized_images as $type => $images) {

                   foreach($images as $image) {

                           if(!isset($image_info['uploaded_images'])) {
                               $image_info['uploaded_images'] = 1;
                           } else {
                               if($image_info['uploaded_images'] > $image_info['multiply']) {
                                   throw new Exception('You have reached maximum limit');
                               }
                               $image_info['uploaded_images'] = $image_info['uploaded_images']+1;
                           }
                               $original_copy = $this->_original($image_info, $image, $type);

                               $original_copy_scale_holder = array(
                                   'name'      => $original_copy['original'].$original_copy['image']['name'],
                                   'w'         => $original_copy['image']['size'][0],
                                   'h'         => $original_copy['image']['size'][1],
                                   'preview'   => false,
                                   'flag'      => 'original'
                               );

                               /** Create hidden fields for scales */
                               $original_copy_holder_hidden_field = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_hidden_scales.html.twig', array(
                                   'scales'    => array($original_copy_scale_holder),
                                   'type'      => $image_info['type']
                               ));


                            /** If crop is requested */
                            if(isset($image_info['crop_scale'])) {

                                /** Prepared image for crop */
                                $prepared_crop = $this->_imageScale(array_merge($image_info, array('scale_size' => array(array($image_info['crop_scale'][0], $image_info['crop_scale'][1])))), $image, $type);

                                /** A prepared crop can have only one scaled image on what the actual crop will be made */
                                $prepared_crop = $prepared_crop[0];

                                /** Get image source template */
                                $image_source = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_preview_crop.html.twig', array(
                                    'croped'            => $prepared_crop,
                                    'image_info'        => $image_info,
                                    'original_image'    => base64_encode(json_encode($original_copy_scale_holder))
                                ));

                               /** Save the prepared image to the image collector */
                               $imageInformation['scaled'][] = array_merge(
                                    $prepared_crop, array(
                                                'jcrop'             => true,
                                                'image_source'      => $image_source));

                               $imageInformation['got_crop'] = true;
                            } elseif(isset($image_info['only_original'])) {
                                $original = $this->_original($image_info, $image, $type);

                                $scale_holder[] = array(
                                    'name'      => $original['original'].$original['image']['name'],
                                    'w'         => $original['image']['size'][0],
                                    'h'         => $original['image']['size'][1],
                                    'preview'   => true,
                                    'flag'      => 'original'
                                );

                                /** Create hidden fields for scales */
                                $hidden_scales = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_hidden_scales.html.twig', array(
                                    'scales'    => $scale_holder,
                                    'type'      => $image_info['type']
                                ));


                                /** Get image source template */
                                $image_source = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_preview.html.twig', 
                                    array(
                                       'images'  =>
                                           array(
                                               array(
                                                   'name'          => $original['original'].$original['image']['name'],
                                                   'preview'       => true,
                                                   'type'          => $type,
                                                   'hidden_scales' => $hidden_scales
                                               )
                                           )
                                    ));

                                $imageInformation['scaled'][] = array_merge(
                                    $original, array(
                                    'jcrop'             => false,
                                    'image_source'      => $image_source));

                            } else {

                                /** Get what scale to be previewed */
                                $preview_scale = array();
                                foreach($image_info['scale_size'] as $scale_size) {
                                    if(isset($scale_size[2])) {
                                        if($scale_size[2] == 'preview') {
                                            $preview_scale = array($scale_size[0] ,$scale_size[1]);
                                        }
                                    }
                                }

                               /** If a normal image scale is requested */
                                $scales = $this->_imageScale($image_info, $image, $type);
                                $scale_holder = array();
                               foreach($scales as $scaled) {

                               $preview = false;

                                if(count($preview_scale) > 0) {
                                    /** If the scale size of the current scale equals to the scale that is marked as preview */
                                    if($scaled['scale_size'][0] == $preview_scale[0] || $scaled['scale_size'][1] == $preview_scale[1]) {
                                        $preview = true;
                                    }
                                }

                                $scale_holder[] = array(
                                    'name'      => $scaled['scaled'].$scaled['image']['name'],
                                    'w'         => $scaled['scale_size'][0],
                                    'h'         => $scaled['scale_size'][1],
                                    'preview'   => $preview,
                                    'flag'      => 'scale'
                                );

                                   $image_source = '';

                                   /** Create hidden fields for scales */
                                   $hidden_scales = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_hidden_scales.html.twig', array(
                                       'scales'    => array_merge($scale_holder, array($original_copy_scale_holder)),
                                       'type'      => $image_info['type']
                                   ));

                                    if($preview) {
                                       /** Get image source template */
                                       $image_source = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_preview.html.twig',
                                           array(
                                               'images'  =>
                                                   array(
                                                       array(
                                                           'name'          => $scaled['scaled'].$scaled['image']['name'],
                                                           'preview'       => true,
                                                           'type'          => $scaled['type'],
                                                           'hidden_scales' => $hidden_scales.$original_copy_holder_hidden_field
                                                       )
                                                   )
                                           )
                                       );
                                   } else {
                                        /** If no preview is requested save only the hidden scales */
                                        $imageInformation['hidden_scales'] = $hidden_scales.$original_copy_holder_hidden_field;
                                    }

                                   $imageInformation['scaled'][] = array_merge(
                                        $scaled, array(
                                        'jcrop'             => false,
                                        'image_source'      => $image_source));
                           }
                       }
                       //$imageInformation['original_hidden_fields'][] = $original_copy_holder_hidden_field;
                   }

                /** Create hidden fields for scales */
                $imageInformation['image_info'] = $media_image_manager->createData($image_info);
             }
        } catch (Exception $e) {
            /**
             * IF EXCEPTION IS CATH.
             * You can make errors to be written to some log files.
             *      And to throw only one user error like -
             *          "Something happen to the uploaded file."
             *
             *      OR you can filter the messages by the message error codes.
             *            You can see them in HBimagesException.php
             *              Filter the messages you want to show to the user
             *              and the one to be written to log files or whatever you want.
             *  */
            $errors = array($e->getMessage());
        }

        /** Current user key */
        $user_api_key = $api_manager->getUserRuntimeKey();

        /** Generating a new user key */
        //$user_api_key = $api_manager->createUserApiKeyFromUserObject($api_manager->getUserRuntimeObject());


        $response = new Response();
        $response->setContent(json_encode(array('user_key' => $user_api_key, 'image' => $imageInformation, 'errors' => $errors)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Call object of HBimage plugin and crop the given file by it's cords.
     * @param object $image Instance of HBimage.
     * @param array  $imageFile The post results (path and cords of image).
     *
     */
    private function _imageCrop($image_info, $image, $crop_positions, $type)
    {

        $hb_image = new MediaImageController();

        /** Save the image and get detailed information about the action */
        return array_merge($hb_image ->mydir($this->base_dir, true, 0777)
            ->crop(true, $image_info['folder'].'croped/',
                $crop_positions['image_x2'],
                $crop_positions['image_y2'],
                $crop_positions['image_x'],
                $crop_positions['image_y'],
                $crop_positions['image_x2'],
                $crop_positions['image_y2'],
                100)
            ->input('path',  $this->currentProtocolHttpHost().$image)
            ->output(), array('type' => $type));

    }

    private function _original($image_info, $image, $type)
    {
        $hb_image = new MediaImageController();

        /** Save the image and get detailed information about the action */
        return array_merge($hb_image ->mydir($this->base_dir, true, 0777)
            ->original(true, $image_info['folder'].'original/', 100)
            ->input('post', $image)
            ->output(), array('type' => $type));
    }

    private function _imageScale($image_info, $image, $type, $input_type = 'post')
    {
        $imageInformation = array();

        foreach($image_info['scale_size'] as $scale_size) {
            $width   = $scale_size[0];
            $height  = $scale_size[1];

            $temp_array = $imageInformation;

            $last_key = key( array_slice( $temp_array, -1, 1, TRUE ) );

            $custom_name = false;
            if(isset($imageInformation[$last_key])) {
                $custom_name = explode('.', $imageInformation[$last_key]['image']['name']);
                $custom_name = $custom_name[0];
            }
            $hb_image = new MediaImageController();
            /** Save the image and get detailed information about the action */
            $imageInformation[] = array_merge($hb_image ->mydir($this->base_dir, true, 0777)
                ->scaled(true,   $image_info['folder'].$width.'x'.$height.'/', array($width, $height), 100)
                ->input($input_type, $image, $custom_name)
                ->output(), array('type' => $type));
        }

        return $imageInformation;
    }


    private function normalizedInputFileArray($files)
    {
        $normalized_images = array();
        foreach($files as $file_key => $file_handler) {
            foreach($file_handler as $type => $file) {
                foreach($file as $name => $value) {
                    $normalized_images[$type][$name][$file_key] = $value;
                }
            }
        }
        return $normalized_images;
    }

    /**
     * Disable cache.
     * @param string $state If set to true it will disable cache.
     *
     */
    private function _noCache($state = false)
    {
        if($state == true) {

            header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

        return true;
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