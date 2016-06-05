<?php

// Starts a session based on the username passed in
function new_session($username, $db){
 // Starts a session for the new user
    session_start();
    $user_info_query = "SELECT * FROM users WHERE username = '$username'";
    $user_info_result = mysqli_query($db, $user_info_query);
    $user_info = mysqli_fetch_assoc($user_info_result);
    foreach ($user_info as $key => $value){
        $_SESSION[$key] = $value;
    }
     header('Location: http://localhost/SOEN287_assignment4/public_html/php/personal_page.php');
}

// Validates username and password to sign in, then starts a session
function sign_in(){
    $username = $_POST['signInUN'];
    $password = $_POST['signInPW'];
    $db = mysqli_connect('localhost', 'root', '', 'rental_7262442');
    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
        exit();
    }
    
    $pw_check_query = "SELECT username FROM users WHERE username='$username' AND password=md5('$password')";
    $pw_check_result = mysqli_query($db, $pw_check_query);
    if(mysqli_fetch_assoc($pw_check_result)){
        new_session($username, $db);
    }else{
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['msg'] = 'Invalid User Name or password';
        header('Location: http://localhost/SOEN287_assignment4/public_html/index.php');
    }
}

// If the post comes from a sign in page, then sign in
if(isset($_POST['signInUN'])){
    sign_in();
}
?>

