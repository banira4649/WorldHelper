<?php

declare(strict_types=1);

namespace banira4649\WorldHelper\commands;

use pocketmine\command\{Command, CommandSender};
use pocketmine\player\Player;

class WorldCommand extends Command{

    public function __construct(string $name, $main){
        $this->setPermission("pocketmine.group.operator");
        parent::__construct($name, "ワールドに関する操作を行います");
        $this->main = $main;
        $this->server = $main->getServer();
        $this->worldManager = $main->getServer()->getWorldManager();
    }

    public function execute(CommandSender $sender, string $label, array $args){
        if($args !== []){
            switch($args[0]){
                case "load":
                if(isset($args[1])){
                    $result = $this->worldManager->loadWorld($args[1]);
                    $result ? $sender->sendMessage("§aWorld loaded successfully.") : $sender->sendMessage("§cFailed to load the world.");
                }
                return true;

                case "unload":
                if(isset($args[1])){
                    $result = $this->worldManager->unloadWorld($args[1]);
                    $result ? $sender->sendMessage("§aWorld unloaded successfully.") : $sender->sendMessage("§cFailed to unload the world.");
                }
                return true;

                case "tp":
                if($sender instanceof Player){
                    if(isset($args[1])){
                        $this->worldManager->loadWorld($args[1]);
                        $world = $this->worldManager->getWorldByName($args[1]);
                        $world !== null ? $sender->sendMessage("§aYou teleported successfully.") : $sender->sendMessage("§cWorld not found.");
                        $sender->teleport($world?->getSafeSpawn() ?? $sender->getLocation());
                    }
                }
                return true;

                case "list":
                $worlds = $this->worldManager->getWorlds();
                $list = [];
                foreach($worlds as $world){
                    $name = $world->getDisplayName();
                    array_push($list, $name);
                }
                $list = implode(", ", $list);
                $sender->sendMessage("§aロードされているワールド: "."\n"."§b".$list);
                return true;
            }
        }
    }

}
