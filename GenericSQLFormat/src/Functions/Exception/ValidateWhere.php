<?php


namespace GenericSQLFormat\Functions\Exception;


class ValidateWhere
{
    public function CheckWhereParametros(array $array)
    {
        if (isset($array['debug'])) {
            if (!isset($array['where']['parametros'][0])) {
                var_dump(['status' => 'error', 'mensage' => 'where parametro não informado']);
                die;
            }
        }
    }

    public function CheckWhereWhereValuer(array $array, $key_parametro)
    {
        if (isset($array['debug'])) {
            if (!isset($array['where']['valuer'][$key_parametro])) {
                var_dump(['status' => 'error',
                    'mensage' => 'where valuer não informado item:' . $key_parametro]);
                die;
            }
        }
    }

    public function CheckWhereWhereCondiconal(array $array, $key_parametros)
    {
        if (isset($array['debug'])) {
            if (!isset($array['where']['condiconal'][$key_parametros])) {
                var_dump(['status' => 'error',
                    'mensage' => 'where condiconal não informado local: ' . $key_parametros]);
                die;
            }
        }
    }
}