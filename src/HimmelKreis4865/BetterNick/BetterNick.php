<?php

namespace HimmelKreis4865\BetterNick;

use HimmelKreis4865\BetterNick\Commands\NickCommand;
use HimmelKreis4865\BetterNick\Listeners\JoinListener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;

class BetterNick extends PluginBase
{
    /**
     * @var null|BetterNick
     */
    public static $instance = null;

	public function onEnable()
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("BetterNick", new NickCommand($this->getConfig()->getNested("command.name"), $this->getConfig()->getNested("command.description"), (array) $this->getConfig()->getNested("command.aliases")));
	    $this->getServer()->getPluginManager()->registerEvents(new JoinListener($this), $this);
    }

    /**
     * @return bool
     */
    public static function usesPurePerms() :bool
    {
        return BetterNick::getString("ranks.enabled");
    }

    /**
     * @param string $config_path
     * @return string
     */
    public static function getString(string $config_path) :string
    {
        return BetterNick::$instance->getConfig()->getNested($config_path);
    }

    /**
     * @param Player $player
     * @param string $nick
     * @param bool $rainbow
     */
	public static function setNick(Player $player, string $nick, bool $rainbow = false)
    {
        $nick = ($rainbow === true ? BetterNick::getRainbowString($nick) : $nick);
        if (BetterNick::usesPurePerms() === true){
            $player->setDisplayName(BetterNick::getRankFormat($player) . $player->getName());
        }
        $player->setDisplayName($nick);
    }

    /**
     * @param Player $player
     * @return string
     */
    public static function getRankFormat(Player $player) :string
    {
        $pperms = self::$instance->getServer()->getPluginManager()->getPlugin("PurePerms");
        $format = BetterNick::getString("ranks.format." . $pperms->getUserDataMgr()->getGroup($player)->getName());
        return ($format !== null ? $format : BetterNick::getString("ranks.format-default"));
    }

    /**
     * @param string $nick
     * @return string
     */
    public static function getRainbowString (string $nick) :string
    {
        $string = str_split($nick);
        $newString = "";
        $amount = 0;

        foreach ($string as $str){
            if ($str !== " "){
                $am = str_split($amount);
                if (isset($am[2])) $am = $am[2];
                elseif (isset($am[1])) $am = $am[1];
                elseif (isset($am[0])) $am = $am[0];
                $returns = $am;
                if ($am == 0) $returns = "§1";
                if ($am == 1) $returns = "§3";
                if ($am == 2) $returns = "§b";
                if ($am == 3) $returns = "§a";
                if ($am == 4) $returns = "§e";
                if ($am == 5) $returns = "§6";
                if ($am == 6) $returns = "§d";
                if ($am == 7) $returns = "§c";
                if ($am == 8) $returns = "§4";
                if ($am == 9) $returns = "§8";

                $ab = $returns . $str;
                $newString .= $ab;
                $amount++;
            }else{
                $newString .= " ";
            }
        }
        return $newString;
    }

    /**
     * @param Player $player
     */
    public static function resetNick(Player $player)
    {
        if (BetterNick::usesPurePerms() === true) {
            $nick = BetterNick::getRankFormat($player) . $player->getName();
        }else{
            $nick = $player->getName();
        }
        BetterNick::setNick($player, $nick);
    }

    /**
     * @param string $nickname
     * @return array
     */
    public static function getRealName(string $nickname) :array
    {
        $players = [];
        foreach (self::$instance->getServer()->getOnlinePlayers() as $player){
            if (strpos($player->getDisplayName(), $nickname) !== false) array_push($players, $player->getName());
        }
        return $players;
    }

    /**
     * @param string $nickname
     * @return string
     */
    public static function sendRealNameAsSting(string $nickname) :string
    {
        $players = BetterNick::getRealName($nickname);
        $text = BetterNick::getString("realname.title");
        if (count($players) > 0) {
            foreach ($players as $p) {
                $p = self::$instance->getServer()->getPlayer($p);
                $text .= str_replace("{player}", $p->getName(), str_replace("{nickname}", $p->getDisplayName(), BetterNick::getString("realname.player")));
            }
        }else{
            $text .= BetterNick::getString("realname.no-player");
        }
        return $text;
    }
}