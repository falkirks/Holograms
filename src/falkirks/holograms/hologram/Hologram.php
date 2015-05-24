<?php
namespace falkirks\holograms\hologram;


use pocketmine\level\Level;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;

class Hologram extends FloatingTextParticle{
    /** @var String */
    private $name;
    private $level;
    public function __construct(Position $pos, $name, $text, $title = ""){
        parent::__construct($pos, $text, $title);
        $this->name = $name;
        $this->level = $pos->getLevel();
    }
    public function spawn(){
        $this->level->addParticle($this, $this->level->getPlayers());
    }
    public function spawnTo(Player $player){
        if($this->getLevel() === $player->getLevel()){
            $this->getLevel()->addParticle($this, [$player]);
        }
    }

    public function setText($text){
        parent::setText($text);
        $this->spawn();
    }

    public function setTitle($title){
        parent::setTitle($title);
        $this->spawn();
    }

    /**
     * @return int
     */
    public function getText(){
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTitle(){
        return $this->title;
    }


    public function setInvisible($value = true){
        parent::setInvisible($value);
        $this->spawn();
    }

    /**
     * @return String
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return \pocketmine\level\Level
     */
    public function getLevel(){
        return $this->level;
    }

    public static function fromData($name, array $data){
        $level = Server::getInstance()->getLevelByName($data["level"]);
        if($level instanceof Level) {
            if(isset($data["text"])) {
                return new Hologram(new Position($data["x"], $data["y"], $data["z"], $level), $name, $data["text"], isset($data["title"]) ? $data["title"] : "");
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function toData(){
        $out = [];
        $out["text"] = $this->text;
        $out["title"] = $this->title;
        $out["x"] = $this->getX();
        $out["y"] = $this->getY();
        $out["z"] = $this->getZ();
        $out["level"] = $this->level->getName();
        return [$this->getName() => $out];
    }

}