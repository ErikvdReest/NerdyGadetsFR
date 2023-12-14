<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

if (isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
} else {
    $stockItemID = 0;
}
//Refreshed de pagina op het moment dat er een post plaats vindt
//De pagina wordt direct gerefreshed als er post plaatsvindt.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Refresh:0");
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title >Winkelwagen</title>
    <style>
        .grid-container {
            display: flex;
            justify-content: space-around;
        }

        h1 {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
        }

        .product {
            margin-top: 10px;
            width: 78%;
            padding: 15px;
            border: 1px solid #FFFFFF;
            border-radius: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex: 2;
        }

        .bestelling {
            border: 1px solid #FFFFFF;
            border-radius: 30px;
            margin-top: 10px;
            text-align: left;
            flex: 1;
            width: 50%;
            margin-right: 10px;
            padding: 15px;
            align-items: center;
        }
        .bestelling h1 {
            text-align: center;
        }

        .bestelling hr {
            border: none;
            border-top: 2px solid white;
            margin: 5px 0;
        }

        .aantal {
            display: inline-block;
            width: 20%;
            border: 1px SOLID lightslategray;
            padding: 20px;
            text-align: left;
            background-color: transparent;
            border-radius: 20px;
        }

        .aantal input {
            text-align: right;
            width: 100%;
            border: 1px SOLID lightslategray;
            background-color: transparent;
            color: #FFFFFF;
        }

        .transparent-button-min {
            background: transparent;
            border: none;
            color: white;
        }

        .transparent-button-plus {
            margin-top: 10px;
            margin-left: 20px;
            background: transparent;
            border: none;
            color: white;
        }

        h2, p {
            text-align: left;
        }

        .product-info {
            flex: 1;
        }

        .transparent {
            background: none;
            border: none;
            color: #FFFFFF;
        }

        .image {
            margin-top: 15px;
            margin-left: 10px;

        }
        #AfrekenenKnop {
            background-color: transparent;
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
        }

        #AfrekenenKnop:hover {
            background-color: rgba(255, 165, 0, 1);
        }
        .transparent-button {
            background-color: transparent;
            border: none;
            padding: 0;
            font-size: 16px;
            color: #FFFFFF;
            cursor: pointer;
        }

        .transparent-button-plus:hover {
            color: #00FF00;
        }
        .transparent-button-min:hover {
            color: orange;
        }

        .delete-button {
            margin-left: 10px;
            background-color: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .delete-button:hover {
            color: #FF0000;
        }
        .totaalPrijs {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .totaalPrijs h3, .totaalPrijs h4 {
            margin: 0;
        }
        .rand {
            border: 1px SOLID transparent;
            flex: auto;
            margin-right: -60px;
            max-width: 1200px;
        }
        .betalen {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

    </style>
</head>
<body>
<h1>Winkelwagen</h1>

<div class="grid-container">
    <div class="rand">


<?php
$cart = getCart();
$connection = connectToDatabase();
$totaalPrijs = 0;
$aantalProducten = 0;
$afgerondePrijs = 0;
$brutoTotaalprijs = 0;
$BTW = 0;
$brutoPrijsPerStuk = 0;
$BtwPrijsPerStuk = 0;
$BtwTotaalPrijs = 0;

//Toont de array $cart met artikelnummer als index//
foreach ($cart as $Artikelnummer => $aantal) {
    print("<div class='cart-item'>");

    //Met gebruik van artikelnummer toont $productdetails de informatie over producten//
    $productDetails = getStockItem($Artikelnummer, $connection);
    $StockItemImage = getStockItemImage($Artikelnummer, $connection);

    if (isset($StockItemImage)) {
        if (count($StockItemImage) == 1) {
        } ?>
            <div id="ImageFrameCart" class="image"
                 style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 155px;  border: 1px solid #FFFFFF background-repeat: no-repeat; background-position: center;">
            </div>
            

            <?php

            if ($productDetails) {
                print("<div class='product'>");
                print("<div class='product-info'>");
                print("<h3>" . $productDetails['StockItemName'] . "</h3>");
                // Rond de prijs op twee decimalen af
                $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
                // Toont de prijs en totaalprijs van het aantal producten
                print("<p>Prijs: €" . totaalPrijsPerProduct($aantal,$afgerondePrijs) . "</p>");
                // Toont de voorraad
                print("<p>" . "Voorraad: ". $productDetails['QuantityOnHand'] . "</p>");

                print("</div>");
                print("<div class='aantal'>");
                print("<form method='post' style='display: inline;'>");
                print("Aantal: ");
                print("<input type='text' name='aantal[$Artikelnummer]' value='$aantal'>");
                print("<button hidden type='submit' name='update_aantal' value='$Artikelnummer' class='transparent-button'>Update</button>");
                print("<div class='aanpassen'>");
                print("<button type='submit' name='toevoegen' value='$Artikelnummer' class='transparent-button-plus fas fa-plus'></button>");
                print("<button type='submit' name='verminderen' value='$Artikelnummer' class='transparent-button-min fas fa-minus'></button>");
                print("<button type='submit' name='verwijderen' value='$Artikelnummer' class='delete-button transparent'><i class='fas fa-trash'></i></button>");
                print("</div>");
                print("</form>");
                print("</div>");
                print("</div>");
                print("</div>");

                //Berekent de bruto prijs per stuk
                $bruto = (0.79 * $productDetails['SellPrice']);

                $brutoPrijsPerStuk += $bruto;

                $Btw = (0.21 * $productDetails['SellPrice']);

                //Berekent Btw prijs per stuk
                $BtwPrijsPerStuk += $Btw;

                //Berekent de bruto prijs totaal per artikel
                $brutoTotaalprijs += $brutoPrijsPerStuk * $aantal;

                //Berekent Btw prijs totaal per artikel
                $BtwTotaalPrijs += $BtwPrijsPerStuk * $aantal;

                $totaalPrijs += ($aantal * $afgerondePrijs);

            }
            $aantalProducten += ($aantal);

        }
}
//Rondt de totaalprijs af op 2 decimalen
$totaalPrijs = number_format($totaalPrijs, 2);

$brutoTotaalprijs = number_format($brutoTotaalprijs,2);

$BTW = number_format($BtwTotaalPrijs, 2);


update($cart);
verminderen($cart);
verwijderen($cart);
toevoegen($cart);
?>
    </div>
<div class="bestelling">
    <h1>Bestelling</h1>
    <div class="totaalPrijs">
        <h3>Totaalprijs:</h3>
        <!--Hier wordt de prijs getoond van alles, Brutoproducten + Btw + verzendkosten-->
        <h4>€<?php print($totaalPrijs) ?></h4>
    </div>
    <hr>

    <!--Hier wordt de brutprijs getoond van alle artikelen-->
    <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;">
        <h6>Brutoprijs:</h6>
        <h6 style="margin-left: auto;"><?php print("€". $brutoTotaalprijs)?></h6>
    </div>

    <!--Hier wordt de btw prijs getoond van alle artikelen-->
    <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;">
        <h6>BTW:</h6>
        <h6 style="margin-left: auto;"><?php print("€". $BTW) ?></h6>
    </div>

    <!--Hier wordt de Verzondkosten van de bestelling getoond-->
    <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;">
        <h6>Verzendkosten:</h6>
        <h6 style="margin-left: auto;"><?php print("€" . 0.00) ?></h6>
    </div>

    <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;">
        <h6>Punten:</h6>
        <h6 style="margin-left: auto;"><?php print("€-" . 0.00) ?></h6>
    </div>

    <!--Deze knop lijdt naar de betaalpagina-->
    <div class="betalen">
        <form action="afrekenen.php" method="post">
            <?php if ($aantalProducten > 0): ?>
                <button type="submit" id="AfrekenenKnop">Naar de kassa</button>
            <?php else: ?>
                <button type="button" id="AfrekenenKnop" disabled>Naar de kassa</button>
            <?php endif; ?>
        </form>
    </div>
</div>
</div>

</body>
</html>