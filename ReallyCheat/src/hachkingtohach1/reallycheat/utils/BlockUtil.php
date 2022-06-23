<?php
declare(strict_types=1);
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

namespace hachkingtohach1\reallycheat\utils;

use pocketmine\block\BlockLegacyIds;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\world\Position;

class BlockUtil{
	public const AIR = [
		BlockLegacyIds::AIR,
	];

	public const STAIRS = [
		BlockLegacyIds::STONE_STAIRS,
		BlockLegacyIds::OAK_STAIRS,
		BlockLegacyIds::BIRCH_STAIRS,
		BlockLegacyIds::BRICK_STAIRS,
		BlockLegacyIds::STONE_BRICK_STAIRS,
		BlockLegacyIds::ACACIA_STAIRS,
		BlockLegacyIds::JUNGLE_STAIRS,
		BlockLegacyIds::PURPUR_STAIRS,
		BlockLegacyIds::QUARTZ_STAIRS,
		BlockLegacyIds::SPRUCE_STAIRS,
		BlockLegacyIds::WOODEN_STAIRS,
		BlockLegacyIds::DIORITE_STAIRS,
		BlockLegacyIds::GRANITE_STAIRS,
		BlockLegacyIds::ANDESITE_STAIRS,
		BlockLegacyIds::DARK_OAK_STAIRS,
		BlockLegacyIds::END_BRICK_STAIRS,
		BlockLegacyIds::SANDSTONE_STAIRS,
		BlockLegacyIds::PRISMARINE_STAIRS,
		BlockLegacyIds::COBBLESTONE_STAIRS,
		BlockLegacyIds::NETHER_BRICK_STAIRS,
		BlockLegacyIds::NORMAL_STONE_STAIRS,
		BlockLegacyIds::RED_SANDSTONE_STAIRS,
		BlockLegacyIds::SMOOTH_QUARTZ_STAIRS,
		BlockLegacyIds::DARK_PRISMARINE_STAIRS,
		BlockLegacyIds::POLISHED_DIORITE_STAIRS,
		BlockLegacyIds::POLISHED_GRANITE_STAIRS,
		BlockLegacyIds::RED_NETHER_BRICK_STAIRS,
		BlockLegacyIds::SMOOTH_SANDSTONE_STAIRS,
		BlockLegacyIds::MOSSY_COBBLESTONE_STAIRS,
		BlockLegacyIds::MOSSY_STONE_BRICK_STAIRS,
		BlockLegacyIds::POLISHED_ANDESITE_STAIRS,
		BlockLegacyIds::PRISMARINE_BRICKS_STAIRS,
		BlockLegacyIds::SMOOTH_RED_SANDSTONE_STAIRS,
	];

	public const ICE = [
		BlockLegacyIds::ICE,
		BlockLegacyIds::BLUE_ICE,
		BlockLegacyIds::PACKED_ICE,
		BlockLegacyIds::FROSTED_ICE,
	];

	public const LIQUIDS = [
		BlockLegacyIds::WATER,
		BlockLegacyIds::LAVA,
		BlockLegacyIds::FLOWING_WATER,
		BlockLegacyIds::FLOWING_LAVA,
	];

	public static function isOnGround(Location $location, int $down = 0) : bool{ // Todo: remove the amount of if-else
		$posX = $location->getX();
		$posZ = $location->getZ();
		$fracX = (fmod($posX, 1.0) > 0.0) ? abs(fmod($posX, 1.0)) : (1.0 - abs(fmod($posX, 1.0)));
		$fracZ = (fmod($posZ, 1.0) > 0.0) ? abs(fmod($posZ, 1.0)) : (1.0 - abs(fmod($posZ, 1.0)));
		$blockX = $location->getX();
		$blockY = $location->getY() - $down;
		$blockZ = $location->getZ();
		$world = $location->getWorld();
		$block_id = $world->getBlock(new Vector3($blockX, $blockY, $blockZ))->getId();
		if (!in_array($block_id, self::ID, true)) {
			return true;
		}
		if ($fracX < 0.3) {
			if (!in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ))->getId(), self::ID, true)) {
				return true;
			}
			if ($fracZ < 0.3) {
				if (!in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ - 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ - 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ - 1))->getId(), self::ID, true)
				) {
					return true;
				}
			} else if ($fracZ > 0.7) {
				if (!in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ + 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ + 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ + 1))->getId(), self::ID, true)
				) {
					return true;
				}
			}
        }elseif($fracX > 0.7) {
			if (!in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ))->getId(), self::ID, true)) {
				return true;
			}
			if ($fracZ < 0.3) {
				if (!in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ - 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ - 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ - 1))->getId(), self::ID, true)
				) {
					return true;
				}
			} else if ($fracZ > 0.7) {
				if (!in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ + 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ + 1))->getId(), self::ID, true) ||
					!in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ + 1))->getId(), self::ID, true)
				) {
					return true;
				}
			}
		} else if ($fracZ < 0.3 && !in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ - 1))->getId(), self::ID, true)) {
			return true;
		} else if ($fracZ > 0.7 && !in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ + 1))->getId(), self::ID, true)) {
			return true;
		}
        return false;
    }

	public static function isUnderBlock(Location $location, array $id, int $down = 0) : bool{
		$posX = $location->getX();
		$posZ = $location->getZ();
		$fracX = (fmod($posX, 1.0) > 0.0) ? abs(fmod($posX, 1.0)) : (1.0 - abs(fmod($posX, 1.0)));
		$fracZ = (fmod($posZ, 1.0) > 0.0) ? abs(fmod($posZ, 1.0)) : (1.0 - abs(fmod($posZ, 1.0)));
		$blockX = $location->getX();
		$blockY = $location->getY() - $down;
		$blockZ = $location->getZ();
		$world = $location->getWorld();
		if (in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ))->getId(), $id, true)) {
			return true;
		}
		if ($fracX < 0.3) {
			if (in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ))->getId(), $id, true)) return true;
			if ($fracZ < 0.3) {
				if (in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ - 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ - 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ - 1))->getId(), $id, true)
				) {
					return true;
				}
			} else if ($fracZ > 0.7) {
				if (in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ + 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ + 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ + 1))->getId(), $id, true)) {
					return true;
				}
			}
        }elseif($fracX > 0.7) {
			if (in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ))->getId(), $id, true)) {
				return true;
			}
			if ($fracZ < 0.3) {
				if (in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ - 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ - 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ - 1))->getId(), $id, true)
				) {
					return true;
				}
			} else if ($fracZ > 0.7) {
				if (in_array($world->getBlock(new Vector3($blockX - 1, $blockY, $blockZ + 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ + 1))->getId(), $id, true) ||
					in_array($world->getBlock(new Vector3($blockX + 1, $blockY, $blockZ + 1))->getId(), $id, true)) {
					return true;
				}
			}
		} else if ($fracZ < 0.3) {
			if (in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ - 1))->getId(), $id, true)) {
				return true;
			}
		} else if ($fracZ > 0.7 && in_array($world->getBlock(new Vector3($blockX, $blockY, $blockZ + 1))->getId(), $id, true)) {
			return true;
		}
        return false;
    }

    public static function isOnStairs(Location $location, int $down = 0) :bool{
        return self::isUnderBlock($location, self::STAIRS, $down);
    }

    public static function isOnIce(Location $location, int $down) :bool{
        return self::isUnderBlock($location, self::ICE, $down);
    }

    public static function isOnLiquid(Location $location, int $down) :bool{
	    return self::isUnderBlock($location, self::LIQUIDS, $down);
    }

	public static function onSlimeBlock(Location $location, int $down) : bool{
		return self::isUnderBlock($location, [BlockLegacyIds::SLIME_BLOCK], $down); // on but under? wut?
	}

	public static function distance(Position $a, Position $b) : float{ // Recommend Vector3::distance(Vector3 $pos)
		//return sqrt((($a->getX() - $b->getX()) ** 2) + (($a->getY() - $b->getY()) ** 2) + (($a->getZ() - $b->getZ()) ** 2));
		return $a->distance($b);
	}

}
