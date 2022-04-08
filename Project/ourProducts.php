<!DOCTYPE html>
<html lang="it">
<head>
    <title>I nostri prodotti</title>
    <link rel="icon" type="image/png" href="img/favicon.ico"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
    <link rel="stylesheet" type="text/css" href="styles/all.css">
    <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');</style>
</head>
<body>
<div class="bodyWrapper">
    <div class="bodyWrapper">
    <?php require 'navbar.php';?>
    <div class="editTitle">
        <h1>I nostri prodotti</h1>
        <form class="productFilter" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <input class='submitFilter' type="submit" name="submit" value="Filtra">
            <input class="wordsFilter" type="text" name="words" placeholder="Filtra per parole chiave">
            <div class="orderFilter">
                <div>
                    <input id="prezzoCrescente" type="radio" name="ord" value="price ASC">
                    <label for="prezzoCrescente">Prezzo crescente</label>
                </div>
                <div>
                    <input id="prezzoDecrescente" type="radio" name="ord" value="price DESC">
                    <label for="prezzoDecrescente">Prezzo decrescente</label>
                </div>
                <div>
                    <input id="piuComprati" type="radio" name="ord" value="npurchase DESC">
                    <label for="piuComprati">Più comprati</label>
                </div>
            </div>

        </form>

    </div>

    <div class="productDisplay">
        <?php
            $con = require '../db/databaseAccess.php';
            $error = "";
            $query = "SELECT * FROM products";
            // consider the words filter: add LIKE condition
            if (!empty($_GET["words"])) {
                $query .= " WHERE name LIKE ? OR description LIKE ?";
            }
            // consider the ord filter: add ORDER BY
            if (!empty($_GET["ord"]) && in_array($_GET["ord"], ["npurchase DESC", "price ASC", "price DESC"])) {
                $query .= " ORDER BY " . $_GET["ord"];
            }
            if (!($stmt = $con->prepare($query))) {
                $error .= "Prepare failed: (" . $con->errno . ") " . $con->error;
            }
            // bind parameters for the LIKE condition, using regex
            if (!empty($_GET["words"])) {
                $likeRegex = "%" . $_GET["words"] . "%";
                if (!$stmt->bind_param("ss", $likeRegex, $likeRegex)) {
                    $error .= "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                }
            }
            if (!$stmt->execute()) {
                $error .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!($res = $stmt->get_result())) {
                $error .= "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            echo "<div class='errorBox'>" . $error . "</div>";
            if ($error == "") { // if no errors
                foreach ($res as $product) { // show a box for each product
                    // containing all its info
                    $id = $product["id"];
                    $name = $product["name"];
                    $price = $product["price"];
                    $imgpath = $product["imgpath"];
                    $description = $product["description"];
                    echo "<div class='product'>
                        <div class='productLeft'>
                            <img class='productImg' src='$imgpath' alt='$name'>
                            <h2 class='productPrice'>$price $</h2>
                        </div>
                        <div class='productMiddle'>
                            <h2 class='productName'>$name</h2>
                            <p class='productDescription'>$description</p>";
                    // special adding if availability is < 10
                    if (($product["availability"] < 10) && ($product['availability'] != 0)) {
                        echo "<p class='availabilityNotice'><i class='fas fa-bolt'></i>Ultimi " . $product["availability"] . " disponibili!<i class='fas fa-bolt'></i></p>";
                    } else if ($product["availability"] == 0) { // or if it is not available
                        echo "<p class='availabilityNotice'><i class='fas fa-store-slash'></i>Non disponibile<i class='fas fa-store-slash'></i></p>";
                    }
                    // right part, with button to add to cart and hidden id to make javascript work
                    echo "</div>";
                    echo "<div class='productRight'>
                          <p hidden>$id</p>
                          <div>Nel carrello: <div class='qty'>0</div></div><br>
                          <i class='addToCart fas fa-cart-plus fa-3x'></i>
                          </div>";
                    echo "</div>";
                }
            }
        ?>
    </div>
    </div>
    <?php require 'footer.php';?>
</div>
<script src="js/shopping.js"></script>
</body>
</html>
