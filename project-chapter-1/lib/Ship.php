<?php

class Ship {

    private $name = "";
    private $weaponPower = 0;
    private $spatiodriveBooster = 0;
    private $strength = 0;
    private $isUnderRepair = false;

    public function __construct()
    {
        $this->isUnderRepair = mt_rand(1, 100) < 30;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setWeaponPower(int $weaponPower)
    {
        $this->weaponPower = $weaponPower;
    }

    public function setSpatiodriveBooster(int $spatiodriveBooster)
    {
        $this->spatiodriveBooster = $spatiodriveBooster;
    }

    public function setStrength(int $strength)
    {
        $this->strength = $strength;
    }

    public function setIsUnderRepair(bool $isUnderRepair)
    {
        $this->isUnderRepair = $isUnderRepair;
    }


    public function sayHello()
    {
    echo 'Hello!';
    }

    public function getName()
    {
    return $this->name;
    }

    public function getWeaponPower()
    {
        return $this->weaponPower;
    }

    public function getSpatiodriveBooster()
    {
        return $this->spatiodriveBooster;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function getNameUppercase()
    {
        return strtoupper($this->name);
    }

    public function getIsUnderRepair()
    {
        return $this->isUnderRepair;
    }

    public function isFunctional()
    {
        return !$this->isUnderRepair;
    }

    public function getNameAndSpecs(bool $useShortFormat = false) {

    if ($useShortFormat) {
    return sprintf(
    '%s (F:%s, BS:%s, R:%s)',
    $this->name,
    $this->weaponPower,
    $this->spatiodriveBooster,
    $this->strength);
    }
    else {
    return sprintf(
    'Vaisseau : (Force: %s, Booster spatiodrive: %s, Résistance: %s)',
    $this->name,
    $this->weaponPower,
    $this->spatiodriveBooster,
    $this->strength);
    }
    }

    public function doesThisShipHasMoreStrengthThanMe(Ship $ship)
    {
    return $ship->strength > $this->strength;
    }
}