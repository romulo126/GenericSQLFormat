<?php


namespace GenericSQLFormat\Functions\Exception;


class ValidateOn
{

    public function CheckOnParametro($array)
    {
        if (isset($array['debug'])) {
            if (!isset($array['on']['parametros'][0])) {
                var_dump(['status' => 'error', 'mensage' => 'where parametro não informado']);
                die;
            }
        }
    }
}