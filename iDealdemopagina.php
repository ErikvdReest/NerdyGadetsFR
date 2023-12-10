<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";
include "betalenFuncties.php";

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
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .titel {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
        }

        .betalen {
            margin-top: 20px;

        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        form {
            margin: 0;
        }

        .qr-code {
            text-align: center;
        }

        .qr-code img {
            width: 150px;
            height: 150px;
        }

        .Terug {
            text-align: center;
            margin-top: 20px;
        }
        .style {
            border: 1px solid #FFFFFF;
            border-radius: 20px;
            padding: 20px;
            width: 40%;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-top: 260px;
        }
        #AfrekenenKnop {
            background-color: transparent; /* Maak de achtergrond transparant */
            border: 1px solid #FFFFFF; /* Voeg een witte rand toe voor zichtbaarheid */
            border-radius: 10px; /* Afgeronde hoeken */
            padding: 15px; /* Vergroot de padding voor een grotere knop */
            font-size: 18px; /* Vergroot de tekstgrootte */
            color: #FFFFFF; /* Tekstkleur wit voor contrast */
        }

        #AfrekenenKnop:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Licht op wanneer de knop wordt aangeraakt */
        }
    </style>
<!--    <script>-->
<!--        document.addEventListener('DOMContentLoaded', function () {-->
<!--            var betalenForm = document.querySelector('.betalen form');-->
<!---->
<!--            betalenForm.addEventListener('submit', function (event) {-->
<!--                event.preventDefault();-->
<!---->
<!--                // Toon een eenvoudige pop-up-->
<!--                alert('Betaling verwerkt!');-->
<!---->
<!--                // Open index.php after the alert is closed-->
<!--                window.location.href = 'index.php';-->
<!--            });-->
<!--        });-->
<!--    </script>-->
</head>
<body>

<div class="style">
<div class="container">
    <div class="titel">
        <h1>Ideal</h1>
    </div>

    <div class="betalen">
        <h1>Bank invoeren</h1>
        <div class="grid-container">
            <form action="" method="post">
                <label for="naam">Voer je bank in:</label>
                <input type="text" id="naam" name="naam" required>
                <div class="betalen">
                    <form method="post">
                        <button type='submit' name='betalen' class="fas fa-shopping-bag" id="AfrekenenKnop"> Bestellen & Betalen</button>
                    </form>
                </div>
            </form>
            <div class="qr-code">
                <h1>QR-code</h1>
                <?php
                $thankYouUrl = 'https://www.example.com/thankyou.php';

                $googleChartsApiUrl = 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' . urlencode($thankYouUrl);
                ?>
                <img src="<?php echo $googleChartsApiUrl; ?>" alt="QR-code">
            </div>
        </div>
    </div>

    <?php
    $cart = getCart();
    $connection = connectToDatabase();

    foreach ($cart as $Artikelnummer => $aantal) {
        $productDetails = getStockItem($Artikelnummer, $connection);

        $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
        $prijsPerProduct = $afgerondePrijs;

        $beschrijving = $productDetails['StockItemName'];

        $productDetails = getStockItem($Artikelnummer, $connection);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['betalen'])) {

            foreach ($cart as $Artikelnummer => $aantal) {
                updateQuantityOnHand($Artikelnummer, $aantal, $connection);
            }
            addOrder($connection);
            addOrderlines($connection,$aantal,$prijsPerProduct,$beschrijving,$Artikelnummer);

            mysqli_close($connection);

            unset($_SESSION['cart']);
        }
    }


    ?>

    <div class="Terug">
        <form action="index.php" method="post">
            <button type="submit" id="AfrekenenKnop" class="fas fa-minus-circle"> Annuleren</button>
        </form>
    </div>
</div>
</div>

</body>
</html>