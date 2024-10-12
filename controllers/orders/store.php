<?php

use Core\Database;
use Core\Validator;

$config = require base_path('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

$errors = [];

// decode the data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// extract data
$cart = $data['cart'];
$customer = $data['customer'];
$totalPrice = $data['totalPrice'];

// add form validation
if (!Validator::string($customer['full_name'], 5, 50)) {
    $errors['full_name'] = 'Il nome deve essere compreso tra 5 e 50 caratteri';
}
if (!Validator::string($customer['address'], 5, 100)) {
    $errors['address'] = 'L\'indirizzo deve essere compreso tra 5 e 100 caratteri';
}
if (!Validator::string($customer['tax_code'], 16, 16)) {
    $errors['tax_code'] = 'Inserire un Codice Fiscale valido.';
}
if (!Validator::string($customer['vat_number'], 13, 13)) {
    $errors['vat_number'] = 'Inserire una P.IVA valida da 13 caratteri (includere IT)';
}
if (!Validator::email($customer['email'])) {
    $errors['email'] = 'Inserire un indirizzo email valido';
}

// in case of errors return errors variable 
if (!empty($errors)) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'errors' => $errors
    ]);
    exit;
}

// CUSTOMER

// check if the customer is in the db
$existingCustomer = $db->query('SELECT id FROM customers WHERE email = :email AND tax_code = :tax_code', [
    'email' => $customer['email'],
    'tax_code' => $customer['tax_code']
])->fetch();

// if there is a correspondecy 
// use the existing customer id to populate
// the variable for the FK
if ($existingCustomer) {
    $customerId = $existingCustomer['id'];
} else {
    // create a new customer
    $db->query('INSERT INTO customers(full_name, address, email, tax_code, vat_number) VALUES(:full_name, :address, :email, :tax_code, :vat_number)', [
        'full_name' => $customer['full_name'],
        'address' => $customer['address'],
        'email' => $customer['email'],
        'tax_code' => $customer['tax_code'],
        'vat_number' => $customer['vat_number']
    ])->fetch();
    // get last customer id
    $customerId = $db->lastInsertId();
}
// END CUSTOMER


// ORDER and ORDER ITEMS

if (empty($errors)) {
    // add order to db
    $db->query('INSERT INTO orders(customer_id, date, final_price) VALUES(:customer_id, :date, :final_price)', [
        'customer_id' => $customerId,
        'date' => date('Y-m-d'),
        'final_price' => $totalPrice,
    ]);
    // get last order id
    $orderId = $db->lastInsertId();

    // add order items to db for each item in the cart
    foreach ($cart as $item) {
        $db->query('INSERT INTO order_items(order_id, product_id, sites_number, users_number, annual_waste, subscription_type, item_price) VALUES(:order_id, :product_id, :sites_number, :users_number, :annual_waste, :subscription_type, :item_price)', [
            'order_id' => $orderId,
            'product_id' => $item['productId'],
            'sites_number' => $item['config']['sites_number']['value'],
            'users_number' => $item['config']['users_number']['value'],
            'annual_waste' => $item['config']['annual_waste']['value'],
            'subscription_type' => $item['config']['subscription_type'],
            'item_price' => $item['updatedPrice']
        ]);
    }

    // send confirmation email
    $to = $customer['email'];
    $subject = 'Conferma dell\'ordine';
    $message = 'Grazie per l\'acquisto ' . $customer['full_name'] . '! ' . 'L\'ID del tuo ordine è ' . $orderId;
    $headers = 'From: noreply@configurazioni.com';

    mail($to, $subject, $message, $headers);


    // set success message
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'L\'acquisto è andato a buon fine! Riceverai una email di conferma. Grazie!'
    ]);
    exit;
}
