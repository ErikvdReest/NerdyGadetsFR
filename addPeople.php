<?php
function AddPeople($FullName, $FirstName,$PhoneNumber, $hashedPassword, $EmailAdress){
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }


    $Query = "INSERT INTO nerdygadgets.people (
        FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, IsExternalLogonProvider,
        HashedPassword, IsSystemUser, IsEmployee, IsSalesperson, UserPreferences, PhoneNumber,
        FaxNumber, EmailAddress, Photo, CustomFields, OtherLanguages, LastEditedBy, ValidFrom, ValidTo
    ) VALUES ('$FullName', 
              '$FirstName', 
              '$FullName', 
              1, 
              'NO LOGON', 
              0,
              '$hashedPassword', 
              0, 
              0, 
              0, 
              '', 
              '$PhoneNumber',
              '', 
              '$EmailAdress',
              '',
              '',
              '',
              1,
              '2016-05-31 23:14:00',
              '9999-12-31 23:59:59')";

    if ($Connection->query($Query) === TRUE) {
        echo "New record created successfully";
        return $Connection->insert_id;
    } else {
        echo "Error: " . $Query . "<br>" . $Connection->error;
    }

    return $Connection;

}

function authenticateUser($inputEmail, $inputPassword) {
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }

    $inputEmail = $_POST['InputEmail'];  // Corrected key
    $inputPassword = $_POST['InputPassword'];   // Corrected key

    // Retrieve hashed password from the database based on the provided email address
    $query = "SELECT p.*, c.* FROM nerdygadgets.people p
              LEFT JOIN nerdygadgets.customers c ON p.PersonID = c.AccountID
              WHERE p.EmailAddress = '$inputEmail'";
    $result = $Connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row['HashedPassword'];

        if (password_verify($inputPassword, $storedHashedPassword)) {
            if ($row['IsPermittedToLogon'] == 1) {
                $_SESSION['userData'] = $row; // Save user data in the session
                header("Location: profile.php"); // Redirect to the profile page

                // Redirect to profile.php
                echo '<script>window.location.replace("profile.php");</script>';
                exit();
            } else {
                echo "User not permitted to log in";
            }
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
    return null;
}

function addNawGegevensRegistratie($FullName,$DeliveryAdressLine2,$PhoneNumber,$PostalCode,$Country,$PostalAddressLine2, $EmailAdress,$lastInsertedPeopleID){

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }

    $query = "
        INSERT INTO customers(CustomerName, DeliveryAddressLine2, BillToCustomerID, CustomerCategoryID, BuyingGroupID,
                              PrimaryContactPersonID, AlternateContactPersonID, DeliveryMethodID, DeliveryCityID,
                              PostalCityID, CreditLimit, AccountOpenedDate, StandardDiscountPercentage, IsStatementSent,
                              IsOnCreditHold, PaymentDays, PhoneNumber, FaxNumber, WebsiteURL, DeliveryAddressLine1,
                              DeliveryPostalCode,DeliveryLocation, PostalAddressLine1,PostalAddressLine2, PostalPostalCode, LastEditedBy, ValidFrom, ValidTo,
                              Emailadres,AccountID)
        VALUES ('$FullName',
                '$DeliveryAdressLine2',
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
                $PhoneNumber,
                '(201) 555-0101',
                'http://www.microsoft.com/',
                'unit 1',
                '$PostalCode',
                '$Country',
                'PO Box 101',
                '$PostalAddressLine2',
                90410, 1,
                '2013-01-01 00:00:00',
                '9999-12-31 23:59:59',
                '$EmailAdress',
                '$lastInsertedPeopleID'
                )
    ";

    if ($Connection->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . $Connection->error;
    }

    return $Connection;

}


