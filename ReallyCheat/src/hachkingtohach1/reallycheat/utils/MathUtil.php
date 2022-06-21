<?php

namespace hachkingtohach1\reallycheat\utils;

use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use pocketmine\math\Vector3;

class MathUtil{

    public static function getVectorOnEyeHeight(RCPlayerAPI $player){
        return $player->getLocation()->add(0, $player->getEyeHeight(), 0);
    }

    public static function getDeltaDirectionVector(RCPlayerAPI $player, float $distance){
        return $player->getDirectionVector()->multiply($distance);
    }

    public static function distance(Vector3 $from, Vector3 $to){
        return sqrt(pow($from->getX() - $to->getX(), 2) + pow($from->getY() - $to->getY(), 2) + pow($from->getZ() - $to->getZ(), 2));
    }

}