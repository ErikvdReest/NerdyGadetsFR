<?php
session_start(); // Start the session at the beginning of the script

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['opslaan'])) {
    // Process form data

    $updatedFullName = $_POST['FullName'];
    $updatedEmail = $_POST['Email'];
    $updatedPhoneNumber = $_POST['PhoneNumber'];
    $updatedPostalAdressLine2 = $_POST['PostalAddressLine2'];
    $updatedDeliveryAdressLine2 = $_POST['DeliveryAdressLine2'];
    $updatedPostalPostalCode = $_POST['PostalPostalCode'];
    $updatedCountry = $_POST['land'];

    // Update session data
    if (isset($_SESSION['userData']['PersonID'])) {
        $_SESSION['userData']['FullName'] = $updatedFullName;
        $_SESSION['userData']['EmailAddress'] = $updatedEmail;
        $_SESSION['userData']['PhoneNumber'] = $updatedPhoneNumber;
        $_SESSION['userData']['PostalAddressLine2'] = $updatedPostalAdressLine2;
        $_SESSION['userData']['DeliveryAdressLine2'] = $updatedDeliveryAdressLine2;
        $_SESSION['userData']['DeliveryPostalCode'] = $updatedPostalPostalCode;
        $_SESSION['userData']['DeliveryLocation'] = $updatedCountry;

        // Update database
        $userId = $_SESSION['userData']['PersonID'];

        try {
            $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
            mysqli_set_charset($Connection, 'latin1');
            $DatabaseAvailable = true;
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            // Check the form data
            var_dump($_POST);

            // Test database connection
            $testQuery = "SELECT 1;";
            $testResult = mysqli_query($Connection, $testQuery);
            if (!$testResult) {
                die("Database test query failed: " . mysqli_error($Connection));
            }

            // Update the database
            $updatePeopleQuery = "UPDATE nerdygadgets.people SET FullName = '$updatedFullName', EmailAddress = '$updatedEmail', PhoneNumber = '$updatedPhoneNumber' WHERE PersonID = '$userId'";
            if (mysqli_query($Connection, $updatePeopleQuery)) {
                echo "People table updated successfully<br>";
            } else {
                echo "Error updating people table: " . mysqli_error($Connection) . "<br>";
            }

            $updateCustomerQuery = "UPDATE nerdygadgets.customers SET CustomerName = '$updatedFullName', Emailadres = '$updatedEmail', PhoneNumber = '$updatedPhoneNumber', DeliveryLocation = '$updatedCountry', DeliveryAddressLine2 = '$updatedDeliveryAdressLine2', PostalAddressLine2 = '$updatedPostalAdressLine2', DeliveryPostalCode = '$updatedPostalPostalCode' WHERE AccountID = '$userId'";
            if (mysqli_query($Connection, $updateCustomerQuery)) {
                echo "Customers table updated successfully<br>";
            } else {
                echo "Error updating customers table: " . mysqli_error($Connection) . "<br>";
            }

            echo "Data updated successfully";

            // Close the database connection
            mysqli_close($Connection);

            header("Location: profile.php");
            exit();

            // Uncomment the following line after testing
            // header("Location: profile.php");
            // exit();
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: 'PersonID' not set in the session.";
        }
}