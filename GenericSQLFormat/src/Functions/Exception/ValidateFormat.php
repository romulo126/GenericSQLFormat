<?php


namespace GenericSQLFormat\Functions\Exception;


class ValidateFormat
{
    public function ValidateFormaTableOrColumn(array $array)
    {

        if (isset($array['debug'])) {
            $exampleexpectedarray = [
                'tabela' => ['You DataBase Table'],
                'coluna' => ['You DataBase Column']
            ];
            if (!isset($array['tabela'][0])) {
                echo "-- Error Log -- \n";
                var_dump([
                    'Status' => 'error',
                    'MSN' => 'Tabela não informado',
                    'ArrayInformed' => [
                        var_dump($array)
                    ],
                    'ExampleExpectedArray' => [
                        var_dump($exampleexpectedarray)
                    ]]);
                echo "\n -- Error Log -- \n";

                die;

            }
            if (!isset($array['coluna'][0])) {
                echo "-- Error Log -- \n";
                $msn = [
                    'Status' => 'error',
                    'MSN' => 'coluna não informado',
                    'ArrayInformed' => [
                        var_dump($array)
                    ],
                    'ExampleExpectedArray' => [
                        var_dump($exampleexpectedarray)
                    ]
                ];
                var_dump($msn);
                echo "\n -- Error Log -- \n";

                die;
            }

        }
    }
    public function ValidateFormaTableOrwhere(array $array)
    {

        if (isset($array['debug'])) {
            if (!isset($array['tabela'][0])) {
                var_dump(['status' => 'error', 'mensage' => 'Tabela não informado']);
                die;
            }
            if (!isset($array['where']['parametros'][0])) {
                var_dump(['status' => 'error', 'mensage' => 'where não informado']);
                die;
            }

        }
    }
    public function CheckFormatInsert(array $array, $key_coluna)
    {
        if (isset($array['debug'])) {
            if (!isset($array['valuer'][$key_coluna])) {
                echo "\n-- Error Log --\n";

                var_dump([
                        'status' => 'error',
                        'mensage' => 'value não passado item: ' . $key_coluna]
                );
                echo "-- Error Log --\n";

                die;
            }
        }
    }



}