<!DOCTYPE html>
<html lang="it">
<head>
  <title>Modifica prodotto</title>
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
    // feature only for admins, with specified product id
    if (!isset($_GET["id"]) || !isset($_SESSION["admin"])) {
        header('Location: allProducts.php');
        exit;
    }
    echo "<h1 class='editTitle'>Modifica i dati e conferma</h1>";
    $con = require '../db/databaseAccess.php';
    $error = "";
    $idOfProductToShow = $_GET["id"];
    // do the update query if coming from post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Update query
        if (!($stmt = $con->prepare("UPDATE products SET name=?, price=?, imgpath=?, description=?, availability=? WHERE id=?"))) {
            echo "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error;
        }
        // gather the product info
        $name = trim($_POST["name"]);
        $price = trim($_POST["price"]);
        $imgpath = trim($_POST["imgpath"]);
        $description = trim($_POST["description"]);
        $availability = trim($_POST["availability"]);
        if (!$stmt->bind_param("sdssii", $name, $price, $imgpath, $description, $availability, $idOfProductToShow)) {
            $error .= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
        }
        if (!$stmt->execute()) {
            $error .= "<p class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
        }
        if ($stmt->affected_rows > 1) {
            $error .= "<p class='error'>Something went wrong</p>";
        }
        if (empty($error)) { // if no errors, show an OK box
            echo "<p class='confirm'>Dati modificati correttamente</p>";
        }
        else { // else show errors
            echo "<div class='errorBox'>$error</div>";
        }
    }
    // get info to show product info already in the appropriate form input fields
    require_once '../db/database.php';
    $product = getFromTableWithId("products", $idOfProductToShow);
    ?>
    <form class="editProfileForm" action="show_product.php?id=<?php echo $idOfProductToShow; ?>" method="post">
            <?php
            // display the product fields dinamically: if one column is added to database, it will appear here too
            foreach ($product as $key => $value) {
                if ($key == "id" || $key == "npurchase") { // skip id and number of purchase
                    continue;
                }
                // translate the attribute in italian
                require_once 'util/translation.php';
                $label = translated($key);

                // text input field of the form
                echo $label . "<input class='formInput' type='text' name='" . strtolower($key) . "' value='$value' required><br>";
            }
            echo "<input class='formInput' type='submit' value='Conferma'>";
            ?>
    </form>
    <?php require 'footer.php'; ?>
</div></body>
</html>
