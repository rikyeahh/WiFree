<!DOCTYPE html>
<html lang="it">
<head>
  <title>Pagina Riservata</title>
  <link rel="icon" type="image/png" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width"/>
  <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="bodyWrapper">
    <?php
    require 'navbar.php';
    require_once '../db/database.php';
    echo "<h1 class='editTitle'>Modifica i dati e conferma</h1>";
    // feature only for authenticated users
    require_once 'util/authentication.php';
    redirectIfNotLoggedIn();
    if (isset($_GET["confirm"])) { // OK message from update_profile.php redirect
        echo "<p class='confirm'>Dati modificati correttamente</p>";
    }
    // if you're an admin, you can choose to show and edit another user's profile: idOfProfileToShow will be the one you specified
    $idOfUserToShow = (isset($_SESSION["admin"]) && isset($_GET["id"])) ? $_GET["id"] : $_SESSION["id"];
    $user = getFromTableWithId("users", $idOfUserToShow);
    ?>
    <form class="editProfileForm" action="update_profile.php?id=<?php echo $idOfUserToShow; ?>" method="post">
            <?php
            // display the user fields dinamically: if one column is added to database, it will appear here too
            foreach ($user as $key => $value) {
                // skip id and password, and the "admin" property too if you're not an admin
                if ($key == "id" || $key == "password" || ($key == "admin" && !isset($_SESSION["admin"]))) {
                    continue;
                }
                // translate the attribute in italian
                require_once 'util/translation.php';
                $label = translated($key);

                if ($label == "Admin") { // special case for admin field: it must be a checkbox (not a text field)
                    echo "Admin<br><input class='formInput' type='checkbox' name='admin' value='1' " . ($value == '0' ? "" : "checked") . "><br>\n";
                    continue;
                }
                if ($label == "Newsletter") { // special case for newsletter field: it must be a checkbox (not a text field)
                    echo "Ricevi newsletter<br><input class='formInput' type='checkbox' name='newsletter' value='1' " . ($value == '0' ? "" : "checked") . "><br>\n";
                    continue;
                }
                // text input field of the form
                echo ucfirst($label) . "<input class='formInput' type='text' name='" . strtolower($key) . "' value='" . htmlspecialchars($value) . "' required><br>\n";
            }
            echo "<input class='formInput' type='submit' value='Conferma'>";
            ?>
    </form>
    <?php require 'footer.php'; ?>
</div></body>
</html>
