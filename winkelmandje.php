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
            border-radius: 10px;
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
            border-radius: 30px;
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
            justify-content: flex-end;
            align-items: center;
            margin-top: 10px;
            width: 100%;
        }
        .betalen form {
            display: flex;
            width: 100%;
        }
        .betalen button {
            width: 100%;

        }
        .punten {
            width: fit-content;
            width: 100%;
            margin-top: 5px;
        }
        .punten {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .punten button{
            background-color: transparent;
            border: 1px solid lightslategray;
            border-radius: 20px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 100%;
            margin-top: 10px;
        }
        .punten button:hover {
            background-color: rgba(255, 165, 0, 0.8);
        }
        .toevoegenPunten input {
            border: 1px solid lightslategray;
            background-color: transparent;
            border-radius: 20px;
            padding: 10px;
            color: white;
            width: 100%;
            text-align: right;
        }
        .puntenBorder {
            border: 1px solid white;
            border-radius: 20px;
            margin-top: 20px;
            padding: 10px;
            width: 400px;
        }
        .rechts {
            margin-right: 10px;
            margin-bottom: 16px;
        }
        .puntenContainer {
            display: none;
        }
        .toggle-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;

        }
        .toggle-container span {
            margin-left: 10px;
            font-size: 18px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 70px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
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
$puntenAantal = 0;

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
                if ($aantal > 1) {
                    print("<p>Totaalprijs: €" . totaalPrijsPerProduct($aantal, $afgerondePrijs) . ' Per stuk: €' . $afgerondePrijs . "</p>");
                } elseif ($aantal == 1){
                    print("<p>Totaalprijs: €" . totaalPrijsPerProduct($aantal, $afgerondePrijs) . "</p>");
                }
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

                $totaalPrijs += ($aantal * $afgerondePrijs);

                $puntenAantal += ($aantal * $afgerondePrijs);

            }
            $aantalProducten += ($aantal);

        }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_aantal'])) {
    $updateItemID = $_POST["update_aantal"];
    $newAantal = max(1, min($_POST['aantal'][$updateItemID], $productDetails['QuantityOnHand']));

    if (array_key_exists($updateItemID, $cart)) {
        $cart[$updateItemID] = (int)$newAantal;
        updateCart($cart);
    }
}
$brutoTotaalprijs = $totaalPrijs * 0.79;

$BTW = $totaalPrijs - $brutoTotaalprijs;

//Rondt de totaalprijs af op 2 decimalen
$totaalPrijs = number_format($totaalPrijs, 2);

$brutoTotaalprijs = number_format($brutoTotaalprijs,2);

$BTW = number_format($BTW, 2);

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

    <?php
    $puntenAantal = number_format($puntenAantal,0)

    ?>

    <!--    --><?php //
    //    if ($ingelogd == TRUE){
    //    ?>

    <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;">
        <h6>Punten:</h6>
        <h6 style="margin-left: auto"><?php print($puntenAantal)?> <i class="fas fa-solid fa-coins"></i></h6>
    </div>

    <hr style="margin-bottom: 20px">

    <div class="toggle-container">
        <label class="switch">
            <input type="checkbox" id="toggleSwitch">
            <span class="slider round"></span>
        </label>
        <span>Punten gebruiken <i class="fas fa-solid fa-coins"></i></span>
    </div>

    <div class="puntenContainer" id="puntenContainer">
        <div class="puntenBorder">
            <div class="punten">
                <div class="rechts">
                    <form method="post">
                        <div class="toevoegenPunten">
                            <input type="number" name="aantal" placeholder="Gespaarde Punten:                          " min="1" max="<?php  ?>" required>
                        </div>
                        <div class="knopPunten">
                            <button
                                    type="submit" name="puntenGebruiken" class="fas fa-user" id="puntenKnop"> Inloggen
                            </button>
                        </div>
                    </form>
                </div>

                <form method="post">
                    <div class="toevoegenPunten">
                        <input type="number" name="aantal" placeholder="aantal punten:         " min="1" max="<?php  ?>" required>
                    </div>
                    <div class="knopPunten">
                        <button
                                type="submit" name="puntenGebruiken" class="fas fa-coins" id="puntenKnop"> Punten gebruiken
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById("toggleSwitch").addEventListener("change", function () {
            var puntenContainer = document.getElementById("puntenContainer");
            puntenContainer.style.display = this.checked ? "block" : "none";
        });
    </script>

<!--    --><?php //} ?>

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
