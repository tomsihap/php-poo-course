<?php
require __DIR__ . '/lib/Ship.php';

function getShips() {

    $ships = [];

    $ship1 = new Ship();
    $ship1->setName("Jedi Starfighter");
    $ship1->setWeaponPower(5);
    $ship1->setSpatiodriveBooster(15);
    $ship1->setStrength(30);
    $ships['starfighter'] = $ship1;

    $ship2 = new Ship();
    $ship2->setName("X-Wing Fighter");
    $ship2->setWeaponPower(2);
    $ship2->setSpatiodriveBooster(2);
    $ship2->setStrength(70);
    $ships['x_wing_fighter'] = $ship2;

    $ship3 = new Ship();
    $ship3->setName("Super Star Destroyer");
    $ship3->setWeaponPower (10);
    $ship3->setSpatiodriveBooster(0);
    $ship3->setStrength(500);
    $ships['super_star_destroyer'] = $ship3;

    $ship4 = new Ship();
    $ship4->setName("RZ1 A-Wing Interceptor");
    $ship4->setWeaponPower(4);
    $ship4->setSpatiodriveBooster(4);
    $ship4->setStrength(50);
    $ships['rz1_a_wing_interceptor'] = $ship4;

    return $ships;
}

function usedSpatiodriveBoosters(Ship $ship)
{
    $spatiodriveBoostersProbability = $ship->getSpatiodriveBooster() / 100;
    // On tire un nombre entre 1 et 100, s'il est inférieur à la probabilité du booster Spatiodrive, alors on retourne true :
    return mt_rand(1, 100) <= ($spatiodriveBoostersProbability * 100);
}