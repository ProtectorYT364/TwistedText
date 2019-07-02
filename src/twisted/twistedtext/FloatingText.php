<?php
declare(strict_types=1);

namespace twisted\twistedtext;

use pocketmine\entity\Entity;

/**
 * Class FloatingText
 *
 * Note for developers: don't directly use this
 * entity, use TwistedText::addFloatingText()
 *
 * @package twisted\twistedtext
 */
class FloatingText extends Entity{

    public $width = 0;
    public $height = 0;

    public const NETWORK_ID = self::CHICKEN;

    protected function initEntity() : void{
        $this->setScale(0.0001); // Hacky method to make it not visible
        $this->setNameTagVisible();
        $this->setNameTagAlwaysVisible();
        $this->propertyManager->setFloat(self::DATA_BOUNDING_BOX_WIDTH, 0); // Hack to remove shadow
        $this->propertyManager->setFloat(self::DATA_BOUNDING_BOX_HEIGHT, 0); // Hack to remove shadow
    }

    public function updateText(string $newText) : void{
        $this->setNameTag($newText);
    }

    public function move(float $dx, float $dy, float $dz) : void{
    }

    public function isImmobile() : bool{
        return true;
    }
}