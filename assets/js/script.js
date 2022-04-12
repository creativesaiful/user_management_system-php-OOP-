





$(document).ready(function () {

  /*============================
Registration, login, forget password,  form toggle 
=============================*/

  $("#register-link").click(function () {
    $("#login-box").hide();
    $("#register-box").fadeIn();
  });
  $("#login-link").click(function () {
    $("#login-box").fadeIn();
    $("#register-box").hide();
  });
  $("#forgot-link").click(function () {
    $("#login-box").hide();
    $("#forgot-box").fadeIn();
  });
  $("#back-link").click(function () {
    $("#login-box").fadeIn();
    $("#forgot-box").hide();
  });


  /*============================
  Registration form validation and ajax request
  ==============================*/

$('#register-btn').click(function (e) {
  if($('#register-form')[0].checkValidity(e) ){
    e.preventDefault();
    $('#register-btn').val('Please wait...');

    if($('#rpassword').val() != $('#cpassword').val()){
      $('#register-btn').val('Register');
      $('#rpassword').css('border-color', 'red');
      $('#cpassword').css('border-color', 'red');
      $('#passError').text('Password does not match');
      alert ('Password does not match');
    }else{
      $('#passError').text('');

      $.ajax({
        type: "post",
        url: "php/action.php",
        data: $('#register-form').serialize()+"&action=register",

        success: function (response) {
          $('#register-btn').val('Register');
          if(response == 'registered'){
            window.location = "home.php";
          }else{
       
           $('#regAlert').html(response);
          }
        }
      });
    }

  }
});




  /*============================
  Login ajax request
  ==============================*/
$('#login-btn').click(function (e) {
  if($('#login-form')[0].checkValidity(e) ){ 
    e.preventDefault();

    $('#login-btn').val('Please wait...');
  
    $.ajax({
      type: "post",
      url: "php/action.php",
      data: $('#login-form').serialize()+"&action=login",
      success: function (response) {
        $('#login-btn').val('Sign In');
        // console.log(response);
        if(response == 'loggedin'){
          window.location = "home.php";
        }else{
          $('#loginAlert').html(response);
        }
  
      }
    });
  }


});








});