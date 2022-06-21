<?php

/**
 *  Copyright (c) 2022 hachkingtohach1
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *  SOFTWARE.
 */

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
