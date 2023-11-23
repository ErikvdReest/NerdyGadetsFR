<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

if (isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
} else {
    $stockItemID = 0;
}

// Refreshes the page when a post occurs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Betalen</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 50%;
        }

        .WinkelmandjeTerug {
            text-align: left;
            padding: 10px;
            background-color: transparent;
        }

        .fa-shopping-cart {
            color: #FFFFFF;
            background-color: transparent;
        }

        .productenWinkelmandje {
            border: 1px solid #FFFFFF;
            padding: 10px;
            margin-left: 60px;
            width: 40%;
            text-align: center;
            margin-top: 10px;
        }

        .product {
            display: flex;
            justify-content: space-between;
            text-align: left;
            margin-bottom: 10px;
            border-bottom: 1px solid #FFFFFF;
            padding-bottom: 10px;
        }

    </style>
</head>
<body>

<div class="WinkelmandjeTerug">
    <form action="winkelmandje.php" method="post">
        <button type="submit" class="fas fa-shopping-cart" id="AfrekenenKnop"> Terug Naar Winkelmandje</button>
    </form>
</div>

<div class="container">
    <h1>Afrekenen</h1>
</div>

<div class="productenWinkelmandje">
    <h1>Producten</h1>
    <div class="productenTonen">
        <?php
        $cart = getCart();
        $connection = connectToDatabase();

        foreach ($cart as $Artikelnummer => $aantal) {
            print("<div class='cart-item'>");

            // With the use of the article number, $productdetails displays information about products
            $productDetails = getStockItem($Artikelnummer, $connection);
            $StockItemImage = getStockItemImage($Artikelnummer, $connection);

            if ($productDetails) {
                print("<div class='product'>");
                print("<div class='product-info'>");
                print("<h3>" . $productDetails['StockItemName'] . "</h3>");
                print("</div>");
                print("</div>");
            }
        }
        ?>
    </div>
</div>

</body>
</html>
