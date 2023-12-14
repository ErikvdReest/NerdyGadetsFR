<?php



//In deze query worden de NAW-gegevens van klanten opgeslagen
//De ingevulde indexen in afrekenen.php worden in variabele gestopt
//De overgebleven kolommen worden gevuld met standaardwaarden
function addCustomer ($Fullname, $DeliveryAdressLine2, $EmailAdress, $connection){
    $query = "
        INSERT INTO customers(CustomerName, DeliveryAddressLine2, BillToCustomerID, CustomerCategoryID, BuyingGroupID, PrimaryContactPersonID, AlternateContactPersonID, DeliveryMethodID, DeliveryCityID, PostalCityID, CreditLimit, AccountOpenedDate, StandardDiscountPercentage, IsStatementSent, IsOnCreditHold, PaymentDays, PhoneNumber, FaxNumber, WebsiteURL, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, LastEditedBy, ValidFrom, ValidTo, Emailadres)
        VALUES (
                '$Fullname', 
                '$DeliveryAdressLine2' ,
                1, 
                3, 
                1, 
                1001, 
                2400, 
                3, 
                15, 
                15, 
                200000.00, 
                '2013-01-01', 
                0.000,
                0, 
                0, 
                7, 
                '(201) 555-0100', 
                '(201) 555-0101', 
                'http://www.microsoft.com/', 
                'unit 1', 
                90410, 
                'PO Box 101', 
                90410, 
                1, 
                '2013-01-01 00:00:00', 
                '9999-12-31 23:59:59', 
                '$EmailAdress');
    ";
    mysqli_query($connection, $query);
}

//In deze query wordt een order aangemaakt van een bestelling van de klant
//De hoogste CustomerID wordt verkregen door een max functie
//De hoogste customerID is ook de laatste klant
//Zo wordt de klant aan een order gekoppeld
//De rest van de kolommen zijn standaardwaardes
function addOrder ($connection){
    $query = "
    INSERT INTO orders (CustomerID, SalespersonPersonID, PickedByPersonID, ContactPersonID, BackorderOrderID, OrderDate, ExpectedDeliveryDate, CustomerPurchaseOrderNumber, IsUndersupplyBackordered, Comments, DeliveryInstructions, InternalComments, PickingCompletedWhen, LastEditedby, LastEditedWhen)
    VALUES (
        (SELECT MAX(CustomerID) FROM customers),
        3,
        18,
        3261,
        70201,
        '2016-05-18',
        '2016-06-18',
        20000,
        1,
        NULL,
        NULL,
        NULL,
        '2016-05-19 11:00:00',
        18,
        '2016-05-19 11:00:00'
);
    ";
    mysqli_query($connection, $query);
}
//In deze query worden de order gegevens opgeslagen
//De variabele worden gevuld vanuit het winkelwagen
//De overige kolommen worden gevuld met standaardwaarden
//De Orderlines wordt aan een Order gekoppeld met max(OrderId) dit is de laatste order
function addOrderlines($connection, $aantal, $prijsPerProduct, $beschrijving, $Artikelnummer){
    $query = " 
    INSERT INTO orderlines (OrderID, StockItemID, Description, PackagetypeID, Quantity, Unitprice, TaxRate, PickedQuantity, PickingCompletedWhen, lastEditedBy, LastEditedWhen)
    VALUES (
        (SELECT OrderID FROM orders ORDER BY OrderID DESC LIMIT 1),
        '$Artikelnummer',
        '$beschrijving',
        7,
        '$aantal',
        '$prijsPerProduct',
        15.000,
        '$aantal',
        '2016-05-31 11:00:00',
        4,
        '2016-05-31 11:00:00'
    );
       ";
    mysqli_query($connection, $query);
}

//Om de Nawgegevens van de klant op te vragen wordt deze query gebruikt
//Door Order By DESC en limit 1 worden de klantgegevens geselecteerd
function opvragenKlantgegevens($connection){
    $query = " 
    SELECT CustomerID, CustomerName, DeliveryAddressLine2, Emailadres
    FROM customers
    ORDER BY CustomerID DESC
    LIMIT 1;
     ";
    mysqli_query($connection, $query);
}

//Om de bestelling gegevens op te vragen worden deze query's uitgevoerd
//Door Order By Desc en limit 1 wordt de laatste OrderID opgevraagd
//Deze orderID wordt gebruikt in de volgende query voor de laatste Orderlines
function opvragenBestellinggegevens($connection){
    $query = " 
    SELECT orderID
    FROM orders
    Order By OrderID desc
    limit 1;
    ";
    mysqli_query($connection, $query);

    $query = " 
    SELECT OrderID, stockitemID, description, quantity
    FROM orderlines
    ORDER BY OrderID DESC
    LIMIT 1;
     ";
    mysqli_query($connection, $query);
}


