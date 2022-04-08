<!DOCTYPE html>
<html lang="it">
<head>
  <title>Amministrazione WiFree</title>
  <link rel="icon" type="image/png" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width"/>
  <link rel="stylesheet" type="text/css" href="styles/allUsers.css">
  <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="bodyWrapper">
    <?php
    require 'navbar.php';
    require_once 'util/authentication.php';
    redirectIfNotAdmin();
    echo "<h1 class='editTitle'>Utenti nel database</h1>";
    require_once '../db/database.php';
    // get all users from db
    $res = getAllFromTable("users");
    // get all user attributes from db
    $fieldsRes = describeTable("users");

    echo "<table class='usersTable'>";
    echo "<tr>";
    // for each attribute/field of the products table
    foreach ($fieldsRes as $row) {
        // skip "id" and "password" field
        if (in_array($row["Field"], ["id", "password"])) { # expandable
            continue;
        }
        // translate field in italian
        require_once 'util/translation.php';
        $fieldIta = translated($row["Field"]);

        // print table headings, with ?ord= same as db attribute but italian label
        echo "<td><a class='ordTableColumnLabel' href='allUsers.php?ord=" . $row["Field"] . "'>" . $fieldIta . "</a></td>";
    }
    echo "<td></td><td></td></tr>";
    // show a row for each user of the table, containing its info
    foreach ($res as $row) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            // except for id and password, that cannot be seen
            if ($key == "id" || $key == "password") {
                continue;
            }
            // show special emojis for admin field
            if ($key == "admin" || $key == "newsletter") {
                echo "<td>" . ($row[$key] == "0" ? "&#x274C;" : "&#10004;&#65039;") . "</td>";
            }
            else {
                echo "<td>" . htmlspecialchars($row[$key]) . "</td>";
            }
        }
        // buttons to edit (show_profile.php) and delete (deleteUser.php) user of this row
        echo "<td><a href='show_profile.php?id=" . $row["id"] . "'>Modifica</a></td>";
        $deleteButton = "<td><a href='deleteUser.php?email=" . $row["email"] . "'>Cancella</a></td>";
        echo $deleteButton;
        echo "</tr>";
    }
    echo "</table><br><br>";
    require 'footer.php';
    ?>
</div>
<script src="js/adminTables.js"></script>
</body>
</html>
