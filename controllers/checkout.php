<?php

$config = require('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

$heading = 'Checkout';

require 'views/checkout.view.php';
