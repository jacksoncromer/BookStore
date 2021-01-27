<?php  require "server.php"; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Bookstore Home</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <script src="scripts.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
      .content {
        background-color: whitesmoke;
      }
          #act_summary {
              width: 300px;
              height: auto;
              box-shadow: 0 0 5px lightgray;
              margin: 20px auto;
          }
          #summary_pic {
              width: 280px;
              height: 280px;
              border-radius: 50%;
              object-fit: cover;
              margin: 10px 10px 0 10px;
          }
          #summary_uname {
              width: 100%;
              text-align: center;
              font-weight: 100;
              font-size: 24px;
          }
          #summary_title {
              width: 290px;
              padding: 5px;
              background-color: #29242e;
              color: white;
              text-align: center;
          }
          table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
          }

          td, th {
            border: 1px solid #5cffce;
            text-align: left;
            padding: 8px;
          }
          .left_td {
            font-weight: bold;
          }

          tr:nth-child(even) {
            background-color: #5cffce;
          }

          .settings_sect {
            width: 60%;
            height: auto;
            padding: 10px 30px;
            margin: 10px;
            margin: 20px auto;
            background-color: white;
          }
          .bor_black {
            box-shadow: 0 0 5px lightgray;
          }
          .bor_red {
            box-shadow: 0 0 5px #ff3b3b;
          }

          .settings_input_bar {
            height: 40px;
            padding: 0 10px;
            border: 1px solid #949494;
            width: 75%;
          }

          .settings_btn {
            height: 42px;
            width: 100px;
            color: white;
            background-color: #22d48a;
            margin-top: 5px;
            margin-left: 0;
            border: none;
            cursor: pointer;
            border-radius: 3px;
          }

          #uname_sum {
            font-size: 20px;
            font-weight: normal;
            color: dimgray;
          }

          #fullname_sum {
            color: #949494;
            font-size: 25px;
          }

          #cc {
            padding: 15px 70px 15px 20px;
            box-shadow: 0 0 10px rgb(163, 163, 163);
            width: max-content;
            border-radius: 10px;
            background-color: rgb(30, 83, 255);
            color: white;
            font-size: 15px;
            font-weight: bolder;
          }

          .cc_title {
            color: #ffdb8c;
            text-decoration: underline;
          }

    </style>

    <script type="text/javascript">

      function start() {

      }

    </script>

    <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
    </script>

  </head>

  <body onload="start()">

    <div class="navarea" id="nav_bar">
      <div class="logo">
        <a href='index.php' style="font-size: 20px; margin-left: 10px;"><span style="color: ghostwhite; font-size: 20px;">Book<span style="color: #22d48a;">Store</span></span></a>
      </div>

      <?php
        if(isset($_SESSION['username'])){
          echo "<a id='loginbtn' href='user_page.php'>" . $_SESSION['username'] . "</a>";
          echo "<form action='index.php' method='post' style='float: right; height: 50px; line-height: 50px;'><button type='submit' name='logout_submit' style='height: 50px; background-color: none; color: ghostwhite; background-color: #24292e; padding: 0 10px 0 0px; text-decoration: underline; outline: none; border: none;cursor: pointer; line-height: 50px; border-bottom: 1px solid dimgray;'>Logout</button></form>";
          echo "<a href='user_settings.php' style='padding-right: 10px; float: right;'><i class='material-icons' style='line-height: 50px; color: ghostwhite;'>settings</i></a>";
        }
        else {
          echo "<a id='loginbtn' href='login.php'>Sign in</a>";
          echo "<a id='regbtn' href='register.php' style='text-decoration: underline;'>Register</a>";
        }
      ?>
    </div>

    <div class="leftmenu mini" id="leftMenu">
      <a href='index.php'><div class="leftmenuitem"><i class="material-icons">home</i><p class="leftdesc">Home</p></div></a>
      <?php
        if(isset($_SESSION['username'])){
          echo "<a href='user_page.php'><div class='leftmenuitem'><i class='material-icons'>book</i><p class='leftdesc'>Library</p></div></a>
                <a href='user_settings.php'><div class='leftmenuitem'><i class='material-icons'>settings</i><p class='leftdesc'>Settings</p></div></a>";
        }
        if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 't'){
          echo "<a href='admin.php'><div class='leftmenuitem'><i class='material-icons'>dashboard</i><p class='leftdesc'>Admin</p></div></a>";
        }
      ?>
    </div>

    <div class="content" id="content_area" style=''>

      <div id="inner_content">

        <br>
        <br>
        <br>

        <div id='act_sum_sect'>

          <h1 style='width: 60%; margin: 5px auto; padding: 0;'>Account Summary</h1>

          <div class='settings_sect bor_black' style='display: table'>
            <div id='act_pic_sect' style='height: 100%; width:auto; float: left; margin-right: 30px;'>
              <img id='summary_pic' src='<?php echo $_SESSION['profile_pic']; ?>' />
            </div>
            <div id='sum_cont_sect' style='height: auto; width: auto; min-width: 400px; float: left; min-height: 290px'>
              <p id='uname_sum'><span style='font-size: 15px; color: #c7c7c7; box-shadow: 0 0 3px dimgray; padding: 10px; margin-right: 20px; border-radius: 3px;'>Username</span><?php echo $_SESSION['username']; ?></p>
              <p id='uname_sum'><span style='font-size: 15px; color: #c7c7c7; box-shadow: 0 0 3px dimgray; padding: 10px; margin-right: 20px; border-radius: 3px;'>Full Name</span><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></p>
              <p id='uname_sum'><span style='font-size: 15px; color: #c7c7c7; box-shadow: 0 0 3px dimgray; padding: 10px; margin-right: 20px; border-radius: 3px;'>Email</span><?php echo $_SESSION['email']; ?></p>
              <p id='uname_sum'><span style='font-size: 15px; color: #c7c7c7; box-shadow: 0 0 3px dimgray; padding: 10px; margin-right: 20px; border-radius: 3px;'>Books</span><?php echo count(array_unique(postgres_to_php_array($_SESSION['owned']))); ?></p>
              <?php
                if($_SESSION['is_admin'] == 'f'){
                  //echo "<p>Standard User</p>";
                }
                else {
                  echo "<p style='line-height: 30px; color: rgb(126, 126, 126)'>Administrator <span class='material-icons' style='font-size: 18px; color: #008cff'>verified_user</span></p>";
                }
              ?>
              <br><br>
              <a href='user_page.php' style='color: #ffffff; padding: 10px; box-shadow: 0 0 5px rgb(167, 167, 167); background-color: #41a0ff;'>View My Library</a>
              <br><br>
            </div>
          </div>
          <br></br>

        </div>

        <!-- End of Account Summary-->

        <br></br>
        <h1 style='width: 60%; margin: 5px auto; padding: 0;'>Settings</h1>
        <div class='settings_sect bor_black'>

          <h3>Change Username</h3>
          <form class="user_settings_form" method="post">
            <input class='settings_input_bar' type="text" name="change_uname_input" value="" placeholder="New Username..." required>
            <input class='settings_btn' type="submit" name="changeuser_submit" value="Save" required>
          </form>
          <?php
            if (isset($_POST['changeuser_submit'])){
              $c_uname = $_SESSION['username'];
              $n_uname = $_POST['change_uname_input'];
              $query = "UPDATE Users set username = '$n_uname' where username = '$c_uname';";
              $result = pg_query($db, $query);
              $_SESSION['username'] = $_POST['change_uname_input'];
              echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>

          <h3>Change Email</h3>
          <form class="user_settings_form" method="post">
            <input class='settings_input_bar' type="text" name="change_email_input" value="" placeholder="New Email..." required>
            <input class='settings_btn' type="submit" name="changeemail_submit" value="Save" required>
          </form>
          <?php
            if (isset($_POST['changeemail_submit'])){
              $c_uname = $_SESSION['username'];
              $n_email = $_POST['change_email_input'];
              $query = "UPDATE Users set email = '$n_email' where username = '$c_uname';";
              $result = pg_query($db, $query);
              $_SESSION['email'] = $_POST['change_email_input'];
              echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>

          <h3>Change Password</h3>
          <form class="user_settings_form" method="post">
            <input class='settings_input_bar' type="text" name="change_password_input" value="" placeholder="New Password..." required>
            <input class='settings_btn' type="submit" name="changepassword_submit" value="Save" required>
          </form>
          <?php
            if (isset($_POST['changepassword_submit'])){
              $c_uname = $_SESSION['username'];
              $n_password = $_POST['change_password_input'];
              $n_password = md5($n_password);
              $query = "UPDATE Users set pwd = '$n_password' where username = '$c_uname';";
              $result = pg_query($db, $query);
              echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>

          <h3>Change Avatar</h3>
          <form class="user_settings_form" method="post" enctype="multipart/form-data">
            <input class='custom-file-input' style='float: left;' type="file" name="fileToUpload" id="fileToUpload">
            <br>
            <br>
            <input class='settings_btn' type="submit" name="changeavatar_submit" value="Save" required>
          </form>
          <?php
            if (isset($_POST['changeavatar_submit'])){
              $c_uname = $_SESSION['username'];

              $target_dir = "profile_pics/";
              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  $query = "UPDATE Users SET avatar_path = '$target_file' WHERE username = '$c_uname';";
                  $profile_pic = $target_file;
                  $result_upload = pg_query($db, $query);
                }
              }
              $_SESSION['profile_pic'] = $profile_pic;
              echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>       

        </div>

        <br></br>

        <h1 style='width: 60%; margin: 5px auto; padding: 0;'>Payment Method</h1>
        <div class='settings_sect bor_black'>

          <h3>Saved Credit Cart</h3>

          <?php
            $c_uname = $_SESSION['username'];
            $query = "SELECT * FROM SavedCreditCards WHERE username='$c_uname';";
            $result = pg_query($db, $query);
            $card = pg_fetch_assoc($result);
            if(!$card){
              echo "<p>You don't have a saved credit card.</p>";
            }
            else {
              echo "
              <div id='cc'>
                <p><span class='cc_title'>Card Number</span>" . " " . $card['cardnum']. "</p>
                <p><span class='cc_title'>Name on Card</span>" . " " . $card['fullname']. "</p>
                <p><span class='cc_title'>CVV</span>" . " " . $card['cvv']. "</p>
                <p><span class='cc_title'>Date</span>" . " " . $card['exp_d']. "</p>
              </div>
              ";
            }
            //echo "<script>window.location.reload();</script>";
          ?>
          
          <br></br>
          <h3>Update Card</h3>
          <form class="user_settings_form" method="post" enctype="multipart/form-data">
            <input class='settings_input_bar' type="text" name="change_cardnum_input" value="" placeholder="Card Number" required>
            <br>
            <br>
            <input class='settings_input_bar' type="text" name="change_fullname_input" value="" placeholder="Full Name" required>
            <br>
            <br>
            <input style='width: 100px; margin-bottom: 10px;' class='settings_input_bar' type="text" name="change_cvv_input" value="" placeholder="CVV" required>
            <input style='width: 130px' class='settings_input_bar' type="text" name="change_expd_input" value="" placeholder="Expiration Date" required>
            <br>
            <br>
            <input class='settings_btn' type="submit" name="changecard_submit" value="Save" required>
            <br>
          </form>
          <?php
            if (isset($_POST['changecard_submit'])){
              $username = $_SESSION['username'];
              $cardnum = $_POST['change_cardnum_input'];
              $fullname = $_POST['change_fullname_input'];
              $cvv = $_POST['change_cvv_input'];
              $expd = $_POST['change_expd_input'];

              $query = "DELETE FROM SavedCreditCards WHERE username='$username';";
              $result = pg_query($db, $query);

              $query = "insert into savedcreditcards (cvv, exp_d, fullname, username, cardnum) values ('$cvv','$expd','$fullname','$username','$cardnum');";
              $result = pg_query($db, $query);

              echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>
          <h3>Delete Saved Card</h3>
          <form class="user_settings_form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to delete your saved credit card?');"> 
            <input style='background-color: #ff3b3b; border: none;' class='settings_btn' type="submit" name="deletecard_submit" value="Delete" required>
          </form>
          <br>
          <?php
            if (isset($_POST['deletecard_submit'])){
              $username = $_SESSION['username'];
              
              $query = "DELETE FROM SavedCreditCards WHERE username='$username';";
              $result = pg_query($db, $query);

              echo "<script>window.location.reload();</script>";
            }
          ?>

        </div>

        <br></br>
        
        <h1 style='color: red; width: 60%; margin: 5px auto; padding: 0;'>Danger Zone</h1>
        <div class='settings_sect bor_red'>
          <h3 style='color: red;'>Delete Account</h3>
          <p style='color: rgb(141, 141, 141);'>This action is final and irreversable! You will lose all data including your owned books by completing this action.</p>
          <form class="user_settings_form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to delete your account and all site data?');">
            <input style='background-color: #ff3b3b; border: none;' class='settings_btn' type="submit" name="deleteaccount_submit" value="Delete" required>
          </form>
          <br>
          <?php
            if (isset($_POST['deleteaccount_submit'])){
              $username = $_SESSION['username'];
              
              $query = "DELETE FROM Users WHERE username='$username';";
              $result = pg_query($db, $query);

              $query = "DELETE FROM SavedCreditCards WHERE username='$username';";
              $result = pg_query($db, $query);

              session_destroy();
              echo "<script>window.location.replace('index.php');</script>";
            }
          ?>
        </div>

        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>

      </div>

    </div>

  </body>

</html>