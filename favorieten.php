<?php
include __DIR__ . "/header.php";
include "favorietenfuncties.php";

if (isset($_SESSION['userData']))
    $userData = $_SESSION['userData'];

function deleteFavoriet ($stockItemID,$connection){
    $query = " 
        DELETE FROM favorieten
        WHERE stockitemID = $stockItemID;
         ";
    mysqli_query($connection, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verwijderen"])) {

    print '<div class="success-message">Uw product is uit favoriet verwijderd</div>';
    print '<hr>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verwijderen'])) {
        // Controleer of stockitemID is ingestuurd via een verborgen veld
        if (isset($_POST['stockitemID'])) {
            $stockItemID = $_POST['stockitemID'];
            $connection = connectToDatabase();
            deleteFavoriet($stockItemID, $connection);
            // Refresh de pagina om de wijzigingen te laten zien
            header("Refresh:5");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Favorieten</title>
    <style>
        .success-message {
            text-align: center;
            color: white;
            border-radius: 10px;
            margin-top: 10px;
            margin-bottom: -10px;
            background-color: black;
        }

        .naarWinkelwagen form {
            margin-right: 10px;
        }

        button {
            background-color: transparent;
            border: 1px solid white;
            border-radius: 10px;
            padding: 10px;
            font-size: 18px;
            color: white;
            margin-bottom: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgba(0, 0, 255, 0.5);
        }
        hr {
            border: 1px SOLID blue;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .titel {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 100%;
            border-radius: 30px;
            background-color: transparent;
            color: #FFFFFF;
        }

        .grid-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
        }

        .cart-item {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 15px;
            max-width: 300px;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(105,105,105,0.4);
        }

        h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
        }

        .ImageFrame {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 200px;
            margin-top: 10px;
            width: 100%; 
        }
        button {
            padding: 10px;
            border-radius: 10px;
            border: 1px SOLID #FFFFFF;
            margin-top: 10px;
            background-color: rgba(105,105,105,0.8);
            color: white;
        }
        button:hover {
            background-color: rgba(255,255,255,0.6);
        }
        .fa-heart-broken {
            color:red;
        }
        .verwijderen {
            display: flex;
            justify-content: space-between;  /* Add this line to space the buttons */
            margin-top: 20px;
        }

        .verwijderen button[name="verwijderen"] {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #FFFFFF;
            margin-top: 10px;
            background-color: rgba(105, 105, 105, 0.8);
            color: red;
            margin-right: 5px;
        }

        .verwijderen button[name="verwijderen"]:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }

        .verwijderen button[name="toevoegen"] {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #FFFFFF;
            margin-top: 10px;
            background-color: rgba(105, 105, 105, 0.8);
            color: white;
            margin-left: 5px;
        }

        .verwijderen button[name="toevoegen"]:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>
<body>
<div class="titel">
    <h1>Favorieten</h1>
</div>

<div class="grid-container">
    <?php
    $connection = connectToDatabase();
    $emailadres = isset($userData['EmailAddress']) ? $userData['EmailAddress'] : '';
    $favorietenGegevens = ophalenFavorieten($connection, $emailadres);

    if ($favorietenGegevens) {
        foreach ($favorietenGegevens as $favoriet) {
            $Artikelnummer = $favoriet['stockitemID'];
            $productDetails = getStockItem($Artikelnummer, $connection);
            $StockItemImage = getStockItemImage($Artikelnummer, $connection);
            ?>

            <div class='cart-item'>
                <p><?php echo $favoriet['description']; ?></p>
                <p>Voorraad: <?php echo $productDetails['QuantityOnHand']; ?></p>

                <?php if (isset($StockItemImage) && count($StockItemImage) == 1) { ?>
                    <div class="ImageFrame" style="background-image: url('Public/StockItemIMG/<?php echo $StockItemImage[0]['ImagePath']; ?>');"></div>
                <?php } ?>

                <div class="verwijderen">
                    <!-- Voeg een verborgen veld toe om stockitemID door te sturen -->
                    <form method="post">
                        <input type="hidden" name="stockitemID" value="<?php echo $Artikelnummer; ?>">
                        <button type="submit" name="verwijderen" class="fas fa-heart-broken"></button>
                    </form>
                </div>
            </div>

            <?php
        }
    } else {
        echo "<p>Geen favorieten gevonden.</p>";
    }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var successMessage = document.getElementById("successMessage");
            if (successMessage) {
                setTimeout(function () {
                    successMessage.style.display = "none";
                }, 2);
            }
        });
    </script>

</div>
</body>
</html>