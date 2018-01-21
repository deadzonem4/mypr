<?php

namespace Zing\Core\CoreBundle\Plugin;


use Symfony\Component\Config\Definition\Exception\Exception;

class Generator {
    private $min_unique_length = 25;

    /** Generate unique string
     * @param $length The length of the generated string, it must be bigger or equals to 25
     * @return string Generate unique string
     * @throws Exception If length is lower than 25
     */
    public function uniqueString($length = 32)
    {

        $length = (int)$length;

        /** On what symbol to substr the unixtime */
        $unixtime_substr = 8;

        /** If request length is lower than the minimum length for generating unique string  */
        if($length < $this->min_unique_length) {
            throw new Exception('The length you have requested is lower than the minimum for generating unique strings. It must be bigger or equals to '.$this->min_unique_length);
        }

        /** Generate unique string */
        $unique_string = substr(time(), $unixtime_substr, 2).substr(str_shuffle(time().str_shuffle('asdfghqwertyuiopasdfghjklzxcvbnm0123456789').rand(111, 9999)), 0, ($length - $unixtime_substr) - 2).substr(time(), 0, $unixtime_substr);
        
        /** If the generated string is bigger than the maximum */
        if(strlen($unique_string) > 64) {
            $unique_string = substr(time(), $unixtime_substr, 2).substr($unique_string, 0, (64-$unixtime_substr)-2).substr(time(), 0, $unixtime_substr);
        }
        elseif($length >= 64 && strlen($unique_string) < 64) {
            $unique_string .= rand(strlen($length - strlen($unique_string)), strlen($length - strlen($unique_string)));
        }

        return $unique_string;
    }
} 