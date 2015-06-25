<?php
namespace falkirks\holograms\command;


use falkirks\holograms\data\HologramParser;
use falkirks\holograms\hologram\Textable;
use falkirks\holograms\hologram\TextHologram;
use falkirks\holograms\hologram\Titleable;
use falkirks\holograms\Holograms;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;

class HologramsCommand extends Command implements PluginIdentifiableCommand{
    private $holograms;
    public function __construct(Holograms $holograms){
        parent::__construct("holograms", "Manage holograms.", "/", ["hologram", "holo"]);
        $this->holograms = $holograms;
    }
    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param string[] $args
     *
     * @return mixed
     */
    public function execute(CommandSender $sender, $commandLabel, array $args){
        if(isset($args[0])){
            switch($args[0]){
                case 'c':
                case 'create':
                case 'spawn':
                case 'new':
                case 'n':
                    if($sender instanceof Player) {
                        if (isset($args[1])) {
                            if ($this->getPlugin()->getHologramManager()->getHologram($args[1]) === null) {
                                if (!isset($args[2])) $args[2] = "text";
                                $holo = HologramParser::getHologram($args[1], [
                                    "x" => $sender->getX(),
                                    "y" => $sender->getY(),
                                    "z" => $sender->getZ(),
                                    "level" => $sender->getLevel()->getName(), //FIXME
                                    "type" => $args[2]
                                ]);
                                if($holo !== false){
                                    $this->getPlugin()->getHologramManager()->addHologram($holo);
                                    $sender->sendMessage("Hologram added");
                                }
                                else{
                                    $sender->sendMessage("Bad hologram type.");
                                }
                            }
                            else {
                                $sender->sendMessage("A hologram already exists with that name");
                            }
                        }
                        else {
                            $sender->sendMessage("You need to specify a name for your hologram.");
                        }
                    }
                    else{
                        $sender->sendMessage("This command must be run in-game.");
                    }
                    break;
                case 'h':
                case 'title':
                    if(isset($args[1])){
                        if (($holo = $this->getPlugin()->getHologramManager()->getHologram($args[1])) !== null) {
                            if($holo instanceof Titleable){
                                $holo->setTitle(isset($args[2]) ? implode(" ", array_slice($args, 2)) : "");
                            }
                            else{
                                $sender->sendMessage("That hologram is not \"titleable\"");
                            }
                        }
                        else{
                            $sender->sendMessage("That hologram doesn't exist");
                        }
                    }
                    else{
                        $sender->sendMessage("You need to specify a hologram.");
                    }

                    break;
                case 'm':
                case 'text':
                case 'content':
                    if(isset($args[1])){
                        if (($holo = $this->getPlugin()->getHologramManager()->getHologram($args[1])) !== null) {
                            if($holo instanceof Textable){
                                $holo->setText(isset($args[2]) ? implode(" ", array_slice($args, 2)) : "");
                            }
                            else{
                                $sender->sendMessage("That hologram is not \"textable\"");
                            }
                        }
                        else{
                            $sender->sendMessage("That hologram doesn't exist");
                        }
                    }
                    else{
                        $sender->sendMessage("You need to specify a hologram.");
                    }
                    break;
            }
        }
        else{
            $sender->sendMessage($this->getPlugin()->getDescription()->getName() . "_v" . $this->getPlugin()->getDescription()->getVersion() . " by " . $this->getPlugin()->getDescription()->getAuthors()[0]);
        }
    }

    /**
     * @return \falkirks\holograms\Holograms
     */
    public function getPlugin(){
        return $this->holograms;
    }

}