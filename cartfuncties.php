<?php
// altijd hiermee starten als je gebruik wilt maken van sessiegegevens

function getCart()
{
    if (isset($_SESSION['cart'])) {               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else {
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart)
{
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID, $quantity = 1)
{
    $cart = getCart();  // Eerst de huidige winkelwagen ophalen

    if (array_key_exists($stockItemID, $cart)) {
        // Controleren of $stockItemID al in de winkelwagen staat
        $cart[$stockItemID] += $quantity;  // Zo ja: het aantal met $quantity verhogen
    } else {
        $cart[$stockItemID] = $quantity;   // Zo nee: key toevoegen en het aantal op $quantity zetten.
    }

    saveCart($cart);  // Werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte winkelwagen
}

function updateCart($cart) {
    $_SESSION['cart'] = $cart; // Set the updated cart in the session
}

function totaalPrijsPerProduct($aantal, $afgerondePrijs){
    $totaalPrijsPerProduct = $aantal * $afgerondePrijs;
    $totaalPrijsPerProduct = number_format($totaalPrijsPerProduct, 2);
    return $totaalPrijsPerProduct;
}

function updateQuantityOnHand($stockItemID, $aantal, $connection)
{
    $query = "
        UPDATE stockItemHoldings
        SET quantityOnHand = quantityOnHand - $aantal
        WHERE stockItemID = $stockItemID;
    ";

    mysqli_query($connection, $query);
}

function update($cart){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_aantal'])) {
        $updateItemID = $_POST["update_aantal"];
        $newAantal = max(1, $_POST['aantal'][$updateItemID]);

        if (array_key_exists($updateItemID, $cart)) {
            $cart[$updateItemID] = (int)$newAantal;
            updateCart($cart);
        }
    }
}

function verminderen($cart){
    //Als er post plaatsvindt bij de min knop neemt de aantal met 1 af.
    //Op het moment dat het aantal 1 is en er post plaatsvindt wordt het product uit de array verwijdert.
    if (isset($_POST["verminderen"])) {
        $verminderenItemID = $_POST["verminderen"];

        if (array_key_exists($verminderenItemID, $cart)) {
            $cart[$verminderenItemID] -= 1;
            if ($cart[$verminderenItemID] <= 0) {
                unset($cart[$verminderenItemID]);
            }
            updateCart($cart);
        }
    }
}

function verwijderen($cart){
    //Als er post plaatsvindt bij de prullenbak knop wordt het product uit de array verwijdert.
    if (isset($_POST["verwijderen"])) {
        $verwijderItemID = $_POST["verwijderen"];

        if (array_key_exists($verwijderItemID, $cart)) {
            unset($cart[$verwijderItemID]);
            updateCart($cart);
        }
    }
}

function toevoegen($cart){
//Als er post plaatsvindt bij de plus knop neemt het aantal met 1 toe
    if (isset($_POST["toevoegen"])){
        $toevoegenItemID = $_POST["toevoegen"];

        if (array_key_exists($toevoegenItemID, $cart)) {
            $cart[$toevoegenItemID] += 1;
        } else {
            $cart[$toevoegenItemID] = 1;
        }
        updateCart($cart);
    }
}


function favorite(){

}


