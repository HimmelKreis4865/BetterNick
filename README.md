# BetterNick

### What it is:
BetterNick is a pretty smart nickname manager to change your / other nicknames, or to see who uses which name.
There is a simple API for Developer, you can see under API in this Readme.
##
### Features
> - compatible with PurePerms and PureChat -> nicknames can be changed with a group prefix (impossible to lose it).
> - custom rank format for it.
> - every message is customizable.
> - change your nickname or others.
> - nickname is showed at playerlist.
> - checking who uses the realname.
> - Auto-Complete for realname search.
> - simple API for developers.
> - possible rainbow to give yourself a rainbow name.
> - customizable command, description and aliases and permission for each part of command.
##
### What's new - V2
> - Completely renew of code.
> - PurePerms is now possible.
> - added API.
> - customizable commands + messages + permissions.
> - auto-complete search for realname.
##
### Commands & Usage
> - The command is customizable in config.yml, as default, it's called `/nick`

Command-Argument | Default-Permission | Alias | Function | Usage
---|----|---|---|---
set | nick.set | s | Change your own nickname | /nick set <nickname> [rainbow]
reset | nick.reset | r | Reset your own nickname | /nick reset
adminset| nick.adminset | as | Change other nicknames | /nick adminset <player> <nickname> [rainbow]
adminreset | nick.adminreset | ar | Reset other nicknames | /nick adminreset <player>
realname |  NONE | rn | See which player uses the given nickname | /nick realname <nickname>

> - [rainbow] means the possibility to add a rainbow nickname, which is in different colors.
> - permission NONE means, everyone can use it by default.

##
### API
You need to use the BetterNick class: 
````php
use HimmelKreis4865\BetterNick\BetterNick;
````
Set a nickname, (the function checks for PurePerms)
```php
/**
* @param Player $player
 * @param string $nick
 */
BetterNick::setNick($player, $nick);
```
Reset a nickname, (the function checks also for PurePerms)
````php
/**
* @param Player $player
 */
BetterNick::resetNick($player);
````
get the realname of a nickname,
````php
/**
* @param string $nickname
 * @return array $players
 */
BetterNick::getRealName($nickname);
````
get the rank format of the a player,
````php
/**
 * @param Player $player
 */
BetterNick::getRankFormat($player);
````
get the rainbow string of a string
````php
/**
* @param string $nick
 */
BetterNick::getRainbowString($nick);
````