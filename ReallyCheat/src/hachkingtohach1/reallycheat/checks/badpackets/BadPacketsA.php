<?php

namespace hachkingtohach1\reallycheat\checks\badpackets;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;

class BadPacketsA extends Check{

    public function getName() :string{
        return "BadPacketsA";
    }

    public function enable() :bool{
        return true;
    }

    public function ban() :bool{
        return false;
    }

    public function maxViolations() :int{
        return 5;
    }

    public function check(DataPacket $packet, RCPlayerAPI $player) :void{
        if($packet instanceof PlayerAuthInputPacket){
            if(abs($packet->getPitch()) > 90){           
                $this->failed($player);
            }
        }
    }

}