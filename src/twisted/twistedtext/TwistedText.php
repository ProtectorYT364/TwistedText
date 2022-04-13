<?php
declare(strict_types=1);

namespace twisted\twistedtext;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use function implode;

class TwistedText extends PluginBase{

    /** @var TwistedText */
    private static $instance;

    /** @var FloatingText[] */
    private $floatingTexts = [];

    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        $this->saveDefaultConfig();
        Entity::registerEntity(FloatingText::class, true);
        $this->loadFloatingTexts();
    }

    public function onDisable(): void {
        foreach($this->floatingTexts as $floatingText){
            $floatingText->close(); // Using flagForDespawn() will not work here
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::RED . "Use command in game");

            return false;
        }
        if(!$sender->hasPermission("twistedtext.command")){
            return false;
        }
        if(empty($args)){
            return false;
        }
        $this->addFloatingText(implode(" ", $args), $sender);
        $sender->sendMessage(TextFormat::GREEN . "Spawned a floating text at your location");

        return true;
    }

    public static function getInstance() : TwistedText{
        return self::$instance;
    }

    public function saveFloatingText(FloatingText $floatingText) : void{
        $config = $this->getConfig();
        $floatingTexts = $config->get("floating-texts", []);
        $floatingTexts[] = [
            "text" => $floatingText->getNameTag(),
            "position" => [
                "x" => $floatingText->getX(),
                "y" => $floatingText->getY(),
                "z" => $floatingText->getZ(),
                "world" => $floatingText->getWorld()->getName()
            ]
        ];
        $config->set("floating-texts", $floatingTexts);
        $config->save();
    }

    public function loadFloatingTexts(): void {
        foreach($this->getConfig()->get("floating-texts", []) as $data){
            $world = $this->getServer()->getWorldByName($data["position"]["world"] ?? "");
            $this->getServer()->loadWorld($data["position"]["world"]);
            $position = new Vector3($data["position"]["x"] ?? 0, $data["position"]["y"] ?? 0, $data["position"]["z"] ?? 0);
            $floatingText = Entity::createEntity("FloatingText", $world ?? $this->getServer()->getDefaultWorld(), Entity::createBaseNBT($position));
            if($floatingText instanceof FloatingText){
                $floatingText->setNameTag($data["text"] ?? "");
                $floatingText->spawnToAll();
                $this->floatingTexts[] = $floatingText;
            }
        }
    }

    public function addFloatingText(string $text, Position $position) : ?FloatingText{
        $floatingText = Entity::createEntity("FloatingText", $position->getWorld(), Entity::createBaseNBT($position));
        if($floatingText instanceof FloatingText){
            $floatingText->setNameTag($text);
            $floatingText->spawnToAll();
            $this->floatingTexts[] = $floatingText;
            $this->saveFloatingText($floatingText);
        }

        return $floatingText;
    }
}