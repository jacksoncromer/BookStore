
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

      h1{
        text-align: center;
      }
      h2{
        text-align: center;
        font-weight: 400;
      }
      h3{
        text-align: center;
      }

      li{
        display: inline;
        align-content: center;
      }
      ul{
        padding-inline-start: 0px;
      }
      .content input[type=text] {
        display: block;
        align-content: center;
        padding: 6px 200px;
        margin: 25px auto;
        outline: none;
        border: solid;
        border-radius: 100px;
        font-size: 17px;
        text-align: center;
      }
      .func_container{
        display: flex;
        justify-content: center;
        margin: auto 250px;
        
      }

      .func_container p {
        text-align: center;
      }
      .func_container ul{
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        
        padding-inline-start: ;
        margin: 30px 0px;
      }


      #book_pg_header {
        text-align: center;

      }

      #books {
        /*
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        margin: 50px 200px;
        */
        display: flex;
        flex-wrap: wrap;
        margin: 50px auto;
        max-width: 1065px;
        width: fit-content;
        justify-content: center;
      }

      .book {
        display: block;
        width: 275px;
        height: auto;
        padding: 30px;
        box-shadow: 0 0 5px dimgray;
        background-color: rgb(250, 250, 250);
        align-content: left;
        margin: 10px 10px;

      }

      .book a{
        width: 100px;
        height: 50px;
        padding: 10px;
        background-color: #22d48a;
        color: white;
        border-radius: 3px;
      }

      .book_div{
        display: block;
        height: 300px;
        width: 100%;
        object-fit: contain;
        padding:auto;
        background-color: lightgrey;
        margin: auto;
      }

      .book img{
        display: block;
        height: 300px;
        width: 100%;
        margin: auto;
        object-fit: contain;
      }

      #pg_nums{
        display: flex;
        justify-content: center;
      }

      #pg_nums a{
        display: inline-block;
        margin: 25px 15px;
      }
      .pg_num{
        color: #22d48a;
      }
      .pg_num_selected{
        color: #grey;
      }
      #bottom-link-buttons-disabled{
        color: dimgray;
        background-color: lightgray;
        pointer-events: none;
      }

      /*
       <div id='book_search'>
        <input type="text" placeholder="Search..">
      </div>
      */
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

    <?php
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
    

    if (isset($_SESSION['username'])){
      if($_SESSION['is_admin'] == 'f'){
        $btn_login_register_btm = 'bottom-link-buttons-disabled';
        $btn_admin_btm = 'bottom-link-buttons-disabled';
      }
      else {
        $btn_login_register_btm = 'bottom-link-buttons-disabled';
        
      }
    }
    else{
        $btn_settings_btm = 'bottom-link-buttons-disabled';
        $btn_admin_btm = 'bottom-link-buttons-disabled';
    }


    
    if (isset($_GET["search_text"])) {
      $search_text = $_GET["search_text"];
      $search_notification = $search_text;
      if (isset($_GET["page"])) { 
        $page  = $_GET["page"]; 
      } 
      else { 
        $page=1; 
      }; 

      $records = 15; // change here for records per page

      $start_from = ($page-1) * $records;

      $qry = pg_query($db,"SELECT count(*) AS total FROM Book WHERE title ILIKE '%$search_text%' OR isbn ILIKE '%$search_text%' OR authors ILIKE '%$search_text%'"); 
      $row_sql = pg_fetch_row($qry); 
      $total_records = $row_sql[0]; 
      $total_pages = ceil($total_records / $records);

      $select = pg_query($db,"SELECT * FROM Book WHERE title ILIKE '%$search_text%' OR isbn ILIKE '%$search_text%' OR authors ILIKE '%$search_text%' LIMIT $records offset $start_from");        
    }
    else{
      $search_notification=null;
      if (isset($_GET["page"])) { 
        $page  = $_GET["page"]; 
      } 
      else { 
        $page=1; 
      }; 

      $records = 15; // change here for records per page

      $start_from = ($page-1) * $records;

      $qry = pg_query($db,"SELECT count(*) AS total FROM Book"); 
      $row_sql = pg_fetch_row($qry); 
      $total_records = $row_sql[0]; 
      $total_pages = ceil($total_records / $records);

      $select = pg_query($db,"SELECT * FROM Book LIMIT $records offset $start_from");
    }
    ?>
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
        
        <div id='home_top_banner'>
          <h1 id='banner_title'>Online Bookstore</h1>
          <img src="https://www.nerdwallet.com/assets/blog/wp-content/uploads/2016/01/how-students-miss-out-on-billions-free-fafsa-college-aid-story.jpg" alt='homepage banner'></img>
        </div>

        
        <h1 id='book_pg_header'>Welcome to the Book Store</h1>
        
        
              
        <form style='display: flex; border-radius: 100px; justify-content: center;' name="book_search" action="<?php if ( isset( $_GET['search_text'] ) )?>" method="get">
          <input type="text" name="search_text" placeholder="ISBN, Title, or Author">
        </form>

        <?php
        if($search_notification!=null){
          echo "<h2>Found <span style='color: #22d48a'>" . $total_records . "</span> results for: <strong style='color: #22d48a;'>'" . $search_notification . "'</strong></h2>";
        }
         ?>
        
        <div id='books'>
          

          <?php 
            /*$query = "SELECT * FROM Book LIMIT 20, '$startIndex'";
            $result = pg_query($db, $query);*/


            while($book = pg_fetch_assoc($select)) {
              $pub_date = date('F d, Y', strtotime($book['creation_time']));
              echo "<div class='book'>
              <!--<p><strong>ISBN:</strong> " . $book['isbn'] . "</p>  isbn-->
              <div class='book_div'><img src='" . $book['thumbnail_src'] . "'></div>  <!--thumbnail_src--> 
              <p><strong> " . $book['title'] . "</strong></p>  <!--title--> 
              <!--<p><strong>descr:</strong> " . $book['descr'] . "</p>  -descr--> 
              <p><strong>by</strong> " . substr($book['authors'], 1, -1) . "</p>  <!--authors-->
              <p> $" . number_format($book['price'], 2, '.', ',') . "</p>  <!--price--> 

              <!--<p>Post Date: " . $pub_date  . "</p>  creation_time--> 
              <a href='book_info.php?isbn=" . $book['isbn'] . "'>Click for details</button></a>
              </div>";
            }

            ?>
        </div>

        
        <div id='pg_nums'>
          <?php
          for ($i=1; $i<=$total_pages; $i++) { 
            if ($i==$page){echo "<a href='index.php?page=".$i."' class='pg_num_selected'>".$i."</a>&nbsp;&nbsp;";}
            else{echo "<a href='index.php?page=".$i."' class='pg_num'>".$i."</a>&nbsp;&nbsp;";} 
          }
          ?>
        </div>
        
      </div>

        <br></br>
        <h1>Site Functionalities</h1>

        <div class='func_container'>
          <div id='funcs'>

            <div class='func'>
              <i class="material-icons">person</i>
              <?php
                if(isset($_SESSION['username'])){
                  echo "<p class='func_d' style='width: 100%; text-align: center;'>Logged in as <span style='color: #22d48a;'>" . $_SESSION['username'] . "</span></p>";
                }
                else {
                  echo "<p class='func_d' style='width: 100%; text-align: center;'>You are not signed in.</p>";
                }
              ?>
              <p class='func_t'>Account Creation and Customization</p>
              <p class='func_d'>Site users can create an account, login to their account, and edit their personal information. The user must have a registered account to purchase books. Not all users are admins and therefore have reduced permissions. A user can delete their own account.</p>
              <p class='func_d'>Users can also see their previously purchased books.</p>
              <p class='func_l'>Links:</p>
              <ul>
                <li><a id='<?php echo $btn_login_register_btm ?>' href='login.php'>Login</a></li>
                <li><a id='<?php echo $btn_login_register_btm ?>' href='register.php'>Register</a></li>
                <li><a id='<?php echo $btn_settings_btm ?>' href='user_settings.php'>Settings</a></li>
              </ul>
            </div>
    
            <div class='func'>
              <i class="material-icons">book</i>
              <p class='func_t'>Book Store</p>
              <p class='func_d'>
                This is where users can use a search function to buy books or browse through our selection manually. You can search for books by there isbn, title, or author. At this time our store contains mainly educational books. Thank you and happy reading!
              </p>
              <p class='func_l'>Links:</p>
              <ul>
                <li><a href=''>Shop</a></li>
              </ul>
            </div>

            <div class='func'>
              <i class="material-icons">dashboard</i>
              <p class='func_t'>Admin Dasboard</p>
              <p class='func_d'>This is where registered admins make edits to the software system. They can do actions such as: delete any user account, add books to the database, and edit their own account. They can also give admin permissions to a regular user account.</p>
              <p class='func_d'>Admins can do everything a normal account can do, plus more!</p>
              <p class='func_l'>Links:</p>
              <ul>
                <li><a href='admin.php' id='<?php echo $btn_admin_btm ?>'>Admin Panel</a></li>
              </ul>
            </div>
          </div> 
        </div>
        <br></br>


        <h3>Developers</h3>
        <div class='func_container'>
          
          <p class='dev'>Brian Bruns</p>
          <p class='dev'>Tristen Arnold</p>
          <p class='dev'>Jackson Cromer</p>
          <p class='dev'>Dan Huffstetler</p>
          <p class='dev'>Sonny Huynh</p>
        </div>
        <strong><h3>About The Site</h3></strong>
        <div class='func_container'>
          
          <p><!--This is where a short description will go. This will provide users, students and course instructors to navigate to pgSQL setup instructions as well as (potentially) our ER Diagram and some buttons to bring them to the content. Another idea: buttons to auto-scroll the site user to the location on the homepage where their desired instructions/content can be found.--> 
          Thank you for visiting our book store. This is a site where students can find educational books at a fair price and access those books through the site anytime they need them without the hassle of lugging around a physical book. Happy reading!
          </p>
        </div>
        <h1>Development Technologies</h1>

        <br></br>

        <div id='techs'>
          <center>
            <img src='https://www.kindpng.com/picc/m/11-118738_php-logo-png-circle-transparent-png.png'></img>
            <img src='https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png'></img>
            <img src='https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582748_1280.png'></img>
            <img src='https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582747_1280.png'></img>
            <img src='https://p1.hiclipart.com/preview/951/574/485/react-logo-javascript-redux-vuejs-angular-angularjs-expressjs-front-and-back-ends-png-clipart.jpg'></img>
            <img src='https://seeklogo.com/images/P/postgre-sql-logo-600AD1A66B-seeklogo.com.png'></img>
          </center>
          <br></br><br></br>

        </div>
        <!--
        <h1>PHP Tests</h1>

        <p>----------------ADD FRIEND DEMO----------------</p>
        <form method="POST">
          <input type='text' name='friend_name' placeholder="Friend name..."></input>
          <button type="submit" name='test' <?php if(!isset($_SESSION['username'])){echo "disabled";} ?>><?php if(!isset($_SESSION['username'])){echo "Login to test";}else {echo "Add Friend";} ?></button>
        </form>

        <?php
          if(isset($_SESSION['username'])){
            echo "<p>" . $_SESSION['username'] . "'s friends: </p>";
            $query = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
            $result = pg_query($db, $query);
            $user = pg_fetch_assoc($result);
            $array = postgres_to_php_array($user['friends']);
            if(sizeof($array) != 0){
              foreach ($array as $x){
                $query = "SELECT * FROM users WHERE username=" . "'" . $x . "'";
                $result = pg_query($db, $query);
                while($friend = pg_fetch_assoc($result)){
                  echo "<p>" . $friend['email'] . " " . $friend['firstname'] . " " . $friend['lastname'] . "</p>";
                }
              }
            }
            
          }
        ?>
        <p>-----------------------------------------------</p>

        <p>------------Input image demo-------------</p>
        <form action="index.php" method="post" enctype="multipart/form-data">
          Select image to upload:
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Upload Image" name="upload_img">
        </form>
        <p>-----------------------------------------------</p>
        -->
      </div>

        

    </div>


    

  </body>

 

</html>
