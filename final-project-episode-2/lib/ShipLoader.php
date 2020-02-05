<?php
class ShipLoader
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return PDO
     */
    private function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }

    /**
     * Retourne tous les ships sous forme d'un tableau d'objets Ship
     * @return Ship[] Tableau d'objets Ship
     */
    public function getShips()
    {
        // On prépare notre tableau de Ships
        $ships = [];

        // On appelle la méthode privée queryForShips() qui nous retourne les Ships de la BDD
        // sous forme de tableau (passez $shipsData dans un var_dump() pour voir à quoi ça ressemble)
        $shipsData = $this->queryForShips();

        // On foreach le tableau de données qui vient de la BDD...
        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }

        // Enfin, on retourne le tableau de Ships !
        return $ships;
    }

    /**
     * Retrouve en BDD la liste des ships sous forme d'un tableau de tableaux de données des ships
     * @return array[] Tableau de tableaux de ships
     */
    private function queryForShips()
    {
        $statement = $this->getPDO()->prepare('SELECT * FROM ship');
        $statement->execute();

        // On récupère les données (fetchAll car il y a plusieurs éléments)
        $shipsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        // On retourne les données
        return $shipsArray;
    }

    /**
     * Retrouve un Ship par son id
     * @param $id
     * @return Ship
     */
    public function findOneById($id)
    {
        $statement = $this->getPDO()->prepare('SELECT * FROM ship WHERE id = :id');
        $statement->execute(array('id' => $id));
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);

        // Si aucun ship n'est trouvé en bdd...
        if (!$shipArray) {
            return null;
        }

        // Sinon, on retourne le ship transformé en objet Ship
        return $this->createShipFromData($shipArray);
    }

    /**
     * Créée un objet Ship depuis un tableau de données d'un ship
     * @param array $shipData
     * @return Ship
     */
    private function createShipFromData(array $shipData)
    {
        $ship = new Ship($shipData['name']);
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setSpatiodriveBooster($shipData['spationdrive_booster']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }
}