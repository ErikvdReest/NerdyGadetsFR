<?php
include __DIR__ . "/header.php";
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

        // Als er post plaatsvindt bij de prullenbak knop wordt het product uit de array verwijderd.
        ?>
    </div>

    <div class="klantGegevens">
        <h1>Klant-Gegevens</h1>
    </div>
</div>



</body>
</html>