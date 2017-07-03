<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Utilities
{

    public static function json_decode( String $file, $associative = true ) : Array
    {
        $handle = \fopen( $file, "r");
        $contents = \json_decode( \fread( $handle, \filesize( $file ) ), $associative );
        \fclose( $handle );
        return $contents;
    }

}