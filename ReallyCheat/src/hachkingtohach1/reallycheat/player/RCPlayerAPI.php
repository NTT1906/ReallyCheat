<?php

namespace hachkingtohach1\reallycheat\player;

use hachkingtohach1\reallycheat\components\player\RCPlayer;
use hachkingtohach1\reallycheat\components\player\IPlayerAPI;
use pocketmine\entity\Location;
use pocketmine\block\BlockLegacyIds;

class RCPlayerAPI extends RCPlayer implements IPlayerAPI{
    
    private bool $attackSpecial = false;
    private bool $underAttack = false;
    private bool $flagged = false;
    private bool $allowJump = false;
    private bool $allowTeleport = false;
    private bool $actionBreakingSpecial = false;
    private bool $actionPlacingSpecial = false;
    private bool $inventoryOpen = false;
    private bool $usingItem = false;
    private bool $transactionArmorInventory = false;
    private bool $attackedSinceVelocity = false;
    private bool $underBlock = false;
    private bool $sniffing = false;
    private bool $inLiquid = false;
    private bool $onStairs = false;
    private bool $onSlimeBlock = false;
    private bool $banWave = false;
    private bool $placing = false;
    private bool $banning = false;
    private bool $onIce = false;
    private float $lastGroundY = 0.0;
    private float $lastNoGroundY = 0.0;
    private float $velocityX = 0.0;
    private float $velocityY = 0.0;
    private float $velocityZ = 0.0;
    private float $lastDelayedMovePacket = 0.0;
    private float $lastAttackPacket = 0.0;
    private float $lastTeleportTime = 0.0;
    private float $lastVelocity = 0.0;
    private float $distanceInteractBlock = 0;
    private float $joinedAtTTime = 0;
    private float $timeSkipJump = 0;
    private float $attackReach = 0;
    private int $velocityH = 0;
    private int $velocityV = 0;
    private int $cps = 0;
    private int $blocksBrokeASec = 0;
    private int $blocksPlacedASec = 0;
    private int $numberBlocksAllowBreak = 1; //1 is normal action
    private int $numberBlocksAllowPlace = 1; //1 is normal action
    private array $violations = [];
    private array $nLocation = [];

    //Attack special
    public function isAttackSpecial() :bool{
        return $this->attackSpecial;
    }

    public function setAttackSpecial(bool $data) :void{
        $this->attackSpecial = $data;
    }

    //Under attack
    public function isUnderAttack() :bool{
        return $this->underAttack;
    }

    public function setUnderAttack(bool $data) :void{
        $this->underAttack = $data;
    }

    //Flagged
    public function isFlagged() :bool{
        return $this->flagged;
    }

    public function setFlagged(bool $data) :void{
        $this->flagged = $data;
    }

    //Teleport
    public function allowTeleport() :bool{
        return $this->allowTeleport;
    }

    public function setAllowTeleport(bool $data) :void{
        $this->allowTeleport = $data;
    }

    //Jump
    public function allowJump() :bool{
        return $this->allowJump;
    }

    public function setAllowJump(bool $data) :void{
        $this->allowJump = $data;
    }

    //Break many blocks just one time break (This can check NUKER PLAYER)
    public function actionBreakingSpecial() :bool{
        return $this->actionBreakingSpecial;
    }

    public function setActionBreakingSpecial(bool $data) :void{
        $this->actionBreakingSpecial = $data;
    }

    //Place many blocks just one time place (This can check FILLBLOCK PLAYER)
    public function actionPlacingSpecial() :bool{
        return $this->actionPlacingSpecial;
    }

    public function setActionPlacingSpecial(bool $data) :void{
        $this->actionPlacingSpecial = $data;
    }

    //Inventory
    public function isInventoryOpen() :bool{
        return $this->inventoryOpen;
    }

    public function setInventoryOpen(bool $data) :void{
        $this->inventoryOpen = $data;
    }

    //Using item
    public function isUsingItem() :bool{
        return $this->usingItem;
    }

    public function setUsingItem(bool $data) :void{
        $this->usingItem = $data;
    }

    //Transaction armor inventory
    public function isTransactionArmorInventory() :bool{
        return $this->transactionArmorInventory;
    }

    public function setTransactionArmorInventory(bool $data) :void{
        $this->transactionArmorInventory = $data;
    }

    //Attack
    public function isAttackedSinceVelocity() :bool{
        return $this->attackedSinceVelocity;
    }

    public function setAttackedSinceVelocity(bool $data) :void{
        $this->attackedSinceVelocity = $data;
    }

    //Under block
    public function isUnderBlock() :bool{
        return $this->underBlock;
    }

    public function setUnderBlock(bool $data) :void{
        $this->underBlock = $data;
    }

    //Sprinting
    public function isRCSprinting() :bool{
        return $this->isSprinting();
    }

    public function setRCSprinting(bool $data) :void{
        $this->setSprinting($data);
    }

    //On ground
    public function isOnGround() :bool{
        return $this->onGround;
    }

    public function setOnGround(bool $data) :void{
        $this->onGround = $data;
    }

    //Sniffing
    public function isSniffing() :bool{
        return $this->sniffing;
    }

    public function setSniffing(bool $data) :void{
        $this->sniffing = $data;
    }

    //In Liquid
    public function isInLiquid() :bool{
        return $this->inLiquid;
    }

    public function setInLiquid(bool $data) :void{
        $this->inLiquid = $data;
    }

    //On stairs
    public function isOnStairs() :bool{
        return $this->onStairs;
    }

    public function setOnStairs(bool $data) :void{
        $this->onStairs = $data;
    }

    //On Slime
    public function isOnSlime() :bool{
        return $this->onSlimeBlock;
    }

    public function setOnSlime(bool $data) :void{
        $this->onSlimeBlock = $data;
    }

    //Ban wave
    public function isBanWave() :bool{
        return $this->banWave;
    }

    public function setBanWave(bool $data) :void{
        $this->banWave = $data;
    }

    //Placing
    public function isPlacing() :bool{
        return $this->placing;
    }

    public function setPlacing(bool $data) :void{
        $this->placing = $data;
    }

    //Banning
    public function isBanning() :bool{
        return $this->banning;
    }

    public function setBanning(bool $data) :void{
        $this->banning = $data;
    }

    //On Ice
    public function isOnIce() :bool{
        return $this->onIce;
    }

    public function setOnIce(bool $data) :void{
        $this->onIce = $data;
    }

    //Digging
    public function isDigging() :bool{
        if($this->blockBreakHandler !== null){
            return true;
        }
        return false;
    }

    //In Web
    public function isInWeb() :bool{
        $world = $this->getWorld();
        $location = $this->getLocation();	
		$blocksAround = [
            $world->getBlock($location),
            $world->getBlock($location->add(0, 1, 0)),
			$world->getBlock($location->add(0, 2, 0)),
            $world->getBlock($location->subtract(0, 1, 0)),
			$world->getBlock($location->subtract(0, 2, 0))
        ];
        foreach($blocksAround as $block){
			if($block->getId() === BlockLegacyIds::COBWEB){
				return true;
			}
		}
        return false;
    }

    //Last ground Y
    public function getLastGroundY() :float{
        return $this->lastGroundY;
    }

    public function setlastGroundY(float $data) :void{
        $this->lastGroundY = $data;
    }

    //Last no ground Y
    public function getLastNoGroundY() :float{
        return $this->lastNoGroundY;
    }

    public function setlastNoGroundY(float $data) :void{
        $this->lastNoGroundY = $data;
    }

    //Velocity X
    public function getVelocityX() :float{
        return $this->velocityX;
    }

    public function setVelocityX(float $data) :void{
        $this->velocityX = $data;
    }

    //Velocity Y
    public function getVelocityY() :float{
        return $this->velocityY;
    }

    public function setVelocityY(float $data) :void{
        $this->velocityY = $data;
    }

    //Velocity Z
    public function getVelocityZ() :float{
        return $this->velocityZ;
    }

    public function setVelocityZ(float $data) :void{
        $this->velocityZ = $data;
    }

    //Last delayed move packet
    public function getLastDelayedMovePacket() :float{
        return $this->lastDelayedMovePacket;
    }

    public function setLastDelayedMovePacket(float $data) :void{
        $this->lastDelayedMovePacket = $data;
    }

    //Last attack packet
    public function getLastAttackPacket() :float{
        return $this->lastAttackPacket;
    }

    public function setLastAttackPacket(float $data) :void{
        $this->lastAttackPacket = $data;
    }

    //Last teleport time
    public function getLastTeleportTime() :float{
        return $this->lastTeleportTime;
    }

    public function setLastTeleportTime(float $data) :void{
        $this->lastTeleportTime = $data;
    }

    //Last velocity
    public function getLastVelocity() :float{
        return $this->lastVelocity;
    }

    public function setLastVelocity(float $data) :void{
        $this->lastVelocity = $data;
    }

    //Ping
    public function getPing() :float{
        return $this->getNetworkSession()->getPing();
    }

    //Velocity H
    public function getVelocityH() :int{
        return $this->velocityH;
    }

    public function setVelocityH(int $data) :void{
        $this->velocityH = $data;
    }

    //Velocity V
    public function getVelocityV() :int{
        return $this->velocityV;
    }

    public function setVelocityV(int $data) :void{
        $this->velocityV = $data;
    }

    //CPS
    public function getCPS() :int{
        return $this->cps;
    }

    public function setCPS(int $data) :void{
        $this->cps = $data;
    }

    //Number blocks broke one second
    public function getBlocksBrokeASec() :int{
        return $this->blocksBrokeASec;
    }

    public function setBlocksBrokeASec(int $data) :void{
        $this->blocksBrokeASec = $data;
    }

    //Number blocks place one second
    public function getBlocksPlacedASec() :int{
        return $this->blocksPlacedASec;
    }

    public function setBlocksPlacedASec(int $data) :void{
        $this->blocksPlacedASec = $data;
    }

    //Number blocks allow break per sec
    public function getNumberBlocksAllowBreak() :int{
        return $this->numberBlocksAllowBreak;
    }

    public function setNumberBlocksAllowBreak(int $data) :void{
        $this->numberBlocksAllowBreak = $data;
    }

    //Number blocks allow break per sec
    public function getNumberBlocksAllowPlace() :int{
        return $this->numberBlocksAllowPlace;
    }

    public function setNumberBlocksAllowPlace(int $data) :void{
        $this->numberBlocksAllowPlace = $data;
    }

    //Distance when place one block
    public function getDistanceInteractBlock() :float{
        return $this->distanceInteractBlock;
    }

    public function setDistanceInteractBlock(float $data) :void{
        $this->distanceInteractBlock = $data;
    }

    //Time when player join
    public function getJoinedAtTheTime() :float{
        return $this->joinedAtTTime;
    }

    public function setJoinedAtTheTime(float $data) :void{
        $this->joinedAtTTime = $data;
    }

    //Attack reach
    public function getAttackReach() :float{
        return $this->attackReach;
    }

    public function setAttackReach(float $data) :void{
        $this->attackReach = $data;
    }

    public function getOnlineTime() :int{
        $time = microtime(true) - $this->joinedAtTTime;
        $delayTime = $time - microtime(true);
        if($delayTime >= 1){
            return 0;
        }
        return (int)$time;
    }

    //Time skip check jump
    public function setTimeSkipJump(float $data) :void{
        $this->timeSkipJump = $data;
    }

    public function getTimeSkipJump() :int{
        $time = microtime(true) - $this->timeSkipJump;
        $delayTime = $time - microtime(true);
        if($delayTime >= 1){
            return 0;
        }
        return (int)$time;
    }

    //Violation
    public function getViolation(string $supplier) :int{
        if(isset($this->violations[$this->getName()][$supplier])){
            return $this->violations[$this->getName()][$supplier];
        }
        return 0;
    }

    public function setViolation(string $supplier, int $amount) :void{
        $this->violations[$this->getName()][$supplier] = $amount;
    }

    public function addViolation(string $supplier) :void{
        if(isset($this->violations[$this->getName()][$supplier])){
            $this->violations[$this->getName()][$supplier] += 1;
        }else{
            $this->violations[$this->getName()][$supplier] = 1;
        }
    }

    //Location
    public function getNLocation() :array{
        return $this->nLocation;
    }

    public function setNLocation(Location $from, Location $to) :void{
        $this->nLocation = ["from" => $from, "to" => $to];
    }

}