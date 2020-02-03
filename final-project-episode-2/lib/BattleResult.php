<?php

class BattleResult
{
    private $usedSpatiodriveBoosters;
    private $winningShip;
    private $losingShip;

    /**
     * @param bool $usedSpatiodriveBoosters
     * @param Ship $winningShip
     * @param Ship $losingShip
     */
    public function __construct(bool $usedSpatiodriveBoosters, Ship $winningShip, Ship $losingShip)
    {
        $this->usedSpatiodriveBoosters = $usedSpatiodriveBoosters;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }

    /**
     * @return Ship
     */
    public function getWinningShip() : Ship {
        return $this->winningShip;
    }

    /**
     * @return Ship
     */
    public function getLosingShip() : Ship {
        return $this->losingShip;
    }

    /**
     * @return bool
     */
    public function whereBoostersUsed() : bool {
        return $this->usedSpatiodriveBoosters;
    }
}