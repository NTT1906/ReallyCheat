<?php

namespace hachkingtohach1\reallycheat\checks\fight;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class Reach extends Check{

    public function getName() :string{
        return "Reach";
    }

    public function enable() :bool{
        return true;
    }

    public function ban() :bool{
        return false;
    }

    public function maxViolations() :int{
        return 3;
    }

    public function check(DataPacket $packet, RCPlayerAPI $player) :void{
        if($player->getAttackReach() > 3.36){
            $this->failed($player);
        }
    }

}