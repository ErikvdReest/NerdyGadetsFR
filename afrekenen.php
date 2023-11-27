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
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-gap: 10px;
        }
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }
        .titel {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
        }

        .productenWinkelmandje {
            border: 1px solid #FFFFFF;
            padding: 10px;
            text-align: center;
            border-radius: 20px;
            margin-top: 10px;
        }

        .productenTonen table {
            width: 100%;
            border-collapse: collapse;
        }
        .productenTonen th, .productenTonen td {
            border: 1px solid #FFFFFF;
            padding: 8px;
            text-align: left;
        }

        .gegevens {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            text-align: center;
            margin-top: 10px;
        }
        .betalen {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            text-align: center;
            margin-top: 10px;
        }

        .fa-shopping-cart {
            color: #FFFFFF;
            background-color: transparent;
        }

        .fa-dollar {
            color: #FFFFFF;
            background-color: transparent;
        }

        .WinkelmandjeTerug {
            text-align: center;
            padding: 4px;
            background-color: transparent;
            margin-top: 10px;
        }
        .naarIDealpagina {
            text-align: center;
            padding: 4px;
            background-color: transparent;
            margin-top: auto;
        }
        .totaalPrijs {
            text-align: left;
            margin-top: 20px;
            margin-left: 50px;

        }
    </style>
</head>
<body>

<div class="titel">
    <h1>Afrekenen</h1>
</div>

<div class="grid-container">
    <div class="productenWinkelmandje">
        <h1>Producten</h1>
        <div class="productenTonen">
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Aantal</th>
                    <th>Totaalprijs</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cart = getCart();
                $connection = connectToDatabase();
                $totaalPrijs = 0;

                foreach ($cart as $Artikelnummer => $aantal) {
                    print("<tr>");

                    $productDetails = getStockItem($Artikelnummer, $connection);

                    // Rond de prijs op twee decimalen af
                    $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
                    if ($productDetails) {
                        print("<td>" . $productDetails['StockItemName'] . "</td>");
                        print("<td>" . $aantal . "</td>");
                        print("<td>". totaalPrijsPerProduct($aantal,$afgerondePrijs));
                    }
                    print("</tr>");
                    $totaalPrijs += $aantal * $afgerondePrijs;
                }
                $totaalPrijs = number_format($totaalPrijs, 2);
                ?>
                </tbody>
            </table>
        </div>
        <div class="WinkelmandjeTerug">
            <form action="winkelmandje.php" method="post">
                <button type="submit" class="fas fa-shopping-cart" id="AfrekenenKnop"> Terug Naar Winkelmandje</button>
            </form>
        </div>
    </div>

    <div class="gegevens">
        <h1>NAW-Gegevens</h1>

    </div>

    <div class="betalen">
        <h1>Betalen</h1>
        <div class="totaalPrijs">
            <h5>Totaalprijs: €<?php print($totaalPrijs) ?></h5>
            <h8>Inclusief Btw</h8>

        </div>


        <div class="naarIDealpagina">
            <form action="iDealdemopagina.php" method="post">
                <button type="submit" class="fas fa-dollar" id="AfrekenenKnop">Betalen</button>
            </form>
        </div>

    </div>
</div>

</body>
</html>