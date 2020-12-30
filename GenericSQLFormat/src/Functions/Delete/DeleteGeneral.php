<?php


namespace GenericSQLFormat\Functions\Delete;


use GenericSQLFormat\Functions\Conect\ConnectMysql;
use GenericSQLFormat\Functions\Exception\ValidateFormat;
use GenericSQLFormat\Functions\Where\WhereGeneral;

class DeleteGeneral extends ConnectMysql
{
    private $exception;
    private $where;

    public function __construct()
    {
        parent::__construct();
        $this->where = new WhereGeneral();
        $this->exception = new ValidateFormat();
    }

    public function Delete(array $array_dados)
    {
        $sql = $this->format($array_dados);
        $query = $this->db->prepare($sql);
        $this->where->FormatWhere($query, $array_dados);
        if (!$query->execute() and isset($array['debug'])) {
            echo "\nPDO::errorInfo():\n";
            print_r($query->errorInfo());
            die;
        }
    }

    private function format(array $array)
    {
        $this->exception->ValidateFormaTableOrwhere($array);
        $tabela_tmp = $array['tabela'][0];
        $where_tmp = $this->where->Format($array);
        return "DELETE FROM {$tabela_tmp} WHERE {$where_tmp}";
    }
}