<?php

namespace hachkingtohach1\reallycheat\checks\fight;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class KillAura extends Check{

    public function getName() :string{
        return "KillAura";
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
        if($player->isAttackSpecial()){         
           $this->failed($player);
        }
    }

}