<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Betalen</title>
    <style>
        .opmaak {
            text-align: center;
            border: 1px solid #FFFFFF;
            padding: 10px;
        }
        .WinkelmandjeTerug {
            text-align: right;
            padding: 10px;
        }
        .fa-shopping-cart {
            color: #FFFFFF;
            background-color: transparent;
        }
    </style>
</html>
<body>

<div class="opmaak">
<h1>Afrekenen</h1>
</div>

<div class="WinkelmandjeTerug">
<form action="winkelmandje.php" method="post">
    <button type="submit"  class="fas fa-shopping-cart" id="AfrekenenKnop"> Terug Naar Winkelmandje</button>
</form>
</div>