<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-11
 * Time: 16:29
 */
namespace FkMetabox\Utils;

class Dumper
{
     public static function dd ($data)
    {
        static::debug($data);
        die;
    }


    static public function debug ($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}