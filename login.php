<?php require "server.php"; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bookstore Login</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>

    html {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      position: absolute;
      display: table-cell;
      background-color: #22d48a;
      background-image: linear-gradient(to right, #29242e, #22d48a);
    }

    body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }

    .registerarea {
      width: 400px;
      height: auto;
      padding-bottom: 15px;
      background-color: white;
      position: relative;
      top: 175px;
    }

    .registerarea img {
      width: 40%;
      height: auto;
    }

    .logoarea {
      width: 100%;
      background-color: #29242e;
    }

    #title {
      color: #0f0f0f;
      font-weight: lighter;
      font-family: sans-serif;
      font-size: 24px;
      margin-top: 0;
      padding-top: 10px;
      margin-bottom: 5px;
    }

    form {
      width: 80%;
      position: relative;
    }

    .input_text {
      border: 2px solid #29242e;
      width: 100%;
      height: 35px;
      font-size: 14px;
      margin-top: 5px;
      margin-bottom: 5px;
      position: relative;
      font-weight: lighter;
      text-align: left;
      padding-left: 5px;
    }

    .input_btn {
      width: 103%;
      margin-top: 5px;
      height: 35px;
      color: white;
      background-color: #29242e;
      border: 2px solid #29242e;
      outline: none;
      border-radius: 0px;
      font-size: 15px;
      font-weight: lighter;
    }

    .registerform ::placeholder {
      color: #29242e;
    }

    </style>
  </head>
  <body>
    <?php
      if(isset($_SESSION['login_error']) AND $_SESSION['login_error'] == true){
        echo "
          <p style='font-family: sans-serif; line-height: 50px; height: 50px; position: absolute; text-align: center; width: 100%; top: 0; margin: 0; color: white; background-color: #29242e;'>Invalid login credentials.</p>
        ";
        $_SESSION['login_error'] = false;
      }
     ?>
    <center>
    
    <div class="registerarea">
      <div class="logoarea" style="padding: 30px 0 30px 0;">
      <a href='index.php' style="font-size: 30px; text-decoration: none; font-family: sans-serif;"><span style="color: ghostwhite; font-size: 30px;">Book<span style="color: #22d48a;">Store</span></span></a>
      </div>
      <form class="registerform" action="index.php" method="post">
        <p id="title">Login</p>
        <input class="input_text" type="text" name="email_input" value="" placeholder="Email" required>
        <input class="input_text" type="password" name="password_input" value="" placeholder="Password" required>
        <input class="input_btn" type="submit" name="login_submit" value="Sign in" required>
      </form>
      <p style="font-family: sans-serif; font-size: 13px;">Not registered? <a href="register.php" style="font-family: sans-serif; font-size: 13px; color: #22d48a;">Create account</a></p>
    </div>
  </center>
  </body>
</html>
