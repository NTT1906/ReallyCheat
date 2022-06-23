<?php
declare(strict_types=1);

namespace hachkingtohach1\reallycheat\components\player;

use pocketmine\entity\Location;

interface IPlayerAPI{

	public function isAttackSpecial() : bool;

	public function setAttackSpecial(bool $data) : void;

	public function isUnderAttack() : bool;

	public function setUnderAttack(bool $data) : void;

	public function isFlagged() : bool;

	public function setFlagged(bool $data) : void;

	public function allowTeleport() : bool;

	public function setAllowTeleport(bool $data) : void;

	public function allowJump() : bool;

	public function setAllowJump(bool $data) : void;

	public function actionBreakingSpecial() : bool;

	public function setActionBreakingSpecial(bool $data) : void;

	public function actionPlacingSpecial() : bool;

	public function setActionPlacingSpecial(bool $data) : void;

	public function isInventoryOpen() : bool;

	public function setInventoryOpen(bool $data) : void;

	public function isUsingItem() : bool;

	public function setUsingItem(bool $data) : void;

	public function isTransactionArmorInventory() : bool;

	public function setTransactionArmorInventory(bool $data) : void;

	public function isAttackedSinceVelocity() : bool;

	public function setAttackedSinceVelocity(bool $data) : void;

	public function isUnderBlock() : bool;

	public function setUnderBlock(bool $data) : void;

	public function isRCSprinting() : bool;

	public function setRCSprinting(bool $data) : void;

	public function isOnGround() : bool;

	public function setOnGround(bool $data) : void;

	public function isSniffing() : bool;

	public function setSniffing(bool $data) : void;

	public function isInLiquid() : bool;

	public function setInLiquid(bool $data) : void;

	public function isOnStairs() : bool;

	public function setOnStairs(bool $data) : void;

	public function isOnSlime() : bool;

	public function setOnSlime(bool $data) : void;

	public function isBanWave() : bool;

	public function setBanWave(bool $data) : void;

	public function isPlacing() : bool;

	public function setPlacing(bool $data) : void;

	public function isBanning() : bool;

	public function setBanning(bool $data) : void;

	public function isOnIce() : bool;

	public function setOnIce(bool $data) : void;

	public function isDigging() : bool;

	public function isInWeb() : bool;

	public function getLastGroundY() : float;

	public function setlastGroundY(float $data) : void;

	public function getLastNoGroundY() : float;

	public function setlastNoGroundY(float $data) : void;

	public function getVelocityX() : float;

	public function setVelocityX(float $data) : void;

	public function getVelocityY() : float;

	public function setVelocityY(float $data) : void;

	public function getVelocityZ() : float;

	public function setVelocityZ(float $data) : void;

	public function getLastDelayedMovePacket() : float;

	public function setLastDelayedMovePacket(float $data) : void;

	public function getLastAttackPacket() : float;

	public function setLastAttackPacket(float $data) : void;

	public function getLastTeleportTime() : float;

	public function setLastTeleportTime(float $data) : void;

	public function getLastVelocity() : float;

	public function setLastVelocity(float $data) : void;

	public function getPing() : float;

	public function getVelocityH() : int;

	public function setVelocityH(int $data) : void;

	public function getVelocityV() : int;

	public function setVelocityV(int $data) : void;

	public function getCPS() : int;

	public function setCPS(int $data) : void;

	public function getBlocksBrokeASec() : int;

	public function setBlocksBrokeASec(int $data) : void;

	public function getBlocksPlacedASec() : int;

	public function setBlocksPlacedASec(int $data) : void;

	public function getNumberBlocksAllowBreak() : int;

	public function setNumberBlocksAllowBreak(int $data) : void;

	public function getNumberBlocksAllowPlace() : int;

	public function setNumberBlocksAllowPlace(int $data) : void;

	public function getDistanceInteractBlock() : float;

	public function setDistanceInteractBlock(float $data) : void;

	public function getJoinedAtTheTime() : float;

	public function setJoinedAtTheTime(float $data) : void;

	public function getAttackReach() : float;

	public function setAttackReach(float $data) : void;

	public function getOnlineTime() : int;

	public function setTimeSkipJump(float $data) : void;

	public function getTimeSkipJump() : int;

	public function getViolation(string $supplier) : int;

	public function setViolation(string $supplier, int $amount) : void;

	public function addViolation(string $supplier) : void;

	public function getNLocation() : array;

	public function setNLocation(Location $from, Location $to) : void;

}
