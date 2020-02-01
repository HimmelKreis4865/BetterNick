<?php

namespace HimmelKreis4865\BetterNick\Commands;

use HimmelKreis4865\BetterNick\BetterNick;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class NickCommand extends Command
{
    public function __construct(string $name = "nick", string $description = "", array $aliases = [])
    {
        parent::__construct($name, $description, null, $aliases);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return true;
        if (isset($args[0])){
            switch($args[0]){
                case "set":
                case "s":
                    if (!$sender->hasPermission(BetterNick::getString("set.permission"))){
                        $sender->sendMessage(BetterNick::getString("general.nopermission"));
                        return true;
                    }
                    if (isset($args[1])){
                        if (isset($args[2]) and $args[2] === "rainbow") {
                            $nick = BetterNick::getRainbowString($args[1]);
                        }else{
                            $nick = $args[1];
                        }
                        if (BetterNick::usesPurePerms() === true) $nick = BetterNick::getRankFormat($sender) . $nick;
                        BetterNick::setNick($sender, $nick);
                        $sender->sendMessage(str_replace("{nick}", $nick, BetterNick::getString("set.success")));
                    }else{
                        $sender->sendMessage(BetterNick::getString("set.syntax"));
                    }
                    break;

                case "reset":
                case "r":
                    if (!$sender->hasPermission(BetterNick::getString("reset.permission"))){
                        $sender->sendMessage(BetterNick::getString("general.nopermission"));
                        return true;
                    }
                    BetterNick::resetNick($sender);
                    $sender->sendMessage(BetterNick::getString("reset.success"));
                    break;

                case "adminset":
                case "as":
                    if (!$sender->hasPermission(BetterNick::getString("adminset.permission"))){
                        $sender->sendMessage(BetterNick::getString("general.nopermission"));
                        return true;
                    }
                    if (isset($args[2])){
                        $target = BetterNick::$instance->getServer()->getPlayer($args[1]);
                        if ($target !== null){
                            if (isset($args[3]) and $args[3] === "rainbow") {
                                $nick = BetterNick::getRainbowString($args[2]);
                            }else{
                                $nick = $args[2];
                            }
                            if (BetterNick::usesPurePerms() === true) {
                                $nick = BetterNick::getRankFormat($target) . $nick;
                            }
                            BetterNick::setNick($target, $nick);
                            $sender->sendMessage(str_replace("{nick}", $nick, str_replace("{player}", $target->getName(), BetterNick::getString("adminset.success"))));
                            $target->sendMessage(str_replace("{nick}", $nick, str_replace("{player}", $sender->getName(), BetterNick::getString("adminset.successByOther"))));
                        }else{
                            $sender->sendMessage(BetterNick::getString("general.notFound"));
                        }
                    }else{
                        $sender->sendMessage(BetterNick::getString("adminset.syntax"));
                    }
                    break;

                case "adminreset":
                case "ar":
                    if (!$sender->hasPermission(BetterNick::getString("adminreset.permission"))){
                        $sender->sendMessage(BetterNick::getString("general.nopermission"));
                        return true;
                    }
                    if (isset($args[1])){
                        $target = BetterNick::$instance->getServer()->getPlayer($args[1]);
                        if ($target !== null){
                            BetterNick::resetNick($target);
                            $sender->sendMessage(str_replace("{player}", $target->getName(), BetterNick::getString("adminreset.success")));
                            $target->sendMessage(str_replace("{player}", $sender->getName(), BetterNick::getString("adminreset.successByOther")));
                        }else{
                            $sender->sendMessage(BetterNick::getString("general.notFound"));
                        }
                    }else{
                        $sender->sendMessage(BetterNick::getString("adminreset.syntax"));
                    }
                    break;
                case "realname":
                case "rn":
                    if (isset($args[1])){
                        $sender->sendMessage(BetterNick::sendRealNameAsSting($args[1]));
                    }else{
                        $sender->sendMessage(BetterNick::getString("realname.syntax"));
                    }
                    break;
                default:
                    $sender->sendMessage(BetterNick::getString("general.help"));
                    break;
            }
        }else{
            $sender->sendMessage(BetterNick::getString("general.help"));
        }
        return true;
    }
}