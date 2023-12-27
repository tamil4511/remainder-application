// this is for sending the data to store in the registration
$(document).ready(function() {
    console.log("1");
    $('#register').submit(function(event) {
        console.log(45);
        event.preventDefault();
        var usern = $('#username').val();
        var email = $('#email').val();
        var pass = $('#password').val();
        var cpass = $('#cpassword').val();
        console.log(email);
        // window.location.href = 'in.html';
        $.ajax({
            type: 'POST',
            url: '../phpfolder/register.php',
            data: {
                register: true,  //this line makes the php as true
                username: usern,
                email: email,
                password: pass,
                cpassword: cpass,
            },
            success: function(response) {
                $('#register')[0].reset();    // reset the form after the response
                 response = JSON.parse(response);
                if(response.status==200 || response.status==220) {
                    // console.log("working");
                     $.notify(response.message, "danger");  //alert
                    console.log(response.message);
                    // window.location.href = 'login.html';
                }
                if(response.status==300 || response.status==240) {
                    $.notify(response.message, "success");
                    window.location.href = 'login.html';
                    console.log(response.message);
                }
                else
                 {
                    console.log(response);
                }
            },
            error: function(error) {
                console.log("2");
                console.log(error);
            }
        });
    });
});
