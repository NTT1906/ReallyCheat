<?php
declare(strict_types=1);

namespace hachkingtohach1\reallycheat\components;

use hachkingtohach1\reallycheat\player\RCPlayerAPI;

interface IRCAPI{

	public function isRCPlayerAPI(RCPlayerAPI $player) : bool;

}