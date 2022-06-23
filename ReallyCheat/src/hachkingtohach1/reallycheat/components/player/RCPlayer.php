<?php
declare(strict_types=1);

namespace hachkingtohach1\reallycheat\components\player;

use hachkingtohach1\reallycheat\components\registry\ComponentWithName;
use pocketmine\player\Player;

abstract class RCPlayer extends Player implements ComponentWithName{

	public function getComponentName() :string{
		return "ReallyCheat_RCPlayer";
	}

}