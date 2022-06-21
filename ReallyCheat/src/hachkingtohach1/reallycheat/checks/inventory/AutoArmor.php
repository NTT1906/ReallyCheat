<?php

namespace hachkingtohach1\reallycheat\checks\inventory;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class AutoArmor extends Check{

    public function getName() :string{
        return "AutoArmor";
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

    //This only causes cheaters to slow down their actions
    public function check(DataPacket $packet, RCPlayerAPI $player) :void{
        if($player->isInventoryOpen() and $player->isTransactionArmorInventory()){
            $this->failed($player);               
        }else{
            $player->setTransactionArmorInventory(false);
        }     
    }

}