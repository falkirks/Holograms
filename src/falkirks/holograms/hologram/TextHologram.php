<?php
namespace falkirks\holograms\hologram;


use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\Server;

class TextHologram extends Hologram implements Titleable, Textable{
    public static function fromData($name, array $data){
        $level = Server::getInstance()->getLevelByName($data["level"]);
        if($level instanceof Level) {
            return new TextHologram(new Position($data["x"], $data["y"], $data["z"], $level), $name, isset($data["text"]) ? $data["text"] : "", isset($data["title"]) ? $data["title"] : "");
        }
        else{
            return false;
        }
    }
}