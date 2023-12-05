<?php ?>
<div class="productenWinkelmandje">
        <h1>Producten</h1>
        <div class="productenTonen">
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Aantal</th>
                    <th>Product Prijs</th>
                    <th>Totaalprijs</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cart = getCart();
                $connection = connectToDatabase();
                $totaalPrijs = 0;

                foreach ($cart as $Artikelnummer => $aantal) {
                    print("<tr>");

                    $productDetails = getStockItem($Artikelnummer, $connection);

                    // Rond de prijs op twee decimalen af
                    $afgerondePrijs = number_format($productDetails['SellPrice'], 2);
                    $voorraad = $productDetails['QuantityOnHand'];
                    if ($productDetails) {
                        print("<td>" . $productDetails['StockItemName'] . "</td>");
                        print("<td>" . $aantal . "</td>");
                        print("<td>". $afgerondePrijs . "</td>");
                        print("<td>". totaalPrijsPerProduct($aantal,$afgerondePrijs));
                    }
                    print("</tr>");
                    $totaalPrijs += $aantal * $afgerondePrijs;
                }
                $totaalPrijs = number_format($totaalPrijs, 2);
                ?>
                </tbody>
            </table>
        </div>

