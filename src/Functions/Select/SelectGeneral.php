<?php


namespace GenericSQLFormat\Functions\Select;

use GenericSQLFormat\Functions\Conect\ConnectMysql;
use GenericSQLFormat\Functions\Exception\ValidateFormat;
use GenericSQLFormat\Functions\Where\WhereGeneral;

class SelectGeneral extends ConnectMysql
{
    private $exception;
    private $where;

    public function __construct()
    {
        parent::__construct();
        $this->exception = new ValidateFormat();
        $this->where = new WhereGeneral();
    }

    protected function Select(array $array_dados)
    {
        $sql = $this->format($array_dados);
        $query = $this->db->prepare($sql);
        if (isset($array_dados['where'])) {

            $this->where->FormatWhere($query, $array_dados);
        }
        if (!$query->execute() and isset($array['debug'])) {
            echo "\nPDO::errorInfo():\n";
            print_r($query->errorInfo());
        } else {
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    private function format(array $array)
    {
        $this->exception->ValidateFormaTableOrColumn($array);
        $tabela = $array['tabela'][0];

        foreach ($array['coluna'] as $key_coluna => $value_coluna) {
            $coluna_tmp = isset($coluna_tmp) ? "{$coluna_tmp} , {$value_coluna}" : "{$value_coluna}";
        }

        if (!isset($array['where']) and !isset($array['limit'][0]))
            return "SELECT {$coluna_tmp} FROM {$tabela} WHERE 1";

        if (!isset($array['where']) and isset($array['limit'][0]))
            return "SELECT {$coluna_tmp} FROM {$tabela} WHERE 1 LIMIT " . $array['limit'][0];

        if (!isset($array['limit'][0]))
            return "SELECT {$coluna_tmp} FROM {$tabela} WHERE " . $this->where->Format($array);

        return "SELECT {$coluna_tmp} FROM {$tabela} WHERE " . $this->where->Format($array) . " LIMIT " . $array['limit'][0];
    }
}