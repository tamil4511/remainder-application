// this is for validate the email and password which is present in the database or not
$(document).ready(function () {
    console.log("1");
    $('#login').submit(function (event) {
        console.log(45);
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        console.log(email);
        $.ajax({
            type: 'POST',
            url: '../phpfolder/login.php',
            data: {
                login: true,
                email: email,
                password: password,
            },
             dataType: 'json', // Specify the expected data type of the response
            success: function (response) {
                try {
                    console.log(response);
                    if (response.status == 200 || response.status == 220 || response.status == 240) {
                        console.log(response.message);
                        $.notify(response.message, "danger");
                    } else if (response.status == 300) {
                        console.log(response.message);
                        // console.log("tamil");
                        window.location.href = 'home.html';
                    } else {
                        console.log(response.message);
                    }
                } catch (error) {
                    console.log("Error parsing JSON response:", error);
                    // Handle the error or log it as needed
                }
            },
            error: function (error) {
                console.log("2");
                console.log(error);
            }
        });
    });
});
