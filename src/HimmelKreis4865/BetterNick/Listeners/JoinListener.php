<?php

namespace HimmelKreis4865\BetterNick\Listeners;

use HimmelKreis4865\BetterNick\BetterNick;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;


class JoinListener implements Listener
{
    /**
     * @var BetterNick
     */
    private $plugin;

    public function __construct(BetterNick $plugin)
    {
        $this->plugin = $plugin;
    }
    public function onJoin(PlayerJoinEvent $event)
    {
        if (BetterNick::usesPurePerms() === true){
            BetterNick::setNick($event->getPlayer(), BetterNick::getRankFormat($event->getPlayer()) . $event->getPlayer()->getName());
        }
    }
}