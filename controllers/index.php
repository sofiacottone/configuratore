<?php

$config = require('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

// fetch all products
$products = $db->query("select * from products")->fetchAll(PDO::FETCH_ASSOC);

$heading = 'Home';

require 'views/index.view.php';
