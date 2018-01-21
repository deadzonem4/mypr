<?php
namespace Zing\Core\SettingBundle\Exception;



class SettingFileException extends \Exception
{
    public function __construct($default_setting, $file)
    {
        parent::__construct('Incorrect bundle setting "'.$default_setting.'" is not found in file "'.$file.'"');
    }
}