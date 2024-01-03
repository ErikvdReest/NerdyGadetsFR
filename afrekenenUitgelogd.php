<?php
//Hier wordt de basis css van de webshop verkregen
include __DIR__ . "/header.php";

//Hier worden de functies van het winkelwagen verkregen voor het berekenen van prijzen
include "cartfuncties.php";

//Hier worden de functies voor het aanpassen van de aantallen verkregen
include "betalenFuncties.php";

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
            justify-content: center;
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
            width: 51%;
            border-radius: 20px;
            margin: auto;
        }
        .titel2 {
            text-align: center;
            border: 1px solid #FFFFFF;
            width: 100%;
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .titel3 {
            text-align: center;
            border: 1px solid #FFFFFF;
            width: 100%;
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 10px;
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
            max-width: 20%;
            margin-right: 10px;
            margin-left: 10px;
            padding: 15px;
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
            max-width: 30%;
            margin-left: 10px;
            padding: 15px;
            width: 400px;
        }

        .gegevens h1 {
            text-align: center;
        }

        button.fas.fa-id-card {
            background-color: rgba(105, 105, 105, 0.5);
            border: 1px solid #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            font-size: 18px;
            color: #FFFFFF;
            max-width: 100%;
            width: 600px;
            margin-top: -40px;
            align-items: center;
        }

        button.fas.fa-id-card:hover {
            background-color: rgba(255, 255, 255, 0.5);
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
            background-color: rgba(105, 105, 105, 0.5);
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
            margin-top: 5px;
        }

        .betalen button {
            width: 100%;
        }

        .center {
            display: flex;
            justify-content: center;
        }
        .Naw input[type="text"] {
            border-radius: 20px;
            width: 100%;
            text-align: center;
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

        $puntenAantal += ($aantal * $afgerondePrijs) * 0.05;
    }
    $brutoTotaalprijs = $totaalPrijs * 0.79;

    $BTW = $totaalPrijs - $brutoTotaalprijs;

    //Rondt de totaalprijs af op 2 decimalen

    $brutoTotaalprijs = number_format($brutoTotaalprijs,2);

    $BTW = number_format($BTW, 2);

    ?>


    <div class="gegevens">
        <div class="titel2">
            <h1>Klant-Gegevens</h1>
        </div>
        <div id="boxNAW">
            <form id="NAW-Gegevens" method="post">
                <div class='center'>

                    <!--            In deze tabel worden klantgegevens opgeslagen-->
                    <!--            De gegevens worden opgeslagen als er een post plaats vindt-->
                    <!--            De bezoeker krijgt een pop-up als de gegevens zijn opgeslagen-->
                    <!--            De klant kan zijn gegevens aanpassen indien nodig-->
                    <table class="Naw Table">
                        <tr>
                            <th><label for="FirstName">Volledige Naam</label></th>
                            <td><input type="text" name="Fullname" id="Fullname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Voer alleen letters in" required></td>
                        </tr>

                        <tr>
                            <th><label for="Emailadres">E-mailadres</label></th>
                            <td><input type="text" name="Email" id="Email" required></td>
                        </tr>

                        <tr>
                            <th><label for="PhoneNumber">Telefoonnummer</label></th>
                            <td><input type="text" name="PhoneNumber" id="PhoneNumber" pattern="[0-9]+" title="Voer alleen cijfers in" required></td>
                        </tr>

                        <tr>
                            <th><label for="PostalAdressLine2">Stad</label></th>
                            <td><input type="text" name="PostalAdressLine2" id="PostalAdressLine2" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Voer alleen letters in" required></td>
                        </tr>

                        <tr>
                            <th><label for="DeliveryAdressLine21">Adres</label></th>
                            <td><input type="text" name="yu_DeliveryAdressLine2" id="DeliveryAdressLine21" required</td>
                        </tr>

                        <th><label for="PostalPostalCode">Postcode</label></th>
                        <td><input type="text" name="PostalPostalCode" id="PostalPostalCode" required></td>
                        </tr>

                        <tr>
                        <th><label for="Country">Land</label></th>
                        <td><input type="text" name="land" id="land" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Voer alleen letters in" required></td>
                        </tr>

                        <tr>
                        <th></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <form class="post">
                    <button name="opslaan" type="submit" value="Submit" class="fas fa-id-card"> Opslaan</button>
                </form>
            </form>
        </div>

        <?php
        //Contreleert of er een post plaats vindt bij Opslaan
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //In deze variabele wordt de straatnaam opgeslagen
            $DeliveryAdressLine2 = $_POST["yu_DeliveryAdressLine2"];

            //In deze variabele wordt het postcode opgeslagen
            $PostalCode = $_POST["PostalPostalCode"];

            //In deze variabele wordt het land opgeslagen
            $Country = $_POST["land"];

            //In deze variabele wordt de voornaam opgeslagen met hoofdletters
            $Fullname = ucfirst($_POST["FirstName"]);

            //In deze variabele wordt het telefoonnummer opgeslagen
            $PhoneNumber = $_POST["PhoneNumber"];

            //In deze variabele wordt het Email-adrs opgeslagen
            $EmailAdress = $_POST["Email"];

            //In deze query wordt de Volledige naam, adres en Emailadres opgeslagen in de database
            addCustomer($Fullname, $DeliveryAdressLine2, $EmailAdress,$connection);
        }
        ?>
    </div>

    <div class="bestelling">
    <div class="titel3">
        <h1>Bestelling</h1>
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

        <?php
        $puntenAantal = number_format($puntenAantal,0);
        $totaalPrijs = number_format($totaalPrijs,2)
        ?>
        <div class="Prijzen" style="display: flex; justify-content: space-between; text-align: left;">
            <h6>Punten:</h6>
            <h6 style="margin-left: auto"><?php print($puntenAantal)?> <i class="fas fa-solid fa-coins"></i></h6>
        </div>

        <hr>
        <div class="totaalPrijs">
            <h3>Totaalprijs:</h3>

            <!--Hier wordt de prijs getoond van alles, Brutoproducten + Btw + verzendkosten-->
            <h4>€<?php print($totaalPrijs) ?></h4>
        </div>

        <hr>

        <!--Deze knop lijdt naar de betaalpagina-->
        <div class="betalen">
            <form action="iDealdemopaginaUitgelogd.php">
                <button style="margin-top: 40px type="submit" name="afrekenen" class="fa fa-credit-card-alt" id="AfrekenenKnop"> Ideal</button>
            </form>
        </div>


            <div class="knoppen">
                <form action="registratie.php">
                    <button>
                        <i class="fa fa-user"> Inloggen</i>
                    </button>
                </form>
            </div>
    </div>

    <style>
        .knoppen button {
            border-radius: 10px;
            background-color: rgba(105,105,105,0.5);
            border: 1px SOLID #FFFFFF;
            padding: 10px;
            margin-top: 20px;
            max-width: 100%;
            width: 500px;
            color: #FFFFFF;
        }
        .knoppen button:hover{
            background-color: rgba(255,255,255,0.5);
        }
    </style>

</body>
</html>




