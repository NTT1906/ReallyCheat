<?php
declare(strict_types=1);

namespace hachkingtohach1\reallycheat\components\log;

interface ILog{

    public static function ContentLogger(string $text) :void;

    public static function sendLogger(string $text) :void;
    
}
