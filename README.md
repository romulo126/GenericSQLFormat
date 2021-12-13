# PHP Generic Query SQL

## Composer Install
    composer require sql/genericsqlformat

## Description
    simple query generator for PHP

## OBS:
- All classes have manualQueryBuilder() method where you can pass a string with the query
- The database connection settings are in the Config folder in the Config.php file

## Usage

- Config

    ```php
    <?php
        require_once __DIR__.'vendor/autoload.php';

        //library
        use sql\genericsqlformat\Config\Config;

        //config
        $config = new Config();
        $config->setHost('localhost');
        $config->setUser('root');
        $config->setPassword('root');
        $config->setDataBaseName('test');
        $config->setPort(5432);
        $config->setDriver('pgsql');

        $config->getDsn();
    ?>
    ```


- Select:
    ```php
    <?php
        require_once __DIR__.'vendor/autoload.php';

        //library
        use sql\genericsqlformat\Select\Select;

        //query
        //enable debug mode
            $select = new Select(true);
        //no debug mode
            $select = new Select();
        $select->setFrom('users');
        $select->setColumns(['id', 'nameuser']);
        $select->setWhere(['id' => 1,'nameuser'=>'teste'],['nameuser'=>'=','id'=>'like'], ['OR']);
        $select->setGroup(['id']);
        $select->setOrder(['id']);
        $select->setLimit(1);
        $select->run();
    ?>
    ```
- Update:
    ```php
    <?php
        require_once __DIR__.'vendor/autoload.php';

        //library
        use sql\genericsqlformat\Update\Update;

        //query
        //enable debug mode
            $update = new Update(true);
        //no debug mode
            $update = new Update();
        $update->setFrom('users');
        $update->setColumns(['id' => 1,'nameuser'=>'teste']);
        $update->setWhere(['id' => 1,'nameuser'=>'teste'],['nameuser'=>'=','id'=>'like'], ['OR']);
        $update->run();
    ?>
    ```
- Insert:
    - OBS:
        - The setDates method expects an array where the key is the table column and the value and value to be inserted into that column
    ```php
    <?php
        require_once __DIR__.'vendor/autoload.php';

        //library
        use sql\genericsqlformat\Insert\Insert;

        //query
        //enable debug mode
            $insert = new Insert(true);
        //no debug mode
            $insert = new Insert();
        $insert->setFrom('users');
        $insert->setDates(['nameuser' => 'teste4', 'birthday' => '2021-12-13','email'=>'tetse1','passworduser'=>'teste2','createdat'=>'2020-12-13']);
        $insert->run();
    ?>
    ```
- Delete:
    ```php
    <?php
        require_once __DIR__.'vendor/autoload.php';

        //library
        use sql\genericsqlformat\Delete\Delete;

        //query
        //enable debug mode
            $delete = new Delete(true);
        //no debug mode
            $delete = new Delete();
        
        $delete->setFrom("users");
        $delete->setWhere(["id"=>1], ["="]);
        $delete->run();
    ?>
    ``` 