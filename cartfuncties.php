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

function addProductToCart($stockItemID)
{
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    } else {
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

function updateCart($cart) {
    $_SESSION['cart'] = $cart; // Set the updated cart in the session
}

function totaalPrijs($aantal, $afgerondePrijs){
    $totaalPrijs = 0;
    $totaalPrijs += ($aantal * $afgerondePrijs);
    $totaalPrijs = number_format($totaalPrijs, 2);
    return $totaalPrijs;
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

function addNawGegevens($Fullname,$DeliveryAdressLine2, $EmailAdress){
    $query = "
        INSERT INTO customers(CustomerName, DeliveryAddressLine2, BillToCustomerID, CustomerCategoryID, BuyingGroupID, PrimaryContactPersonID, AlternateContactPersonID, DeliveryMethodID, DeliveryCityID, PostalCityID, CreditLimit, AccountOpenedDate, StandardDiscountPercentage, IsStatementSent, IsOnCreditHold, PaymentDays, PhoneNumber, FaxNumber, WebsiteURL, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, LastEditedBy, ValidFrom, ValidTo, Emailadres)
        VALUES ('$Fullname', '$DeliveryAdressLine2', 1, 3, 1, 1001, 2400, 3, 15, 15, 200000.00, '2013-01-01', 0.000, 0, 0, 7, '(201) 555-0100', '(201) 555-0101', 'http://www.microsoft.com/', 'unit 1', 90410, 'PO Box 101', 90410, 1, '2013-01-01 00:00:00', '9999-12-31 23:59:59', '$EmailAdress')
    ";
    mysqli_query($connection, $query);
}
