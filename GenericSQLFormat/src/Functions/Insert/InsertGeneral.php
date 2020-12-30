<?php


namespace GenericSQLFormat\Functions\Insert;


use GenericSQLFormat\Functions\Conect\ConnectMysql;
use GenericSQLFormat\Functions\Exception\ValidateFormat;

class InsertGeneral extends ConnectMysql
{
    private $exception;

    public function __construct()
    {
        parent::__construct();
        $this->exception = new ValidateFormat();
    }

    public function Insert(array $array_item)
    {
        $sql = $this->format($array_item);

        $query = $this->db->prepare($sql);
        $this->format_prepare($query, $array_item);
        if (!$query->execute() and isset($array['debug'])) {
            echo "\nPDO::errorInfo():\n";
            print_r($query->errorInfo());
        }
    }

    private function format(array $array)
    {
        $this->exception->ValidateFormaTableOrColumn($array);
        $tabela = $array['tabela'][0];
        foreach ($array['coluna'] as $key_coluna => $value_coluna) {
            $coluna_str_tmp = isset($coluna_str_tmp) ?
                "{$coluna_str_tmp} , {$value_coluna}" : "{$value_coluna}";
            $value_str_tmp = isset($value_str_tmp) ?
                "{$value_str_tmp} , :{$value_coluna}" : ":{$value_coluna}";
        }

        return "INSERT INTO {$tabela}($coluna_str_tmp) VALUES ($value_str_tmp)";

    }

    private function format_prepare($query, array $array)
    {
        $this->exception->ValidateFormaTableOrColumn($array);

        foreach ($array['coluna'] as $key_coluna => $value_coluna) {
            $this->exception->CheckFormatInsert($array, $key_coluna);
            $value_temp = $array['valuer'][$key_coluna];

            $query->bindValue(":{$value_coluna}", $value_temp);
        }
    }
}