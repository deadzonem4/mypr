<?php

namespace Zing\Component\MediaBundle\Controller;

use Zing\Core\CoreBundle\Controller\CoreController;
use Zing\Component\MediaBundle\Exceptions\HBimagesException as HBimagesException;

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
class MediaImageController extends CoreController
{

    /** HBimages.
     *  @param array $options Configuration array of current behavior.
     */
    private $options = array(
        'ext' => array(
            'jpeg',
            'gif',
            'png'
        ),
        'supportedMethods' =>
            array(
                'original',
                'scaled',
                'crop',
                'thumb'
            ),
        'exception' => true,
        'dirMode' => 0777,
        'dir' => '',
        'imageInfos' => array(
            'path',
            'post'
        ),
        'thumb' => array(
            'state' => false,
            'path' => null,
            'size' => 40,
            'quality' => null
        ),
        'original' => array(
            'state' => false,
            'path' => null,
            'quality' => null
        ),
        'scaled' => array(
            'state' => false,
            'path' => null,
            'size' => 500,
            'quality' => null
        ),
        'crop' => array(
            'state' => false,
            'path' => null,
            'quality' => null,
            'x' => null,
            'y' => null,
            'w' => null,
            'h' => null
        )
    );

    /** HBimages.
     *  @param array $image Information of current image(name, size, extension etc.)
     */
    private $image = array(
        'io' => array(),
        'wm' => array('status' => false)
    );

    /**
     * HBimages.
     * Apply state for exceptions.
     *
     *  @param boolean $state enable(true)/disable(false) exceptions
     *  @return object HBimages.
     */
    public function exception($state = true) {
        $this->_applyOptions(
            array('exception' => $state)
        );
        return $this;
    }

    /**
     * HBimages.
     * Apply state for Extensions.
     *
     *  @param array $ext extenstions to be used.
     *  @return object HBimages.
     */
    public function extensions($ext = array('jpeg, gif, png')) {
        $this->_applyOptions(
            array('ext' => $ext)
        );
        return $this;
    }

    /**
     * HBimages.
     * Use/create main directory for images to be saved.
     *
     *  @param string $dir Directory to use.
     *  @param boolean $mdir Create $dir if dose not exist.
     *  @param int $mode The folder priv if $mdir is used.
     *  @return object HBimages.
     *  */
    public function mydir($dir, $mdir = false, $mode = 0777) {
        if ($this->_dirExist($dir) != true) {
            if ($mdir != false) {
                $this->_mdir($dir, $mode);
            } else {
                throw new HBimagesException(31);
            }
        }
        $this->options['dir'] = $dir;
        return $this;
    }



    /**
     * HBimages.
     * Remove current directory.
     *
     *  @param string $dir Directory to use.
     *  @return object HBimages.
     */
    public function rmydir($dir) {
        if ($this->_dirExist($dir) != true) {
            throw new HBimagesException(31);
        }

        $this->_rdir($dir);

        if ($this->_dirExist($dir) == true) {
            rmdir($dir);
        }

        return $this;
    }

    /**
     * HBimages.
     * Configure the original image options.
     *
     * @param boolean $state enable(true)/disable(false) saving original image.
     * @param string $path path to the folder in the main directory(set in mydir).
     * @param int $quality The quality of the final saved image.
     * @return object HBimages.
     */
    public function original($state = false, $path = null, $quality = null) {
        $this->_applyOptions(
            array(
                'original' =>
                    array('quality' => $this->_quality($quality),
                        'state' => $state,
                        'path' => $this->options['dir'] . $path
                    )
            )
        );
        return $this;
    }

    /**
     * HBimages.
     * Configure the crop image options.
     *
     * @param boolean $state enable(true)/disable(false) saving crop image.
     * @param string $path path to the folder in the main directory(set in mydir).
     * @param int $outputWidth The proportion width calculated by the aspect ratio of croped region.
     * @param int $outputHeight The proportion height calculated by the aspect ratio of croped region.
     * @param int $x Croped region.
     * @param int $y Croped region.
     * @param int $w Croped region.
     * @param int $h Croped region.
     * @param int $quality The quality of the final saved image.
     * @return object HBimages.
     */
    public function crop($state = false, $path = null, $outputWidth = null, $outputHeight = null, $x = null, $y = null, $w = null, $h = null, $quality = null) {
        $this->_applyOptions(
            array(
                'crop' =>
                    array('quality' => $this->_quality($quality),
                        'state' => $state,
                        'path' => $this->options['dir'] . $path,
                        'outputWidth' => $outputWidth,
                        'outputHeight' => $outputHeight,
                        'x' => $x,
                        'y' => $y,
                        'w' => $w,
                        'h' => $h,
                    )
            )
        );
        return $this;
    }

    /**
     * HBimages.
     * Configure the thumb image options.
     *
     * @param boolean $state enable(true)/disable(false) saving thumb image.
     * @param string $path path to the folder in the main directory(set in mydir).
     * @param int $size min/max size of the final saved image.
     * @param int $quality The quality of the final saved image.
     * @return object HBimages.
     */
    public function thumb($state = false, $path = null, $size = 40, $w = null, $h = null, $quality = null) {
        $this->_applyOptions(
            array(
                'thumb' =>
                    array('quality' => $this->_quality($quality),
                        'state' => $state,
                        'path' => $this->options['dir'] . $path,
                        'size' => $size,
                        'w' => $w,
                        'h' => $h
                    )
            )
        );
        return $this;
    }

    /**
     * HBimages.
     * Configure the scaled image options.
     *
     * @param boolean $state enable(true)/disable(false) saving scaled image.
     * @param string $path path to the folder in the main directory(set in mydir).
     * @param array $size min/max size of the final saved image.
     * @param int $quality The quality of the final saved image.
     * @return object HBimages.
     */
    public function scaled($state = false, $path = null, $size = array(500, 500), $quality = null) {
        $this->_applyOptions(
            array(
                'scaled' =>
                    array('quality' => $this->_quality($quality),
                        'state' => $state,
                        'path' => $this->options['dir'] . $path,
                        'size' => $size
                    )
            )
        );
        return $this;
    }

    /**
     * HBimages.
     * Apply options set by user.
     *
     * @param array $options User configurations.
     * @return object HBimages.
     */
    public function settings($options = array()) {
        $this->_applyOptions($options);
        return $this;
    }

    public function test($qqq) {
        echo $this->_convertQualityPNG($qqq);
    }

    /**
     * HBimages.
     * Input image for proceeding.
     *
     * @param string $type By default you can chose from post and path method.
     * @param string $image Image source.
     * @param string $custom_name Set a custom name to the current image
     * @return object HBimages.
     */
    public function input($type = null, $image = null, $custom_name = false) {

        $imageInfo = $this->_getImageInfo($type, $image);

        if($custom_name) {
            $imageInfo['name'] = $custom_name;
        }

        $this->image['io']['name'] = $imageInfo['name'] . '.' . $imageInfo['ext'];
        $this->image['io']['tmp_name'] = $imageInfo['tmp_name'];


        if ($imageInfo['dirname'] != false) {
            $this->image['io']['tmp_name'] = $imageInfo['dirname'].$this->image['io']['name'];
        }


        //$this->dump($imageInfo);

        $this->image['io']['ext'] = $imageInfo['ext'];
        $this->image['io']['size'] = $imageInfo['size'];
        $this->_msdir();

        if ($this->image['io']['ext'] == 'png') {
            $this->_convertQualityPNG();
        }


        return $this;
    }

    public function watermark($path = null, $position = null, $opacity = null, $perc = null) {
        $this->image['wm']['state'] = true;

        if ($path == null) {
            throw new HBimagesException(17);
        };
        if ($position == null) {
            throw new HBimagesException(18);
        };
        if ($opacity == null) {
            throw new HBimagesException(19);
        };
        if ($perc == null) {
            throw new HBimagesException(20);
        };

        if (!file_exists($path)) {
            throw new HBimagesException(24);
        }

        if (!in_array($position, array('top-center', 'right-center', 'bottom-center', 'left-center', 'center',
            'top-right', 'bottom-right', 'bottom-left', 'top-left'
        ))) {
            throw new HBimagesException(21);
        }
        if ($opacity > 100 OR $opacity < 1) {
            throw new HBimagesException(22);
        }
        if ($perc > 100 OR $perc < 1) {
            throw new HBimagesException(23);
        }
        $this->image['wm']['path'] = $path;
        $this->image['wm']['position'] = $position;
        $this->image['wm']['opacity'] = $opacity;
        $this->image['wm']['perc'] = $perc;
        $this->image['wm']['ext'] = $this->_ext($path, $this->options['ext']);
        $this->image['wm']['size'] = $this->_size($path);

        return $this;
    }

    /**
     * HBimages.
     * Call methods for proceeding image.
     * @return array current image information.
     */
    public function output() {

        $collect = array('image' => $this->image['io']);

        if ($this->options['original']['state'] == true) {
            $this->_original(true, $this->image['io']['tmp_name'], $this->image['io']['ext'], $this->options['original']['path'] . $this->image['io']['name'], $this->options['original']['quality'], $this->image['io']['size'][0], $this->image['io']['size'][1]
            );
            $collect['original'] = $this->options['original']['path'];
        }
        if ($this->options['scaled']['state'] == true) {

            $this->_scale(true, $this->image['io']['tmp_name'], $this->image['io']['ext'], $this->options['scaled']['path'] . $this->image['io']['name'], $this->options['scaled']['quality'], $this->image['io']['size'][0], $this->image['io']['size'][1], $this->options['scaled']['size']);

            $collect['scale_size'] = $this->scale_size;
            $collect['scaled'] = $this->options['scaled']['path'];
        }
        if ($this->options['thumb']['state'] == true) {
            $this->_thumb(true, $this->image['io']['tmp_name'], $this->image['io']['ext'], $this->options['thumb']['path'] . $this->image['io']['name'], $this->options['thumb']['quality'], $this->image['io']['size'][0], $this->image['io']['size'][1], $this->options['thumb']['size'], $this->options['thumb']['w'], $this->options['thumb']['h']
            );
            $collect['thumb'] = $this->options['thumb']['path'];
        }
        if ($this->options['crop']['state'] == true) {
            $this->_crop(true, $this->image['io']['tmp_name'], $this->image['io']['ext'], $this->options['crop']['path'] . $this->image['io']['name'], $this->options['crop']['quality'], $this->options['crop']['outputWidth'], $this->options['crop']['outputHeight'], $this->options['crop']['x'], $this->options['crop']['y'], $this->options['crop']['w'], $this->options['crop']['h']
            );
            $collect['crop'] = $this->options['crop']['path'];
        }

        $this->image['io'] = array();
        unset($collect['image']['tmp_name']);
        return $collect;
    }

    private function _convertQualityPNG() {
        if ($this->image['io']['ext'] == 'png') {
            $quC = array(
                1 => array(1, 15),
                2 => array(15, 25),
                3 => array(25, 35),
                4 => array(35, 45),
                5 => array(45, 55),
                6 => array(55, 65),
                7 => array(65, 75),
                8 => array(75, 85),
                9 => array(85, 105)
            );

            foreach ($this->options['supportedMethods'] as $type) {
                if ($this->options[$type]['state'] == true) {
                    foreach ($quC as $key => $value) {
                        if ($this->options[$type]['quality'] >= $value[0] AND
                            $this->options[$type]['quality'] <= $value[1]
                        ) {
                            $this->options[$type]['quality'] = $key;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * HBimages.
     * Check if requested source method exist.
     *
     *  @param string $type Checking methods for getting image source.
     *  @return boolean If source method exist.
     */
    private function _imageInfos($type) {
        if (!in_array($type, $this->options['imageInfos'])) {
            throw new HBimagesException(26);
        }
        return true;
    }

    /**
     * HBimages.
     * Get image information.
     *
     *  @param string $type Method of getting image source.
     *  @param string $image Image source.
     *  @return object Current image information.
     */
    private function _getImageInfo($type, $image) {
        $this->_imageInfos($type);

        $imageInfosMethod = '_info' . $type;
        if (!method_exists($this, $imageInfosMethod)) {
            throw new HBimagesException(27);
        }

        return $this->$imageInfosMethod($image);
    }

    /**
     * HBimages.
     *
     *  @param string $image Path.
     *  @return string Image name.
     */
    private function _imageName($image) {
        $pathinfo = pathinfo($image);
        return $pathinfo['filename'];
    }

    /**
     * HBimages.
     *
     *  @param string $image Path.
     *  @return string Image directory.
     */
    private function _imageDirname($image) {
        $pathinfo = pathinfo($image);
        return $pathinfo['dirname'] . '/';
    }

    /**
     * HBimages.
     * Collect path information for image.
     *
     *   @param string $image Path.
     *   @return array Image information by given path.
     */
    private function _infopath($image) {
        $this->_existPath($image);
        $name = $this->_imageName($image);
        $dirname = $this->_imageDirname($image);

        return array(
            'name' => $name,
            'tmp_name' => $name,
            'dirname' => $dirname,
            'ext' => $this->_ext($image, $this->options['ext']),
            'size' => $this->_size($image)
        );
    }

    /**
     * HBimages.
     * Collect post information for image.
     *
     *  @param string $image Post request($_FILES).
     *  @return array Image information by given post request($_FILES).
     */
    private function _infopost($image) {
        $this->_existPost($image);

        return array(
            'name' => $this->_uniqueName($image['name']),
            'tmp_name' => $image['tmp_name'],
            'dirname' => false,
            'ext' => $this->_ext($image['tmp_name'], $this->options['ext']),
            'size' => $this->_size($image['tmp_name'])
        );
    }

    /**
     * HBimages.
     * Check if directory exist.
     *
     *  @param string $dir Directory.
     *  @return boolean Exist(true)/Not exist(false).
     */
    private function _dirExist($dir) {
        if (!file_exists($dir) OR !is_dir($dir)) {
            return false;
        }
        return true;
    }

    /** HBimages.
     *  Create folders in main directory set in mydir.
     *
     *  @return boolean true.
     */
    private function _msdir() {
        $SupportTypes = array('original', 'scaled', 'crop', 'thumb');
        foreach ($SupportTypes as $type) {
            if ($this->options[$type]['path'] != null) {
                if ($this->_dirExist($this->options[$type]['path']) != true) {
                    $this->_mdir($this->options[$type]['path'], $this->options['dirMode']);
                }
            }
        }
        return true;
    }

    /**
     * HBimages.
     * Create directory.
     *
     * @param string $dir Direcotry to use.
     * @param int $mode Priv of directory.
     * @return boolean If created true.
     *
     */
    private function _mdir($dir, $mode) {
        if ($this->_dirExist($dir) == true) {
            throw new HBimagesException(29);
        }

        @mkdir($dir, $mode, true);

        if (!is_writable($dir)) {
            throw new HBimagesException(30);
        }

        return true;
    }

    /**
     * HBimages.
     * Remove directory.
     *
     * @param string $dir Directory to use. */
    private function _rdir($dir) {
        $i = new DirectoryIterator($dir);
        foreach ($i as $f) {
            if ($f->isFile()) {
                unlink($f->getRealPath());
            } elseif (!$f->isDot() && $f->isDir()) {
                $this->_rdir($f->getRealPath());
                rmdir($f->getRealPath());
            }
        }
    }

    /**
     * HBimages.
     * Apply user options.
     *
     * @param array $options The user input options.
     */
    private function _applyOptions($options) {
        foreach ($options as $option => $value) {
            if (isset($this->options[$option])) {
                $this->options[$option] = $value;
            }
        }
    }

    private function _GDImageCreate($image, $ext) {
        $imagecreatefrom = 'imagecreatefrom' . $ext;
        $imageType = 'image' . $ext;
        if (!function_exists($imagecreatefrom) OR !function_exists($imageType)) {
            throw new HBimagesException(15);
        }
        $image = call_user_func($imagecreatefrom, $image);
        return array('create' => $image, 'type' => $imageType);
    }


    private function _watermark($canvas) {
        $wm = $this->image['wm'];
        $image = $this->_GDImageCreate($wm['path'], $wm['ext']);
        $maxS = max($canvas['width'], $canvas['height']);
        $minS = min($canvas['width'], $canvas['height']);
        $scale_size =  $minS*(($wm['perc']/100)*($maxS / $minS));
        $ImageScale = min($scale_size / $wm['size'][0], $scale_size / $wm['size'][1]);
        $width = ceil($ImageScale * $wm['size'][0]);
        $height = ceil($ImageScale * $wm['size'][1]);
        $stamp = imagecreatetruecolor(
            $width, $height
        );
        imagecopyresampled($stamp, $image['create'], 0, 0, 0, 0, $width, $height, $wm['size'][0], $wm['size'][1]);


        $pos = $wm['position'];
        if($pos == 'top-left') {
            $x = 0;
            $y = 0;
        } elseif($pos == 'top-right') {
            $x = $canvas['width'] - $width;
            $y = 0;
        }
        elseif($pos == 'bottom-right') {
            $x = $canvas['width'] - $width;
            $y = $canvas['height'] - $height;
        }
        elseif($pos == 'bottom-left') {
            $x = 0;
            $y = $canvas['height'] - $height;
        }
        elseif($pos == 'left-center') {
            $x = 0;
            $y = ($canvas['height'] / 2) - ($height / 2);
        }
        elseif($pos == 'bottom-center') {
            $x = ($canvas['width'] / 2 ) - ($width / 2);
            $y = $canvas['height'] - $height;
        }
        elseif($pos == 'right-center') {
            $x = $canvas['width'] - $width;
            $y = ($canvas['height'] / 2) - ($height / 2);
        }
        elseif($pos == 'top-center') {
            $x = ($canvas['width'] / 2) - ($width / 2);
            $y = 0;
        }
        elseif($pos == 'center') {
            $x = ($canvas['width'] / 2 ) - ($width / 2);
            $y = ($canvas['height'] / 2) - ($height / 2);
        }
        else {
            $x = 0;
            $y = 0;
        }

        imagecopymerge(
            $canvas['image'],
            $stamp,
            $x,
            $y,
            0,
            0,
            $width,
            $height,
            $wm['opacity']
        );

        $this->_clearMem($stamp);

        return $canvas['image'];

    }


    /**
     * HBimages.
     * Proceed original image with given options.
     */
    private function _original($saveImage = true, $image = null, $ext = null, $path = null, $quality = null, $image_w = null, $image_h = null) {
        $image = $this->_GDImageCreate($image, $ext);
        $NewCanves = imagecreatetruecolor($image_w, $image_h);

        /** If image extenstion is png then set transperancy flag. */
        if($ext == 'png') {
            imagealphablending($NewCanves, false);
            imagesavealpha($NewCanves, true);
        }

        imagecopyresampled($NewCanves, $image['create'], 0, 0, 0, 0, $image_w, $image_h, $image_w, $image_h
        );

        if(isset($this->image['wm']['state'])) {
            if($this->image['wm']['state'] == true) {
                $NewCanves = $this->_watermark(array('image' => $NewCanves, 'width' => $image_w, 'height' => $image_h));
            }
        }

        if ($saveImage != true) {
            return array($image_w, $image_h, $NewCanves);
        }
        $this->_save($NewCanves, $path, $quality, $image['type']);
        return true;
    }

    /**
     * HBimages.
     * Proceed crop image with given options.
     */
    private function _crop($saveImage = true, $image = null, $ext = null, $path = null, $quality = null, $image_w = null, $image_h = null, $crop_x = null, $crop_y = null, $crop_w = null, $crop_h = null) {

        $image = $this->_GDImageCreate($image, $ext);

        if($image_w == null AND $image_h == null) {
            $image_w = $crop_w;
            $image_h = $crop_h;
        } elseif($image_w == null AND $image_h != null) {
            $sizes = $this->_scalingAlg($image_h, $crop_w, $crop_h);
            $image_w = $sizes[0];
            $image_h = $sizes[1];
        }
        elseif($image_h == null AND $image_w != null) {
            $sizes = $this->_scalingAlg($image_w, $crop_w, $crop_h);
            $image_w = $sizes[0];
            $image_h = $sizes[1];
        }


        $NewCanves = imagecreatetruecolor($image_w, $image_h);
        imagecopyresampled($NewCanves, $image['create'], 0, 0, $crop_x, $crop_y, $image_w, $image_h, $crop_w, $crop_h
        );
        if(isset($this->image['wm']['state'])) {
            if($this->image['wm']['state'] == true) {
                $NewCanves = $this->_watermark(array('image' => $NewCanves, 'width' => $image_w, 'height' => $image_h));
            }
        }
        if ($saveImage != true) {
            return array($image_w, $image_h, $NewCanves);
        }
        $this->_save($NewCanves, $path, $quality, $image['type']);
        return true;
    }

    private function _scalingAlg($scale_size, $image_w, $image_h)
    {
        $ImageScale = min($scale_size / $image_w, $scale_size / $image_h);
        return array(ceil($ImageScale * $image_w), ceil($ImageScale * $image_h));
    }

    /**
     * HBimages.
     * Proceed scaled image with given options.
     */
    private function _scale($saveImage = true, $image = null, $ext = null, $path = null, $quality = null, $image_w = null, $image_h = null, $scale_size = null) {
        $image = $this->_GDImageCreate($image, $ext);

        $scale_size_max = max($scale_size[0], $scale_size[1]);

        $ImageScale = min($scale_size_max / $image_w, $scale_size_max / $image_h);
        $cWidth = ceil($ImageScale * $image_w);
        $cHeight = ceil($ImageScale * $image_h);

        if($cHeight < $scale_size[1]) {
            $diff = $scale_size[1] - $cHeight;
            $cHeight += $diff;
            $cWidth  += $diff*($image_w/$image_h);
        }

        if($cWidth < $scale_size[0]) {
            $diff = $scale_size[0] - $cWidth;
            $cWidth  += $diff;
            $cHeight += $diff*($image_h/$image_w);
        }

        /** Cast to int */
        $cWidth = (int)$cWidth;
        $cHeight = (int)$cHeight;

        $NewCanves = imagecreatetruecolor(
            $cWidth, $cHeight
        );

        /** If image extenstion is png then set transperancy flag. */
        if($ext == 'png') {
            imagealphablending($NewCanves, false);
            imagesavealpha($NewCanves, true);
        }

        imagecopyresampled($NewCanves, $image['create'], 0, 0, 0, 0, $cWidth, $cHeight, $image_w, $image_h);
        if(isset($this->image['wm']['state'])) {
            if($this->image['wm']['state'] == true) {
                $NewCanves = $this->_watermark(array('image' => $NewCanves, 'width' => $cWidth, 'height' => $cHeight));
            }
        }

        $this->scale_size = array($cWidth, $cHeight);

        if ($saveImage != true) {
            return array($cWidth, $cHeight, $NewCanves);
        }

        $this->_save($NewCanves, $path, $quality, $image['type']);
        return true;
    }

    private function _thumb($saveImage = true, $image = null, $ext = null, $path = null, $quality = null, $image_w = null, $image_h = null, $scale_size = null, $cropW = null, $cropH = null) {

        $imageType = $this->_GDImageCreate($image, $ext);
        $imageType = $imageType['type'];
        $scaled = $this->_scale(false, $image, $ext, $path, $quality, $image_w, $image_h, $scale_size);
        $newImage = imagecreatetruecolor($cropW, $cropH);
        imagecopy($newImage, $scaled[2], 0, 0, ($scaled[0] - $cropW) / 2, ($scaled[1] - $cropH) / 2, $cropW, $cropH);
        if(isset($this->image['wm']['state'])) {
            if($this->image['wm']['state'] == true) {
                $newImage = $this->_watermark(array('image' => $newImage, 'width' => $cropW, 'height' => $cropH));
            }
        }

        if ($saveImage != true) {
            return array($cropW, $cropH, $newImage);
        }
        $this->_save($newImage, $path, $quality, $imageType);
        return true;
    }

    private function _save($image, $path, $quality, $imageType) {
        $imgSave = array($image, $path);
        if ($quality != null) {
            $imgSave[] = $quality;
        }
        call_user_func_array($imageType, $imgSave);
        $this->_clearMem($image);
        return true;
    }

    /**
     * HBimages.
     * Clear memory.
     *
     * @param object $canvas GD canvas.
     * @return boolean true.
     */
    private function _clearMem($canvas) {
        if (is_resource($canvas)) {
            imagedestroy($canvas);
        }
        return true;
    }

    /**
     * HBimages.
     * Check if image exist in path request.
     *
     * @param string $image Image path.
     * @return boolean true if image exist.
     */
    private function _existPath($image) {
        if (!$this->_size($image) > 0) {
            throw new HBimagesException(27);
        }
        return true;
    }

    /**
     * HBimages.
     * Check if image exist in post request.
     *
     * @param string $image Image post request($_FILES).
     * @return boolean true if image exist.
     */
    private function _existPost($image) {
        if (!is_array($image)) {
            throw new HBimagesException(11);
        }
        if (!in_array('tmp_name', $image) OR !in_array('type', $image)) {
            throw new HBimagesException(11);
        }
        if (!strlen($image['tmp_name']) > 0) {
            throw new HBimagesException(13);
        } elseif (!$this->_size($image['tmp_name']) > 0) {
            throw new HBimagesException(12);
        }
        return true;
    }

    /**
     * HBimages.
     * Get image extension.
     *
     * @param string $image Image source.
     * @param array $exts Possible extensions.
     * @return string Image extension.
     */
    private function _ext($image, $exts) {
        if (function_exists('exif_imagetype')) {
            $imgType = exif_imagetype($image);
        } else {
            $imgType = getimagesize($image);
        }
        $ext = image_type_to_extension($imgType, false);

        if (!in_array($ext, $exts)) {
            throw new HBimagesException(14);
        }
        return $ext;
    }

    /**
     * HBimages.
     * Get image size.
     *
     * @param string $image Image source.
     * @return integer Image size;
     */
    private function _size($image) {
        return @getimagesize($image);
    }

    /**
     * HBimages.
     * Validate image quality.
     *
     * @param int $quality Image quality.
     * @return int Image quality.
     */
    private function _quality($quality) {
        $quality = (int) $quality;
        if ($quality > 100) {
            $quality = 100;
        }
        if ($quality < 1) {
            $quality = 1;
        }
        return $quality;
    }

    /**
     * HBimages.
     * Create unique string.
     *
     * @param string $name Additional randomness with the image name.
     * @return string randomness unique string.
     */
    private function _uniqueName($name) {
        return time() . 'time' .
        substr(str_shuffle('qwertyuiopasdfghjklzxcvbnm1234567890'), 1, 15) .
        substr(str_shuffle(sha1($name)), 1, 18) .
        mt_rand(10000, 10000000);
    }

}


