<?php


namespace GenericSQLFormat\Functions\Join\Select;


use GenericSQLFormat\Functions\Conect\ConnectMysql;
use GenericSQLFormat\Functions\Exception\ValidateFormat;
use GenericSQLFormat\Functions\Join\On\FormatOn;
use GenericSQLFormat\Functions\Where\WhereGeneral;

class SelectInnerGeneral extends ConnectMysql
{
    private $exception;
    private $where;
    private $formateon;

    public function __construct()
    {
        parent::__construct();
        $this->exception = new ValidateFormat();
        $this->where = new WhereGeneral();
        $this->formateon = new FormatOn();
    }

    protected function select_inner_join_generic(array $array_dados)
    {
        $sql = $this->format($array_dados);
        $query = $this->db->prepare($sql);
        if (isset($array_dados['where'])) {

            $this->where->FormatParamAs($query, $array_dados);
        }
        // echo $sql;
        if (!$query->execute()) {
            echo "\nPDO::errorInfo():\n";
            print_r($query->errorInfo());
        } else {

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    private function format(array $array)
    {
        foreach ($array['tabela'] as $key_tabela => $value_tabela) {
            $name_tab = $value_tabela[0];
            $name_as = $value_tabela[1];
            $tabela_tmp = isset($tabela_tmp) ?
                "{$tabela_tmp} INNER JOIN {$name_tab} as {$name_as}" : "{$name_tab} as {$name_as}";
        }
        foreach ($array['coluna'] as $key_coluna => $value_coluna) {
            foreach ($value_coluna as $key_colum => $name_coluna) {

                $name_coluna = $array['tabela'][$key_coluna][1] . ".{$name_coluna}";
                $coluna_tmp = isset($coluna_tmp) ? "{$coluna_tmp} , {$name_coluna}" : "{$name_coluna}";
            }
        }

        if (!isset($array['on']) and !isset($array['limit']) and !isset($array['where']))
            return "SELECT {$coluna_tmp} FROM {$tabela_tmp}";
        elseif (!isset($array['on']) and isset($array['limit']) and !isset($array['where']))
            return "SELECT {$coluna_tmp} FROM {$tabela_tmp} LIMIT " . $array['limit'][0];
        elseif (!isset($array['on']) and isset($array['limit']) and isset($array['where'])) {

            return "SELECT {$coluna_tmp} FROM {$tabela_tmp} " . $this->where->FormatAs($array)
                . " LIMIT " . $array['limit'][0];
        } elseif (!isset($array['limit']) and !isset($array['where']))
            return "SELECT {$coluna_tmp} FROM {$tabela_tmp} on " . $this->formateon->Format($array);
        elseif (!isset($array['limit']) and isset($array['where']))
            return "SELECT {$coluna_tmp} FROM {$tabela_tmp} on " . $this->formateon->Format($array)
                . " where " . $this->where->FormatAs($array);
        elseif (isset($array['limit']) and isset($array['where']))
            return "SELECT {$coluna_tmp} FROM {$tabela_tmp} on " . $this->formateon->Format($array) .
                " where " . $this->where->FormatAs($array) . " LIMIT " . $array['limit'][0];


        return "SELECT {$coluna_tmp} FROM {$tabela_tmp} on " . $this->formateon->Format($array) .
            " LIMIT " . $array['limit'][0];
    }
}