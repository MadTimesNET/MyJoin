<?php

namespace Pytrox\MyJoin;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\utils\TextFormat as Color;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Pytrox\MyJoin\commands\MyJoinCommand;

class Main extends PluginBase implements Listener
{
    public $prefix = Color::BOLD . Color::RED . "My" . Color::AQUA . "Join" . Color::DARK_GRAY . " > " . Color::RESET . Color::GRAY;
    
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info($this->prefix . Color::GREEN . 'Plugin was loaded.');
        $this->getServer()->getLogger()->info($this->prefix . Color::GREEN . 'Made by: github.com/MadTimesNET.');
        $this->getServer()->getCommandMap()->register('myjoin', new MyJoinCommand($this));
        $config = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
        if (empty)
        {
            $config->set('messageformat', '§l§b{player}§r§7: §e{message}');
            $config->set('defaultmessage', 'The king is now online!');
            $config->save();
        }
    }
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $config = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
        $playerfile = new Config($this->getDataFolder() . 'players/' . $player->getName() . '.yml', Config::YAML);
        if ($sender->hasPermission("myjoin.myjoin"))
        {
            $message = $playerfile->get('status');
            $this->getServer()->broadcastMessage($this->convert($config->get('messageformat'), $player, $message));
        }
    }
    public function onJoin(PlayerLoginEvent $event)
    {
        $config = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
        $playerfile = new Config($this->getDataFolder() . 'players/' . $player->getName() . '.yml', Config::YAML);
        if (empty($playerfile))
        {
            $playerfile->set('status', $config->get('defaultmessage'));
            $playerfile->save();
        }
    }
    public function convert(string $string, $player, $message) : string
    {
        $string = str_replace("{player}", $player, $string);
        $string = str_replace("{message}", $message, $string);
        return $string;
    }
}