<?php
//Includes the file for checking username and password
include("loginserv.php");

//Includes file for adding new user
include("register.php");
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="./css/login.css">
    
    <body>
      
    <h2>Enter Your Credentials And Start Eating</h2>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form action="#" method="POST">
          <h1>Create Account</h1>
          <input type="text" id="newuser" name="newuser" placeholder="Name" />
          <input type="email" id="newemail" name="newemail" placeholder="Email" />
          <input type="password" id="newpass" name="newpass" placeholder="Password" />
          <button type="submit" name="register">Sign Up</button>
          <button style="margin: 15px;"> <a href="./index.php" style="color: wheat;">Go Back!</a></button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form action="#" method="POST">
          <h1>Sign in</h1>
          <input type="username" id="user" name="user" placeholder="Username" />
          <input type="password" id="pass" name="pass" placeholder="Password" />
          <a href="#">Forgot your password?</a>
          <button type="submit" name="submit">Sign In</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h2>Hey! Heard you are a Foodie ?</h2>
            <h2>Fill the form and start munching.</h2>
            <p>
              To keep connected with us please login with your personal info
            </p>
            <button class="ghost" id="signIn">Sign In</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello, Foodie!</h1>
            <p>Quickly Fill The Form And Start Munching.</p>
            <button class="ghost" id="signUp">Sign Up</button>
            <button style="margin: 15px;"> <a href="./index.php" style="color: wheat;">Go Back!</a></button>
          </div>
        </div>
      </div>
    </div>

  
  </body>
</html>

<script>
  const signUpButton = document.getElementById("signUp");
  const signInButton = document.getElementById("signIn");
  const container = document.getElementById("container");

  signUpButton.addEventListener("click", () => {
    container.classList.add("right-panel-active");
  });

  signInButton.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
  });
</script>
