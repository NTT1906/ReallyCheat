<?php

namespace hachkingtohach1\reallycheat\checks\moving;

use hachkingtohach1\reallycheat\checks\Check;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\network\mcpe\protocol\DataPacket;

class AirMovement extends Check{

    public function getName() :string{
        return "AirMovement";
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
        $nLocation = $player->getNLocation();
        if(!empty($nLocation)){   
            $canCheck = !$player->isUnderAttack() and !$player->allowJump() and !$player->allowTeleport() and !$player->getAllowFlight() and !$player->isInLiquid() and !$player->isOnGround() and $player->getVelocityV() === 0 and $player->getLastGroundY() !== 0 and $nLocation["to"]->getY() > $player->getLastGroundY() and $nLocation["to"]->getY() > $nLocation["from"]->getY() ? true : false;           
            if($canCheck and $player->getOnlineTime() >= 15 and !$player->isCreative() and $player->getTimeSkipJump() > 10){     
                $distance = $nLocation["to"]->getY() - $player->getLastGroundY();                         
                $effects = [];
                $limit = 1.45;
                foreach($player->getEffects()->all() as $index => $effect){
                    $transtable = $effect->getType()->getName()->getText();
                    $effects[$transtable] = $effect->getEffectLevel() + 1;
                }
                $limit += isset($effects["potion.jump"]) ? (pow($effects["potion.jump"] + 1.4, 2) / 16) : 0;
                if($distance > $limit){
                    $this->failed($player);
                }            
            }
        }
    }

}