<?php
/**
 * Created by PhpStorm.
 * User: noahheyl
 * Date: 2015-06-24
 * Time: 5:22 PM
 */

namespace falkirks\holograms;


use falkirks\holograms\data\HologramParser;
use pocketmine\scheduler\PluginTask;

class HologramRegisterTask extends PluginTask{
    /**
     * Actions to execute when run
     *
     * @param $currentTick
     *
     * @return void
     */
    public function onRun($currentTick){
        /** @var Holograms $plugin */
        $plugin = $this->getOwner();
        $plugin->getHologramManager()->addHolograms(HologramParser::getHolograms($plugin->getConfig()->getAll()));
    }


}