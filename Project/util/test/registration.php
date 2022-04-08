<!DOCTYPE html>
<html lang="it">

<head>
  <title>Registrati</title>
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
    require 'navbar.php';
    echo '<h1 class="editTitle">Registrati</h1>';
    $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if ($_POST["pass"] != $_POST["confirm"]) {
            $error .= "<p class='error'>Password and password confirm are different</p>";
        }
        // check that all fields are set
        if(!isset($_POST["firstname"]) || trim($_POST["firstname"]) == ''){
            $error .= "<p class='error'>First name field is not set</p>";
        }
        if(!isset($_POST["lastname"]) || trim($_POST["lastname"]) == ''){
            $error .= "<p class='error'>Last name field is not set</p>";
        }
        if(!isset($_POST["email"]) || trim($_POST["email"]) == ''){
            $error .= "<p class='error'>Email field is not set</p>";
        }
        if(!isset($_POST["pass"]) || trim($_POST["pass"]) == ''){
            $error .= "<p class='error'>Password field is not set</p>";
        }
        if(!isset($_POST["confirm"]) || trim($_POST["confirm"]) == ''){
            $error .= "<p class='error'>Password confirm field is not set</p>";
        }

        // check for well formed inputs
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $error .= "<p class='error'>Email isn't in the right format</p>";
        }
        echo "<div class='errorBox'>" . $error . "</div>";
        if ($error == "") { // input is valid
            // store the user info in db
            // connecting to db
            $con = require '../db/databaseAccess.php';
            $dbError = "";
            if (!($stmt = $con->prepare("INSERT INTO users (firstname, lastname, email, password, nickname) VALUES (?,?,?,?,?)"))) {
                $dbError .= "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error . "</p>";
            }
            echo $dbError;
            $firstname = trim($_POST["firstname"]);
            $lastname = trim($_POST["lastname"]);
            $email = trim($_POST["email"]);
            $password = password_hash(trim($_POST["pass"]), PASSWORD_DEFAULT);
            $nickname = isset($_POST["nickname"]) ? trim($_POST["nickname"]) : date('Format String');
            if (!$stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $nickname)) {
                $dbError.= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
            }
            // execute the query
            if (!$stmt->execute()) {
                $error .= "<p class='error'>Credenziali non valide</p>";
                $dbError .= "<p class='error'> Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
            }
            //free memory and close connection
            $con->close();
            echo "<div class='errorBox'>" . $error . $dbError . "</div>";
            if ($error == "" && $dbError == "") {
                echo "<p class='confirm'>Dati registrati correttamente: puoi accedere</p>";
            }
        }
    }
    ?>
    <div class="errorBox" id="errorBox">
         <!-- this will be filled by javascript -->
    </div>
  <div class="registrationForm" id="registrationForm">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <i class="fas fa-file-signature"></i>
      <input class="formInput" type="text" id="firstname" name="firstname" placeholder="Firstname" required><br>
      <i class="fas fa-file-signature"></i>
      <input class="formInput" type="text" id="lastname" name="lastname" placeholder="Lastname" required><br>
      <i class="fas fa-at"></i>
      <input class="formInput" type="email" id="email" name="email" placeholder="E-mail" required><br>
      <i class="fas fa-key"></i>
      <input class="formInput" type="password" id="pass" name="pass" placeholder="Password" required><br>
      <i class="fas fa-key"></i>
      <input class="formInput" type="password" id="confirm" name="confirm" placeholder="Confirm password" required><br>
      <i class="fas fa-user-alt"></i>
      <input class="formInput" type="text" id="nickname" name="nickname" placeholder="Nickname" required><br>
      <input id="submit" class="formInput" type="submit" value="Submit">
    </form>
  </div>
  <?php require 'footer.php'; ?>
</div>
<script src="js/utility.js" type="text/javascript"></script>
<script src="js/checkRegistration.js" type="text/javascript"></script>
</body>
</html>
