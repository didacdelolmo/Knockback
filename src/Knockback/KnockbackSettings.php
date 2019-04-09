<?php

declare(strict_types=1);

namespace Knockback;


class KnockbackSettings {

    /** @var Knockback */
    private $plugin;

    /** @var bool */
    private $enableKnockback;

    /** @var float */
    private $knockback;

    /** @var int */
    private $attackDelay;

    /** @var string[] */
    private $allowedWorlds;

    public function __construct(Knockback $plugin) {
        $this->plugin = $plugin;
        $this->initialize();
    }

    /**
     * @return bool
     */
    public function isEnableKnockback(): bool {
        return $this->enableKnockback;
    }

    /**
     * @return float
     */
    public function getKnockback(): float {
        return $this->knockback;
    }

    /**
     * @return int
     */
    public function getAttackDelay(): int {
        return $this->attackDelay;
    }

    /**
     * @return string[]
     */
    public function getAllowedWorlds(): array {
        return $this->allowedWorlds;
    }

    /**
     * @param bool $enableKnockback
     */
    public function setEnableKnockback(bool $enableKnockback): void {
        $this->enableKnockback = $enableKnockback;
    }

    /**
     * @param float $knockback
     */
    public function setKnockback(float $knockback): void {
        $this->knockback = $knockback;
    }

    /**
     * @param int $attackDelay
     */
    public function setAttackDelay(int $attackDelay): void {
        $this->attackDelay = $attackDelay;
    }

    public function saveSettings(): void {
        $config = $this->plugin->getConfig();

        $config->set("enable_knockback", $this->enableKnockback);
        $config->set("knockback", $this->knockback);
        $config->set("attack_delay", $this->attackDelay);
        $config->set("allowed_attack_delay_worlds", $this->allowedWorlds);

        $config->save();
    }


    private function initialize(): void {
        $config = $this->plugin->getConfig();

        $this->enableKnockback = $config->get("enable_knockback");
        $this->knockback = $config->get("knockback");
        $this->attackDelay = $config->get("attack_delay");
        $this->allowedWorlds = $config->get("allowed_attack_delay_worlds");
    }

}