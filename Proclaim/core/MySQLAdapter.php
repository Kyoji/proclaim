<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class MySQLAdapter extends \PDO implements AdapterInterface
{
    private $opt = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];

    function __construct( array $dbConfig )
    {
        $dsn =  "mysql:host="
                .$dbConfig['host']
                .";dbname="
                .$dbConfig['db']
                .";charset="
                .$dbConfig['charset']
                .";";

        parent::__construct($dsn, $dbConfig['user'], $dbConfig['password'], $this->opt);
    }

}