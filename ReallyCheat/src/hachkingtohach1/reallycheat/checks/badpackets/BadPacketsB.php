<?php

namespace hachkingtohach1\reallycheat\checks\badpackets;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;

class BadPacketsB extends Check{

    public function getName() :string{
        return "BadPacketsB";
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
            if(abs($packet->getPosition()->getY()) > 500){
                $this->failed($player);
            }
        }
    }

}