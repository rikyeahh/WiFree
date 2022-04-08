<nav>
    <div class="navbarLogo">
        <a href="home.php">
            <?php require 'logoInteractive.php'; ?>
        </a>
    </div>
    <ul>
       <li id="cartIcon"><a href="myCart.php"><i class="fa fa-shopping-cart fa-lg"></i></a></li>
       <li><a href="aboutUs.php">Chi siamo</a></li>
       <li><a href="ourProducts.php">I nostri prodotti</a></li>
       <?php
        session_start();
        // if not logged in, display "Accedi" and "Registrati" links
        if (!isset($_SESSION["login"])) {
            echo '<li><a href="login.php">Accedi</a></li>';
            echo '<li><a href="registration.php">Iscriviti</a></li>';
        } else { // if logged in, display "logout" and edit profile links
            // to prevent cURL generated users having empty nickname, show generic "user"
            $nickname = isset($_SESSION["nickname"]) && !empty(trim($_SESSION["nickname"])) ? htmlspecialchars($_SESSION["nickname"]) : "user";
            echo '<li id="myProfileId"><a href="show_profile.php?id='.$_SESSION["id"].'">'.$nickname.'</a></li>';
            echo '<li><a href="logout.php">Logout<br></a></li>';
        }
        // if logged account is an admin, display the toggle for a special menu/navbar (navbarAdmin.php)
        if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
            echo '<li><a id="adminNavbarToggle">Admin</a></li>';
            echo "</ul></nav>";
            require 'navbarAdmin.php';
            echo "<script src='js/hideShowAdminNavbar.js'></script>";
            return;
        }
        ?>
    </ul>
</nav>
