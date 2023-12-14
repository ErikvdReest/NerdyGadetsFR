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
                    <div id="ImageFrame">
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
            <div id="StockItemHeaderLeft" class="Prijs">
                <p class="StockItemPriceText" style="margin-top: 60px"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                <h6> Inclusief BTW </h6>

                <!--                <form method="post" action="">-->
                <!--                    <input type="number" name="stockItemID" value="--><?php //print($stockItemID) ?><!--" hidden>-->
                <!--                    <button type="submit" name="submitfavorit" id="Toevoegen" style="margin-top: 75px;">-->
                <!--                        <i class="fas fa-heart"> Favorieten</i>-->
                <!--                    </button>-->
                <!--                </form>-->

                <form method="post" action="" >
                    <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                        <button type="submit" name="submit" style="margin-top: 55px; background-color: transparent; border: 1px solid white; border-radius: 10px; padding: 10px; font-size: 18px; color: white;">
                            <i class="fas fa-shopping-cart"></i> Toevoegen Winkelwagen
                        </button>
                    <div class="toevoegenWinkelwagen">
                        <input type="number" name="aantal" placeholder="aantal:                                       " min="1" max="<?php print $StockItem['QuantityOnHand']; ?>" required style="text-align: right; margin-top: 10px"  >
                    </div>
                </form>

                <style>
                    .toevoegenWinkelwagen input {
                        border: 1px solid white;
                        background-color: transparent;
                        border-radius: 10px;
                        padding: 10px;
                        color: white;
                        width: 10%
                        margin-top: 10px;
                        text-align: right;
                        margin-bottom: 20px;
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

        if (isset($_POST["submitfavorit"])) {
            $stockItemID = $_POST["stockItemID"];
            addProductToFavorit($stockItemID);
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