<?php
include __DIR__ . "/header.php";

if (isset($_SESSION['userData'])) {
    $userData = $_SESSION['userData'];

} else {
    header("Location: registratie.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .rand {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: transparent;
            margin-bottom: 200px;
            margin-top: -100px;
        }

        .gegevens {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid white;
            border-radius: 40px;
            padding: 40px;
            max-width: 1500px;
            width: 82%;
            margin: auto;
        }

        h1 {
            text-align: center;
            border-radius: 30px;
            border: 1px solid white;
            padding: 10px;
            margin-top: -20px;
            width: 600px;
        }

        .gegevens input {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid white;
            background-color: transparent;
            border-radius: 30px;
            color: white;
            margin-bottom: 10px;
            text-align: center;
            padding: 10px;
        }

        .uitloggen {
            text-align: center;
        }

        hr {
            background-color: blue;
        }
    </style>
</head>
<body>

<div class="rand">
    <div class="gegevens">
        <h1>Klant Gegevens</h1>
        <form id="userInfoForm" action="updateProfile.php" method="post">
            <table class="Naw Table">
                <hr style="margin-top: 20px">
                <tr>
                    <th><label for="FullName">Volledige naam:  </label></th>
                    <td><input type="text" name="FullName" id="FullName" value="<?php echo isset($userData['FullName']) ? $userData['FullName'] : ''; ?>" required></td>

                    <th><label for="E-mailadres">E-mailadres</label></th>
                    <td><input type="text" name="Email" id="Email" value="<?php echo isset($userData['EmailAddress']) ? $userData['EmailAddress'] : ''; ?>" required></td>

                    <th><label for="PhoneNumber">Telefoonnummer</label></th>
                    <td><input type="text" name="PhoneNumber" id="PhoneNumber" value="<?php echo isset($userData['PhoneNumber']) ? $userData['PhoneNumber'] : ''; ?>" required></td>
                </tr>

                <tr>
                    <th><label for="PostalAdressLine2">Stad: </label></th>
                    <td><input type="text" name="PostalAddressLine2" id="PostalAddressLine2" value="<?php echo isset($userData['PostalAddressLine2']) ? $userData['PostalAddressLine2'] : ''; ?>" required></td>

                    <th><label for="DeliveryAdressLine21">Straat en Huisnummer: </label></th>
                    <td><input type="text" name="DeliveryAdressLine2" id="DeliveryAdressLine21" value="<?php echo isset($userData['DeliveryAddressLine2']) ? $userData['DeliveryAddressLine2'] : ''; ?>" required></td>


                </tr>
                <th><label for="PostalPostalCode">Postcode: </label></th>
                <td><input type="text" name="PostalPostalCode" id="PostalPostalCode" value="<?php echo isset($userData['DeliveryPostalCode']) ? $userData['DeliveryPostalCode'] : ''; ?>" required></td>

                <th><label for="Country">Land: </label></th>
                <td><input type="text" name="land" id="land" value="<?php echo isset($userData['DeliveryLocation']) ? $userData['DeliveryLocation'] : ''; ?>" required></td>

                <th></th>

                <td>
                    <form class="post">
                        <div class="opslaan">
                            <button name="opslaan" type="submit" value="Submit" class="fas fa-id-card"> Opslaan</button>
                        </div>
                    </form>
                </td>
                </tr>
                </tbody>

            </table>

        </form>
        </form>

        <hr>

        <div class="button-container">
            <div class="uitloggen">
                <button onclick="logout()">Logout <i class="fas fa-sign-out-alt"></i></button>
            </div>

            <form action="afrekenenIngelogd.php">
                <button>Naar Afrekenen
                     <i class=" fa fa-credit-card-alt"></i>
                </button>
            </form>
        </div>

        <style>
            .button-container {
                display: flex;
                justify-content: center;
                align-items: center;
            }

             button {
                border: 1px solid white;
                background-color: rgba(105, 105, 105, 0.5);
                cursor: pointer;
                display: flex;
                align-items: center;
                color: #FFFFFF;
                justify-content: center;
                margin-right: 10px;
                text-align: center;
                padding: 10px;
                border-radius: 20px;
                width: 220px;

            }
            button:hover{
                background-color: rgba(0, 0, 255, 0.5);
            }
            .opslaan button {
                padding: 15px;
            }
        </style>

    </div>
</div>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="profile.js"></script>
</body>
</html>

<?php

?>