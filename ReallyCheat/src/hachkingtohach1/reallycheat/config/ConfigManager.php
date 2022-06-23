<?php
declare(strict_types=1);

namespace hachkingtohach1\reallycheat\config;

use hachkingtohach1\reallycheat\components\config\ConfigPaths;
use hachkingtohach1\reallycheat\RCAPIProvider;

class ConfigManager extends ConfigPaths{

    public static function getData(string $path){
        return RCAPIProvider::getInstance()->getConfig()->getNested($path);
    }

	public static function setData(string $path, $data) : void{
		RCAPIProvider::getInstance()->getConfig()->setNested($path, $data);
	}

	public static function setLogs(string $path, $data) : void{
		RCAPIProvider::getInstance()->getConfig()->setNested($path, $data);
	}

}