<?php
/* library for database access and some operations */

require 'databaseAccess.php';

// gets all attributes from db table using DESCRIBE query
function describeTable($tableName) {
    $error = "";
    $con = getDbConnection();
    if(!$fieldsRes = $con->query("DESCRIBE $tableName")){
        $error .= "<p class='error'>Errore nella query: riprova più tardi<p>";
    }
    if (!empty($error)) {
        echo "<div class='errorBox'>" . $error . "</div>";
    }
    return $fieldsRes;
}

// gets all lines from specified table

function getAllFromTable($tableName){
    $con = getDbConnection();
    $query = "SELECT * FROM $tableName";
    // check if ordering is specified
    if (isset($_GET["ord"])) {
        // real_escape_string since prepared statements cannot be used with parameters on ORDER BY
        $query .= " ORDER BY " . $con->real_escape_string(trim($_GET['ord']));
    }
    $error = "";
    if (!$res = $con->query($query)) {
        $error .= "<p class='error'>Errore nella query: riprova più tardi</p>";
    }
    if (!empty($error)) {
        echo "<div class='errorBox'>" . $error . "</div>";
    }
    return $res;
}

// gets the item with specified id from specified table
function getFromTableWithId($tableName, $id){
    $error = "";
    $con = getDbConnection();
    // get info to show product info already in the appropriate form input fields
    if (!($stmt = $con->prepare("SELECT * FROM $tableName WHERE id=?"))) {
        $error .= "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error . "</p>";
    }
    if (!$stmt->bind_param("i", $id)) {
        $error .= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if (!$stmt->execute()) {
        $error .= "<p class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if (!($res = $stmt->get_result())) {
        $error .= "<p class='error'>Getting result set failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if(!$row = $res->fetch_assoc()){
        $error .= "<p class='error'>Fetch_assoc failed</p>";
    }
    if (!empty($error)) {
        echo "<div class='errorBox'>" . $error . "</div>";
    }
    return $row;
}

// gets the user with specified email from the db
function getUserWithEmail($email){
    $error = "";
    $con = getDbConnection();
    // get info to show product info already in the appropriate form input fields
    if (!($stmt = $con->prepare("SELECT * FROM users WHERE email=?"))) {
        $error .= "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error . "</p>";
    }
    if (!$stmt->bind_param("s", $email)) {
        $error .= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if (!$stmt->execute()) {
        $error .= "<p class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if (!($res = $stmt->get_result())) {
        $error .= "<p class='error'>Getting result set failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if(!$row = $res->fetch_assoc()){
        $NoSuchUserError = "<p class='error'>Fetch_assoc failed</p>";
    }
    if (!empty($error)) {
        echo "<div class='errorBox'>" . $error . "</div>";
    }
    return $row;
}
