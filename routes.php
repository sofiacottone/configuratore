<?php

$router->get('/', 'controllers/index.php');
$router->get('/checkout', 'controllers/checkout.php');

$router->post('/checkout', 'controllers/orders/store.php');
