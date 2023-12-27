//this is by default want to call the refresh function(profile data showing)
$(document).ready(function () {
  refresh();
});

//this is for send the data from html model to database
function ts(event) {
  event.preventDefault();
  var formData = {
    profile: true,
    firstname: $('#firstname').val(),
    lastname: $('#lastname').val(),
    mobileno: $('#mobileno').val(),
    dob: $('#dob').val(),
    address: $('#address').val(),
    district: $('#district').val(),
    pincode: $('#pincode').val()
  };
  console.log(formData);

  // AJAX request
  $.ajax({
    type: 'POST',
    url: '../phpfolder/profile.php',
    data: formData,
    success: function (response) {
      console.log('Update successful:', response);
      // $.notify(response.message, "success");
      $('#profile').trigger("reset");
      closemodel();
      refresh();
    },
    error: function (error) {
      // Handle error, if needed
      console.error('Update failed:', error);
    }
  });
}

//this is model closing line after the data is updated
function closemodel() {
  document.getElementById('close-model').click();
}



// this is for changing the password
function password(event)
{
  event.preventDefault();
  var changedata={
    changepassword:true,
    oldpassword:$('#oldpassword').val(),
    newpassword:$('#newpassword').val(),
  }
  $.ajax({
    type: 'POST',
    url: '../phpfolder/profile.php',
    data: changedata,
    success: function(response) {
      $('#changepassword')[0].reset();
      $.notify(response.message, "success");
      closepassword_field();
       console.log(response.message);

    },
    error: function(error) {
        // Handle error, if needed
        console.error('Update failed:', error);
    }
});
}
//this password closing function
function closepassword_field()
{
  $('#cpassword-close').click();
}



//retrieveing the data from the database
function refresh() {
  $.ajax({
    type: 'POST',
    url: '../phpfolder/retrieve.php',
    data:{
      profile:true,
    },
    // dataType: 'json',
    success: function (response) {
      console.log(response);

      if (response && response.status === 200) {
        $("#firstname1").text(response.firstname ? response.firstname : 'NA');
        $("#lastname1").text(response.lastname ? response.lastname : 'NA');
        $("#mobileno1").text(response.mobileno ? response.mobileno : 'NA');
        $("#dob1").text(response.dob !== null ? response.dob : 'NA');
        $("#address1").text(response.address ? response.address : 'NA');
        $("#district1").text(response.district ? response.district : 'NA');
        $("#pincode1").text(response.pincode ? response.pincode : 'NA');
        $("#user-name").text(response.username);
      } else {
        console.error('Unexpected response:', response);
      }
    },
    error: function (error) {
      // Handle error, if needed
      console.error('Request failed:', error);
    }
  });
}






//task submission

$(document).ready(function () {
  console.log("1");
  $('#task').submit(function (event) {
      console.log(45);
      event.preventDefault();
      var date=$('#taskdate').val();
      var category=$('#category').val();
      var abouttask=$('#abouttask').val();
      console.log(date);
      console.log(category);
      console.log(abouttask);
      $.ajax({
          type: 'POST',
          url: '../phpfolder/task.php',
          data: {
              task: true,
              date:date,
              category:category,
              abouttask:abouttask,
          },
           dataType: 'json',
          success: function (response) {
              try {
                $('#task')[0].reset();
                  console.log(response.message);
                  $.notify(response.message, "success");
                  tasks();
                  all_task();
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
























//logout session
$(document).ready(function () {
  $('#logout').click(function () {
    $.ajax({
      type: 'POST',
      url: '../phpfolder/session.php',
      data: {
        logout: true,
      },
      dataType: 'json', 
      success: function (response) {
        console.log(response.message);
        window.location.replace('../htmlfolder/login.html'); // use replace because there is a chance of back error so use replace instead of href
      },
      error: function (error) {
        console.error('Logout failed:', error);
      }
    });
  });
});




