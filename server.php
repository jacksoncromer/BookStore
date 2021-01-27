<?php

session_start();

$username = "";
$fname = "";
$lname = "";
$password = "";
$email = "";
$result = false;
$profile_pic = 'profile_pics/default.jpg';
$owned = array();

$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin") OR die();

if (isset($_POST['register_submit'])){
  if (!$result) {
    $username = $_POST['username_input'];
    $fname = $_POST['fname_input'];
    $lname = $_POST['lname_input'];
    $password = md5($_POST['password_input']);
    $email = $_POST['email_input'];
    $query = "SELECT * from users WHERE username = '$username' OR email = '$email' LIMIT 1";
    $result = pg_query($db, $query);
    $user = pg_fetch_assoc($result);

    if (!$user) {
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      $_SESSION['email'] = $email;
      $_SESSION['firstname'] = $fname;
      $_SESSION['lastname'] = $lname;
      $_SESSION['is_admin'] = 'f';
      if (!isset($_POST['sub_input'])){
        $sub_bool = 0;
      }
      else {
        $sub_bool = 1;
      }
      $defaultAvatar = 'profile_pics/default.png';
      $query = "INSERT INTO users (email, firstname, lastname, username, pwd, avatar_path, is_admin, owned) VALUES ('$email', '$fname', '$lname', '$username', '$password', 'profile_pics/default.png', false, '{}')";
      $result = pg_query($db, $query);
      $_SESSION['reg_error'] = false;

      //
      $target_dir = "profile_pics/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $query = "UPDATE Users SET avatar_path = '$target_file' WHERE username = '$username';";
          $profile_pic = $target_file;
          $result_upload = pg_query($db, $query);
        }
      }
      //

      $query = "select * from users where username = '$username' limit 1;";
      $result = pg_query($db, $query);
      $user = pg_fetch_assoc($result);

      $_SESSION['profile_pic'] = $user['avatar_path'];
      $_SESSION['owned'] = $user['owned'];

      if (!$result){
        $username = "";
        $fname = "";
        $lname = "";
        $email = "";
        $password = "";
        $profile_pic = '';
        $_SESSION['reg_error'] = true;
        header("Location:register.php");
      }
    }
    else {
      $_SESSION['reg_error'] = true;
      header("Location:register.php");
    }
  }
  else {
    $_SESSION['reg_error'] = true;
    header("Location:register.php");
  }
}

if (isset($_POST['login_submit'])){
  $_SESSION['login_error'] = false;
  $password = md5($_POST['password_input']);
  $email = $_POST['email_input'];
  $query = "SELECT * FROM users WHERE pwd = '$password' AND email = '$email' LIMIT 1";
  $result = pg_query($db, $query);
  $user = pg_fetch_assoc($result);
  if (!$user){
    $_SESSION['login_error'] = true;
    header("Location:login.php");
  }
  else {
    $_SESSION['login_error'] = false;
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['lastname'] = $user['lastname'];
    $_SESSION['profile_pic'] = $user['avatar_path'];
    $_SESSION['owned'] = $user['owned'];
    $_SESSION['is_admin'] = $user['is_admin'];
  }
}

if(isset($_POST['logout_submit'])){
  session_destroy();
  header("Location:index.php");
}


function postgres_to_php_array($postgresArray){
  if($postgresArray == "{}"){
    return array();
  }
  $postgresStr = trim($postgresArray,'{}');
  $elmts = explode(',',$postgresStr);
  return $elmts;
}

// PG SQL ARRAY FUNCTIONS
// NOTE: pgSQL arrays are strings! ex. an array that looks like {1,2,3} is actually stored as "{1,2,3}"
// array_append(array_col_name, 'value')
// array_remove(array_col_name, 'value')

 ?>

 
