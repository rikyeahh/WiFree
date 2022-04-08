<!DOCTYPE html>
<html lang="it">
 <head>
  <title>WiFree</title>
  <link rel="icon" type="image/png" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width"/>
  <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
  <style>@import url('https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap');</style>
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
 </head>

 <body>
<div class="bodyWrapper">
 <?php require 'navbar.php'; ?>
 <div class="themeButtons">
     <button class="themeButton" id="Redania">Redania</button>
     <button class="themeButton" id="Greench">Greench</button>
     <button class="themeButton" id="Classic">Classic</button>
 </div>
 <main class="homeImage" id="homeImage">
     <p class="slogan">WELCOME TO THE <strong>OUT</strong>ERNET<br></p>
 </main>
 <?php require 'footer.php'; ?>
</div>
<script src="js/homeBackground.js"></script>
<script src="js/changeTheme.js"></script>
</body>
</html>
