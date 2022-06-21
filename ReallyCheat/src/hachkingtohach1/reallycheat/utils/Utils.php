<?php

namespace hachkingtohach1\reallycheat\utils;

use hachkingtohach1\reallycheat\RCAPIProvider;

class Utils{

    /**
     * @param string $file
	 * @return string
     */
    public static function getResourceFile(string $file): string{
        return str_replace(["\\utils", "/utils"], DIRECTORY_SEPARATOR . "resources", __DIR__) . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * @param string $directory
	 * @param callable $callable
	 * @return void
     */
    public static function callDirectory(string $directory, callable $callable): void{
		$main = explode("\\", RCAPIProvider::getInstance()->getDescription()->getMain());
		unset($main[array_key_last($main)]);
        $pathPlugin = RCAPIProvider::getInstance()->getServer()->getPluginPath(). "/ReallyCheat";
        $main = implode("/", $main);
        $directory = rtrim(str_replace(DIRECTORY_SEPARATOR, "/", $directory), "/");
        $dir = rtrim($pathPlugin, "/" . DIRECTORY_SEPARATOR) . "/" . "src/$main/" . $directory;
        foreach(array_diff(scandir($dir), [".", ".."]) as $file){
            $path = $dir . "/$file";
            $extension = pathinfo($path)["extension"] ?? null;
            if($extension === null){
                self::callDirectory($directory."/".$file, $callable);
            }elseif($extension === "php"){
                $namespaceDirectory = str_replace("/", "\\", $directory);
                $namespaceMain = str_replace("/", "\\", $main);
                $namespace = $namespaceMain."\\$namespaceDirectory\\". basename($file, ".php");
                $callable($namespace);
            }
        }
    }
}