<?php


namespace GenericSQLFormat\Functions\Exception;


class ValidateUpdate
{
    public function ValidateValuer(array $array, $key_coluna)
    {
        if (isset($array['debug'])) {
            if (!isset($array['valuer'][$key_coluna])) {
                var_dump(['status' => 'error', 'mensage' => 'value não informado local: ' . $key_coluna]);
                die;
            }
        }
    }
}