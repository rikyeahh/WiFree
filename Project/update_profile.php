<?php
/* script called by show_profile to update user profile */
session_start();
if ((!isset($_SESSION["id"]) || !isset($_SESSION["login"]))) { // can do it only if you're logged in
    header('Location: login.php');
    exit;
}
// if you're an admin, you can choose to edit another user's profile: idOfProfileToUpdate will be the one you specified
$idOfProfileToUpdate = (isset($_SESSION["admin"]) && isset($_GET["id"])) ? $_GET["id"] : $_SESSION["id"];
//echo "L'id da fare update è $idOfProfileToUpdate e il tuo è " . $_SESSION["id"] . "\n";
$con = require '../db/databaseAccess.php';
$error = "";
//check if all field are present and valid
require_once 'util/authentication.php';
$error .= validatePostData("firstname", "lastname", "email"); // can expand with nickname and newsletter
// do the update query with prepared statements
$con = require '../db/databaseAccess.php';
if (!($stmt = $con->prepare("UPDATE users SET firstname=?, lastname=?, email=?, admin=?, nickname=?, newsletter=? WHERE id=?"))) {
    echo "Prepare failed: (" . $con->errno . ") " . $con->error;
}
$firstname = trim($_POST["firstname"]);
$lastname = trim($_POST["lastname"]);
$email = trim($_POST["email"]);
$admin = isset($_SESSION["admin"]) ? trim($_POST["admin"] ?? '0') : 'DEFAULT';
$newsletter = isset($_POST["newsletter"]) ? trim($_POST["newsletter"] ?? '0') : 'DEFAULT';
$nickname = trim($_POST["nickname"]);
if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (!$stmt->bind_param("sssisii", $firstname, $lastname, $email, $admin, $nickname, $newsletter, $idOfProfileToUpdate)) {
        $error .= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if (!$stmt->execute()) {
        $error .= "<p class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
    }
    if ($stmt->affected_rows != 1) {
        $error .= "<p class='error'>Something went wrong\n</p>";
    }
    $con->close();
}
else {
    $error .= "<p class='error'>Email isn't in the right format</p>";
}

if (!empty($error)) { // if there are errors
    echo "<div class='errorBox'>$error</div>"; // only for debugging
    header("Location: show_profile.php?id=" . $idOfProfileToUpdate);
    exit;
}
else { // if everything ok, if nickname was empty reset nickname in session and redirect with an OK flag
    if (!isset($_SESSION["nickname"]) || empty($_SESSION["nickname"])) {
        $_SESSION["nickname"] = $nickname;
    }
    header("Location: show_profile.php?id=" . $idOfProfileToUpdate . "&confirm=OK");
    exit;
}
?>
