<?php

// This page adds an owners tenant selection criteria to the database

    session_start();
    if(!isset($_SESSION['userType']) || $_SESSION['userType']!= 'owner'){
        $_SESSION['msg'] = 'You are not signed in as an owner';
        header('Location: http://localhost/SOEN287_assignment4/public_html/index.php');
        
    }
    else{
        //print_r($_POST);
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
        if(!isset($specPro)){
            $specPro = "N/A";
        }
        if(!isset($specNat)){
            $specNat = "N/A";
        }

        $username = $_SESSION['username'];
        $db = mysqli_connect('localhost', 'root', '', 'rental_7262442');
        if(mysqli_connect_errno()){
            echo mysqli_connect_error();
            exit();
        }

        $profile_query = "SELECT username FROM owner_selection WHERE username = '$username'";
        $profile_query_result = mysqli_query($db, $profile_query);
        $profile = mysqli_fetch_assoc($profile_query_result);
        $add_query = "INSERT INTO `owner_selection`(`username`, `gender`, `ilevel`, `pets`, `smoke`, `nat`, `specNat`, `pro`, `specPro`) VALUES ('$username', '$gender', '$ilevel', '$pets', '$smoke', '$nat','$specNat', '$pro','$specPro')";
        $update_query = "UPDATE `owner_selection` SET `gender`='$gender',`ilevel`='$ilevel',`pets`='$pets',`smoke`='$smoke',`nat`='$nat',`specNat`='$specNat',`pro`='$pro',`specPro`='$specPro' WHERE username = '$username'";
        $success;
        if ($profile){
            $success = mysqli_query($db, $update_query);
        }
        else{
            $success = mysqli_query($db, $add_query);
        }
        if($success){
            $_SESSION['msg'] = '<h3>Your selection criteria have been created/updated successfully.</h3><br />';
        }
        header('Location: http://localhost/SOEN287_assignment4/public_html/php/personal_page.php');
    }
    ?>