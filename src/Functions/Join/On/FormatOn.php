<?php


namespace GenericSQLFormat\Functions\Join\On;


use GenericSQLFormat\Functions\Exception\ValidateOn;

class FormatOn
{
    private $exeptionon;

    public function __construct()
    {
        $this->exeptionon = new ValidateOn();
    }

    public function Format($array)
    {
        $this->exeptionon->CheckOnParametro($array);

        foreach ($array['on']['parametros'] as $key_parametro => $value_parametro) {
            $valuer_tmp = $array['on']['valuer'][$key_parametro];
            $condicao_tmp = $array['on']['condiconal'][$key_parametro];
            if (isset($array['on']['separador'][$key_parametro])) {
                $separador_tmp = $array['on']['separador'][$key_parametro];
                $on_tmp = isset($on_tmp) ? "{$on_tmp} {$value_parametro} {$condicao_tmp} {$valuer_tmp} {$separador_tmp}" :
                    "{$value_parametro} {$condicao_tmp} {$valuer_tmp} {$separador_tmp}";
            } else {
                $on_tmp = isset($on_tmp) ?
                    "{$on_tmp} {$value_parametro} {$condicao_tmp} {$valuer_tmp}" :
                    "{$value_parametro} {$condicao_tmp} {$valuer_tmp}";
                break;
            }
        }
        return $on_tmp;
    }
}