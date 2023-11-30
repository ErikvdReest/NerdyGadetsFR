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
            margin-left: 10px;
            width: 120%;
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
            width: 100%;
            margin-left: 110px;
        }
        .betalen {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            text-align: center;
            margin-top: 10px;
            width: 77.5%;
            margin-left: auto;
            margin-right: 5px;
        }

        .fa-shopping-cart {
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
        .IdealKnop {
            color: #FFFFFF;
            background-color: transparent;
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
                    <th>Product Prijs</th>
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
                    $voorraad = $productDetails['QuantityOnHand'];
                    if ($productDetails) {
                        print("<td>" . $productDetails['StockItemName'] . "</td>");
                        print("<td>" . $aantal . "</td>");
                        print("<td>". $afgerondePrijs . "</td>");
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
        <div id="boxNAW">
            <form id="NAW-Gegevens" method="post">
                <table class="Naw Table">
                    <tbody>
                    <tr>
                        <th><label for="FirstName">Voornaam</label></th>
                        <td><input type="text" name="FirstName" id="FirstName" required></td>
                    </tr>
                    <tr>
                        <th><label for="LastName">Achternaam</label></th>
                        <td><input type="text" name="LastName" id="LastName" required></td>
                    </tr>
                    <tr>

                        <th><label for="PostalPostalCode">Postcode</label></th>
                        <td><input type="text" name="PostalPostalCode" id="PostalPostalCode" required></td>
                    </tr>
                    <tr>
                        <th><label for="PostalAdressLine2">Stad</label></th>
                        <td><input type="text" name="PostalAdressLine2" id="PostalAdressLine2" required></td>
                    </tr>
                    <tr>
                        <th><label for="DeliveryAdressLine21">Straatnaam</label></th>
                        <td><input type="text" name="yu_DeliveryAdressLine2" id="DeliveryAdressLine21" required></td>
                    </tr>
                    <tr>

                        <th><label for="DeliveryAdressLine22">Huisnummer</label></th>
                        <td><input type="text" name="xu_DeliveryAdressLine2" id="DeliveryAdressLine22" required></td>
                    </tr>
                    <tr>

                        <th><label for="PhoneNumber">Telefoonnummer</label></th>
                        <td><input type="text" name="PhoneNumber" id="PhoneNumber" required></td>
                    </tr>
                    <tr>
                        <th><label for="Country">Land</label></th>
                        <td>
                            <select id="Country" id="Country" required>
                                <?php
                                $sql = "SELECT CountryName FROM Countries";
                                $result = $databaseConnection->query($sql);

                                // Generate options dynamically
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
                                }

                                // Close connection
                                $databaseConnection->close()
                                ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><button type="submit" value="Submit">Check</button></td>
                    </tr>
                    </tbody>
                </table>



            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve values from the form
            $DeliveryStreet = $_POST["yu_DeliveryAdressLine2"];
            $DeliveryNumber = $_POST["xu_DeliveryAdressLine2"];

            $FirstName = $_POST["FirstName"];
            $Lastname = $_POST["LastName"];

            // Combine the values into a single string
            $DeliveryAdressLine = $DeliveryStreet . ' ' . $DeliveryNumber;
            $CustomerName = $FirstName. " ". $Lastname;}


      ?>

    </div>

    <div class="betalen">
        <h1>Betalen</h1>
        <div class="totaalPrijs">
            <h5>Totaalprijs: €<?php print($totaalPrijs) ?></h5>
            <h8>Inclusief Btw

                <div class="naarIDealpagina">
                    <form method="post" action="iDealdemopagina.php">
                        <button type="submit" name="afrekenen" class="IdealKnop" id="AfrekenenKnop">Ideal</button>
                    </form>
        </div>
</body>
</html>


