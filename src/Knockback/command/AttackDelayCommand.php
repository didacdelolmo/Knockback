<?php

declare(strict_types=1);

namespace Knockback\command;


use Knockback\Knockback;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class AttackDelayCommand extends Command {

    /** @var Knockback */
    private $plugin;

    /**
     * KnockbackCommand constructor.
     * @param Knockback $plugin
     */
    public function __construct(Knockback $plugin) {
        $this->plugin = $plugin;
        $this->setPermission("knockback.command");
        parent::__construct("attackdelay", "Change attack delay settings", "/attackdelay (number)");
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
        } elseif(!is_numeric($args[0])) {
            $sender->sendMessage("§aAttack delay value must be a number!");
            return;
        }

        $this->plugin->getSettings()->setAttackDelay((int) $args[0]);
        $sender->sendMessage("§aYou have set attack delay to §f$args[0]§a!");
    }

}