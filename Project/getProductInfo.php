<?php
/* php service (called by buy.js) to get info from the products in the cart */
session_start();
if (!isset($_SESSION["login"])) {
    echo "ERROR";
    return;
}
$id = trim($_GET["id"]);
// connect to the database
require_once '../db/database.php';
$product = getFromTableWithId("products", $id);
if ($product == null) { // if getFromTableWithId failed, product will be null
    echo "ERROR";
}
else { // else return a JSON string containing the product info
    $result = new stdClass();
    $result->name = $product["name"];
    $result->price = $product["price"];
    $result->availability = $product["availability"];
    echo json_encode($result);
}
