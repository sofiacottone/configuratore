<?php

use Core\Database;

$config = require base_path('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

// fetch all products
$products = $db->query("select * from products")->fetchAll(PDO::FETCH_ASSOC);

// return the selected view with data
view('index.view.php', [
    'heading' => 'Home',
    'products' => $products
]);
