<!DOCTYPE html>
<html lang="it">
<head>
    <title>Il mio Carrello</title>
    <link rel="icon" type="image/png" href="img/favicon.ico"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
    <link rel="stylesheet" type="text/css" href="styles/all.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');</style>
    <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="bodyWrapper">
<?php
require 'navbar.php';
echo "<h1 class='editTitle'>Carrello</h1>";
require_once 'util/authentication.php';
redirectIfNotLoggedIn();
?>
<div class="cartSummary" id='cartSummary'>
    <div class="productSummary" id="productSummary">
        <!-- javascript will fill this div -->
    </div>
    <div class="cartButtons">
        <button class="cartButton" type="button" id="clearCart">Svuota carrello</button>
        <button class="cartButton" type="button" id="buy">Compra</button>
        <p id="totalPrice">Totale: 0 €</p> <!-- total price will be updated by js -->
    </div>
</div>
</div>
<?php require 'footer.php';?>
<script src="js/utility.js"></script>
<script src="js/shopping.js"></script>
<script src="js/buy.js"></script>
</body>
</html>
