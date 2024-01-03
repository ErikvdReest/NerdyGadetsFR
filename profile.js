function loadUserInfo() {
    // Make an AJAX request to retrieve user data
    $.ajax({
        url: 'get_user_info.php', // Create a new PHP file for this purpose
        type: 'GET',
        success: function (data) {
            // Populate the form fields with user data
            // Update the input fields in the userInfoForm
        },
        error: function () {
            // Handle error
        }
    });
}

// Function to handle user logout
function logout() {
    // Make an AJAX request to logout
    $.ajax({
        url: 'logout.php', // Create a new PHP file for this purpose
        type: 'POST',
        success: function () {
            // Redirect to the login page or perform any other actions
            window.location.replace('registratie.php');
        },
        error: function () {
            // Handle error
        }
    });
}