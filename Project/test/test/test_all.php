<?php

require 'test_login.php';
require 'test_register.php';
require 'test_show.php';
require 'test_update.php';
require 'utils.php';

/****************************************/
/* replace $baseurl with your directory */
/****************************************/
$baseurl =  'http://localhost/progetto/';
//$baseurl =  'http://localhost/~S4675091/';
//$baseurl =  'https://webdev19.dibris.unige.it/~S4675091';

echo "[+] Testing Registration - Login - Show Profile<br>\n";

echo "[*] Generating random user<br>\n";

echo "---<br>\n";
$email = generate_random_email();
$pass = generate_random_password();
$first_name = generate_random_name();
$last_name = generate_random_name();
echo "Email: $email<br>\n";
echo "Pass: $pass<br>\n";
echo "First name: $first_name<br>\n";
echo "Last name: $last_name<br>\n";
echo "---<br>\n";

//echo "[-] Calling logout.php<br>\n";
//logout($email, $pass, $baseurl);
echo "[-] Calling register.php<br>\n";
register($email, $pass, $first_name, $last_name, $baseurl);

echo "[-] Calling login.php<br>\n";
login($email, $pass, $baseurl);


echo "[-] Calling show_profile.php<br>\n";

echo check_correct_user($email, $first_name, $last_name, show_logged_user($baseurl))
    ? "[*] Success!<br>\n"
    : "[*] Failed<br>\n";

echo "------------------------<br>\n";

echo "[+] Testing Update - Show Profile<br>\n";

echo "[*] Generating new random user<br>\n";
$first_name = generate_random_name();
$last_name = generate_random_name();

echo "---<br>\n";
echo "Email: $email<br>\n";
echo "First name: $first_name<br>\n";
echo "Last name: $last_name<br>\n";
echo "---<br>\n";

echo "[-] Calling update_profile.php<br>\n";
update($email, $first_name, $last_name, $baseurl);

echo "[-] Calling show_profile.php<br>\n";

echo check_correct_user($email, $first_name, $last_name, show_logged_user($baseurl))
    ? "[*] Success!<br>\n"
    : "[*] Failed<br>\n";


echo "------------------------<br>\n";
