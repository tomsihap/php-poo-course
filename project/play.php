<?php
require __DIR__ . '/lib/Ship.php';
$myShip = new Ship();
$myShip->setName('Jedi Fighter');
var_dump($myShip);
$myShip = new Ship();
$myShip->name = "X-Wing";
$myShip->weaponPower = 100;
$myShip->spatiodriveBooster = 30;
$myShip->strength = 400;

$otherShip = new Ship();
$otherShip->name = "TIE Fighter";
$otherShip->weaponPower = 900;
$otherShip->spatiodriveBooster = 40;
$otherShip->strength = 300;

var_dump($myShip);

echo $myShip->getNameAndSpecs();
echo "<hr>";
echo $myShip->getNameAndSpecs(true);
echo "<hr>";
echo $otherShip->getNameAndSpecs();
echo "<hr>";
echo $otherShip->getNameAndSpecs(true);
echo "<hr>";

if ($myShip->doesThisShipHasMoreStrengthThanMe($otherShip)) {
    echo $otherShip->name . ' a plus de résistance.';
}
else {
    echo $myShip->name . ' a plus de résistance.';
}

