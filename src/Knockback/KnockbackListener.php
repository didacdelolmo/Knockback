<?php

declare(strict_types=1);

namespace Knockback;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;

class KnockbackListener implements Listener {

    /** @var Knockback */
    private $plugin;

    /**
     * KnockbackListener constructor.
     * @param Knockback $plugin
     */
    public function __construct(Knockback $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event): void {
        $settings = $this->plugin->getSettings();

        $allowedWorlds = $settings->getAllowedWorlds();
        if(empty($allowedWorlds)) {
            return;
        }

        foreach($allowedWorlds as $world) {
            if($event->getEntity()->getLevel()->getName() != $world) {
                continue;
            }

            $event->setAttackCooldown($settings->getAttackDelay());
            return;
        }
    }

    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function onFight(EntityDamageByEntityEvent $event): void {
        $settings = $this->plugin->getSettings();

        if($settings->isEnableKnockback()) {
            $event->setKnockBack($settings->getKnockback());
        }
    }

}