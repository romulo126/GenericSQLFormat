<?php


namespace GenericSQLFormat\Functions\Conect;

require_once __DIR__ . '/../../Config/ConfigDB.php';

abstract class ConnectMysql
{
    protected $db;

    public function __construct()
    {

        $this->db = new \PDO(
            "mysql:dbname=" . NameDataBase . ";host=" . HostDataBase,
            UserDataBase, PassDataBase
        );
    }
}