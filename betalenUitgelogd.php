<?php
include __DIR__ . "/header.php";
include "betalenFuncties.php";
include "cartfuncties.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print '<h5>Wij gaan zo snel mogelijk met uw bestelling aan de slag !</h5>';
        print '<div class="naarWinkelwagen">';
        print '<form action="browse.php">';
        print '<button type="submit" name="submit">';
        print '<i class="fa fa-shopping-bag"> Verder winkelen</i>';
        print '</button>';
        print '</form>';
        print '<form action="profile.php">';
        print '<button type="submit" name="submit">';
        print '<i class="fas fa-user"> Naar account</i>';
        print '</button>';
        print '</form>';
        print '</div>';
        print '<hr>';
    }
    ?>
    <style>
        .naarWinkelwagen {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        h5 {
            text-align: center;
            margin: auto;
            justify-content: center;
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
    </style>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur</title>
    <style>
        body {
            margin: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            margin-top: 20px;
        }

        .titel, .flex-container {
            width: 100%;
            text-align: center;
        }

        .flex-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
        }

        .factuurGegevens, .rand {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .gegevens, .factuurGegevens {
            border: 1px solid white;
            border-radius: 30px;
            padding: 20px;
            width: 100%;
            max-width: 800px;
        }
        .gegevens {
            margin-top: 200px;
            margin-left: 5px;
        }
        .factuurGegevens {
            margin-right: 5px;
        }
        .factuurGegevens hr {
            width: 500px;
            background-color: #FFFFFF;
        }

        .rand {
            margin-top: -200px;
        }

        .totaalPrijs {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .Terug {
            text-align: center;
            margin-top: 20px;
        }
        .gegevens input {
            text-align: center;
            background-color: transparent;
            border-radius: 20px;
            border: 1px SOLID white;
            color: #FFFFFF;
            width: 300px;
        }
        .gegevens {
            text-align: left;
        }
        .gegevens h1 {
            text-align: center;
            border: 1px SOLID #FFFFFF;
            border-radius: 20px;
            padding: 15px;
        }
        .titel h1 {
            text-align: center;
            border: 1px SOLID #FFFFFF;
            border-radius: 20px;
            padding: 15px;
            max-width: 100%;
            width: 1100px;
            justify-content: center;
            margin: auto;
        }
        .totaalPrijs {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }
        .totaalPrijs h3, .totaalPrijs h4 {
            margin: 0;
            text-align: left;
        }
        button {
            border-radius: 20px;
            border: 1px SOLID #FFFFFF;
            padding: 15px;
            background-color: rgba(105,105,105,0.5);
            justify-content: center;
            text-align: center;
            width: 200px;
        }
        button:hover {
            background-color: rgba(255,255,255,0.8);
        }
        .Terug button {
            border: 1px SOLID white;
            width: 200px;
            border-radius: 20px;
            padding: 10px;
            background-color: rgba(105,105,105,0.8);
        }
        .Terug button:hover {
            background-color: rgba(0,0,255,0.8);
        }
    </style>
</head>
<body>
<div class="titel">
    <h1>Uw bestelling is voltooid!</h1>
</div>

<div class="Terug">
    <form method="post">
        <button type="submit" name="terug" id="AfrekenenKnop" class="fas fa-house">Terug naar home</button>
    </form>
</div>

<div class="container">
    <div class="flex-container">
        <div class="factuurGegevens">
            <h1>Bestelling</h1>
            <hr>

            <?php
            $cart = getCart();
            $connection = connectToDatabase();
            $totaalPrijs = 0;
            $aantalProducten = 0;
            $afgerondePrijs = 0;

            // Toont de array $cart met artikelnummer als index
            foreach ($cart as $Artikelnummer => $aantal) {
                print("<div class='factuur-item'>");

                // Met gebruik van artikelnummer toont $productdetails de informatie over producten
                $productDetails = getStockItem($Artikelnummer, $connection);

                $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
                $prijsPerStuk = $afgerondePrijs;

                if ($productDetails) {
                    print("<div class='product-info'>");
                    print("<h3>" . $productDetails['StockItemName'] . "</h3>");
                    // Toont de voorraad
                    print("<p>Aantal: " . $aantal . " </p>");
                    print("<hr>");
                    print("</div>");
                }

                print("</div>");
                $aantalProducten += ($aantal);
                $totaalPrijs += ($aantal * $afgerondePrijs);
                $totaalPrijs = number_format($totaalPrijs,2);
            }

            ?>
        </div>
    </div>
</div>


</body>
</html>

<?php
    $cart = getCart();
    $connection = connectToDatabase();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['terug'])) {

    foreach ($cart as $Artikelnummer => $aantal) {
    updateQuantityOnHand($Artikelnummer, $aantal, $connection);
    }
    mysqli_close($connection);

    unset($_SESSION['cart']);
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
