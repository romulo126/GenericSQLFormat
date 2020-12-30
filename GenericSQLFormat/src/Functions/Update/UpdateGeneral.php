<?php


namespace GenericSQLFormat\Functions\Update;


use GenericSQLFormat\Functions\Conect\ConnectMysql;
use GenericSQLFormat\Functions\Exception\ValidateFormat;
use GenericSQLFormat\Functions\Exception\ValidateUpdate;
use GenericSQLFormat\Functions\Where\WhereGeneral;

class UpdateGeneral extends ConnectMysql
{
    private $exception;
    private $where;
    private $exceptionupdate;

    public function __construct()
    {
        parent::__construct();
        $this->exception = new ValidateFormat();
        $this->exceptionupdate = new ValidateUpdate();
        $this->where = new WhereGeneral();
    }

    public function Update(array $array_dados)
    {
        $sql = $this->Format($array_dados);

        $query = $this->db->prepare($sql);
        if (isset($array_dados['where'])) {
            $this->where->FormatWhere($query, $array_dados);
        }
        $this->FormatPrepare($query, $array_dados);
        if (!$query->execute()) {
            echo "\nPDO::errorInfo():\n";
            print_r($query->errorInfo());
        }
    }


    private function Format(array $array)
    {
        $this->exception->ValidateFormaTableOrColumn($array);
        $tabela_tmp = $array['tabela'][0];
        foreach ($array['coluna'] as $key_coluna => $value_coluna) {
            $coluna_str_tmp = isset($coluna_str_tmp) ?
                "{$coluna_str_tmp} , {$value_coluna}=:{$value_coluna}" :
                "{$value_coluna}=:{$value_coluna}";
        }
        if (!isset($array['where']))
            return "UPDATE $tabela_tmp SET $coluna_str_tmp";

        return "UPDATE $tabela_tmp SET $coluna_str_tmp WHERE " . $this->where->Format($array);
    }

    private function FormatPrepare($query, array $array)
    {
        foreach ($array['coluna'] as $key_coluna => $value_coluna) {
            $this->exceptionupdate->ValidateValuer($array, $key_coluna);

            $value_tmp = $array['valuer'][$key_coluna];
            $query->bindValue(":{$value_coluna}", $value_tmp);
        }
    }
}