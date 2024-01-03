<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";
include "addPeople.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            width: 86%;
        }

        .bestaandInloggen,
        .boxInloggen_nieuweklant {
            border: 1px solid white;
            border-radius: 30px;
            padding: 20px;
            margin-top: 10px;
            width: 86%;
        }
        .boxInloggen_nieuweklant {
            margin-left: 10px;
            flex 1;
            width: 1200px;
            max-width: 402%;
        }
        .bestaandInloggen {
            flex 1;
            width: 200%;
        }

        h2 {
            margin-top: 0;
            border: 1px solid white;
            border-radius: 20px;
            text-align: center;
            padding: 20px;

        }
        .boxInloggen_nieuweklant input {
            border-radius: 30px;
            background-color: transparent;
            border: 1px SOLID white;
            color: #FFFFFF;
            width: 200px;
        }
        .bestaandInloggen input{
            border-radius: 30px;
            background-color: transparent;
            border: 1px SOLID white;
            color: #FFFFFF;
            width: 200px;
        }

        button {
            border: 1px SOLID white;
            padding: 10px;
            border-radius: 20px;
            background-color: transparent;
            color: #FFFFFF;
            width: 200px;
        }
        button:hover {
            background-color: rgba(0, 0, 255, 0.8);
        }
        .rand {
           border: 1px SOLID transparent;
            margin-left: -350px;
        }


    </style>
</head>
<body>
<div class="rand">
    <div class="box box2forms">
        <div class="boxInloggen_account">
            <div class="container">
            <div class="bestaandInloggen" id="loginform-parent">
                <h2>Inloggen</h2>
                Vul uw e-mail adres en wachtwoord in om in te loggen.<br><br>
                <form id="loginform" method="post" action="">
                    <table class="adresgegevens">
                        <tbody><tr>
                            <th><label for="InputEmail">E-mailadres</label></th>
                            <td><input type="email" id="InputEmail" name="InputEmail" value="" autocomplete="email"></td>
                        </tr>
                        <tr>
                            <th><label for="InputPassword">Wachtwoord</label></th>
                            <td><input type="password" id="InputPassword" name="InputPassword" autocomplete="current-password"></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><button name="loginButton" type="submit">Inloggen <i class="fas fa-user"></i></button></td>
                        </tr>
                        </tbody></table>
                </form>
            </div>

            <div class="boxInloggen_nieuweklant">
                <form id="nieuweKlantForm" method="post" action="" autocomplete="off" novalidate="novalidate">
                    <h2>Nieuwe klant</h2>
                    Vul hieronder uw gegevens in om een account aan te maken.<br><br>
                    <table class="adresgegevens">
                        <tbody>
                        <tr>
                            <th>E-mailadres</th>
                            <td><input type="text" name="Email" id="Email" class="" value="" autocomplete="off"></td>

                            <th><label for="password">Wachtwoord</label></th>
                            <td><input type="password" id="password" name="password" autocomplete="current-password"></td>

                            <th><label for="PhoneNumber">Telefoonnummer</label></th>
                            <td><input type="text" name="PhoneNumber" id="PhoneNumber" required></td>
                        </tr>

                        <tr>
                            <th><label for="FirstName">Voornaam</label></th>
                            <td><input type="text" name="FirstName" id="FirstName" required></td>

                            <th><label for="Tussenvoegsel">Tussenvoegsel</label></th>
                            <td><input type="text" name="Tussenvoegsel" id="Tussenvoegsel" ></td>

                            <th><label for="LastName">Achternaam</label></th>
                            <td><input type="text" name="LastName" id="LastName" required></td>
                        </tr>
                        <tr>
                            <th><label for="PostalAdressLine2">Stad</label></th>
                            <td><input type="text" name="PostalAdressLine2" id="PostalAdressLine2" required></td>

                            <th><label for="DeliveryAdressLine21">Straatnaam</label></th>
                            <td><input type="text" name="yu_DeliveryAdressLine2" id="DeliveryAdressLine21" required></td>

                            <th><label for="DeliveryAdressLine22">Huisnummer</label></th>
                            <td><input type="text" name="xu_DeliveryAdressLine2" id="DeliveryAdressLine22" required></td>

                        </tr>
                        <tr>
                            <th><label for="PostalPostalCode">Postcode</label></th>
                            <td><input type="text" name="PostalPostalCode" id="PostalPostalCode" required></td>

                            <th><label for="Country">Land</label></th>
                            <td><input type="text" name="land" id="land" required></td>

                            <th></th>
                            <td><button name="registerButton" type="submit">Aanmelden <i class="fas fa-user"></i></button></td>


                        </tr>
                        </tbody></table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
    authenticateUser($_POST['InputEmail'], $_POST['InputPassword']);
}
//Contreleert of er een post plaats vindt bij Opslaan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerButton'])) {

    //In deze variabele wordt de straatnaam opgeslagen
    $DeliveryStreet = $_POST["yu_DeliveryAdressLine2"];

    //In deze variabele wordt het huisnummer opgeslagen
    $DeliveryNumber = $_POST["xu_DeliveryAdressLine2"];

    //In deze variabele wordt het postcode opgeslagen
    $PostalCode = $_POST["PostalPostalCode"];

    //In deze variabele wordt het land opgeslagen
    $Country = $_POST["land"];

    //In deze variabele wordt de woonplaats opgeslagen
    $PostalAddressLine2 =$_POST["PostalAdressLine2"];

    //In deze variabele wordt de voornaam opgeslagen met hoofdletters
    $FirstName = ucfirst($_POST["FirstName"]);

    //In deze variabele wordt de achternaam opgeslagen met hoofdletters
    $LastName = ucfirst($_POST["LastName"]);

    //In deze variabele wordt de achternaam opgeslagen met hoofdletters
    $Tussenvoegsel = ucfirst($_POST["Tussenvoegsel"]);

    //In deze variabele wordt het telefoonnummer opgeslagen
    $PhoneNumber = $_POST["PhoneNumber"];

    //In deze variabele wordt het Email-adrs opgeslagen
    $EmailAdress = $_POST["Email"];

    $Password = $_POST["password"];
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    //In deze variabele wordt de straatnaam en huisnummer samengevoegd als adres
    $DeliveryAdressLine2 = $DeliveryStreet . ' ' . $DeliveryNumber;

    //Als de bezoeker een tussenvoegsel invult zal deze worden toegevoegd bij de volledige naam
    //Als de bezoeker geen tussenvoegsel invult zal de voor en achternaam samen de volledige naam worden
    if ($Tussenvoegsel == "") {
        $FullName = ($FirstName . " " . $LastName);
    } elseif ($Tussenvoegsel != "") {
        $FullName = ($FirstName . " " . $Tussenvoegsel . " " . $LastName);
    }

    $lastInsertedPeopleID = addPeople($FullName, $FirstName, $PhoneNumber, $hashedPassword, $EmailAdress);
    addNawGegevensRegistratie($FullName,$DeliveryAdressLine2,$PhoneNumber,$PostalCode,$Country,$PostalAddressLine2, $EmailAdress,$lastInsertedPeopleID);
}

$hash = '$2y$10$fCBQa9kDvBFkDhmpKil4mu8RB7v3fb1VHwTbEDWkuWYYZ.KSHC4Ae';


?>


