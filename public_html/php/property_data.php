<?php

// This page adds new property info to the database

    session_start();
    if(!isset($_SESSION['userType']) || $_SESSION['userType']!= 'owner'){
        $_SESSION['msg'] = 'You are not signed in as an owner';
        header('Location: http://localhost/SOEN287_assignment4/public_html/index.php');
        
    }
    else{
    // print_r($_POST);
     $post_data = array();
     foreach ($_POST as $key => $value) {
         $post_data[$key] = $value;
     }

     $username = $_SESSION['username'];
     $db = mysqli_connect('localhost', 'root', '', 'rental_7262442');
         if(mysqli_connect_errno()){
            echo mysqli_connect_error();
          exit();
         }

     $table_info = mysqli_fetch_fields(mysqli_query($db, "SELECT * FROM properties LIMIT 1"));
     $fields = array();
     foreach ($table_info as $val) {
         $fields[] = $val->name;    
     }
     print_r($fields);
     $insert = 'username';
     $values = "'$username'";
     foreach ($post_data as $key => $value) {
         for($i = 0; $i < count($fields); $i++) {
             if($key === $fields[$i]){
                 $insert .= ", $key";
                 $values .= ", '$value'";
             }
         }
     }
     $entry_query = "INSERT INTO properties ($insert) VALUES ($values)";
     //echo $entry_query;
     mysqli_query($db, $entry_query);
     header('Location: http://localhost/SOEN287_assignment4/public_html/php/personal_page.php');
    }
?>