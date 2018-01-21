<?php
namespace Zing\Component\MediaBundle\Controller\Manager;

use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\CoreBundle\Plugin\CryptIT;

class MediaImage extends CoreManager {

    CONST media_image_key = 'HLbcvTndcEMI1GcEdE2X5cZElBEKKv6ccqOXalOI6qOcW346W6GCeKRTM9CCAB5';

    /** @var object $doctrine Doctrine object */
    private $doctrine;

    /**
     * @param object $doctrine. Doctrine object
     * @param object $service_container. Service container
     */
    public function __construct($doctrine, $service_container)
    {
        $this->doctrine = $doctrine;
        $this->container = $service_container;
    }

    /** Get image info
     * @param string $info Encrypt it image info
     * @return array Image info in array
     */
    public function getImageInfo($info)
    {
        return json_decode($this->_decrypt($info), true);
    }

    /** Prepare - encrypt image info and return form as response
     * @param array Image info in array
     * @return string $image info in encrypt it string
     */
    public function imageForm($info)
    {

        if(!isset($info['folder'])) {
            return false;
        }

        if(!isset($info['type'])) {
            return false;
        }

        if(!isset($info['multiply'])) {
            $info['multiply'] = false;
        }

        if(!isset($info['preview'])) {
            $info['preview'] = false;
        } elseif(!is_array($info['preview'])) {
            $info['preview'] = false;
        }

        if(!isset($info['progress'])) {
            $info['progress'] = false;
        }

        if(!isset($info['response'])) {
            $info['response'] = false;
        }

        if(!isset($info['scale_size']) && !isset($info['only_original'])) {
            return false;
        }

        if(!isset($info['crop_scale'])) {
            //return false;
        }

        $form = array();

        $info['uploaded_images'] = 0;

        if(isset($info['preview'][0])) {
            $info['uploaded_images'] = count($info['preview'][0]['name']);
        }

        /** Get hidden field */
        $form[] = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/hidden_field.html.twig', array(
            'image_value' => $this->_encrypt(json_encode($info))
        ));

        /** Get input for image */
        $form[] = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/fields.html.twig', array(
            'type'      => $info['type'],
            'multiply'  => $info['multiply']
        ));

        $existing_images = '';

        /** If preview for images is given */
        if(count($info['preview']) > 0) {
            $existing_images = $this->imageResponse($this->_normalizeImageData($info['preview']), $info['type']);
        }

        $form[] = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/progress.html.twig', array(
            'progress'   => $info['progress']
        ));

        $form[] = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/response.html.twig', array(
            'response'          => $info['response'],
            'existing_images'   => $existing_images
        ));

        /** Return the generated form */
        return implode("&nbsp;", $form);
    }

    public function createData($info)
    {
        return $this->_encrypt(json_encode($info));
    }

    public function getImagesByPreview($image_container)
    {
        $found_images = array();
        $images = $this->_normalizeImageData($image_container);
        foreach($images as $scaled) {
            foreach($scaled as $image) {
            if($image['preview'] == true) {
                $found_images[] = $image;
            }
        }
       }

        if(count($found_images) > 0) {
            return $found_images;
        }

        $images = $this->getImagesByFlag('original', $image_container);
        if($images) {
            return $images;
        }

        return false;
    }

    public function getImagesByFlag($flag, $image_container)
    {
        $found_images = array();
        $images = $this->_normalizeImageData($image_container);
        foreach($images as $scaled) {
            foreach($scaled as $image) {
                if($image['flag'] == $flag) {
                    $found_images[] = $image;
                }
            }
        }

        if(count($found_images) > 0) {
            return $found_images;
        }

        return false;
    }

    public function getImagesByWidth($width, $image_container)
    {
        $found_images = array();
        $images = $this->_normalizeImageData($image_container);
            foreach($images as $scaled) {
                foreach($scaled as $image) {
                if($image['w'] == $width) {
                    $found_images[] = $image;
                }
            }
        }

        if(count($found_images) > 0) {
            return $found_images;
        }

        $image = $this->getImagesByPreview($image_container);
        if($image) {
            return $image;
        }

        return false;
    }

    private function _normalizeImageData($scales)
    {

        if($scales == false || !count($scales) > 0) {
            return array();
        }

        $images = array();
        foreach($scales as $scale) {
            foreach($scale['name'] as $k => $image) {
                $flag = '';
                if(isset($scale['flag'])) {
                    $flag = $scale['flag'][$k];
                }
                $images[$k][] =
                    array(
                        'name'          => substr($scale['name'][$k], 1),
                        'w'             => (int)$scale['w'][$k],
                        'h'             => (int)$scale['h'][$k],
                        'preview'       => (int)$scale['preview'][$k],
                        'flag'          => $flag
                    );
            }
        }

        return $images;
    }

    /** Get previews of images from uploaded images
     * @param array $images Array of the saved images with the media bundle
     * @return array The requested preview images
     */
    public function getPreviewImages($images)
    {

        if(!$images) {
            return array();
        }

        $previews = array();
        foreach($images as $scaled) {
            foreach($scaled['name'] as $key => $image_name) {
                if((int)$scaled['preview'][$key]) {
                    $flag = '';
                    if(isset($scaled['flag'])) {
                        $flag = $scaled['flag'][$key];
                    }
                    $previews[] =
                        array(
                            'name' => substr($scaled['name'][$key], 1),
                            'w' => (int)$scaled['w'][$key],
                            'h' => (int)$scaled['h'][$key],
                            'preview' => $scaled['preview'][$key],
                            'flag'  => $flag
                        );
                }
            }
        }
        return $previews;
    }

    public function imageResponse($images, $type)
    {

        if($images == false || !count($images) > 0) {
            return '';
        }

        $scale_holder = array();
        $imageInformation = array();


        foreach($images as $scales) {

            foreach($scales as $image) {
            $preview = false;

            /** If the scale size of the current scale equals to the scale that is marked as preview */
            if($image['preview']) {
                $preview = true;
            }

            $flag = '';
            if(isset($image['flag'])) {
                $flag = $image['flag'];
            }

            $scale = array(
                'name'      => $image['name'],
                'w'         => (int)$image['w'],
                'h'         => (int)$image['h'],
                'preview'   => $preview,
                'flag'      => $flag
            );

            $preview = $scale['preview'];
            $name    = $scale['name'];
            if($preview) {
                /** Get image source template */
                $imageInformation[] = $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_preview.html.twig', array(
                        'images'  =>
                            array(
                                array(
                                    'name'       => $name,
                                    'preview'    => true,
                                    'type'          => $type,
                                    'hidden_scales' => $this->container->get('templating')->render('ZingComponentMediaBundle:Default:Form/image_hidden_scales.html.twig', array(
                                            'scales'    => $scales,
                                            'type'      => $type
                                        ))
                                )
                            )
                    )
                );
            }
        }
    }


        /** Return the generated form */
        return implode("&nbsp;", $imageInformation);
    }

    /** Encrypt requested data
     * @param string $data Data to be encrypted
     * @return string Encrypted data
     */
    private function _encrypt($data)
    {
        $crypt_it = new CryptIT();
        return $crypt_it->encrypt($data, self::media_image_key);
    }

    /** Decrypt given data
     * @param string Data to decrypt
     * @return string Decrypted data
     */
    private function _decrypt($data)
    {
        $crypt_it = new CryptIT();
        return $crypt_it->decrypt($data, self::media_image_key);
    }
}