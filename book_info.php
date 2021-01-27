<?php require "server.php"; 
    
    $isbn = $_GET['isbn'];

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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Product Page </title>
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
      #left, #middle {display: inline-block; *display: inline; vertical-align: top; margin-top: 3%; margin-left: 3%;}
      #middle {margin-right: 3%; max-width: 75%}
      #book_details_desc, #book_details_extended {margin: 3%}
      #cover_img {border: 5px solid #ddd; border-radius: 4px; width: 180px;}
      #pay_button a {width: 100px; height: 50px; padding-left: 30px; padding-right: 30px; padding-top: 10px; padding-bottom: 10px; background-color: #22d48a; color: white; border-radius: 3px; font-size: 20px}
      #inner_content {box-shadow: 0 0 5px dimgray; height: auto; width: 70%; margin-top: 50px; padding-bottom: 50px;}
      @media(max-width: 880px){
        #inner_content {
          padding: 2em;
        }
      }
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
          echo "<p id='loginbtn' onclick=''>" . $_SESSION['username'] . "</p>";
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
      <div id="inner_content" style=''>

        <div>
          <div id="left">
            <div id='book_details_thumbnail_src'>
              <img id="cover_img" src=<?php echo $thumbnail_src;?> alt='homepage banner'></img>
            </div>
          </div>

          <div id="middle">
            <div id='book_details_title'>
              <h1><?php echo $title; ?></h1>
            </div>

            <div id='book_details_authors'>
              <p> By: 
                <?php 
                  $authors_trimmed = trim($authors,'{}');
                  echo $authors_trimmed;
                ?>
              </p>
            </div>
        

            <div id='book_details_price'>
              <h3>
                $<?php echo number_format($price, 2, ".", ","); ?> 
              </h3>
              <div id="pay_button">
                <a href = <?php echo 'payment.php?isbn=' . $isbn ?>> Buy now </a>
              </div>
            </div>
          </div>
        </div>

        <div id='book_details_desc'>
          <h3>Description</h3>
          <p> <?php echo $desc; ?> </p>

        </div>

        <div id='book_details_extended'>
          <h3>Book Details</h3>
          <p> Print ISBN: <?php echo $isbn; ?> </p>
          <p> Date Added: <?php echo explode(' ', $creation_time)[0] ?> </p>
        </div>          

      </div>      

    </div>

  </body>
</html>