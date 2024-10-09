<?php

namespace Core;

use PDO;

class Database
{
    public $connection;
    public function __construct($config)
    {
        // connect to db
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $username = $config['user'];
        $password = $config['password'];

        // create a new instance of a php data object 
        // return -> associative array
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query)
    {
        // prepare a query to send to mysql
        $statement = $this->connection->prepare($query);
        // execute the query
        $statement->execute();

        // fetch all the products as an associative array
        return $statement;
    }
}
