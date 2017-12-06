
var username_min = 6;
var username_error = "needs to be at least 6 characters";
var email_error = "invalid email address";
var password_min = 8;
var password_error = "passwords are not the same";

var validated = new Object();
//set an observer to check on the number of validated inputs
function observeValidation(){
  requestAnimationFrame(observeValidation);
  if(validated.email && validated.username && validated.password){
    $('button[type="submit"]').removeAttr('disabled');
  }
  else{
    $('button[type="submit"]').attr('disabled','');
  }
}
observeValidation();

$(document).ready(
  function(){
    //add listener for username input to check as user types
    $("#username").on("input", function(event){
      let username = $(event.target).val();
      if( checkUserName(username) == false ){
        setFormError( $('[data-group="username"]') );
        displayError($('[data-error="username"]'), username_error);
        validated.username = false;
      }
      else{
        removeFormError( $('[data-group="username"]') );
        setFormSuccess( $('[data-group="username"]') );
        displayError($('[data-error="username"]'), '');
        validated.username = true;
      }
    });
    //add listener for email input to check as user types
    $("#email").on("input", function(event){
      let email = $(event.target).val();
      if( checkEmail(email) == false){
        setFormError( $('[data-group="email"]') );
        displayError($('[data-error="email"]'), email_error);
        validated.email = false;
      }
      else{
        removeFormError( $('[data-group="email"]') );
        setFormSuccess( $('[data-group="email"]') );
        displayError($('[data-error="email"]'), '');
        validated.email = true;
      }
    });
    //add listener for password input to check as user types
    $('[type="password"]').on("input", function(event){
      let pwd_inputs = $('[type="password"]');
      let password1 = $(pwd_inputs[0]).val();
      let password2 = $(pwd_inputs[1]).val();
      
      if( checkPasswords(password1,password2) == false){
        setFormError( $('[data-group="password"]') );
        displayError($('[data-error="password"]'), password_error);
        validated.password = false;
      }
      else{
        removeFormError( $('[data-group="password"]') );
        setFormSuccess( $('[data-group="password"]') );
        displayError($('[data-error="password"]'), '');
        validated.password = true;
      }
    });
    //add listener for register button
    $('button[name="register"]').on("click",
      function(event){
        event.preventDefault();
        //create data object to send for registration
        let dataobj = new Object();
        dataobj.username = $("#username").val();
        dataobj.email = $("#email").val();
        dataobj.password1 = $("#password1").val();
        dataobj.password2 = $("#password2").val();
        dataobj.action = "register";
        //make ajax request
        $.ajax({
          type: 'post',
          url: 'ajax/ajaxregister.php',
          data: dataobj,
          dataType: 'json',
          encode: true
        })
        .done( (response) => {
          console.log(response);
          if(response.success == true){
            //registration successful
            displayAlert("success","registration successful");
          }
          else{
            displayAlert("warning","registration unsuccessful" + " " + response.errors);
          }
        });
      }
    );
  }
);

function displayAlert(type,message){
  $(".alert").remove();
  let template = $("#register-template").html().trim();
  let clone = $(template);
  //add message
  $(clone).find('.message').text(message);
  
  if(type == "success"){
    $(clone).addClass('alert-success');
  }
  else{
    $(clone).addClass('alert-danger');
  }
  $('#registration').append(clone);
}

function setFormError(elm){
  $(elm).removeClass("has-success");
  $(elm).addClass("has-error");
}
function removeFormError(elm){
  $(elm).removeClass("has-error");
}
function setFormSuccess(elm){
  $(elm).addClass("has-success");
}
function displayError(elm,message){
  //display message
  $(elm).text(message);
}

//checkers
function checkUserName(username){
  let strlength = username.length;
  if( strlength >= username_min && strlength < 16){
    let dataobj = new Object();
    dataobj.action = "checkuser";
    dataobj.username = username;
    //check if username exists
    $.ajax({
      type: 'post',
      url: 'ajax/ajaxregister.php',
      data: dataobj,
      dataType: 'json',
      encode: true
    })
    .done(function(response){
      if(response.success == false){
        setFormError( $('[data-group="username"]') );
        displayError($('[data-error="username"]'), 'username already used');
        //user exists
        
        validated.username = false;
        return false;
      }
      else{
        //user exists
        return true;
        validated.username = true;
      }
    });
  }
  else{
    return false;
  }
}
function checkEmail(email){
  let strlength = email.length;
  let count = 0;
  let charpos = new Array();
  //check if email contains '@' and at which position
  for(let i=0; i<strlength; i++){
    if(email.charAt(i) == '@'){
      count++;
      charpos.push(i);
    }
  }
  //if email address contains only 1 '@' symbol and it is not at the beginning or end
  if( count == 1 && charpos[0] > 0 && charpos[0] < strlength-1 ){
    //if email meets requirements, check if it is already used
    //check if username exists
    let dataobj = new Object();
    dataobj.action = "checkemail";
    dataobj.email = email;
    $.ajax({
      type: 'post',
      url: 'ajax/ajaxregister.php',
      data: dataobj,
      dataType: 'json',
      encode: true
    })
    .done(function(response){
      // console.log(response);
      if(response.success == false){
        setFormError( $('[data-group="email"]') );
        displayError($('[data-error="email"]'), 'email already used');
        //email exists
        
        validated.email = false;
        return false;
      }
      else{
        validated.email = true;
        return true;
      }
    });
    
  }
  else{
    return false;
  }
}

function checkPasswords(pass1,pass2){
  if(pass1 == pass2 && pass1.length >= password_min && pass2.length >= password_min){
    return true;
  }
  else{
    return false;
  }
}