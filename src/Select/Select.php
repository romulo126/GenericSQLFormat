<?php
##################################################
# Description: This file contains the Select class.
##################################################
# Authot: Romulo Henrique D. S.
# Version: 1.0
# Date: 2021/12/11
# GitHub: https://github.com/romulo126/
# LinkedIn: https://www.linkedin.com/in/romulo-henrique-364976133/
##################################################
# Copyright (c) 2020 Romulo Henrique D. S.
##################################################

namespace GenericSQLFormat\Select;

use GenericSQLFormat\Conect\Conect;
use GenericSQLFormat\Where\Where;



class Select extends Conect
{
    private $from;
    private $columns;
    private $where;
    private $order;
    private $limit;
    private $group;
    private $query;
    private $conect;
    private $debug;

    public function __construct($debug = false)
    {
        parent::__construct();
        $this->where = new Where();
        $this->conect = $this->getPdo($debug);
        $this->debug = $debug;
    }

    public function setFrom(string $from)
    {
        $this->from = $from;
    }

    public function setColumns(array $columns)
    {
        $this->columns = implode(', ', $columns);
    }

    public function setWhere(array $wherevalues, array $whereoperators, array $wherelogics = [])
    {
        $this->where->setWhere($wherevalues, $whereoperators, $wherelogics);
    }


    public function setOrder(array $order)
    {
        $this->order = implode(', ', $order);
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function setGroup(array $group)
    {
        $this->group = implode(', ', $group);
    }

    public function run()
    {

        $this->query = $this->conect->prepare($this->getQuery());
        if ($this->where->getWhere()) {
            $this->query = $this->where->bindParamWhere($this->query);
        }
        if ($this->query->execute()) {
            return $this->query->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            if ($this->debug) {
                var_dump($this->query->errorInfo());
            }
        }
        return false;
    }

    public function manualQueryBuilder(string $query)
    {
        $this->query = $this->conect->prepare($query);
        if ($this->query->execute()) {
            return $this->query->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            if ($this->debug) {
                var_dump($this->query->errorInfo());
            }
        }
        return false;
    }

    public function getQuery()
    {
        $query = "SELECT $this->columns FROM $this->from";
        if ($this->where->getWhere()) {
            $query .= " WHERE" . $this->where->getWhere();
        }
        if ($this->group) {
            $query .= " GROUP BY $this->group";
        }
        if ($this->order) {
            $query .= " ORDER BY $this->order";
        }
        if ($this->limit) {
            $query .= " LIMIT $this->limit";
        }
        return $query . ' ;';
    }
}