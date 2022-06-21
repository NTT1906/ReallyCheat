<?php

namespace hachkingtohach1\reallycheat\checks\blockplace;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class FillBlock extends Check{

    public function getName() :string{
        return "FillBlock";
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
        if($player->actionPlacingSpecial() and (($player->getNumberBlocksAllowPlace() + $isCreative) < $player->getBlocksPlacedASec())){
            $this->failed($player);
            $player->setActionPlacingSpecial(false);
            $player->setBlocksPlacedASec(0); 
            $player->setFlagged(true);          
        }
    }

}