<?php
namespace Zing\Core\SettingBundle\Exception;



class SettingNotFoundException extends \Exception
{
    public function __construct($path, $file)
    {
        parent::__construct('File "'.$file.'" is not found in "'.$path.'"');
    }
}