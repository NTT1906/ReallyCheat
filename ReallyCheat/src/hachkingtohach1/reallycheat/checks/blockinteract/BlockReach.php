<?php

namespace hachkingtohach1\reallycheat\checks\blockinteract;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class BlockReach extends Check{

    public function getName() :string{
        return "BlockReach";
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
        if($player->getDistanceInteractBlock() > 6){
            $this->failed($player);         
        }
    }

}