<?php
declare (strict_types=1);
/**
 * By: Oyta
 * Email: oyta@daucn.com
 * local: daucn.com
 * Version: V1.0.0
 **/

namespace Oyta\Emercapp\Http;

class Sign
{
    public static function set($data,$key)
    {
        //ksort($data);
        $str =  implode("",$data);
        return md5($str.$key);
    }
}