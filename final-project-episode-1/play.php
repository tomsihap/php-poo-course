<?php
require __DIR__ . '/lib/Ship.php';

$jediShip = new Ship();
$jediShip->setName("Jedi Ship (attaquant)");
$jediShip->setWeaponPower(100);
$jediShip->setStrength(500);

$sithShip = new Ship();
$sithShip->setName("Sith Ship (attaqué)");
$sithShip->setWeaponPower(100);
$sithShip->setStrength(500);


$jediShip->attack($sithShip);

echo $jediShip;