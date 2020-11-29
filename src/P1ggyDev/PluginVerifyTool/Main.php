<?php

namespace P1ggyDev\PluginVerifyTool;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as C;

class Main extends PluginBase {
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        if($cmd->getName() == "verifyplugin") {
            if(!$sender instanceof Player) {
                if(empty($args[0])) {
                    $sender->sendMessage(C::YELLOW . "Usage: /verifyplugin <plugin name> <hash> \n" . C::RED . "Example: /verifyplugin Sheep 5bce5fc181f786a27efdb907d0975540e843739a7117edb53dabc1e350ba9735");                    
                    return true;
                } else {
                    if(empty($args[1])) {
                        $sender->sendMessage(C::YELLOW . "Usage: /verifyplugin <plugin name> <hash> \n" . C::RED . "Example: /verifyplugin Sheep 5bce5fc181f786a27efdb907d0975540e843739a7117edb53dabc1e350ba9735");
                        return true;
                    } else {
                        $pluginName = $args[0];
                        $pluginHash = strtolower($args[1]);
                        $pluginDirectory = $this->getServer()->getDataPath() . "plugins/" . $pluginName . ".phar";
                        if(file_exists($pluginDirectory)) {
                            $hashStr = hash_file("sha256", $pluginDirectory);
                            if($pluginHash == strtolower($hashStr)) {
                                $sender->sendMessage(C::GREEN . "Valid!");
                                return true;
                            } else {
                                $sender->sendMessage($hashStr);
                                $sender->sendMessage(C::RED . "You are holding the corrupted file!");
                                return true;
                            }
                        } else {
                            $sender->sendMessage(C::RED . "Plugin not found!");
                            return true;
                        }
                    }
                }
            } else {
                $sender->sendMessage(C::RED . "Please use this command in console");
            }
        }
        return true;
    }
}