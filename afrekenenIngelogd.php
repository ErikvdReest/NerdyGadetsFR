<?php
//Hier wordt de basis css van de webshop verkregen
include __DIR__ . "/header.php";

//Hier worden de functies van het winkelwagen verkregen voor het berekenen van prijzen
include "cartfuncties.php";

//Hier worden de functies voor het aanpassen van de aantallen verkregen
include "betalenFuncties.php";

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

        .titel {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 1010px;
            border-radius: 20px;
            margin: 0 auto;
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
        .bestellingIngelogd h1 {
            text-align: center;
        }

        .bestellingIngelogd hr {
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
            flex: 2;
            width: 80%;
            margin-left: 10px;
            padding: 10px;
        }

        .gegevens h1 {
            text-align: center;
        }

        .gegevensIngelogd {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            margin-top: 10px;
            flex: 3;
            max-width: 70%;
            padding: 10px;
            width: 500px;
        }
        .gegevensIngelogd input{
            text-align: center;
        }
        .gegevensIngelogd h1 {
            text-align: center;
            margin-left: 70px;
            margin-bottom: 40px;
        }

        .bestellingIngelogd {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            margin-top: 10px;
            text-align: left;
            flex: 1;
            width: 500px;
            margin-right: 10px;
            margin-left: 10px;
            padding: 10px;
            max-width: 100%;
        }
        .gegevensIngelogd h1{
            text-align: center;
        }

        button.fas.fa-id-card {
            background-color: rgba(105,105,105,0.5);
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 100%;
        }

        button.fas.fa-id-card:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .grid-container .fa-shopping-cart {
            background-color: rgba(105,105,105,0.5);
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
            margin-top: 10px;
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
            background-color: rgba(105,105,105,0.5);
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 50%;
            margin-top: 10px;
        }

        .fa-credit-card-alt:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }
        .grid-container .fa-credit-card-alt {
            display:inline-block;
        }
        .betalen {
            width: fit-content;
            width: 100%;
            margin-top: 15px;
            border-radius: 30px;
        }

        .betalen button {
            width: 100%;
        }

        .Naw input[type="text"] {
            border-radius: 20px;
            width: 100%;
        }
        .container-flex {
            display: flex;
            justify-content: space-between;
            margin-top: 10px; /* Add margin if needed */
        }
        ..toggle-container {
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

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .inlogPunten {
            border: 1px solid lightslategray;
            background-color: transparent;
            border-radius: 20px;
            padding: 10px;
            color: white;
            width: 120%;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .puntenBorder {
            border: 1px solid white;
            border-radius: 20px;
            margin-top: 20px;
            padding: 10px;
            width: 450px;
            margin-bottom: 20px;
        }
        .knopInlogPunten {
            width: 120%;
        }
        .rechts {
            margin-top: -20px;
        }
        .puntenContainer {
            display: none;
        }
        .toggle-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;

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
        .toevoegenPunten input {
            border: 1px solid lightslategray;
            background-color: transparent;
            border-radius: 20px;
            padding: 10px;
            color: white;
            width: 100%;
            text-align: right;
        }
         .punten button{
             background-color: rgba(105,105,105,0.5);
            border: 1px solid lightslategray;
            border-radius: 20px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            width: 100%;
            margin-top: 10px;
        }
        .punten button:hover {
            background-color: rgba(0, 0, 255, 0.8);
        }

        .toggle-container button{
            background-color: rgba(105,105,105,0.5);
            border: 1px SOLID white;
            border-radius: 30px;
            color: red;
            margin-left: 50px;
        }
        .titel2 {
            border: 1px SOLID white;
            border-radius: 30px;
        }
        .titel3 h1 {
             border: 1px solid white;
             border-radius: 30px;
             width: 400px;
             margin: 0 auto;
             text-align: center;
             padding: 10px;
         }

    </style>
</head>
<body>
<div class="titel">
    <h1>Afrekenen</h1>
</div>

<div class="grid-container">
    <?php
    $totaalPrijs = 0;
    $aantalProducten = 0;
    $afgerondePrijs = 0;
    $brutoTotaalprijs = 0;
    $BTW = 0;
    $puntenAantal = 0;

    //Haalt de producten uit het winkelwagen op.
    $cart = getCart();

    //Maakt verbinding met de database
    $connection = connectToDatabase();

    //Zet standaard waarde op 0 om mee te rekenen
    $totaalPrijs = 0;
    $brutoprijs = 0;

    //Voor ieder product in het winkelwagen wordt deze foreach uitgevoerd
    foreach ($cart as $Artikelnummer => $aantal) {

        //Haalt de gegevens van het product op
        $productDetails = getStockItem($Artikelnummer, $connection);

        // Rond de prijs op twee decimalen af
        //$productDetails['SellPrice'] haalt de prijs van het product op uit de database
        $afgerondePrijs = number_format($productDetails['SellPrice'], 2);

        $totaalPrijs += ($aantal * $afgerondePrijs);

        $puntenAantal += (($aantal * $afgerondePrijs) * 0.79) * 0.05;
    }
    $brutoTotaalprijs = $totaalPrijs * 0.79;

    $BTW = $totaalPrijs - $brutoTotaalprijs;

    $brutoTotaalprijs = number_format($brutoTotaalprijs,2);

    $BTW = number_format($BTW, 2);

    ?>

    <?php
    if (isset($_SESSION['userData'])) {
        $userData = $_SESSION['userData'];
        ?>
    <div class="container-flex">
        <div class="gegevensIngelogd">
            <div class="titel3">
                <h1>Klant-Gegevens</h1>
            </div>
            <div id="boxNAW">
                <form id="NAW-Gegevens" method="post">
                    <table class="Naw Table">
                        <tr>
                            <th><label for="FullName">Volledige Naam: </label></th>
                            <td><input type="text" name="FullName" id="FullName" value="<?php echo isset($userData['FullName']) ? $userData['FullName'] : ''; ?>" required></td>
                        </tr>
                        <tr>
                            <th><label for="Emailadres">E-mailadres</label></th>
                            <td><input type="text" name="Email" id="Email" value="<?php echo isset($userData['EmailAddress']) ? $userData['EmailAddress'] : ''; ?>" required></td>
                        </tr>

                        <tr>
                            <th><label for="PhoneNumber">Telefoonnummer</label></th>
                            <td><input type="text" name="PhoneNumber" id="PhoneNumber" value="<?php echo isset($userData['PhoneNumber']) ? $userData['PhoneNumber'] : ''; ?>" required></td>
                        </tr>

                        <tr>
                            <th><label for="PostalAdressLine2">Stad: </label></th>
                            <td><input type="text" name="PostalAdressLine2" id="PostalAdressLine2" value="<?php echo isset($userData['PostalAddressLine2']) ? $userData['PostalAddressLine2'] : ''; ?>" required></td>
                        </tr>

                        <tr>
                            <th><label for="DeliveryAdressLine21">Straat en Huisnummer: </label></th>
                            <td><input type="text" name="yu_DeliveryAdressLine2" id="DeliveryAdressLine21" value="<?php echo isset($userData['DeliveryAddressLine2']) ? $userData['DeliveryAddressLine2'] : ''; ?>" required></td>


                        </tr>
                        <th><label for="PostalPostalCode">Postcode: </label></th>
                        <td><input type="text" name="PostalPostalCode" id="PostalPostalCode" value="<?php echo isset($userData['DeliveryPostalCode']) ? $userData['DeliveryPostalCode'] : ''; ?>" required></td>
                        </tr>

                        <tr>
                        <th><label for="Country">Land: </label></th>
                        <td><input type="text" name="land" id="land" value="<?php echo isset($userData['DeliveryLocation']) ? $userData['DeliveryLocation'] : ''; ?>" required></td>

                        </tr>
                        </tbody>

                    </table>

                </form>

            </div>
        </div>
    <div class="bestellingIngelogd">
        <div class="titel2">
            <h1>Bestelling</h1>
        </div>
        <hr style="margin-top: 10px">
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

        <?php
        $emailadres = isset($userData['EmailAddress']) ? $userData['EmailAddress'] : '';
        $puntenAantal = number_format($puntenAantal,0);
        $punten = maxPunten($connection,$emailadres);

        // Display the discount and calculate the final total price
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['puntenGebruiken'])) {
            $puntenGebruik = $_POST['puntenGebruiken'];
            $puntenGebruik = number_format($puntenGebruik, 0);

            // Ensure $puntenGebruik is not higher than $totaalPrijs
            if ($puntenGebruik > $totaalPrijs) {
                $puntenGebruik = $totaalPrijs;
            }


            $korting = $puntenGebruik;
            function removeCommasFromNumber($number) {
                return str_replace(',', '', $number);
            }
            $korting = removeCommasFromNumber($korting);
            $puntenGebruik = removeCommasFromNumber($puntenGebruik);
            $puntenGebruik = floor($puntenGebruik);
            $korting = floor($korting);

            $totaalPrijs -= $korting;
            $korting = number_format($korting,2);
            $totaalPrijs = number_format($totaalPrijs,2)

            ?>
            <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;" id="prijzenContainer">
                <h6>Korting:</h6>
                <h6 style="margin-left: auto" id="korting"><?php print("-€" . $korting) ?></h6>
            </div>

            <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;" id="prijzenContainer">
                <h6>Punten:</h6>
                <h6 style="margin-left: auto" type =  id="puntenAantal"><?php print("-" . $puntenGebruik) ?> <i class="fas fa-solid fa-coins"></i></h6>
            </div>
        <?php }    elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel'])) {  ?>
            <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;" id="prijzenContainer">
                <h6>Punten:</h6>
                <h6 style="margin-left: auto" id="puntenAantal"><?php print($puntenAantal) ?> <i class="fas fa-solid fa-coins"></i></h6>
            </div>

    <?php } else {   ?>
            <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;" id="prijzenContainer">
                <h6>Punten:</h6>
                <h6 style="margin-left: auto" id="puntenAantal"><?php print($puntenAantal) ?> <i class="fas fa-solid fa-coins"></i></h6>
            </div>
       <?php }?>
        <hr>
        <div class="totaalPrijs">
            <h3>Totaalprijs:</h3>

            <!--Hier wordt de prijs getoond van alles, Brutoproducten + Btw + verzendkosten-->
            <h4>€<?php print($totaalPrijs) ?></h4>
        </div>
        <hr style="margin-bottom: 20px">

        <div class="annuleren" id="annulerenContainer">
            <form method="post">
                <button name="cancel">
                    Geen Punten gebruiken <i class="fa fa-times-circle"></i>
                </button>
            </form>
        </div>

        <style>
            .annuleren button{
                border-radius: 10px;
                border: 1px SOLID white;
                padding: 10px;
                background-color: rgba(105,105,105,0.5);
                color: white;
                align-items: center;
                width: 100%;
                margin-bottom: 10px;
            }
            .fa-times-circle {
                color: red;
            }
            .annuleren button:hover{
                background-color: rgba(255,255,255,0.5);
            }
        </style>

        <div class="puntenBorder">
            <div class="punten">
                <div class="links">
                        <div class="inlogPunten">
                            <h6>U heeft:</h6><h6><?php print $punten['punten']  ?> punten</h6>
                        </div>
                    <form action="profile.php">
                        <div class="knopInlogPunten">
                            <button
                                    type="submit" name="puntenGebruiken" class="fas fa-user" id="puntenKnop"> Naar Account
                            </button>
                        </div>
                    </form>
                </div>

                <form method="post">
                    <div class="toevoegenPunten">
                        <input type="number" name="puntenGebruiken" placeholder="aantal punten:                     " min="1" max="<?php print $punten['punten'] ?>" required>
                        <div class="knopPunten">
                            <button type="submit" name="puntenGebruikenSubmit" class="fas fa-coins" id="puntenKnop"> Punten gebruiken </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="betalen">
            <form action="iDealdemopaginaIngelogd.php">
                <button style="margin-top: 40px type="submit" name="afrekenen" class="fa fa-credit-card-alt" id="AfrekenenKnop"> Ideal</button>
            </form>
        </div>
        <?php
        $puntenUsed = false;


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['puntenGebruikenSubmit'])) {
            $puntenGebruik = $_POST['puntenGebruiken'];
            $puntenUsed = true;

            // Store puntenUsed in the session
            $_SESSION['puntenUsed'] = true;
            $_SESSION['puntenGebruik'] = $puntenGebruik;
            }
        ?>

            </div>
        </div>


    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['puntenGebruiken'])) {
            $puntenGebruik = $_POST['puntenGebruiken'];
        }
    }
    ?>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var successMessage = document.getElementById("successMessage");
            if (successMessage) {
                setTimeout(function () {
                    successMessage.style.display = "none";
                }, 20000);
            }
        });
    </script>


</div>
</div>

    <?php }
        ?>

</body>
</html>

