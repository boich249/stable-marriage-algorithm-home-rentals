
<?php
    session_start();
    
    $username = $_SESSION['username'];
    $db = mysqli_connect('localhost', 'root', '', 'rental_7262442');
    
    
// Displays the data related to tenants    
function tenant_data(){
    global $username, $db;
    
    // Deals with Tenant's profile
    $profile_query = "SELECT `username`AS 'User Name', `gender` AS 'Gender', `ilevel` AS 'Income Level', `pets` AS 'Pets', `smoke`AS 'Smoking', `nat`AS 'Nationality', `specNat`'From', `pro` AS 'Profession', `specPro` AS 'Ocupation' FROM `tenant_profile` WHERE username = '$username'";
    $profile_query_result = mysqli_query($db, $profile_query);
    $profile = mysqli_fetch_assoc($profile_query_result);
    
// If tenant does not yet have a profile, offer to create one
    if(!$profile){
        echo '<h3>Create a profile!</h3><br />
        <p><a class="btn btn-default" href="../html/tenantProfile.html" role="button">Create a Profile &raquo;</a></p><br />';
    }
    // If tenant already has a profile, display it, and offer to update
    else{
        echo '<h3>Your Profile</h3><br />';
        foreach ($profile as $key => $value) {
            if($value == '' || $value == null || $value == 'N/A'){
                continue;
            }
            if($key != 'User Name'){
                $value = ucfirst($value);
            }
            echo "<p>$key: $value </p>";
        }
        echo '<br /><p><a class="btn btn-default" href="../html/tenantProfile.html" role="button">Update Profile &raquo;</a></p><br />';
    }
    
    // Deals with Tenant's rental preferences
    $rental_preferences_query = "SELECT `city` AS 'City', `sector` AS 'Sector', `type` AS 'Type', `minPrice` AS 'Min Price', `available` AS 'Available By:', `area` AS 'Min Area (square ft)', `total_rooms` AS 'Total Rooms', `bed_rooms`  AS 'Bed Rooms', `bath_rooms`  AS 'Bath Rooms', `airc` AS 'Air Conditioning', `park` AS 'Parking', `yard`  AS 'Yard', `balc` AS 'Balcony', `tran` AS 'Near Public Transport', `pool` AS 'Pool', `htub` AS 'Hot Tub', `wifi` AS 'Free WiFi', `wash` AS 'Washer/Dryer', `elev` AS 'Elevator', `addInfo` AS 'Additional Information' FROM `rental_preferences` WHERE username = '$username'";
    $rental_preferences_query_result = mysqli_query($db, $rental_preferences_query);
    $rental_preferences = mysqli_fetch_assoc($rental_preferences_query_result);
    
    // If tenant does not yet have a rental preference list, offer to create one
    if(!$rental_preferences){
        echo '<hr><br /><h3>Tell us your rental preferences!</h3><br />
        <p><a class="btn btn-default" href="../html/rentalPreferences.html" role="button">Rental Preferences &raquo;</a></p>';
    }
    // If tenant already has a rental preference list, display it, and offer to update
    else{
        echo '<hr><br /><h3>Your Rental Preferences:</h3><br />';
        foreach ($rental_preferences as $key => $value) {
            if($value == 0){
                continue;
            }elseif($value == 1 && !preg_match('/Room/', $key)){
                echo "<p>$key </p>";
            }else{
                echo "<p>$key: $value </p>";
            }
        }
        echo '<br /><p><a class="btn btn-default" href="../html/rentalPreferences.html" role="button">Update Preferences &raquo;</a></p>';
    }
    // If user has asked for a match, display match information
    if(isset($_SESSION['matched']) && $_SESSION['matched'] === true){
        $match = mysqli_fetch_assoc(mysqli_query($db, "SELECT owner FROM matches WHERE tenant = '$username'"))['owner'];
        $match_property = mysqli_fetch_assoc(mysqli_query($db, "SELECT `id`, `address` AS 'Address', `city` AS 'City', `postal`AS 'Postal Code', `sector` AS 'Sector', `type` AS 'Type', `price` AS 'Price', `available` AS 'Date Available', `area` AS 'Area (square ft)', `total_rooms` AS 'Total Rooms', `bed_rooms`  AS 'Bed Rooms', `bath_rooms`  AS 'Bath Rooms', `airc` AS 'Air Conditioning', `park` AS 'Parking', `yard`  AS 'Yard', `balc` AS 'Balcony', `tran` AS 'Near Public Transport', `pool` AS 'Pool', `htub` AS 'Hot Tub', `wifi` AS 'Free WiFi', `wash` AS 'Washer/Dryer', `elev` AS 'Elevator', `other` AS 'Additional Information' FROM `properties` WHERE username = '$match'"));
        $match_owner = mysqli_fetch_assoc(mysqli_query($db, "SELECT fname AS 'First Name', lname AS 'Last Name', email AS 'Email' , phone AS 'Phone' FROM users WHERE username = '$match'"));
        
        // Property info
        foreach ($match_property as $key => $value ) {
            if($key === "id"){
                 echo '<br /><hr><br /><h3>Property ID: '.$match_property['id'].'</h3> <br />';
            }
            elseif($value == 0){
                continue;
            }elseif($value == 1 && !preg_match('/Room/', $key)){
                echo "<p>$key </p>";
            }else{
                echo "<p>$key: $value </p>";
            }
        }
        
        // Owner info
        echo '<h3>Owner Information:</h3> <br />';
        foreach ($match_owner as $key => $value ) {
            if($key === "password"){
                continue;
            }
            else{
                echo "<p>$key: $value </p>";
            }
        }
        unset($_SESSION['matched']);
    }
    
    // If user has not requested a match, offer to match if user has filled in all forms
    else{
        if($profile && $rental_preferences){
            echo '<br/><hr><br /><p>Let\'s find the perfect match!</p><p><a class="btn btn-default" href="matching.php" role="button">Match! &raquo;</a></p>';
    
        }
    }
}

// Displays data related to owners
function owner_data(){
    global $username, $db;
    
    // Deals with owner's tenant selection
    $selection_query = "SELECT `username`AS 'User Name', `gender` AS 'Gender', `ilevel` AS 'Income Level', `pets` AS 'Pets', `smoke`AS 'Smoking', `nat`AS 'Nationality', `specNat`'From', `pro` AS 'Profession', `specPro` AS 'Ocupation' FROM `owner_selection` WHERE username = '$username'";
    $selection_query_result = mysqli_query($db, $selection_query);
    $selection = mysqli_fetch_assoc($selection_query_result);
    
    // If owner has not created a tenant selection list, offer to create one
    if(!$selection){
        echo '<h3>Who is your ideal tenant?</h3><br />
        <p><a class="btn btn-default" href="../html/tenantSelection.html" role="button">Selection Criteria &raquo;</a></p>';
    }
    // If he has created one, display it, and offer to update
    else{
        echo '<h3>Your Selection Criteria:</h3><br />';
        foreach ($selection as $key => $value) {
            if($key === 'User Name'){
                continue;
            }
            $value = ucfirst($value);
            if($value === 'non'){
                $value = 'No Preference';
            }
            echo "<p>$key: $value </p>";
        }
        echo '<p><a class="btn btn-default" href="../html/tenantSelection.html" role="button">Update Criteria &raquo;</a></p>';
    }
    echo '<br /><hr><br />';
    
    // Deals with owners's property listings
    $properties_query = "SELECT `id`, `address` AS 'Address', `city` AS 'City', `postal`AS 'Postal Code', `sector` AS 'Sector', `type` AS 'Type', `price` AS 'Price', `available` AS 'Date Available', `area` AS 'Area (square ft)', `total_rooms` AS 'Total Rooms', `bed_rooms`  AS 'Bed Rooms', `bath_rooms`  AS 'Bath Rooms', `airc` AS 'Air Conditioning', `park` AS 'Parking', `yard`  AS 'Yard', `balc` AS 'Balcony', `tran` AS 'Near Public Transport', `pool` AS 'Pool', `htub` AS 'Hot Tub', `wifi` AS 'Free WiFi', `wash` AS 'Washer/Dryer', `elev` AS 'Elevator', `other` AS 'Additional Information' FROM `properties` WHERE username = '$username'";
    $properties_query_result = mysqli_query($db, $properties_query);
    
    // If user has listed properties
    if(mysqli_num_rows($properties_query_result)){
        echo '<h3>Your Properties:</h3><br />';
    }
    // If not, offer to list
    else{
        echo '<h3>List a Property</h3><br />';
    }
    // If user has listed properties, displays all properties' information
    while($properties = mysqli_fetch_assoc($properties_query_result)){
        foreach ($properties as $key => $value ) {
            if($key === "id"){
                 echo '<h3>Property ID: '.$properties['id'].'</h3> <br />';
            }
            elseif($value == 0){
                continue;
            }elseif($value == 1 && !preg_match('/Room/', $key)){
                echo "<p>$key </p>";
            }else{
                echo "<p>$key: $value </p>";
            }
        }
        
    }
    echo '<p><a class="btn btn-default" href="../html/listProperty.html" role="button">New Property &raquo;</a></p><br />';
}


// Displays the relevant info based on users user type (tenant/owner)
if($_SESSION['userType']=== 'tenant'){
    $display_data = 'tenant_data';
}
else if($_SESSION['userType']=== 'owner'){
    $display_data = 'owner_data';
}
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/jumbotron.css" rel="stylesheet">
        <link href="../css/main.css" rel="stylesheet">
    </head>
    <body>
        <div class="jumbotron">
          <div class="container" id="puzzle">
            <h1>HoMeMatcH</h1>
            <p>Matching the perfect tenant with the perfect home!</p>
            <p></p>
          </div>
        </div>
        <div class="container">
            <h3>Welcome <?php echo $_SESSION['fname']; ?></h3>
            <br/><hr><br /><br />
            <?php 
            if (isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                $_SESSION['msg'] = null;
            }
            if(is_callable($display_data)){
                    $display_data();
            }
            ?>
            <hr>
            <footer>
                <div class="row">
                    <div class="col-lg-4">
                        <p><strong>Contact Us</strong></p>
                      <ul>
                          <li><a href ="mailto:homematch@homematch.com">Email</a></li>
                          <li>Phone 1(888)888-8888</li>
                          <li><a href="http://www.homematch.com">www.homematch.com</a></li>
                          <li>450 DeMaisonneuve</li>
                          <li>Montreal, QC</li>
                      </ul>
                    </div>
                    <div class="col-lg-4">
                      <p><strong>Site Map</strong></p>
                      <ul>
                          <li><a href="../index.php">Home</a></li>
                          <li><a href="../html/signup.html">Sign Up</a></li>
                          <li><a href="../html/listProperty.html">List a Property</a></li>
                          <li><a href="../html/tenantSelection.html">Tenant Selection</a></li>
                          <li><a href="../html/tenantProfile.html">Tenant Profile</a></li>
                          <li><a href="../html/rentalPreferences.html">Rental Preferences</a></li>
                      </ul>
                    </div>
                    <div class="col-lg-4">
                       <p>&copy; HoMeMatcH</p>
                    </div>
                </div>
            </footer>
        </div>
        <script type="text/javascript" src="../js/formVal.js"></script>
    </body>
</html>