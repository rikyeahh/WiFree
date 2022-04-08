<?php
if(!defined("dbHost")){define('dbHost', 'localhost');}
if(!defined("dbUser")){define('dbUser', '***USER***');}
if(!defined("dbPassword")){define('dbPassword', '***PASSWORD***');}
if(!defined("dbName")){define('dbName', '***DB_NAME***');}

// returns a connection to the database
if(!function_exists('getDbConnection')) {
    function getDbConnection() {
        $con = new mysqli(dbHost, dbUser, dbPassword, dbName);
        if ($con->connect_error) {
            die('<p class="error">Connect Error (' . $con->connect_errno . ') ' . $con->connect_error . "</p>");
        }
        return $con;
    }
}

return getDbConnection(); // many php scripts need $con returned to them
