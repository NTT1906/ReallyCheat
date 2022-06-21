<?php

namespace hachkingtohach1\reallycheat\checks\blockbreak;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class WrongMining extends Check{

    public function getName() :string{
        return "WrongMining";
    }

    public function enable() :bool{
        return true;
    }

    public function ban() :bool{
        return true;
    }

    public function maxViolations() :int{
        return 1;
    }

    public function check(DataPacket $packet, RCPlayerAPI $player) :void{
        $isCreative = $player->isCreative() ? 5 : 0;
        if($player->actionBreakingSpecial() and (($player->getNumberBlocksAllowBreak() + $isCreative) < $player->getBlocksBrokeASec())){
            $this->failed($player);
            $player->setActionBreakingSpecial(false);
            $player->setBlocksBrokeASec(0); 
            $player->setFlagged(true);          
        }
    }

}