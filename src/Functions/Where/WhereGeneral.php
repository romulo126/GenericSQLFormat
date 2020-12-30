<?php


namespace GenericSQLFormat\Functions\Where;


use GenericSQLFormat\Functions\Exception\ValidateWhere;

class WhereGeneral
{
    private $exception;

    public function __construct()
    {
        $this->exception = new ValidateWhere();
    }

    public function FormatWhere($query, array $array)
    {
        $this->exception->CheckWhereParametros($array);

        foreach ($array['where']['parametros'] as $key_parametro => $value_parametro) {

            $this->exception->CheckWhereWhereValuer($array, $key_parametro);

            $value_tmp = $array['where']['valuer'][$key_parametro];

            $query->bindValue(":{$value_parametro}", $value_tmp);
        }

    }

    public function Format(array $array)
    {
        $this->exception->CheckWhereParametros($array);

        foreach ($array['where']['parametros'] as $key_parametros => $value_parametros) {
            $this->exception->CheckWhereWhereCondiconal($array, $key_parametros);
            $condicional_tmp = $array['where']['condiconal'][$key_parametros];
            if (isset($array['where']['separador'][$key_parametros])) {
                $separador_tmp = $array['where']['separador'][$key_parametros];
                $where_tmp = isset($where_tmp) ?
                    "{$where_tmp} {$value_parametros} {$condicional_tmp} :{$value_parametros} {$separador_tmp}" :
                    "{$value_parametros} {$condicional_tmp} :{$value_parametros} $separador_tmp";
            } else {
                $where_tmp = isset($where_tmp) ?
                    "{$where_tmp} {$value_parametros} {$condicional_tmp} :{$value_parametros}" :
                    "{$value_parametros} {$condicional_tmp} :{$value_parametros}";
            }
        }
        return $where_tmp;
    }

    public function FormatAs(array $array)
    {
        $this->exception->CheckWhereParametros($array);

        foreach ($array['where']['parametros'] as $key_parametros => $value_parametros) {
            $this->exception->CheckWhereWhereCondiconal($array, $key_parametros);

            $value_parametros_ex = explode('.', $value_parametros);
            if (isset($value_parametros_ex[1]))
                $value_parametros_as = $value_parametros_ex[0] . "_" . $value_parametros_ex[1];
            else
                $value_parametros_as = $value_parametros;
            $condicional_tmp = $array['where']['condiconal'][$key_parametros];
            if (isset($array['where']['separador'][$key_parametros])) {
                $separador_tmp = $array['where']['separador'][$key_parametros];
                $where_tmp = isset($where_tmp) ?
                    "{$where_tmp} {$value_parametros} {$condicional_tmp} :{$value_parametros_as} {$separador_tmp}" :
                    "{$value_parametros} {$condicional_tmp} :{$value_parametros_as} $separador_tmp";
            } else {
                $where_tmp = isset($where_tmp) ?
                    "{$where_tmp} {$value_parametros} {$condicional_tmp} :{$value_parametros_as}" :
                    "{$value_parametros} {$condicional_tmp} :{$value_parametros_as}";
            }
        }
        return $where_tmp;
    }

    public function FormatParamAs($query, array $array)
    {
        $this->exception->CheckWhereParametros($array);


        foreach ($array['where']['parametros'] as $key_parametro => $value_parametro) {
            $this->exception->CheckWhereWhereValuer($array, $key_parametro);

            $value_parametros_ex = explode('.', $value_parametro);
            if (isset($value_parametros_ex[1]))
                $value_parametros_as = $value_parametros_ex[0] . "_" . $value_parametros_ex[1];
            else
                $value_parametros_as = $value_parametro;
            $value_tmp = $array['where']['valuer'][$key_parametro];

            $query->bindValue(":{$value_parametros_as}", $value_tmp);
        }
    }
}