<?php

// This page adds a tenant's rental preferences to the database

    session_start();
    if(!isset($_SESSION['userType']) || $_SESSION['userType']!= 'tenant'){
        $_SESSION['msg'] = 'You are not signed in as a tenant';
        header('Location: http://localhost/SOEN287_assignment4/public_html/index.php');    
    }
    else{
     print_r($_POST);
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

     $table_info = mysqli_fetch_fields(mysqli_query($db, "SELECT * FROM rental_preferences LIMIT 1"));
     $fields = array();
     foreach ($table_info as $val) {
         $fields[] = $val->name;    
     }
     print_r($fields);
     $insert = 'username';
     $values = "'$username'";
     $set = '';
     foreach ($post_data as $key => $value) {
         for($i = 0; $i < count($fields); $i++) {
             if($key === $fields[$i]){
                 $insert .= ", $key";
                 $values .= ", '$value'";
                 if($set != ''){
                     $set .= ', ';
                 }
                 $set .= "$key = '$value'";
                
             }
         }
     }
     $preferences_query = "SELECT username FROM rental_preferences WHERE username = '$username'";
     $preferences_query_result = mysqli_query($db, $preferences_query);
     $preferences = mysqli_fetch_assoc($preferences_query_result);
     $add_query = "INSERT INTO rental_preferences ($insert) VALUES ($values)";
     $update_query = "UPDATE `rental_preferences` SET $set WHERE username = '$username'";
     if ($preferences){
         mysqli_query($db, $update_query);
         echo $update_query;
     }
     else{
         mysqli_query($db, $add_query);
     }
     
     /*$entry_query = "INSERT INTO rental_preferences ($insert) VALUES ($values)";
     echo $entry_query;
     mysqli_query($db, $entry_query);*/
    header('Location: http://localhost/SOEN287_assignment4/public_html/php/personal_page.php');
    }
?>