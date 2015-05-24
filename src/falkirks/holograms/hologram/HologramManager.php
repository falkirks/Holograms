<?php
namespace falkirks\holograms\hologram;


use falkirks\holograms\Holograms;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\utils\Config;

class HologramManager implements Listener{
    /** @var Holograms  */
    private $plugin;
    /** @var  Hologram[] */
    private $holograms;
    public function __construct(Holograms $holograms){
        $this->plugin = $holograms;
        $this->holograms = [];
        $this->getPlugin()->getServer()->getPluginManager()->registerEvents($this, $this->getPlugin());
    }
    /**
     * @param $name
     * @return Hologram|null
     */
    public function getHologram($name){
        return isset($this->holograms[$name]) ? $this->holograms[$name] : null;
    }
    /**
     * @return Hologram[]
     */
    public function getHolograms(){
        return $this->holograms;
    }
    public function addHologram(Hologram $hologram){
        $hologram->spawn();
        $this->holograms[$hologram->getName()] = $hologram;
    }
    public function addHolograms(array $holograms){
        foreach($holograms as $hologram){
            $this->addHologram($hologram);
        }
    }
    public function spawnAllTo(Player $player){
        foreach($this->holograms as $hologram){
            $hologram->spawnTo($player);
        }
    }
    public function onEntityTeleport(EntityTeleportEvent $event){
        if($event->getEntity() instanceof Player && $event->getFrom()->getLevel() !== $event->getTo()->getLevel()){
            $this->spawnAllTo($event->getEntity());
        }
    }
    public function onPlayerJoin(PlayerJoinEvent $event){
        $this->spawnAllTo($event->getPlayer());
    }

    /**
     * @return Holograms
     */
    public function getPlugin(){
        return $this->plugin;
    }

}