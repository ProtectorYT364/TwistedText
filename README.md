[![](https://poggit.pmmp.io/shield.state/TwistedText)](https://poggit.pmmp.io/p/TwistedText) [![](https://poggit.pmmp.io/shield.api/TwistedText)](https://poggit.pmmp.io/p/TwistedText) [![](https://poggit.pmmp.io/shield.dl.total/TwistedText)](https://poggit.pmmp.io/p/BetterVoting)

# TwistedText
TwistedText is a small plugin for PocketMine-MP which implements a better version of FloatingTexts, which do not spawn in all worlds and can be spawned using a command.

# API Usage
TwistedText has a simple API; all it is, is 1 method to create a floating text! ``\twisted\twistedtext\TwistedText::addFloatingText()`` requires 2 parameters, a ``string`` for the text, and a ``\pocketmine\level\Position`` instance for the position of the floating text. This method returns ``null`` or a ``\twisted\twistedtext\FloatingText`` instance.
> Note: When you create a floating text, it automatically saves the data to the config.
To update the name of a floating text, you can use the ``\twisted\twistedtext\FloatingText::updateText()`` method. It requires a ``string`` instance for the new text.
## API Example
```php
$twistedText = \twisted\TwistedText\TwistedText::getInstance();
$floatingText = $twistedText->addFloatingText("Hello", \pocketmine\Server::getInstance()->getDefaultLevel()->getSpawn());
$floatingText->updateText("Hello World!");
```