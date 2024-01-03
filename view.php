<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";
include "favorietenfuncties.php";

$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);

?>

<?php
//?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
if (isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
} else {
    $stockItemID = 0;
}
?>

<?php
$cart = getCart();
$connection = connectToDatabase();
foreach ($cart as $Artikelnummer => $aantal) {

}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && !isset($_POST["favoriet"])) {

print '<div class="success-message">Uw product is toegevoegd aan de winkelwagen</div>';
print '<div class="naarWinkelwagen">';
print '<form action="browse.php">';
print '<button type="submit" name="submit">';
print '<i class="fa fa-shopping-bag"> Verder winkelen</i>';
print '</button>';
print '</form>';
print '<form action="winkelmandje.php">';
print '<button type="submit" name="submit">';
print '<i class="fas fa-shopping-cart"> Naar winkelwagen</i>';
print '</button>';
print '</form>';
print '</div>';
print '<hr>';
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] && isset($_POST["favoriet"])) {
    print '<div class="success-message">Uw product is toegevoegd aan favorieten</div>';
    print '<div class="naarWinkelwagen">';
    print '<form action="browse.php">';
    print '<button type="submit" name="submit">';
    print '<i class="fa fa-shopping-bag"> Verder winkelen</i>';
    print '</button>';
    print '</form>';
    print '<form action="favorieten.php">';
    print '<button type="submit" name="submit">';
    print '<i class="fas fa-heart"> Naar favorieten</i>';
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
<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
        ?>
        <?php
        if (isset($StockItem['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($StockItemImage)) {
                // één plaatje laten zien
                if (count($StockItemImage) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($StockItemImage) >= 2) { ?>
                    <!-- meerdere plaatjes laten zien -->
                    <div class="image" id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- knoppen 'vorige' en 'volgende' -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>
            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>

            <div class="QuantityText"><?php print "voorraad: ". $StockItem['QuantityOnHand']; ?></div>

                <?php if ($StockGroups = 1 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>       Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 2 && $StockItem['QuantityOnHand'] <= 10 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>         Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 3 && $StockItem['QuantityOnHand'] <= 2 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>         Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 4 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10> <i class='fas fa-exclamation-triangle'></i>          Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 5 && $StockItem['QuantityOnHand'] <= 2 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>         Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 6 && $StockItem['QuantityOnHand'] <= 1 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>         Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 7 && $StockItem['QuantityOnHand'] <= 2 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>        Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 8 && $StockItem['QuantityOnHand'] <= 8 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>   <i class='fas fa-exclamation-triangle'></i>        Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 9 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1) {
                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>        Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                elseif ($StockGroups = 10 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1) {

                    print("<h10>  <i class='fas fa-exclamation-triangle'></i>         Product is bijna uitverkocht. Laatste kans!! OP=OP <i class='fas fa-exclamation-triangle'></i> </h10>");
                }
                ?>



            <div id="StockItemHeaderLeft" class="Prijs">

                <p class="StockItemPriceText" style="margin-top: 70px"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                <?php
                $puntenAantal = ($StockItem['SellPrice'] * 0.79) * 0.05;
                $puntenAantal = number_format($puntenAantal,1)

                ?>
                <h6 style="margin-top: -10px"> Inclusief BTW </h6>
                <h5 style="margin-top: 20px"><?php print($puntenAantal)?> <i class="fas fa-solid fa-coins"></i></h5>

                <?php
                if (isset($_SESSION['userData'])) {
                $userData = $_SESSION['userData'];
                ?>

                    <form method="post" >
                        <div class="favoriet">
                            <button type="submit" name="favoriet">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </form>

                    <?php
                    $description = $StockItem['SearchDetails'];
                    $prijsPerStuk = $StockItem['SellPrice'];
                    $emailadres = isset($userData['EmailAddress']) ? $userData['EmailAddress'] : '';

                    if(isset($_POST['favoriet'])){
                        addProductTofavorites($description,$stockItemID,$prijsPerStuk,$connection,$emailadres);
                    }
                }?>

                <div class="winkelwagenBorder">
                    <form method="post" action="" style="display: flex;">
                        <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                        <?php
                        if (($StockGroups == 1 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 2 && $StockItem['QuantityOnHand'] <= 10 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 3 && $StockItem['QuantityOnHand'] <= 2 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 4 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 5 && $StockItem['QuantityOnHand'] <= 2 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 6 && $StockItem['QuantityOnHand'] <= 1 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 7 && $StockItem['QuantityOnHand'] <= 2 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 8 && $StockItem['QuantityOnHand'] <= 8 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 9 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1)||
                            ($StockGroups == 10 && $StockItem['QuantityOnHand'] <= 5 && $StockItem['QuantityOnHand'] >= 1)){
                            ?>

                        <div class="toevoegenWinkelwagen">
                            <input name="aantal" type="number" placeholder="koop nu !                " min="1" max="<?php print $StockItem['QuantityOnHand']; ?>" required>
                        </div>

                            <?php
                            print '<div class="button-container2">';
                            print '<button type="submit" name="submit">';
                            print '<i class="fas fa-shopping-cart"></i>';
                            print '</button>';
                            print '</div>';

                            ?>

                        <?php
                        } else {
                            ?>

                            <div class="toevoegenWinkelwagen">
                                <input name="aantal" type="number" placeholder="aantal:                 " min="1" max="<?php print $StockItem['QuantityOnHand']; ?>" required>
                            </div>

                                <?php
                        print '<div class="button-container">';
                        print '<button type="submit" name="submit">';
                        print '<i class="fas fa-shopping-cart"></i>';
                        print '</button>';
                        print '</div>';
                        }
                        ?>


                    </form>
                </div>


                <style>
                    .uitverkoop {

                        color: #005cbf;
                        width: 800px;
                        border-radius: 30px;
                        background-color: #FFFFFF;
                        max-width: 90%;
                    }
                    .winkelwagenBorder {
                        border: 1px solid transparent;
                        display: flex;
                        align-items: center;
                        width: 150px;
                        margin-top: -10px;
                    }

                    .button-container {
                        flex: 0 0 auto;
                        margin-top: 11px;
                        margin-left: 10px;
                    }
                    .button-container2 {
                        flex: 0 0 auto;
                        margin-top: 11px;
                        margin-left: 10px;
                    }

                    button {
                        background-color: transparent;
                        border: 1px solid white;
                        border-radius: 10px;
                        padding: 10px;
                        font-size: 18px;
                        color: white;
                        margin-bottom: 10px;
                    }

                    button:hover {
                        background-color: rgba(0, 0, 255, 0.5);
                    }

                    .toevoegenWinkelwagen {
                        flex: 1;
                        margin-top: 10px;
                    }

                    .toevoegenWinkelwagen input {
                        border: 1px solid white;
                        background-color: transparent;
                        border-radius: 10px;
                        padding: 10px;
                        color: white;
                        width: 100%;
                        text-align: right;
                        margin-right: 10px;
                    }
                    .favoriet {
                        margin-top: 10px;
                    }
                    .success-message {
                        margin-top: 10px;
                        background-color: transparent;
                        color: white;
                        padding: 10px;
                        text-align: center;
                    }
                </style>

                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild" style="margin-top: 0px">
                    </div>
                </div>

            </div>
        </div>

        <?php
        if (isset($_POST["submit"])) {
            $stockItemID = $_POST["stockItemID"];
            $aantal = isset($_POST["aantal"]) ? intval($_POST["aantal"]) : 1;
            addProductToCart($stockItemID, $aantal);
        }
        ?>



        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
            <ul id="Content" style="margin-top: 0;">
            </ul>
        </div>

        <div id="StockItemSpecifications" style="text-align: left;">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($StockItem['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                    <thead>
                    <th>Naam</th>
                    <th>Data</th>
                    </thead>
                    <?php
                    foreach ($CustomFields as $SpecName => $SpecText) { ?>
                        <tr>
                            <td>
                                <?php print $SpecName; ?>
                            </td>
                            <td>
                                <?php
                                if (is_array($SpecText)) {
                                    foreach ($SpecText as $SubText) {
                                        print $SubText . " ";
                                    }
                                } else {
                                    print $SpecText;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p><?php print $StockItem['CustomFields']; ?>.</p>
            <?php } ?>
        </div>

        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>

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