<?php require "server.php"; 
  $orderComplete = false;
  $isbn = $_GET['isbn'];

  // If they aren't logged in
  $savedCNum = "";
  $savedCExp = "";
  $savedCCvv = "";
  $savedCFNa = "";

  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $grabCreditInfoQuery = "SELECT * FROM savedcreditcards WHERE username = '$username';";
    $result = pg_query($db, $grabCreditInfoQuery);
    
    $SavedCC = pg_fetch_row($result);

    if ($SavedCC) {
      $savedCNum = $SavedCC[1];
      $savedCExp = $SavedCC[2];
      $savedCCvv = $SavedCC[3];
      $savedCFNa = $SavedCC[4];
    }
  } else {
    header("Location:login.php");
  }

  $query = "SELECT * FROM book WHERE isbn = '$isbn'";
  $result = pg_query($db, $query);
  $book = pg_fetch_row($result);

  if ($book[0]){
    $title = $book[1];
    $desc = $book[2];
    $authors = $book[3];
    $price = $book[4];
    $thumbnail_src = $book[5];
    $creation_time = $book[6];
  };

  if (isset($_POST['buy_submit'])){
    //Grab necessary values
    $cardNumber = $_POST['card_input'];
    $fullName = $_POST['name_input'];
    $expDate = $_POST['exp_input'];
    $cvv = $_POST['cvv_input'];

    if(!empty($_POST['saveInfo'])) {
      $removeQuery = "DELETE FROM savedcreditcards WHERE username = '$username';";
      $result = pg_query($db, $removeQuery);

      $cardQuery = "INSERT INTO savedcreditcards (cardnum, exp_d, cvv, fullname, username) VALUES ('$cardNumber', '$expDate', '$cvv', '$fullName', '$username');";
      $result = pg_query($db, $cardQuery);
    }

    $purchaseQuery = "INSERT INTO purchasehistory (username, isbn, cardnum, price_at_time) VALUES ('$username', '$isbn', '$cardNumber', '$price');";
    $result = pg_query($db, $purchaseQuery);

    $ownedQuery = "UPDATE users SET owned = array_append(owned, '$isbn') WHERE username = '$username';";
    $result = pg_query($db, $ownedQuery);

    $query = "SELECT * from users WHERE username = '$username'";
    $result = pg_query($db, $query);
    $user = pg_fetch_assoc($result);

    $_SESSION['owned'] = $user['owned'];

    $orderComplete = true;
    
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Payment Page</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <script src="scripts.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <script type="text/javascript">

      function start() {

      }

    </script>

    <style type="text/css">
      #left, #middleL, #middleR, #right {display: inline-block; *display: inline; vertical-align: middle; margin-right: 3%; margin-left: 3%; margin-top: 1%; margin-bottom: 1%;}
      #middleL {width: 50%; max-width: 50%;}
      #middleR {width: 10%; max-width: 10%; text-align: right;}

      #inner_content {box-shadow: 0 0 5px dimgray; height: auto; width: 70%; margin-top: 50px; padding-bottom: 50px;}
      @media(max-width: 880px){
        #inner_content {
          padding: 2em;
        }
      }
      #cart_item {width: 100%;}

      #pay_button a {width: 100px; height: 50px; padding-left: 30px; padding-right: 30px; padding-top: 10px; padding-bottom: 10px; background-color: #22d48a; color: white; border-radius: 3px; font-size: 20px}
      #book_thumbnail {border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 100px;}
    </style>

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
        <div id="cart_item">     
          <div id="left">
            <div>
              <img id="book_thumbnail" src=<?php echo $thumbnail_src;?> alt='homepage banner'></img>
            </div>
          </div>

          <div id="middleL">   
            <h2><?php echo $title; ?></h2>
            <p> By: 
              <?php 
                $authors_trimmed = trim($authors,'{}');
                echo $authors_trimmed; 
              ?>
            </p>
          </div>

          <div id="middleR">
              <h2> $<?php echo number_format($price, 2, ".", ","); ?> </h2>
          </div>

          <div id="right">
              <p> Quantity: 1 </p>
          </div>
        </div>

        <?php
          if ($orderComplete) {
            echo '
              <center>
                <div class="paymentarea">
                  <div class="logoarea" style="padding: 30px 0 30px 0; background-color: lightgray;">
                    <a href="index.php" style="font-size: 30px; text-decoration: none; font-family: sans-serif;"><span style="color: ghostwhite; font-size: 30px;">Book<span style="color: #22d48a;">Store</span></span></a>
                  </div>
                  <h4>
                    Thank you, the order has been completed.
                  </h4>
                  <a href="index.php">
                    Return to store
                  </a>
                </div>
              </center>
            ';
          }
          else {
          echo '
            <center>
              <div class="paymentarea">
                <div class="logoarea" style="padding: 30px 0 30px 0; background-color: lightgray;">
                  <a href="index.php" style="font-size: 30px; text-decoration: none; font-family: sans-serif;"><span style="color: ghostwhite; font-size: 30px;">Book<span style="color: #22d48a;">Store</span></span></a>
                </div>

                <form class="registerform" method="post">
                  <h2 id="title">Payment Info</h2>
                  <input class="input_text" type="text" name="name_input" placeholder="Full Name" value="'.$savedCFNa.'" required>
                  <br></br>
                  <input class="input_text" type="text" name="card_input" placeholder="Card Number" value="'.$savedCNum.'" required>
                  <br></br>
                  <input class="input_text" type="text" name="exp_input" placeholder="Expiration Date" value="'.$savedCExp.'" required>
                  <br></br>
                  <input class="input_text" type="text" name="cvv_input" placeholder="CVV" value="'.$savedCCvv.'" required>
                  <br></br>
                  <input type="submit" name="buy_submit" value="Buy" style="width: 100px; height: 25px; background-color: white; color: green; " required>
                  <span>
                    <input type="checkbox" id="saveInfo" name="saveInfo" value="Yes">
                    <label for="saveInfo">Save Card Info</label>
                  </span>
                </form>
              </div>
            </center>
          ';
          }
        ?>

      </div>

    </div>

  </body>
</html>