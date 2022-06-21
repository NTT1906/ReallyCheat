<?php

namespace hachkingtohach1\reallycheat\logging;

use hachkingtohach1\reallycheat\RCAPIProvider;
use hachkingtohach1\reallycheat\components\log\ILog;

class LogManager implements ILog{

    public static function ContentLogger(string $text) :void{
        $today = date("Y-m-d");
        $file = fopen(RCAPIProvider::getInstance()->getDataFolder() . "{$today}.txt", "a+") or die("Unable to open file!");
        fwrite($file, "[{$today} " . date("h:i:sA") . "] {$text}\n");
        fclose($file);
    }

    public static function sendLogger(string $text) :void{
        RCAPIProvider::getInstance()->getLogger()->warning($text);           
        LogManager::ContentLogger($text);
    }

}