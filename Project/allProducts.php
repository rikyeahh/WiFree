<!DOCTYPE html>
<html lang="it">
<head>
  <title>Amministrazione WiFree</title>
  <link rel="icon" type="image/png" href="img/favicon.ico"/>
  <meta name="viewport" content="width=device-width"/>
  <link rel="stylesheet" type="text/css" href="styles/allUsers.css">
  <link rel="stylesheet" type="text/css" href="styles/stileHome.css">
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <script src="https://kit.fontawesome.com/1a712afbb2.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="bodyWrapper">
    <?php
    require 'navbar.php';
    require_once 'util/authentication.php';
    redirectIfNotAdmin();
    echo "<h1 class='editTitle'>Prodotti nel database</h1>";
    require_once '../db/database.php';
    // get all products from db
    $res = getAllFromTable("products");
    // get all product attributes from db
    $fieldsRes = describeTable("products");

    echo "<table class='usersTable'>";
    echo "<tr>";
    // for each attribute/field of the products table
    foreach ($fieldsRes as $row) {
        // skip "id" field
        if (in_array($row["Field"], ["id"])) { # expandable
            continue;
        }

        // translate the field in italian
        require_once 'util/translation.php';
        $fieldIta = translated($row["Field"]);

        // print table headings, with ?ord= same as db attribute but italian label
        echo "<td><a class='ordTableColumnLabel' href='allProducts.php?ord=" . $row["Field"] . "'>" . $fieldIta . "</a></td>";
    }
    echo "<td></td><td></td></tr>";
    // show a table row for each product of the table, containing its info
    foreach ($res as $row) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            // exclude id
            if ($key == "id") {
                continue;
            }
            echo "<td>" . $row[$key] . "</td>";
        }
        // links to edit (show_product.php) and delete product (deleteProduct.php) of this row
        echo "<td><a href='show_product.php?id=" . $row["id"] . "'>Modifica</a></td>";
        echo "<td><a href='deleteProduct.php?id=" . $row["id"] . "'>Cancella</a></td>";
        echo "</tr>";
    }
    echo "</table><br><br>";
    require 'footer.php';
?>
</div>
<script src="js/adminTables.js"></script>
</body>
</html>
