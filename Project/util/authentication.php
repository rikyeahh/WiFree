<?php
// redirects to login if you are not an admin, used in admin-exclusive pages
function redirectIfNotAdmin() {
    if (!isset($_SESSION["admin"])) {
        header('Location: login.php');
        exit;
    }
}

// redirects to login if you are not logged in
function redirectIfNotLoggedIn() {
    if (!isset($_SESSION["login"])) {
        header('Location: login.php');
        exit;
    }
}

// checks if arguments are valid: set and not empty
function validatePostData(...$postKeys) {
    $error = "";
    foreach ($postKeys as $key) {
        if(!isset($_POST[$key]) || trim($_POST[$key]) == ''){
            $error .= "<p class='error'>Il campo $key non è valido</p>";
        }
    }
    return $error;
}
