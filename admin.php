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
    <!-- <script src="scripts.js"></script> -->
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
            font-family: sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
            margin-top: 0;
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
        <h1 style='width: 60%; margin: 5px auto; padding: 0; text-align:center'>Administrator</h1>
        <br></br>


        <!-- START ADD BOOK SECTION -->
        <h1 style='width: 60%; margin: 5px auto; padding: 0;'>Add Book</h1>
        <div class='settings_sect bor_black'>
          <h3>Enter Book Details</h3>
          <form class="user_settings_form" method="post" enctype="multipart/form-data">
            <input class='settings_input_bar' type="text" name="admin_title_input" value="" placeholder="Title" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_author_input" value="" placeholder="Author/s" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_description_input" value="" placeholder="Description" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_isbn_input" value="" placeholder="ISBN" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_price_input" value="" placeholder="Price" required>
            <br></br> 
            <p>Book Image</p>        
            <input class='custom-file-input' style='float: left;' type="file" name="fileToUpload" id="fileToUpload">
            <br>
            <br>
            <input class='settings_btn' type="submit" name="admin_addbook_submit" value="Save" required>
          </form>
          <?php
            if (isset($_POST['admin_addbook_submit'])){
              
              $n_title = $_POST['admin_title_input'];
              $n_author = $_POST['admin_author_input'];
              $begin = '{';
              $end = '}';
              $n_author = $begin . $n_author . $end;
              $n_description = $_POST['admin_description_input'];
              $n_isbn = $_POST['admin_isbn_input'];
              $n_price = $_POST['admin_price_input'];

              $target_dir = "book_images/";
              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  $result_upload = pg_query($db, $query);
                  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                }
                else {
                  $target_file = 'book_images/default.png';
                }
              } else {
                $target_file = 'book_images/default.png';
              }
              
              $query = "INSERT INTO Book (isbn, title, descr, authors, price, thumbnail_src) VALUES ('$n_isbn', '$n_title', '$n_description', '$n_author', $n_price, '$target_file')";
              $result = pg_query($db, $query);
              
              echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>       
        </div>
        <br></br>
        <!-- END ADD BOOK SECTION -->

        
        <!-- START DELETE BOOK SECTION
        <h1 style='color: red; width: 60%; margin: 5px auto; padding: 0;'>Danger Zone</h1>
        <div class='settings_sect bor_red'>
          <h3 style='color: red;'>Delete Book</h3>
          <p style='color: rgb(141, 141, 141);'>This action is final and irreversable! You will not be able to recover any data for this book.</p>
          <form class="user_settings_form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to delete this Book?');">
            <input class='settings_input_bar' type="text" name="admin_delete_book_input" value="" placeholder="ISBN" required>
            <br></br>
            <input style='background-color: #ff3b3b; border: none;' class='settings_btn' type="submit" name="deletebook_submit" value="Delete" required>
          </form>-->
          <?php
            if (isset($_POST['deletebook_submit'])){
              $isbn = $_POST['admin_delete_book_input'];
              
              $query = "DELETE FROM book WHERE isbn='$isbn';";
              $result = pg_query($db, $query);
              
              
              echo "<script>window.location.replace('index.php');</script>";
            }
          ?>
        <!--</div>-->  
        <!-- END DELETE BOOK SECTION -->
        

        <!-- START ADD USER SECTION -->
        <h1 style='width: 60%; margin: 5px auto; padding: 0;'>Add User</h1>
        <div class='settings_sect bor_black'>
        <h3>Enter User Details</h3>
        <form class="user_settings_form" method="post" enctype="multipart/form-data">
            <input class='settings_input_bar' type="text" name="admin_fname_input" value="" placeholder="First Name" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_lname_input" value="" placeholder="Last Name" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_username_input" value="" placeholder="Username" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_password_input" value="" placeholder="Password" required>
            <br></br>
            <input class='settings_input_bar' type="text" name="admin_email_input" value="" placeholder="Email" required>
            <br></br>
            <input  type="checkbox" name="admin_isAdmin_input">
            <label for="admin_isAdmin__input">Admin</label>
            <br></br>
            <p>Avatar</p>
            <input class='custom-file-input' style='float: left;' type="file" name="fileToUpload" id="fileToUpload">
            <br></br>
            <input class='settings_btn' type="submit" name="admin_adduser_submit" value="Save" required>
          </form>
          <?php
            if (isset($_POST['admin_adduser_submit'])){
              $n_fname = $_POST['admin_fname_input'];
              $n_lname = $_POST['admin_lname_input'];
              $n_username = $_POST['admin_username_input'];
              $n_password= $_POST['admin_password_input'];
              $n_password = md5($n_password);
              $n_email = $_POST['admin_email_input'];
              $is_admin = "false";
              if(!empty($_POST['admin_isAdmin_input']))
              {
                $is_admin = true;
              }
              
              $target_dir = "profile_pics/";
              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                  $result_upload = pg_query($db, $query);
                }
                else {
                  $target_file = 'profile_pics/default.png';
                }
              } else {
                $target_file = 'profile_pics/default.png';
              }
              $query = "INSERT INTO users (email, firstname, lastname, username, pwd, avatar_path, is_admin, owned) VALUES ('$n_email', '$n_fname', '$n_lname', '$n_username', '$n_password','$target_file','$is_admin','{}')";
              $result = pg_query($db, $query);
              //echo "<script>window.location.reload();</script>";
            }
          ?>
          <br></br>       
        </div>
        <br></br>
        <!-- END ADD USER SECTION -->

        <!-- START TRANSACTIONS SECTION -->
        <h1 style='width: 60%; margin: 5px auto; padding: 0;'>View Site Transactions</h1>
        <div class='settings_sect bor_black'>
          <h3>Transactions</h3>
          <form class="user_settings_form" method="post">
            <div name='scrollList;' style="border: 1px solid black; width:100%;height:500px;line-height:3em;overflow:scroll;padding:5px;">
                <?php
          
                  $query = "SELECT * FROM PurchaseHistory";
                  $result = pg_query($db, $query);

                  echo "<table>";
                  echo "<th>ID</th><th>Username</th><th>ISBN</th><th>Card Number</th><th>Price</th><th>Time</th>";
                  while($row = pg_fetch_assoc($result)){
                    echo "<tr>
                    <td>" . $row['t_id'] . "</td>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['isbn'] . "</td>
                    <td>" . $row['cardnum'] . "</td>
                    <td>" . $row['price_at_time'] . "</td>
                    <td>" . $row['creation_time'] . "</td>
                    </tr>";
                    
                  } 
                  echo "</table>";
            
                ?>
            </div>
          </form>
          <br></br>       
        </div>
        <!-- END TRANSACTIONS SECTION -->

        <br><br>            
        <!-- START DELETE USER SECTION -->
        <h1 style='color: red; width: 60%; margin: 5px auto; padding: 0;'>Danger Zone</h1>
        <div class='settings_sect bor_red'>
          <h3 style='color: red;'>Delete User Account</h3>
          <p style='color: rgb(141, 141, 141);'>This action is final and irreversable! The user will lose all data including their owned books by completing this action.</p>
          <form class="user_settings_form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to delete this account? All data for this user will be lost.');">
            <input class='settings_input_bar' type="text" name="admin_delete_account_input" value="" placeholder="Username" required>
            <br></br>
            <input style='background-color: #ff3b3b; border: none;' class='settings_btn' type="submit" name="deleteaccount_submit" value="Delete" required>
          </form>
          <br>
          <h3 style='color: red;'>Delete Book</h3>
          <p style='color: rgb(141, 141, 141);'>This action is final and irreversable! You will not be able to recover any data for this book.</p>
          <form class="user_settings_form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to delete this Book?');">
            <input class='settings_input_bar' type="text" name="admin_delete_book_input" value="" placeholder="ISBN" required>
            <br></br>
            <input style='background-color: #ff3b3b; border: none;' class='settings_btn' type="submit" name="deletebook_submit" value="Delete" required>
          </form>
          <br>
          <?php
            if (isset($_POST['deleteaccount_submit'])){
              $username = $_POST['admin_delete_account_input'];
              
              $query = "DELETE FROM Users WHERE username='$username';";
              $result = pg_query($db, $query);

              $query = "DELETE FROM SavedCreditCards WHERE username='$username';";
              $result = pg_query($db, $query);

      
              echo "<script>window.location.reload();</script>";;
            }
          ?>
          
        </div>
        <br></br>
        <!-- END DELETE USER SECTION -->

        

        

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
