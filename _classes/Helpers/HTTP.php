<?php

namespace Helpers;

class HTTP
{
   static $baseUrl = 'http://localhost/products_store';

   static function redirect($path, $q = '')
    {
        $url = static::$baseUrl . $path;
        if($q) $url .= "?$q";

        header("location: $url");
        exit();
    }
}