<?php

declare(strict_types=1);

namespace Knockback\command;


use Knockback\Knockback;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class KnockbackCommand extends Command {

    /** @var Knockback */
    private $plugin;

    /**
     * KnockbackCommand constructor.
     * @param Knockback $plugin
     */
    public function __construct(Knockback $plugin) {
        $this->plugin = $plugin;
        $this->setPermission("knockback.command");
        parent::__construct("knockback", "Change knockback settings", "/knockback (enable/disable/<value>) <number>", ["kb"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!$this->testPermission($sender)) {
            return;
        } elseif(!isset($args[0])) {
            $sender->sendMessage($this->getUsage());
            return;
        }

        switch($args[0]) {
            case "enable":
                $this->allowKnockback();
                $sender->sendMessage("§aYou have enabled knockback!");
                break;

            case "disable":
                $this->allowKnockback(false);
                $sender->sendMessage("§aYou have disabled knockback!");
                break;

            case "value":
                if(!isset($args[1]) or !is_numeric($args[1])) {
                    break;
                }

                $this->setKnockback($args[1]);
                $sender->sendMessage("§aYou have set knockback to §f$args[1]§a!");
                break;
        }
    }

    /**
     * @param bool $bool
     */
    public function allowKnockback(bool $bool = true): void {
        $this->plugin->getConfig()->set("enable_knockback", $bool);
    }

    /**
     * @param float $knockback
     */
    public function setKnockback(float $knockback): void {
        $this->plugin->getConfig()->set("knockback", $knockback);
    }

}