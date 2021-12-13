<?php
##################################################
# Description: This file contains the Config class for the DataBase.
##################################################
# Authot: Romulo Henrique D. S.
# Version: 1.0
# Date: 2021/12/11
# GitHub: https://github.com/romulo126/
# LinkedIn: https://www.linkedin.com/in/romulo-henrique-364976133/
##################################################
# Copyright (c) 2020 Romulo Henrique D. S.
##################################################

namespace GenericSQLFormat\Config;

class Config
{
    private $host = "127.0.0.1";
    private $user = "postgres";
    private $password = "postgres";
    private $databasename = "postgres";
    private $port = 5432;// 5432 (PostgreSQL), 3306 (MySQL), 1521 (Oracle)
    private $driver = "pgsql"; //mysql, pgsql, sqlite, sqlsrv, oci, mssql, dblib, oracle, 

    public function __construct()
    {
    }

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function setUser(string $user)
    {
        $this->user = $user;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setDataBaseName(string $database)
    {
        $this->databasename = $database;
    }

    public function setPort(int $port)
    {
        $this->port = $port;
    }


    public function setDriver(string $driver)
    {
        $this->driver = $driver;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDatabase()
    {
        return $this->databasename;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getDsn()
    {
        return "{$this->driver}:host={$this->host};port={$this->port};dbname={$this->databasename};";
    }
}
