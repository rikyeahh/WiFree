<!DOCTYPE html>
<html lang="it">
<head>
    <title>Login</title>
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
    echo '<h1 class="editTitle">Accedi</h1>';
    $error = "";

    // if coming from post
    // decomment for stricter behaviour: prevent login if already logged in
    if (/*!isset($_SESSION["login"]) && */$_SERVER["REQUEST_METHOD"] == "POST") {
        // check that all fields are set and not empty
        require_once 'util/authentication.php';
        $error .= validatePostData("email", "pass");
        if (empty($error)) { // if all fields are set
            // collect the credentials
            $email = trim($_POST["email"]);
            $password = trim($_POST["pass"]);
            // connect to the database
            require_once '../db/database.php';
            $row = getUserWithEmail($email);
            // verify equality of the password using the built-in function
            if ($row != null && password_verify($password, $row["password"])) {
                // set session valiables
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                $_SESSION["nickname"] = $row["nickname"];
                // if account is an admin one
                if ($row["admin"]) {
                    $_SESSION["admin"] = true;
                }
                else {
                    // if account that was previously logged in did not perform a logout
                    // and is logging to a non-admin user, remove admin privilege
                    if (isset($_SESSION["admin"])) {
                        unset($_SESSION["admin"]);
                    }
                }
                header("Location: home.php");
                exit;
            }
            else { // error: account does not exist in db or wrong password
                $error .= "<p class='error'>Credenziali sbagliate: riprova o registrati</p>";
            }
        }
    }
    echo "<div class='errorBox'>" . $error . "</div>";
    if (isset($_SESSION["login"])) {
        echo "<p class='confirm'>Hai già fatto l'accesso</p>";
    }
    ?>
    <div class="loginForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <i class="fas fa-at"></i>
            <input class="formInput" type="email" id="email" name="email" placeholder="Email" required><br>
            <i class="fas fa-key"></i>
            <input class="formInput" type="password" id="pass" name="pass" placeholder="Password" required><br>
            <input class="formInput" type="submit" value="Submit">
        </form>
    </div>
    <?php require 'footer.php'; ?>
</div>
</body>

</html>
