<!DOCTYPE html>
<html lang="it">

<head>
  <title>Titolo</title>
  <link rel="icon" type="image/png" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width"/>
  <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
  <style>@import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');</style>
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="bodyWrapper">
    <?php
    /* script to add a new product to the db */
    require 'navbar.php';
    echo "<h1 class='editTitle'>Registra un nuovo prodotto</h1>";
    if (!isset($_SESSION["admin"])) { // feature only for admins
        header('Location: allProducts.php');
        exit;
    }
    $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // check that all fields are valid and set
        require_once 'util/authentication.php';
        $error .= validatePostData("name", "price", "imgpath", "description", "availability");
        // display possible errors
        echo "<div class='errorBox'>" . $error . "</div>";
        if ($error == "") { // input is valid
            // store the user info in db
            $con = require '../db/databaseAccess.php';
            $dbError = "";
            if (!($stmt = $con->prepare("INSERT INTO products (name, price, imgpath, description, availability) VALUES (?,?,?,?,?)"))) {
                $dbError .= "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error . "</p>";
            }
            // gather the product info
            $name = trim($_POST["name"]);
            $price = trim($_POST["price"]);
            $imgpath = trim($_POST["imgpath"]);
            $description = trim($_POST["description"]);
            $availability = trim($_POST["availability"]);
            if (!$stmt->bind_param("sssss", $name, $price, $imgpath, $description, $availability)) {
                $dbError.= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
            }
            // execute the query
            if (!$stmt->execute()) {
                $error .= "<p class='error'>Dati non validi</p>";
                $dbError .= "<p class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
            }
            // close connection
            $con->close();
            // show possible errors
            echo "<div class='errorBox'>" . $error . $dbError . "</div>";
            if ($error == "" && $dbError == "") { // if no errors
                echo "<p class='confirm'>Dati registrati correttamente</p>";
            }
        }
    }
    ?>
  <div class="registrationForm">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <i class="fas fa-file-signature"></i>
      <input class="formInput" type="text" name="name" placeholder="Nome" required><br>
      <i class="fas fa-dollar-sign"></i>
      <input class="formInput" type="text" name="price" placeholder="Prezzo" required><br>
      <i class="fas fa-image"></i>
      <input class="formInput" type="text" name="imgpath" placeholder="Percorso immagine" required><br>
      <i class="fas fa-align-justify"></i>
      <input class="formInput" type="text" name="description" placeholder="Descrizione" required><br>
      <i class="fas fa-boxes"></i>
      <input class="formInput" type="text" name="availability" placeholder="Disponibilità" required><br>
      <input class="formInput" type="submit" value="Inserisci">
    </form>
  </div>
  <?php require 'footer.php'; ?>
</div></body>

</html>
