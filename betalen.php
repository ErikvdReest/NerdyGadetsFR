<?php
include __DIR__ . "/header.php";
include "betalenFuncties.php";
include "cartfuncties.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur</title>
    <style>
        body {
            margin: 20px;
        }

        h1 {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .factuurGegevens,
        .klantGegevens {
            border: 1px solid #FFFFFF;
            border-radius: 30px;
            text-align: left;
            width: 48%;
            padding: 20px;
            box-sizing: border-box;
            margin-top: 10px;
        }

        .factuurGegevens hr,
        .klantGegevens hr {
            color: #FFFFFF;
            border: 1px solid;
        }

        .factuurGegevens h1,
        .klantGegevens h1 {
            padding: 10px;
            margin-bottom: 10px;
        }

        .factuurGegevens {
            width: 100%;
        }
        .klantGegevens {
            width: 100%;
            margin-left: 10px;
        }
        .Terug {
            text-align: center;
            margin-top: 20px;

        }
    </style>
</head>
<body>
<h1>Bedankt voor het bestellen bij NerdyGadgets !</h1>


<div class="container">
    <div class="factuurGegevens">
        <h1>Bestelling</h1>

        <?php
        $cart = getCart();
        $connection = connectToDatabase();
        $totaalPrijs = 0;
        $aantalProducten = 0;
        $afgerondePrijs = 0;

        // Toont de array $cart met artikelnummer als index
        foreach ($cart as $Artikelnummer => $aantal) {
            print("<div class='factuur-item'>");

            // Met gebruik van artikelnummer toont $productdetails de informatie over producten
            $productDetails = getStockItem($Artikelnummer, $connection);

            if ($productDetails) {
                print("<div class='product-info'>");
                print("<h3>" . $productDetails['StockItemName'] . "</h3>");
                // Toont de voorraad
                print("<p>Aantal: " . $aantal . "</p>");
                print("<hr>");
                print("</div>");
            }

            print("</div>");
            $aantalProducten += ($aantal);
            // Prijs en totaalprijs van het aantal producten worden niet toegevoegd aan $totaalPrijs
        }
        $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
        $totaalPrijs= $aantalProducten * $afgerondePrijs;
        print "Totaalprijs inclusief BTW: " . "€". totaalPrijsPerProduct($aantal,$afgerondePrijs);
        // Als er post plaatsvindt bij de prullenbak knop wordt het product uit de array verwijderd.
        ?>
    </div>

    <div class="klantGegevens">
        <h1>Klant-Gegevens</h1>
        <?php
        $klantgegevens = opvragenKlantgegevens($connection);
        if ($klantgegevens) {
            print("<h2>Klantgegevens</h2>");
            print("<p>Customer ID: " . $klantgegevens['CustomerID'] . "</p>");
            print("<p>Naam: " . $klantgegevens['CustomerName'] . "</p>");
            print("<p>Adres: " . $klantgegevens['DeliveryAddressLine2'] . "</p>");
            print("<p>Email: " . $klantgegevens['Emailadres'] . "</p>");
        }
        ?>
    </div>
</div>



</body>
</html>

<style>
    #AfrekenenKnop {
        background-color: transparent;
        border: none;
        padding: 0;
        font-size: 16px;
        color: #FFFFFF;
        cursor: pointer;
    }

    #AfrekenenKnop:hover {
        text-decoration: underline; /* Optional: Add underline on hover */
    }
</style>

<div class="Terug">
    <form action="index.php" method="post">
        <button type="submit" id="AfrekenenKnop" class="fas fa-shopping-alt">Terug naar Homepage</button>
    </form>
</div>
