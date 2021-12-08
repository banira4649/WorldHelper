<?php

declare(strict_types=1);

namespace banira4649\WorldHelper;

use pocketmine\plugin\PluginBase;
use banira4649\WorldHelper\commands\WorldCommand;

class Main extends PluginBase implements \pocketmine\event\Listener{

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->registerAll($this->getName(), [
            new WorldCommand("world", $this)
        ]);
    }

}
