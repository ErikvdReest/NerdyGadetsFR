<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";
include "betalenFuncties.php";

if (isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
} else {
    $stockItemID = 0;
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform any necessary processing

    // Redirect to betalen.php
    header("Location: betalenUitgelogd.php");
    exit(); // Make sure to exit after sending the header
}

// Refresh de pagina op het moment dat er een post plaatsvindt
// De pagina wordt direct gerefreshed als er post plaatsvindt.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Refresh:0");
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Ideal Betalen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            background-color: transparent;
            color: white;
            padding: 10px;
            text-align: center;
            border: 1px SOLID white;
            border-radius: 20px;
            justify-content: center;
            width: 600px;
            margin: auto;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #AfrekenenKnop {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 15px;
            font-size: 18px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #AfrekenenKnop:hover {
            background-color: #0056b3;
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }

        .qr-code img {
            width: 150px;
            height: 150px;
        }

        .cancel-button {
            text-align: center;
            margin-top: 20px;
        }

        .cancel-button button {
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cancel-button button:hover {
            background-color: #bd2130;
        }
        #ideal-logo {
            max-width: 100%;
            height: auto;
            margin: auto;
            width: 100px;

        }
        .border {
            padding: 30px;
            border: 1px SOLID white;
            border-radius: 30px;
            justify-content: center;
            margin: auto;
            max-width: 100%;
            width: 700px;
        }
        .border2 {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="border2">
    <div class="border">

        <header>
            <h1>Betalen</h1>
        </header>

        <div class="container">
            <img src="Public/Img/Ideal.png" alt="Ideal Logo" id="ideal-logo">
            <form method="post">
                <label for="bank">Kies een bank:</label>
                <select id="bank" name="bank" required>
                    <option value="Kies een bank">Kies een bank</option>
                    <option value="ING">ING</option>
                    <option value="ABN AMRO">ABN AMRO</option>
                    <option value="Rabobank">Rabobank</option>
                    <option value="SNS Bank">SNS Bank</option>
                    <option value="ASN Bank">ASN Bank</option>
                    <option value="Triodos Bank">Triodos Bank</option>
                    <option value="Knab">Knab</option>
                    <option value="Regiobank">Regiobank</option>
                </select>

                <button type='submit' name='betalen' id="AfrekenenKnop"> Bestellen & Betalen</button>
            </form>

            <div class="qr-code">
                <?php
                $thankYouUrl = 'https://www.example.com/thankyou.php';
                $googleChartsApiUrl = 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' . urlencode($thankYouUrl);
                ?>
                <img src="<?php print $googleChartsApiUrl; ?>" alt="QR-code">
            </div>

            <div class="cancel-button">
                <form action="index.php" method="post">
                    <button type="submit"> Annuleren</button>
                </form>
            </div>

            <?php
            $cart = getCart();
            $connection = connectToDatabase();
            $puntenAantal = 0;
            $totaalPrijs = 0;

            addOrder($connection);

            foreach ($cart as $Artikelnummer => $aantal) {
                $productDetails = getStockItem($Artikelnummer, $connection);

                $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
                $prijsPerProduct = $afgerondePrijs;
                $totaalPrijs += ($aantal * $afgerondePrijs);

                $beschrijving = $productDetails['StockItemName'];

                $productDetails = getStockItem($Artikelnummer, $connection);
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['betalen'])) {

                    foreach ($cart as $Artikelnummer => $aantal) {
                        updateQuantityOnHand($Artikelnummer, $aantal, $connection);
                    }
                    mysqli_close($connection);

                    unset($_SESSION['cart']);
                }
                addOrderlines($connection,$aantal,$prijsPerProduct,$beschrijving,$Artikelnummer);

                $puntenAantal += (($aantal * $afgerondePrijs) * 0.79) * 0.05;
                $puntenAantal = number_format($puntenAantal,0);

            }
            $brutoTotaalprijs = $totaalPrijs * 0.79;

            ?>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var successMessage = document.getElementById("successMessage");
                if (successMessage) {
                    setTimeout(function () {
                        successMessage.style.display = "none";
                    }, 2000);
                }
            });
        </script>

    </div>
</div>

</body>
</html>
