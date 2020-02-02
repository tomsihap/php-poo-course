<?php
require __DIR__ . '/lib/Ship.php';

function getShips() {

    $ships = [];

    $ship1 = new Ship();
    $ship1->name = "Jedi Starfighter";
    $ship1->weaponPower = 5;
    $ship1->spatiodriveBooster = 15;
    $ship1->strength = 30;
    $ships['starfighter'] = $ship1;

    $ship2 = new Ship();
    $ship2->name = "X-Wing Fighter";
    $ship2->weaponPower = 2;
    $ship2->spatiodriveBooster = 2;
    $ship2->strength = 70;
    $ships['x_wing_fighter'] = $ship2;

    $ship3 = new Ship();
    $ship3->name = "Super Star Destroyer";
    $ship3->weaponPower = 70;
    $ship3->spatiodriveBooster = 0;
    $ship3->strength = 500;
    $ships['super_star_destroyer'] = $ship3;

    $ship4 = new Ship();
    $ship4->name = "RZ1 A-Wing Interceptor";
    $ship4->weaponPower = 4;
    $ship4->spatiodriveBooster = 4;
    $ship4->strength = 50;
    $ships['rz1_a_wing_interceptor'] = $ship4;

    return $ships;
}

/**
 * L'algorithme de combat super complexe !
 *
 * @return array [winning_ship, losing_ship, used_jedi_powers]
 */
function battle(array $ship1, $ship1Quantity, array $ship2, $ship2Quantity)
{

    // Calcul de la résistance totale de chaque groupe (strength * nombre de combattants)
    $ship1Health = $ship1['strength'] * $ship1Quantity;
    $ship2Health = $ship2['strength'] * $ship2Quantity;

    // Par défaut, personne n'a utilisé le spatiodrive booster
    $ship1UsedSpatiodriveBoosters = false;
    $ship1UsedSpatiodriveBoosters = false;

    // Tant que les 2 groupes ont une résistance supérieure à 0, on combat :
    while ($ship1Health > 0 && $ship2Health > 0) {
        // On vérifie à chaque tour si quelqu'un a utilisé le spatiodrive booster
        // en appelant la fonction usedSpatiodriveBoosters()
        if (usedSpatiodriveBoosters($ship1)) {
            $ship2Health = 0;
            $ship1UsedSpatiodriveBoosters = true;
            // Si le spatiodrive booster a été utilisé, on break la boucle while
            break;
        }
        if (usedSpatiodriveBoosters($ship2)) {
            $ship1Health = 0;
            $ship1UsedSpatiodriveBoosters = true;
            // Si le spatiodrive booster a été utilisé, on break la boucle while
            break;
        }

        // Si pas de spatiodrive booster, on poursuit le combat :
        // On soustrait la force de chaque groupe à la résistance de l'autre groupe
        $ship1Health = $ship1Health - ($ship2['weapon_power'] * $ship2Quantity);
        $ship2Health = $ship2Health - ($ship1['weapon_power'] * $ship1Quantity);
    }

    // Si les 2 groupes tombent à 0 au même tour :
    if ($ship1Health <= 0 && $ship2Health <= 0) {
        $winningShip = null;
        $losingShip = null;
        $usedSpatiodriveBoosters = $ship1UsedSpatiodriveBoosters || $ship1UsedSpatiodriveBoosters;
    } elseif ($ship1Health <= 0) {
        // Si la résistance du groupe 1 tombe à 0
        $winningShip = $ship2;
        $losingShip = $ship1;
        $usedSpatiodriveBoosters = $ship1UsedSpatiodriveBoosters;
    } else {
        // Sinon, c'est la résistance du groupe 2 qui tombe à 0
        $winningShip = $ship1;
        $losingShip = $ship2;
        $usedSpatiodriveBoosters = $ship1UsedSpatiodriveBoosters;
    }

    return array(
        'winning_ship' => $winningShip,
        'losing_ship' => $losingShip,
        'used_spatiodrive_boosters' => $usedSpatiodriveBoosters,
    );
}

function usedSpatiodriveBoosters(array $ship)
{
    $spatiodriveBoostersProbability = $ship['spatiodrive_booster'] / 100;
    // On tire un nombre entre 1 et 100, s'il est inférieur à la probabilité du booster Spatiodrive, alors on retourne true :
    return mt_rand(1, 100) <= ($spatiodriveBoostersProbability * 100);
}