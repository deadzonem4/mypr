<?php
/**
 *
 * HBimages v1.0
 * Part of plugin for proceeding images with PHP - released under MIT License
 * Copyright (c) 2013 Hristo Boyarov
 * https://boyarov.bg/
 *
 *
 * HBimagesException.
 *    In used with HBimages. You can find examples and information on web page:
 *    http://boyarov.bg/
 *
 * @author Hristo Boyarov <hristo939393@gmail.com>
 *
 */
namespace Zing\Component\MediaBundle\Exceptions;

class HBimagesException extends \Exception {

    private $errors = array(
        0 => 'Object error.',
        11 => 'Uncorrect send header array.',
        12 => 'Upload only IMAGE file types bigger than 0 bytes.',
        13 => 'No image sellected.',
        14 => 'You cannot upload images with this image type.',
        15 => 'You need to have height.',
        16 => 'You need to have width.',
        17 => 'You have to specify path for the watermark.',
        18 => 'You have to specify where to be placed the watermark, please read the readme file.',
        19 => 'You have to specify a opacity for the watermark.',
        20 => 'You have to specify a size for the watermark.',
        21 => 'You can use only the listed positions for the watermark, please read the readme file.',
        22 => 'Opacity for the watermark need to be bigger than 1% and lower than 100%.',
        23 => 'Size for the watermark need to be bigger than 1% and lower than 100%.',
        24 => 'Your path to the watermark does not exist.',
        25 => 'Unknown type of image format.',
        26 => 'Unknown type of image source, please read the readme file, to see available options.',
        27 => 'File does not exist',
        28 => 'Method for this type of image source is missing.',
        29 => 'Directory or file with this name already exist.',
        30 => 'This directory is not writable.',
        31 => 'Directory or file dose not exist.',
        32 => 'Quality of png extensions must be lower or eque to 9'
    );

    public function message() {
        return array('code' => $this->getMessage(), 'message' => $this->errors[$this->getMessage()]);
    }

}