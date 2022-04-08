<?php
session_start();
// remove PHPSESSID from browser
if (isset($_COOKIE[session_name()]))
    setcookie( session_name(), "", time() - 3600, "/" );
// remove data from globals
$_SESSION = [];
// clear session from server
if (!session_destroy()) {
    echo "Logout Error";
}
else {
    header('Location: home.php');
    exit;
}
