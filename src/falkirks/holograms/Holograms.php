<?php
namespace falkirks\holograms;

use falkirks\holograms\command\HologramsCommand;
use falkirks\holograms\data\HologramParser;
use falkirks\holograms\hologram\HologramManager;
use pocketmine\plugin\PluginBase;

class Holograms extends PluginBase{
    /** @var  HologramsCommand */
    private $hologramsCommand;
    /** @var  HologramManager */
    private $hologramManager;
    public function onEnable(){
        $this->saveDefaultConfig();

        $this->hologramsCommand = new HologramsCommand($this);
        $this->getServer()->getCommandMap()->register("holograms", $this->hologramsCommand);

        $this->hologramManager = new HologramManager($this);
        $this->getServer()->getScheduler()->scheduleDelayedTask(new HologramRegisterTask($this), 1);

    }
    public function onDisable(){
        $out = [];
        foreach($this->hologramManager->getHolograms() as $hologram){
            $out = array_merge($out, $hologram->toData());
        }
        $this->getConfig()->setAll($out);
        $this->getConfig()->save();
    }

    /**
     * @return HologramsCommand
     */
    public function getHologramsCommand(){
        return $this->hologramsCommand;
    }

    /**
     * @return HologramManager
     */
    public function getHologramManager(){
        return $this->hologramManager;
    }


}