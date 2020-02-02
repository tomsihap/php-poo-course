<?php

class Ship {

public $name = "";
public $weaponPower = 0;
public $spatiodriveBooster = 0;
public $strength = 0;

public function sayHello()
{
echo 'Hello!';
}
public function getName()
{
return $this->name;
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