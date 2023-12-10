<?php
function addCustomer ($Fullname, $DeliveryAdressLine2, $EmailAdress, $connection){
    $query = "
        INSERT INTO customers(CustomerName, DeliveryAddressLine2, BillToCustomerID, CustomerCategoryID, BuyingGroupID, PrimaryContactPersonID, AlternateContactPersonID, DeliveryMethodID, DeliveryCityID, PostalCityID, CreditLimit, AccountOpenedDate, StandardDiscountPercentage, IsStatementSent, IsOnCreditHold, PaymentDays, PhoneNumber, FaxNumber, WebsiteURL, DeliveryAddressLine1, DeliveryPostalCode, PostalAddressLine1, PostalPostalCode, LastEditedBy, ValidFrom, ValidTo, Emailadres)
        VALUES ('$Fullname', '$DeliveryAdressLine2' , 1, 3, 1, 1001, 2400, 3, 15, 15, 200000.00, '2013-01-01', 0.000, 0, 0, 7, '(201) 555-0100', '(201) 555-0101', 'http://www.microsoft.com/', 'unit 1', 90410, 'PO Box 101', 90410, 1, '2013-01-01 00:00:00', '9999-12-31 23:59:59', '$EmailAdress');
    ";
    mysqli_query($connection, $query);
}

function addOrder ($connection){
    $query = "
    INSERT INTO orders(CustomerID, SalespersonPersonID, PickedByPersonID, ContactPersonID, BackorderOrderID, OrderDate, ExpectedDeliveryDate, CustomerPurchaseOrderNumber, IsUndersupplyBackordered, Comments, DeliveryInstructions, InternalComments, PickingCompletedWhen, LastEditedby, LastEditedWhen)
VALUES (1061,3,18,3261,70201,'2016-05-18', '2016-06-18', 20000, 1, NULL, NULL, NUll, '2016-05-19 11:00:00', 18, '2016-05-19 11:00:00');
    ";
    mysqli_query($connection, $query);
}

function addOrderlines($connection, $aantal, $prijsPerProduct, $beschrijving, $Artikelnummer){
    $query = " 
    INSERT INTO orderlines(OrderID,StockItemID, Description, PackagetypeID, Quantity, Unitprice, TaxRate, PickedQuantity, PickingCompletedWhen, lastEditedBy, LastEditedWhen)
    VALUES (73586, $Artikelnummer, '$beschrijving', 7, $aantal, $prijsPerProduct, 15.000, $aantal, '2016-05-31 11:00:00', 4, '2016-05-31 11:00:00')
       ";
    mysqli_query($connection, $query);
}


