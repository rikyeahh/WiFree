<?php
/* delete the product with specified id */
session_start();
if (!isset($_REQUEST["id"]) || !isset($_SESSION["admin"])) { // cannot delete if not admin
    header('Location: allProducts.php');
    exit;
}
$con = require '../db/databaseAccess.php';
// delete product with prepared statement
$error = "";
$id = trim($_REQUEST["id"]);
if (!($stmt = $con->prepare("DELETE FROM products WHERE id=?"))) {
    $error .= "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error . "</p>";
}
if (!$stmt->bind_param("s", $id)) {
    $error .= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
}
if (!$stmt->execute()) {
    $error .= "<p class='error'>Execute failed: (" . $con->errno . ") " . $con->error . "</p>";
}
if ($stmt->affected_rows != 1) {
    $error .= "<p class='error'>Something went wrong</p>";
}
// if there are errors, show them and do not redirect
if ($error != "") {
    echo "<div class='errorBox'>" . $error . "</div>";
}
else { // all good
    header('Location: allProducts.php');
    exit;
}
