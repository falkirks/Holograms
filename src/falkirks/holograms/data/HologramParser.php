<?php
namespace falkirks\holograms\data;


use falkirks\holograms\hologram\Hologram;
use falkirks\holograms\hologram\TextHologram;
use pocketmine\Server;

class HologramParser {
    static private $classList = false;

    private static function init(){
        if(self::$classList === false){
            self::registerClasses();
        }
    }
    private static function registerClasses(){
        self::$classList = [];

        self::registerClass("text", TextHologram::class);
    }
    private static function registerClass($name, $class){
        self::$classList[$name] = $class;
    }
    public static function getHologram($name, $data){
        self::init();
        if(isset($data["type"]) && isset($data["level"]) && isset($data["x"]) && isset($data["y"]) && isset($data["z"])){
            if(isset(self::$classList[$data["type"]])){
                $class = self::$classList[$data["type"]];
                return $class::fromData($name, $data);
            }
        }
        return null;
    }
    public static function getHolograms($array, callable $failure = null){
        self::init();
        $out = [];
        foreach($array as $name => $data){
            $holo = self::getHologram($name, $data);
            if($holo instanceof Hologram){
                $out[] = $holo;
            }
            else{
                if($failure != null) {
                    $failure($name, $data);
                }
                else{
                    Server::getInstance()->getLogger()->error("Error loading hologram");
                }
            }
        }
        return $out;
    }
}