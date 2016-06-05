<?php
// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'rental_7262442');
if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}

/*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*
 *   
 *              First step: 
 *                 Ranking
 * 
 *!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*/

// Clears old rankings and matches
mysqli_query($db, 'DELETE FROM `property_rank` WHERE 1');
mysqli_query($db, 'DELETE FROM `tenant_rank` WHERE 1');
mysqli_query($db, 'DELETE FROM `matches` WHERE 1');

/*************************************************
 *      Ranks the properties for each tenant
 *************************************************/


// Queries for tenant preference and property info 
$tenants_preferences_query = "SELECT * FROM rental_preferences";
$properties_info_query = "SELECT * FROM properties";

// Gets the tenant preferences
$tenants_preferences_result = mysqli_query($db, $tenants_preferences_query);




// For all tenants
while($tenants_preferences = mysqli_fetch_assoc($tenants_preferences_result)){
    $i = 0;
    
    // Gets the property info from the database
    $properties_info_result = mysqli_query($db, $properties_info_query);
    
    // Array that stores all the properties' info and ranking    
    $all_properties = array();
    
    // For all properties
    while($all_properties[$i] = mysqli_fetch_assoc($properties_info_result)){
        
        // Rank starts at zero and inc/dec based on preferences
        $rank = 0;
        
        $tenants_preferences['sector'] == $all_properties[$i]['sector']? $rank++ : $rank--;
        $tenants_preferences['type'] == $all_properties[$i]['type']? $rank++ : $rank--;
        
        if($tenants_preferences['minPrice'] != null && $tenants_preferences['maxPrice'] != null && $tenants_preferences['minPrice'] <= $all_properties[$i]['price'] && $tenants_preferences['maxPrice'] >= $all_properties[$i]['price']){
            $rank += 5;
        }else if(($tenants_preferences['minPrice'] != null && $tenants_preferences['maxPrice'] == null && $tenants_preferences['minPrice'] <= $all_properties[$i]['price']) || ($tenants_preferences['maxPrice'] != null && $tenants_preferences['minPrice'] == null && $tenants_preferences['maxPrice'] >= $all_properties[$i]['price'])){
            $rank += 3;
        }else{
            $rank--;
        }
        
        $tenants_preferences['area'] >= $all_properties[$i]['area']? $rank++ : $rank--;
        
        $tenants_preferences['total_rooms'] >= $all_properties[$i]['total_rooms']? $rank++ : $rank--;
        
        $tenants_preferences['bed_rooms'] >= $all_properties[$i]['bed_rooms']? $rank++ : $rank--;
        
        $tenants_preferences['bath_rooms'] >= $all_properties[$i]['bath_rooms']? $rank++ : $rank--;
        
        $tenants_preferences['total_rooms'] >= $all_properties[$i]['total_rooms']? $rank++ : $rank--;
        
        // Compares the additional info BOOLEAN values
        foreach ($tenants_preferences as $key => $value) {
            if($value == 1 && $all_properties[$i][$key] == 1){
                $rank++;
            }
        }
        // Adds the rank  to the array of properties
        $all_properties[$i]['rank'] = $rank;
        
        // Increment index for next loop
        $i++;
    }   
    
    // Values to be inserted into the ranking table
    
    $values = '\''.$tenants_preferences['username'].'\'';
    
    // While there are properties that have not been added
    while(isset($all_properties[0])){
       
        // Index of remaining property with highest rank
        $best_rank = 0;
        
        // For all other properties in the array
        for ($i = 1; $i < count($all_properties); $i++) {
            // If the rank is higher than the current highest, assign index to $best_rank
            if($all_properties[$i]['rank'] > $all_properties[$best_rank]['rank']){
                $best_rank = $i;
            }
        }
        
        // Concats the property ID to $values
        $values .= ', '.$all_properties[$best_rank]['id'];
        
        //Then removes the property from the array
        unset($all_properties[$best_rank]);
        $all_properties = array_values($all_properties);
    }
    
    // Insert entry into DB
    $rank_entry = "INSERT INTO property_rank VALUES ($values)";
    mysqli_query($db, $rank_entry);
    
}

/*************************************************
 *      Ranks the tenants for each owner
 *************************************************/

// Queries the owner's tenant selection criteria and tenant profile
$owner_selection_query = "SELECT * FROM owner_selection";
$tenant_profile_query = "SELECT * FROM tenant_profile";

// Gets the owners selection criteria from the database
$owner_selection_result = mysqli_query($db, $owner_selection_query);

// For all owners
while($owner_selection = mysqli_fetch_assoc($owner_selection_result)){
    $i = 0;
    
    // Gets the tenant profile from the database
    $tenant_profile_result = mysqli_query($db, $tenant_profile_query);
    
    // Array that stores all the tenants' info and ranking    
    $all_tenants = array();

    // For all tenants
    while($all_tenants[$i] = mysqli_fetch_assoc($tenant_profile_result)){
        
        // Rank starts at zero and inc/dec based on preferences
        $rank = 0;
        
        foreach ($all_tenants[$i] as $key => $value) {
            if(!isset($owner_selection[$key]) || $owner_selection[$key] == null || $owner_selection[$key] == 'non' || $owner_selection[$key] == 'N/A'){
                continue;
            }
            $owner_selection[$key] == $value ? $rank++ : $rank--;
        }
    
     // Adds the rank  to the array of tenants
        $all_tenants[$i]['rank'] = $rank;
        
        // Increment index for next loop 
        $i++;
    }
    
    // Values to be inserted into the ranking table
    $values = '\''.$owner_selection['username'].'\'';
    
    // While there are tenants that have not been added
    while(isset($all_tenants[0])){
        // Index of remaining property with highest rank
        $best_rank = 0;
        
        // For all tenants in the array
        for ($i = 1; $i < count($all_tenants); $i++) {
            // If the rank is higher, assign index to $best_rank
            if($all_tenants[$i]['rank'] > $all_tenants[$best_rank]['rank']){
                $best_rank = $i;
            }
        }
        
        // Concats the tenant username to $values
        $values .= ', \''.$all_tenants[$best_rank]['username'].'\'';
        
        //Then removes the tenant from the array
        unset($all_tenants[$best_rank]);
        $all_tenants = array_values($all_tenants);
    }
    
    // Insert entry into DB
    $rank_entry = "INSERT INTO tenant_rank VALUES ($values)";
    mysqli_query($db, $rank_entry);
    echo $rank_entry;
}


/*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*
 *   
 *              Second step: 
 *                Matching
 * 
 *!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*!*/


// Gets all the ranks
$tenant_rank_query = 'SELECT * FROM tenant_rank';
$property_rank_query = 'SELECT * FROM property_rank';

$tenant_rank_result = mysqli_query($db, $tenant_rank_query);
$property_rank_result = mysqli_query($db, $property_rank_query);

// Create an array of tenants
$tenants = array();

// For each tenant $t
$t = 0;
while($property_rank = mysqli_fetch_row($property_rank_result)){
    
    // The first column of the entry is the tenant's user name
    $tenants[$t]['username'] = $property_rank[0];
    
    // The rest of the columns are the rankings
    for ($i = 1; $i < count($property_rank); $i++) {
        $tenants[$t]['ranks']['id'][$i - 1] = $property_rank[$i];
        // Since we ranked only the properties, we need to query the property's owner 
        $owner = mysqli_fetch_assoc(mysqli_query($db, "SELECT username FROM properties WHERE id =$property_rank[$i]"))['username'];
        $tenants[$t]['ranks']['owner'][$i - 1] = $owner;
        
    }
    // Increment $t for next loop
    $t++;
}

// Create an array of owners
$owners = array();
// for each owner $o
$o = 0;

while($tenant_rank = mysqli_fetch_row($tenant_rank_result)){
    
    // Again, the first column is the user name and the rest are the rankings
    $owners[$o]['username'] = $tenant_rank[0];
    for ($i = 1; $i < count($tenant_rank); $i++) {
        $owners[$o]['ranks'][$i - 1] = $tenant_rank[$i];
    }
    
// Stores the tenant that the owner is tentatively 'engaged' to
    $owners[$o]['hold'] = null;
    
    // Increment for next loop
    $o++;
}

// Boolean, is set to true when the matching is complete
$done = false;

while(!$done){
    
    // Each tenant 'proposes' to an owner
    for ($t = 0; $t < count($tenants); $t++) {
        propose($tenants[$t]);
    }
    // The next part determines if the matching is complete
    // For each owner
    for ($o = 0; $o < count($owners); $o++) {
        // If an owner is not 'holding' a tenant we are obviously not finished
        if($owners[$o]['hold'] == null){ 
            break;
        }
        // If all the owners up to the last one are 'holding' a tenant, we are done
        elseif($o == (count($owners) - 1)){
            $done = true;   
        }
    }
    
}

// Inserts matches into database
for ($i = 0; $i < count($owners); $i++) {
    mysqli_query($db, 'INSERT INTO matches VALUES (\''.$owners[$i]['username'].'\', \''.$owners[$i]['hold'].'\')');
    
}


// Function simulates the proposal
function propose(&$tenant){
    global $owners;
    
    // Checks if tenant is already 'engaged'
    
    // For each owner
    for ($i = 0; $i < count($owners); $i++) {
        // If an owner is already 'holding' this tenant, he does not need to propose again
        if($owners[$i]['hold'] != null && $owners[$i]['hold'] == $tenant['username']){
	return;
        }
    }
    
    // If not already engaged
    
    // Finds the owner that is first on the list, that he has not proposedd to yet
    for ($o = 0; $o < count($owners); $o++) {
        if($owners[$o]['username'] == $tenant['ranks']['owner'][0]){
            // If owner is not 'engaged'
            if($owners[$o]['hold'] === null){
                // Set tenant engaged to owner
                $owners[$o]['hold'] = $tenant['username'];
            }
            // If owner is already 'engaged'
            else{
                // Looks at the owner's rankings
                for ($r = 0; $r < count($owners[$o]['ranks']); $r++) {
                    // If owners current tenant has a better rank, refuse this tenants proposal 
                    if($owners[$o]['ranks'][$r] == $owners[$o]['hold']){
                        break;
                    }
                    // If this tenant has higher ranking, accept proposal
                    elseif ($owners[$o]['ranks'][$r] === $tenant['username']) {
                        $owners[$o]['hold'] = $tenant['username'];
                        break;
                    }
                }
            }
        }
    }
    // Remove the owner from tenants list
    unset($tenant['ranks']['id'][0]);
    unset($tenant['ranks']['owner'][0]);
    if(isset($tenant['ranks']['id'])){
        $tenant['ranks']['id'] = array_values($tenant['ranks']['id']);
        $tenant['ranks']['owner'] = array_values($tenant['ranks']['owner']);
    }
}
// Information will be displayed on user's page
session_start();
$_SESSION['matched'] = true;
header('Location: http://localhost/SOEN287_assignment4/public_html/php/personal_page.php');
