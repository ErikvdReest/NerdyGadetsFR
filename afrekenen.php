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
            display: flex;
            justify-content: space-around;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .post {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: #fff;
            color: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .close {
            float: right;
            cursor: pointer;
        }
        .titel {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
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

        .bestelling {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            margin-top: 10px;
            text-align: left;
            flex: 1;
            width: 20%;
            margin-right: 10px;
            margin-left: 10px;
            padding: 10px;
        }
        .bestelling h1 {
            text-align: center;
        }

        .bestelling hr {
            border: none;
            border-top: 2px solid white;
            margin: 5px 0;
        }
        .totaalPrijs {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .totaalPrijs h3, .totaalPrijs h4 {
            margin: 0;
        }

        .gegevens {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            margin-top: 10px;
            text-align: left;
            flex: 3;
            width: 80%;
            margin-left: 10px;
            padding: 10px;
        }

        .gegevens h1 {
            text-align: center;
        }

        button.fas.fa-id-card {
            background-color: transparent;
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 60%;
        }

        button.fas.fa-id-card:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .grid-container .fa-shopping-cart {
            background-color: transparent;
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 50%;
            margin-top: 10px;
        }

        .grid-container .fa-shopping-cart:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .Naw input[type="text"],
        .Naw select {
            background-color: transparent;
            border: 1px solid white;
            color: white;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        .Naw button {
            background-color: transparent;
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 60%;
            margin-top: 10px;
        }

        .Naw button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .Prijzen h6 {
            margin-top: 10px;
        }
        .fa-credit-card-alt {
            background-color: transparent;
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 50%;
            margin-top: 10px;
        }

        .fa-credit-card-alt:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .grid-container .fa-credit-card-alt {
            display:inline-block;
        }
        .container {
            display: flex;
            justify-content: space-around;
        }
        .betalen {
            width: fit-content;
            width: 100%;
            margin-top: 10px;
        }

        .betalen button {
            width: 100%;
        }

    </style>
</head>
<body>

<div class="titel">
    <h1>Afrekenen</h1>
</div>

<div class="grid-container">
    <?php
                $cart = getCart();
                $connection = connectToDatabase();
                $totaalPrijs = 0;
                $brutoprijs = 0;

                foreach ($cart as $Artikelnummer => $aantal) {
                    $productDetails = getStockItem($Artikelnummer, $connection);

                    // Rond de prijs op twee decimalen af
                    $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
                    $voorraad = $productDetails['QuantityOnHand'];
                    $totaalPrijs += $aantal * $afgerondePrijs;
                }
                $totaalPrijs = number_format($totaalPrijs, 2);
                ?>


    <div class="gegevens">
        <h1>NAW-Gegevens</h1>
        <div id="boxNAW">
            <form id="NAW-Gegevens" method="post">
                <table class="Naw Table">
                    <tr>
                        <th><label for="FirstName">Voornaam</label></th>
                        <td><input type="text" name="FirstName" id="FirstName" required></td>

                        <th><label for="Tussenvoegsel">Tussenvoegsel</label></th>
                        <td><input type="text" name="Tussenvoegsel" id="Tussenvoegsel" ></td>

                        <th><label for="LastName">Achternaam</label></th>
                        <td><input type="text" name="LastName" id="LastName" required></td>
                    </tr>

                    <tr>
                        <th><label for="Emailadres">Emailadres</label></th>
                        <td><input type="text" name="Email" id="Email" required></td>

                        <th><label for="PhoneNumber">Telefoonnummer</label></th>
                        <td><input type="text" name="PhoneNumber" id="PhoneNumber" required></td>
                    </tr>

                    <tr>
                        <th><label for="PostalAdressLine2">Stad</label></th>
                        <td><input type="text" name="PostalAdressLine2" id="PostalAdressLine2" required></td>

                        <th><label for="DeliveryAdressLine21">Straatnaam</label></th>
                        <td><input type="text" name="yu_DeliveryAdressLine2" id="DeliveryAdressLine21" required></td>

                        <th><label for="DeliveryAdressLine22">Huisnummer</label></th>
                        <td><input type="text" name="xu_DeliveryAdressLine2" id="DeliveryAdressLine22" required></td>


                    </tr>
                        <th><label for="PostalPostalCode">Postcode</label></th>
                        <td><input type="text" name="PostalPostalCode" id="PostalPostalCode" required></td>

                        <th><label for="Country">Land</label></th>
                        <td><input type="text" name="land" id="land" required></td>

                        <th></th>

                        <td>
                            <form class="post">
                            <button name="opslaan" type="submit" value="Submit" class="fas fa-id-card"> Opslaan</button>
                            </form>
                        </td>
                    </tr>
                    </tbody>

                </table>

            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $DeliveryStreet = $_POST["yu_DeliveryAdressLine2"];
            $DeliveryNumber = $_POST["xu_DeliveryAdressLine2"];
            $PostalCode = $_POST["PostalPostalCode"];
            $Country = $_POST["land"];

            $FirstName = ucfirst($_POST["FirstName"]);
            $Lastname = ucfirst($_POST["LastName"]);
            $Tussenvoegsel = ucfirst($_POST["Tussenvoegsel"]);
            $PhoneNumber = $_POST["PhoneNumber"];
            $EmailAdress = $_POST["Email"];


            $DeliveryAdressLine2 = $DeliveryStreet . ' ' . $DeliveryNumber;

            if ($Tussenvoegsel == "") {
                $Fullname = ($FirstName . " " . $Lastname);
            } elseif ($Tussenvoegsel != "") {
                $Fullname = ($FirstName . " " . $Tussenvoegsel . " " . $Lastname);
            }

            addNawGegevens($Fullname, $DeliveryAdressLine2, $EmailAdress);
        }
      ?>
    </div>

    <?php
    ?>

    <div class="bestelling">
        <h1>Bestelling</h1>
        <div class="totaalPrijs">
            <h3>Totaalprijs:</h3>
            <h4>€<?php print($totaalPrijs) ?></h4>
        </div>
        <hr>

        <div class="Prijzen">
            <h6>Brutoprijs</h6>
            <h6><?php  ?></h6>
            <h6>BTW</h6>
            <h6><?php  ?></h6>
            <h6>Verzendkosten</h6>
            <h6><?php  ?></h6>
        </div>

        <div class="betalen">
            <form action="iDealdemopagina.php">
                <button type="submit" name="afrekenen" class="fa fa-credit-card-alt" id="AfrekenenKnop"> Ideal</button>
            </form>
        </div>
    </div>

    <?php
    if(isset($_POST["afrekenen"])) {
        addOrder();
    }

    ?>

<!--<div id="popup" class="popup">-->
<!--    onclick="openPopup()"-->
<!--    <div class="popup-content">-->
<!--        <span class="close" onclick="closePopup()">&times;</span>-->
<!--        <p>Uw gegevens zijn opgeslagen</p>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<script src="scripts.js"></script>-->

</body>
</html>




