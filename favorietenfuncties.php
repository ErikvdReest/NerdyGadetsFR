<?php
 // altijd hiermee starten als je gebruik wilt maken van sessiegegevens

function getFavorite()
{
    if (isset($_SESSION['lijst'])) {               //controleren of winkelmandje (=cart) al bestaat
        $Favoriet = $_SESSION['lijst'];                  //zo ja:  ophalen
    } else {
        $Favoriet = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $Favoriet;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveFavorit($Favoriet)
{
    $_SESSION["lijst"] = $Favoriet;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToFavorit($stockItemID)
{
    $Favoriet = getFavorite();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $Favoriet)) {  //controleren of $stockItemID(=key!) al in array staat
        $Favoriet[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    } else {
        $Favoriet[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($Favoriet);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}
function updateFavoriet($favoriet) {
    $_SESSION['lijst'] = $favoriet;
}