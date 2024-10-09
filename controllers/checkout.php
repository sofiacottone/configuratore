<?php

$config = require('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

// return the selected view with data
view('checkout.view.php', [
    'heading' => 'Checkout',
]);
