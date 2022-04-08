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
    if($_SERVER["REQUEST_METHOD"] == "POST") { // if coming from post request
        // check for password == confirm
        if ($_POST["pass"] != $_POST["confirm"]) {
            $error .= "<p class='error'>Password and password confirm are different</p>";
        }
        // check that all fields are set
        require_once 'util/authentication.php';
        $error .= validatePostData("firstname", "lastname", "email", "pass", "confirm");
        // check for well formed email
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $error .= "<p class='error'>Email isn't in the right format</p>";
        }
        // display possible errors
        echo "<div class='errorBox'>" . $error . "</div>";
        if ($error == "") { // input is valid
            // store the user info in db with prepared statement
            $con = require '../db/databaseAccess.php';
            $dbError = "";
            if (!($stmt = $con->prepare("INSERT INTO users (firstname, lastname, email, password, nickname, newsletter) VALUES (?,?,?,?,?,?)"))) {
                $dbError .= "<p class='error'>Prepare failed: (" . $con->errno . ") " . $con->error . "</p>";
            }
            echo $dbError;
            // gather input data
            $firstname = trim($_POST["firstname"]);
            $lastname = trim($_POST["lastname"]);
            $email = trim($_POST["email"]);
            // hash the password with the built-in function
            $password = password_hash(trim($_POST["pass"]), PASSWORD_DEFAULT);
            // nickname is "user" if it is not specified, since the automatic tests do not send it
            $nickname = isset($_POST["nickname"]) && !empty(trim($_POST["nickname"])) ? trim($_POST["nickname"]) : "user";
            // newsletter subscription if specified by user
            $newsletter = isset($_POST["newsletter"]) ? $_POST["nickname"] : 0;
            if (!$stmt->bind_param("sssssi", $firstname, $lastname, $email, $password, $nickname, $newsletter)) {
                $dbError.= "<p class='error'>Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
            }
            // execute the query
            if (!$stmt->execute()) {
                $error .= "<p class='error'>Credenziali non valide</p>";
                $dbError .= "<p class='error'> Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
            }
            // close connection
            $con->close();
            // display possible errors
            echo "<div class='errorBox'>" . $error . "</div>";
            echo "<div class='errorBox'>" . $dbError . "</div>";
            if ($error == "" && $dbError == "") { // if no errors
                echo "<p class='confirm'>Dati registrati correttamente: puoi accedere</p>";
            }
        }
    }
    ?>
    <div class="errorBox" id="errorBox">
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
      <i class="fas fa-envelope"></i>
      Vuoi ricevere newsletter?
      <input class="formInput" type="checkbox" id="newsletter" name="newsletter" value="1" checked><br>
      <input id="submit" class="formInput" type="submit" value="Submit">
    </form>
  </div>
  <?php require 'footer.php'; ?>
</div>
<script src="js/utility.js"></script>
<script src="js/checkRegistration.js"></script>
</body>
</html>
