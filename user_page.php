<?php  require "server.php"; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>My Library</title>
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

      #book_pg_header {
        text-align: center;

      }

      #books {
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        margin: 50px 200px;
        justify-content: center;
      }

      .book {
        display: block;
        width: 275px;
        height: auto;
        padding: 30px;
        box-shadow: 0 0 5px dimgray;
        background-color: rgb(250, 250, 250);
        align-content: center;
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
        height: 350px;
        width: auto;
        padding:auto;
        background-color: lightgrey;
        margin: auto;
      }

      .book img{
        display: block;
        height: 350px;
        width: auto;
        margin: auto;
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
        <br><br>
        <h1>Owned Books</h1>
        <div id='books'>
          <?php 
              $c_owned = $_SESSION['owned'];
              $query = "SELECT * FROM book WHERE isbn = ANY('$c_owned');";
              $result = pg_query($db, $query);
             
              while($book = pg_fetch_assoc($result)) {
                $pub_date = date('F d, Y', strtotime($book['creation_time']));
                echo "<div class='book'>
                  <!--<p><strong>ISBN:</strong> " . $book['isbn'] . "</p>  isbn-->
                  <div class='book_div'><img src='" . $book['thumbnail_src'] . "'></div>  <!--thumbnail_src--> 
                  <p><strong> " . $book['title'] . "</strong></p>  <!--title--> 
                  <!--<p><strong>descr:</strong> " . $book['descr'] . "</p>  -descr--> 
                  <p><strong>by</strong> " . substr($book['authors'], 1, -1) . "</p>  <!--authors-->
                  <p> $" . number_format($book['price'], 2, '.', ',') . "</p>  <!--price-->
                  <a class='view_btn' onclick=" . "\" open_book_viewer('" . $book['title'] . "','" . substr($book['authors'], 1, -1) . "') \"" . "><i class='material-icons' style='font-size: 16px; margin-right: 10px;'>insert_drive_file</i>View</a>
                  </div>";
              }

          ?>
        </div>

        <style>
          .view_btn {
            cursor: pointer;
          }
          #view_book {
            position: fixed;
            width: calc(100% - 50px);
            height: calc(100% - 50px);
            background-color: rgb(107, 107, 107, .75);
            backdrop-filter: blur(5px);
            top: 0;
            left: 0;
            margin-top: 50px;
            margin-left: 50px;
          }
          #book_content {
            background-color: white;
            padding:  0 20px;
            min-height: calc(100% - 200px);
            top: 50%;
            position: absolute;
            left: 50%;
            transform: translate(-50%, -50%);
            width: calc(75%);
            overflow-y: scroll;
            max-height: calc(100% - 200px);
            padding: 0 50px;
          }    
          #close_button {
            position: absolute;
            top: 20px;
            left: calc(12.5% - 50px);
            height: 40px;
            width: 100px;
            background-color: rgb(255, 67, 67);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
          }
          #book_content_title {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 0;
          }
          #book_content_authors {
            color: gray;
            font-style: italic;
          }
        </style>

        <script>
          function close_book_viewer(){
            document.getElementById('view_book').classList.remove('shown');
            document.getElementById('view_book').classList.add('hidden')
          }
          function open_book_viewer(title, authors){
            document.getElementById('view_book').classList.remove('hidden');
            document.getElementById('view_book').classList.add('shown');
            document.getElementById('book_content_title').innerText = title;
            document.getElementById('book_content_authors').innerText = "Written by " + authors;
          }
        </script>

        <div id='view_book' class='hidden'>
          <button id='close_button' onclick="close_book_viewer()">Close</button>
          <div id='book_content'>
            <p id='book_content_title'>Title</p>
            <p id='book_content_authors'>Written by Authors</p>
            <br><br>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
          </div>
        </div>

      </div>
    </div>

    </body>

</html>