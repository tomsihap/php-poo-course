<?php
class Container
{

    private $configuration;
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }
    
    /**
     * @return PDO
     */
    public function getPDO()
    {
        $configuration = array(
            'db_dsn'  => 'mysql:host=localhost;dbname=hbbattleships',
            'db_user' => 'root',
            'db_pass' => null,
        );
        $pdo = new PDO(
            $configuration['db_dsn'],
            $configuration['db_user'],
            $configuration['db_pass']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}