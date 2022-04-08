<?php
// navbar that shows options only for admins, toggled by "Admin" in the normal navbar
require_once 'util/authentication.php';
redirectIfNotAdmin();
// options are adding/editing products/users and sending newsletter
echo<<<EOL
<nav id="adminNavbar" class="adminNavbar">
    <ul>
        <li><a href="registration.php">Registra utente</a></li>
        <li><a href="registrationProduct.php">Registra prodotto</a></li>
        <li><a href="allUsers.php">Gestisci utenti</a></li>
        <li><a href="allProducts.php">Gestisci prodotti</a></li>
        <li><a href="newsletter.php">Invia Newsletter</a></li>
    </ul>
</nav>
EOL;
