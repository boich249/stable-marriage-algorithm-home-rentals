<?php

// This page adds newly signed up user's to the database 

    if(!isset($_POST['submit'])){
        header('Location: http://localhost/SOEN287_assignment4/public_html/index.php');
    }
    //$x = $_POST;
    //print_r($x);
    echo '<br />';
    $db = mysqli_connect('localhost', 'root', '', 'rental_7262442');
    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
        exit();
    }
    // Stores POST
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $psw1 = $_POST['psw1'];
    $psw2 = $_POST['psw2'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    
    // Checks if username is available
    $usernamecheck = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $usernamecheck);
    $row = mysqli_fetch_assoc($result);

    print_r($result);
    echo '<br />Now row:<br />';
    print_r($row);
    echo '<br />';
    
    if($row){
        echo 'User name is unavailable, please choose another';
        exit();
    }
    
    // Insert new user into database
    $entry = "INSERT INTO users (username, password, userType, fname, lname, email, phone) VALUES('$username', md5('$psw1'), '$userType', '$fname', '$lname', '$email', '$phone')";
    echo $entry;
    if(!mysqli_query($db, $entry)){
        echo 'ERROR! ABORTING';
        exit();
    }
            
    // Signs in the new user
    include_once 'sign_in.php';
    new_session($username, $db);

   
    ?>