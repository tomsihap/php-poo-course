<?php
class BattleManager {
    /**
     * L'algorithme de combat super complexe !
     *
     * @return array [winning_ship, losing_ship, used_jedi_powers]
     */
    public function battle(Ship $ship1, $ship1Quantity, Ship $ship2, $ship2Quantity)
    {

        // Calcul de la résistance totale de chaque groupe (strength * nombre de combattants)
        $ship1Health = $ship1->getStrength() * $ship1Quantity;
        $ship2Health = $ship2->getStrength() * $ship2Quantity;

        // Par défaut, personne n'a utilisé le spatiodrive booster
        $ship1UsedSpatiodriveBoosters = false;
        $ship1UsedSpatiodriveBoosters = false;

        // Tant que les 2 groupes ont une résistance supérieure à 0, on combat :
        while ($ship1Health > 0 && $ship2Health > 0) {
            // On vérifie à chaque tour si quelqu'un a utilisé le spatiodrive booster
            // en appelant la fonction usedSpatiodriveBoosters()
            if ($this->usedSpatiodriveBoosters($ship1)) {
                $ship2Health = 0;
                $ship1UsedSpatiodriveBoosters = true;
                // Si le spatiodrive booster a été utilisé, on break la boucle while
                break;
            }
            if ($this->usedSpatiodriveBoosters($ship2)) {
                $ship1Health = 0;
                $ship1UsedSpatiodriveBoosters = true;
                // Si le spatiodrive booster a été utilisé, on break la boucle while
                break;
            }

            // Si pas de spatiodrive booster, on poursuit le combat :
            // On soustrait la force de chaque groupe à la résistance de l'autre groupe
            $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
            $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
        }

        $ship1->setStrength($ship1Health);
        $ship2->setStrength($ship2Health);

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

        return new BattleResult($usedSpatiodriveBoosters, $winningShip, $losingShip);
    }

    function usedSpatiodriveBoosters(Ship $ship)
    {
        $spatiodriveBoostersProbability = $ship->getSpatiodriveBooster() / 100;
        // On tire un nombre entre 1 et 100, s'il est inférieur à la probabilité du booster Spatiodrive, alors on retourne true :
        return mt_rand(1, 100) <= ($spatiodriveBoostersProbability * 100);
    }
}