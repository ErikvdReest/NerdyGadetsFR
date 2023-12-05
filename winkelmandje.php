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
         h1 {
             text-align: center;
             border: 1px solid #FFFFFF;
             padding: 10px;
             width: 100%;
             border-radius: 20px;
         }

        .product {
            display: inline-block;
            margin-top: 5px;
            width: 55%;
            padding: 15px;
            border: 1px solid #FFFFFF;
            margin-left: 20px;
            border-radius: 20px;

        }
        .aantal {
            display: inline-block;
            width: 20%;
            border: 1px solid #FFFFFF;
            padding: 20px;
            text-align: left;
            background-color: transparent;
            border-radius: 20px;

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

        .product {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-info {
            flex: 1;
        }

        .transparent {
            background: none;
            border: none;
            color: #FFFFFF;
        }

        .prijs {
            text-align: right;
            margin-right: 300px;
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
             margin-left: 10px;
             background-color: transparent;
             border: none;
             padding: 0;
             font-size: 16px;
             color: #FFFFFF;
             cursor: pointer;
         }

         .transparent-button-plus:hover {
             color: #00FF00; /* Groene kleur bij hover alleen voor plusknop */
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
             color: #FF0000; /* Rode kleur bij hover voor verwijderknop */
         }


    </style>
</head>
<body>
<h1>Winkelmandje</h1>


<?php
$cart = getCart();
$connection = connectToDatabase();
$totaalPrijs = 0;
$aantalProducten = 0;
$afgerondePrijs = 0;

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
                print("<p>" . $productDetails['QuantityOnHand'] . "</p>");

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
//                print("<button type='submit' name='favorieten' value='$Artikelnummer' style='color: #FFFFFF; background: transparent; border: none;' class='fas fa-heart'></button>");
                print("</div>");
                print("</form>");
                print("</div>");
                print("</div>");
            }
            $aantalProducten += ($aantal);
            $totaalPrijs += ($aantal * $afgerondePrijs);
        }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_aantal'])) {
    $updateItemID = $_POST["update_aantal"];
    $newAantal = max(1, $_POST['aantal'][$updateItemID]);

    if (array_key_exists($updateItemID, $cart)) {
        $cart[$updateItemID] = (int)$newAantal;
        updateCart($cart);
        }
}
//Als er post plaatsvindt bij de prullenbak knop wordt het product uit de array verwijdert.
if (isset($_POST["verwijderen"])) {
    $verwijderItemID = $_POST["verwijderen"];

    if (array_key_exists($verwijderItemID, $cart)) {
        unset($cart[$verwijderItemID]);
        updateCart($cart);
    }
}
//Als er post plaatsvindt bij de min knop neemt de aantal met 1 af.
//Op het moment dat het aantal 1 is en er post plaatsvindt wordt het product uit de array verwijdert.
if (isset($_POST["verminderen"])) {
    $verminderenItemID = $_POST["verminderen"];

    if (array_key_exists($verminderenItemID, $cart)) {
        $cart[$verminderenItemID] -= 1;
        if ($cart[$verminderenItemID] <= 0) {
            unset($cart[$verminderenItemID]);
        }
        updateCart($cart);
    }
}
//Als er post plaatsvindt bij de plus knop neemt het aantal met 1 toe
if (isset($_POST["toevoegen"])) {
    $toevoegenItemID = $_POST["toevoegen"];

    if (array_key_exists($toevoegenItemID, $cart)) {
        $cart[$toevoegenItemID] += 1;
    } else {
        $cart[$toevoegenItemID] = 1;
    }
    updateCart($cart);
}
//Als er post plaatsvindt bij de heart knop wordt het product toegevoegd aan favorieten.
if (isset($_POST["favorieten"])) {
    $favorietenItemID = $_POST["favorieten"];

}

?>

<div class="prijs">
    <div class="box">
        <h6>Subtotaal:</h6>
        <h1><?php $totaalPrijs = number_format($totaalPrijs, 2);   ?></h1>
        <h9><?php print("€".$totaalPrijs) ?></h9>
        <hr>
        <h7>Artikelen:</h7>

        <h10> <?php print($aantalProducten) ?></h10>
        <h8>Totaalprijs</h8>
        <div class="NaarKassa"></div>
        <form action="afrekenen.php" method="post">
            <button type="submit" id="AfrekenenKnop">Naar de kassa</button>
        </form>
    </div>
</div>

</body>
</html>
