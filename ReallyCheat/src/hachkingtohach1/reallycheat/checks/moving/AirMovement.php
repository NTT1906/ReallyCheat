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
        //This is can false check
        $nLocation = $player->getNLocation();
        if(!empty($nLocation)){   
            $canCheck = !$player->isUnderAttack() and !$player->allowJump() and !$player->allowTeleport() and !$player->getAllowFlight() and !$player->isInLiquid() and !$player->isOnGround() and $player->getVelocityV() === 0 and $player->getLastGroundY() !== 0 and $nLocation["to"]->getY() > $player->getLastGroundY() and $nLocation["to"]->getY() > $nLocation["from"]->getY() ? true : false;           
            if($canCheck and $player->getOnlineTime() >= 15 and !$player->isCreative() and $player->getTimeSkipJump() > 10){     
                $distance = $nLocation["to"]->getY() - $player->getLastGroundY();                         
                $effects = [];
                $limit = 2;
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
