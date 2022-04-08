<?php
/* php service (called by checkRegistration.js) to check if specified email is already in database */

$email = trim($_GET["email"]);
// connect to the database
require_once '../db/database.php';
if (getUserWithEmail($email) != null) {
    echo "NO";
}
else { // email not in db, you can register it
    echo "OK";
}
