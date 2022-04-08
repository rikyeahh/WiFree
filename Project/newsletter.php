<!DOCTYPE html>
<html lang="it">
<head>
  <title>Newsletter</title>
  <link rel="icon" type="image/png" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width"/>
  <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="bodyWrapper">
    <?php
    // send email using PHPMailer library
    use PHPMailer\PHPMailer\PHPMailer;
    require 'navbar.php';
    // feature only available for admins
    require_once 'util/authentication.php';
    redirectIfNotAdmin();
    echo "<h1 class='editTitle'>Invia newsletter agli iscritti</h1>";
    $con = require '../db/databaseAccess.php';
    // if coming from post, collect data and send email
    $error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // TODO add email to db
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';
        require 'PHPMailer/Exception.php';

        $mail = new PHPMailer(true);
        // set up mail using gmail
        $mail->IsSMTP(); // telling the class to use SMTP
        //$mail->SMTPDebug = 1;
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the server
        $mail->Host = "smtp.gmail.com"; // set GMAIL as the SMTP server
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->IsHTML(true);
        $mail->Username = "wifreenewsletter@gmail.com"; // GMAIL username
        $mail->Password = $_POST["password"]; // GMAIL password
        $mail->addAddress("riccardororato99@gmail.com"); // main TO recipient
        // add all emails in the db as recipients (BCC for privacy reasons)
        require_once '../db/database.php';
        if (!$res = getAllFromTable("users")) {
            echo "<p class='error'>Errore: riprova più tardi</p>";
        }
        foreach ($res as $row) {
            if ($row["newsletter"]) { // send email only to the ones who have allowed
                if (!$mail->addBCC($row["email"])) {
                    $error .= "<p class='error'>Error in adding BBC</p>";
                }
            }
        }
        $mail->SetFrom("wifreenewsletter@gmail.com", "WiFree");
        // set subject and body as specified by the admin
        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"];
        // send email
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "<h3 class='confirm'>Messaggio inviato correttamente<h3>";
        }
    }
    ?>
    <form class="editProfileForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input class="formInput" type="text" name="subject" value="" placeholder="Oggetto">
        <textarea class="formInput" name="message" placeholder="Messaggio da inviare" cols="22"></textarea><br>
        <br><input class="formInput" type="password" name="password" value="" placeholder="Password dell'email WiFree">
        <input class="formInput" type="submit" name="submit" value="Invia">
    </form>
    <?php require 'footer.php'; ?>
</div></body>
</html>
