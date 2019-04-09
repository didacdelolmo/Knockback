<?php

declare(strict_types=1);

namespace Knockback;


use Knockback\command\AttackDelayCommand;
use Knockback\command\KnockbackCommand;
use pocketmine\plugin\PluginBase;

class Knockback extends PluginBase {

    /** @var Knockback */
    private static $instance;

    /** @var KnockbackSettings */
    private $settings;

    public function onLoad() {
        self::$instance = $this;
        if(!is_dir($dataFolder = $this->getDataFolder())) {
            mkdir($dataFolder);
        }
    }

    public function onEnable() {
        $this->settings = new KnockbackSettings($this);

        $this->registerEvents();
        $this->registerCommands();

        $this->getLogger()->info("§8[§cKnockback§8] §7Knockback has been enabled!");
    }

    public function registerEvents(): void {
        $this->getServer()->getPluginManager()->registerEvents(new KnockbackListener($this), $this);
    }

    public function onDisable() {
        $this->settings->saveSettings();
    }

    public function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("attackdelay", new AttackDelayCommand($this));
        $commandMap->register("knockback", new KnockbackCommand($this));
    }

    /**
     * @return KnockbackSettings
     */
    public function getSettings(): KnockbackSettings {
        return $this->settings;
    }

}