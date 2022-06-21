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

namespace hachkingtohach1\reallycheat\listener;

use hachkingtohach1\reallycheat\components\player\RCPlayer;
use hachkingtohach1\reallycheat\RCAPIProvider;
use hachkingtohach1\reallycheat\utils\Utils;
use hachkingtohach1\reallycheat\utils\BlockUtil;
use hachkingtohach1\reallycheat\utils\MathUtil;
use hachkingtohach1\reallycheat\player\RCPlayerAPI;
use hachkingtohach1\reallycheat\components\registry\RCListener;
use pocketmine\inventory\ArmorInventory;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\types\LevelSoundEvent;
use pocketmine\math\Vector3;

class PlayerListener extends RCListener{

    private ?RCAPIProvider $plugin;
    private array $blockInteracted = [];
    private array $clicksData = [];

    const DELTAL_TIME_CLICK = 1;
    
    public function __construct(RCAPIProvider $plugin){
        $this->plugin = $plugin;
    }

    public function onPlayerCreation(PlayerCreationEvent $event) {
		$event->setPlayerClass(RCPlayerAPI::class);
	}

    public function onDataPacketReceive(DataPacketReceiveEvent $event) :void{
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();
        $files = ["badpackets", "blockbreak", "blockplace", "blockinteract", "fight", "inventory", "moving"];
        if($player instanceof RCPlayerAPI){
            foreach($files as $file){
                Utils::callDirectory("checks/$file", function (string $namespace) use($packet, $player): void{
                    $class = new $namespace();
                    if($class->enable()){                                       
                        $class->check($packet, $player);
                    }
                });
            }
            if($player->isUnderAttack()) $player->setUnderAttack(false);
            if($player->isAttackSpecial()) $player->setAttackSpecial(false);
            if($player->allowJump()) $player->setAllowJump(false);
            if($packet instanceof LevelSoundEventPacket){
                if($packet->sound === LevelSoundEvent::ATTACK_NODAMAGE){
                    $this->addCPS($player);
                    $player->setCPS($this->getCPS($player));
                }
            }
            if($packet instanceof InventoryTransactionPacket){
                if($packet->trData instanceof UseItemOnEntityTransactionData){
                    $this->addCPS($player);
                    $player->setCPS($this->getCPS($player)); 
                }
            }
        }
    }

	public function onPlayerMove(PlayerMoveEvent $event) :void{
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){
            $player->setNLocation($event->getFrom(), $event->getTo());
            $player->setOnGround(BlockUtil::isOnGround($event->getTo(), 0) or BlockUtil::isOnGround($event->getTo(), 1));
            if($player->isOnGround()){
                $player->setLastGroundY($player->getPosition()->getY());
            }else{             
                $player->setLastNoGroundY($player->getPosition()->getY());
            }    
            if($event->getTo()->getY() != $event->getFrom()->getY() && $player->getVelocityV() > 0){
                $player->setVelocityV($player->getVelocityV() - 1);
            }
            if(hypot($event->getTo()->getX() - $event->getFrom()->getX(), $event->getTo()->getZ() - $event->getFrom()->getZ()) > 0.0 && $player->getVelocityH() > 0){
                $player->setVelocityH($player->getVelocityH() - 1);
            }
            if($player->getVelocityY() > 0.0 && $event->getTo()->getY() > $event->getFrom()->getY()){
                $player->setVelocityY(0.0);
            }
            $player->setOnSlime(BlockUtil::onSlimeBlock($event->getTo(), 0) or BlockUtil::onSlimeBlock($event->getTo(), 1));          
            if($player->isOnSlime()){
                $player->setTimeSkipJump(microtime(true));
            }
            $player->setOnIce(BlockUtil::isOnIce($event->getTo(), 1) or BlockUtil::isOnIce($event->getTo(), 2));
            $player->setOnStairs(BlockUtil::isOnStairs($event->getTo(), 0) or BlockUtil::isOnStairs($event->getTo(), 1));
            $player->setUnderBlock(BlockUtil::isOnGround($player->getLocation(), -2));
            $player->setInLiquid(BlockUtil::isOnLiquid($event->getTo(), 0) or BlockUtil::isOnLiquid($event->getTo(), 1));
        }
    }

    public function onPlayerInteract(PlayerInteractEvent $event) :void{
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $posBlock = $block->getPosition();
        $posPlayer = $player->getPosition();
        if(!isset($this->blockInteracted[$player->getXuid()])){
            $this->blockInteracted[$player->getXuid()] = $block;
        }else{
            unset($this->blockInteracted[$player->getXuid()]);
        }
        if($player instanceof RCPlayerAPI){
            $isBlockTop = $posBlock->getY() > $posPlayer->getY() ? -1 : 0;
            $distance = BlockUtil::distance($posPlayer, $posBlock) + $isBlockTop;
            $player->setDistanceInteractBlock($distance);
        }
    }

    public function onPlayerBreak(BlockBreakEvent $event) :void{
        $block = $event->getBlock();
        $x = $block->getPosition()->getX();
        $z = $block->getPosition()->getZ();
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){ 
            if($player->isFlagged()){
                $event->cancel(); 
                $player->setFlagged(false);
            }         
            if(isset($this->blockInteracted[$player->getXuid()])){
                $blockInteracted = $this->blockInteracted[$player->getXuid()];       
                $xI = $blockInteracted->getPosition()->getX();
                $zI = $blockInteracted->getPosition()->getZ();
                if((int)$x != (int)$xI and (int)$z != (int)$zI){                  
                    $player->setActionBreakingSpecial(true);
                    $player->setBlocksBrokeASec($player->getBlocksBrokeASec() + 1);                   
                }else{
                    $player->setBlocksBrokeASec(0);  
                    unset($this->blockInteracted[$player->getXuid()]);
                }
            }           
		}
    }

    public function onPlayerPlace(BlockPlaceEvent $event) :void{
        $block = $event->getBlock();
        $x = $block->getPosition()->getX();
        $z = $block->getPosition()->getZ();
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){  
            if($player->isFlagged()){
                $event->cancel(); 
                $player->setFlagged(false);
            }
            if(isset($this->blockInteracted[$player->getXuid()])){
                $blockInteracted = $this->blockInteracted[$player->getXuid()];       
                $xI = $blockInteracted->getPosition()->getX();
                $zI = $blockInteracted->getPosition()->getZ();
                if((int)$x != (int)$xI and (int)$z != (int)$zI){
                    $player->setActionPlacingSpecial(true);
                    $player->setBlocksPlacedASec($player->getBlocksPlacedASec() + 1);                                      
                }else{
                    $player->setBlocksPlacedASec(0);
                    unset($this->blockInteracted[$player->getXuid()]);  
                }            
            }
		}
    }

    public function onPlayerItemUse(PlayerItemUseEvent $event){
        $player = $event->getPlayer();       
        if($player instanceof RCPlayerAPI){
            $player->setUsingItem(true);
        }
    }

    public function onInventoryTransaction(InventoryTransactionEvent $event){
        $player = $event->getTransaction()->getSource();
        if($player instanceof RCPlayerAPI) foreach($event->getTransaction()->getInventories() as $inventory){          
            if($inventory instanceof ArmorInventory){
                $player->setTransactionArmorInventory(true);
            }
        }
    }

    public function onInventoryOpen(InventoryOpenEvent $event){
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){
            $player->setInventoryOpen(true);
        }
    }

    public function onInventoryClose(InventoryCloseEvent $event){
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){
            $player->setInventoryOpen(false);
        }
    }

    public function onEntityTeleport(EntityTeleportEvent $event){
        $entity = $event->getEntity();
        if($entity instanceof RCPlayerAPI){
            $entity->setAllowTeleport(true);
        }
    }

    public function onPlayerJump(PlayerJumpEvent $event){
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){
            $player->setAllowJump(true);
        }
    }

    public function onPlayerJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if($player instanceof RCPlayerAPI){
            $player->setJoinedAtTheTime(microtime(true));
        }
    }

    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event){
        $cause = $event->getCause();
        $entity = $event->getEntity();
        $damager = $event->getDamager();
        $locEntity = $entity->getLocation();
        $locDamager = $damager->getLocation();
        //$event->setAttackCooldown(0.1);       
        if($cause === EntityDamageEvent::CAUSE_ENTITY_ATTACK and $damager instanceof RCPlayerAPI){
            $isPlayerTop = $locEntity->getY() > $locDamager->getY() ? ($locEntity->getY() - $locDamager->getY()) : 0;
            $distance = MathUtil::distance($locEntity, $locDamager) - $isPlayerTop;
            $damager->setAttackReach($distance); 
            $delta = MathUtil::getDeltaDirectionVector($damager, 3);	
            $from = new Vector3($locDamager->getX(), $locDamager->getY() + $damager->getEyeHeight(), $locDamager->getZ());           
            $to = $damager->getLocation()->add($delta->getX(), $delta->getY() + $damager->getEyeHeight(), $delta->getZ());		
            $distance = MathUtil::distance($from, $to);
            $vector = $to->subtract($from->x, $from->y, $from->z)->normalize()->multiply(1);
            $entities = [];
            for($i = 0; $i <= $distance; $i += 1){
                $from = $from->add($vector->x, $vector->y, $vector->z);
                foreach($damager->getWorld()->getEntities() as $target){	
                    $distanceA = new Vector3($from->x, $from->y, $from->z);
                    if($target->getPosition()->distance($distanceA) <= 2.6){
                        $entities[$target->getId()] = $target;
                    }
                }
            }
            if(!isset($entities[$entity->getId()])){
                $damager->setAttackSpecial(true);
            }
        }
        if($entity instanceof RCPlayerAPI){
            $entity->setUnderAttack(true);
        }
    }

    private function addCPS(RCPlayerAPI $player) :void{
        $time = microtime(true);
        $this->clicksData[$player->getName()][] = $time;
    }

    private function getCPS(RCPlayerAPI $player) :int{
        $newTime = microtime(true);
        return count(array_filter($this->clicksData[$player->getName()] ?? [], static function(float $lastTime) use ($newTime):bool{
            return ($newTime - $lastTime) <= self::DELTAL_TIME_CLICK;
        }));
    }

}
