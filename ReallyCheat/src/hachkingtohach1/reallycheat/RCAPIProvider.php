<?php

namespace hachkingtohach1\reallycheat;

use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use hachkingtohach1\reallycheat\components\player\RCPlayer;
use hachkingtohach1\reallycheat\components\IRCAPI;
use hachkingtohach1\reallycheat\listener\PlayerListener;
use pocketmine\plugin\PluginBase;

class RCAPIProvider extends PluginBase implements IRCAPI{
	
	private static $instance = null;
	
	/**
	 * @return void
	 */
	public function onLoad() :void{
        self::$instance = $this;
	}
	
	/**
	 * @return RCAPIProvider
	 */
	public static function getInstance(): self{
        return self::$instance;
    }
        
    /**
     * @return void
     */
    public function onEnable() :void{
        $this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
    }

	/**
	 * @param RCPlayer $player
	 * 
	 * @return bool
	 */
	public function isRCPlayerAPI(RCPlayer $player) :bool{
		if($player instanceof RCPlayerAPI){
			return true;
		}
		return false;
	}
	
}