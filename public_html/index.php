<?php
session_start();

// Function displays a sign in form, when not signed in, and a sign out button and a link to user's personal page when signed in
function toggle_sign_in(){
    // If signed in
    if (isset($_SESSION['username'])){
        echo '<a class="navbar-brand navbar-right" href="html/personal_page.php">'.$_SESSION['fname'].'&nbsp &nbsp</a><a class="navbar-brand navbar-right" href="php/sign_out.php">Sign Out</a>';
    }
    // If not signed in, display a sign in form
    else{
        echo '<form class="navbar-form navbar-right" action="php/sign_in.php" method="POST">
            <div class="form-group">';
        // Alerts user to an invalid sign in attempt
        if (($invalid_pw = isset($_SESSION['msg']))){
            echo '<label id="invalidpw" >'.$_SESSION['msg'].'&nbsp&nbsp </label>';
            unset($_SESSION['msg']);
        }
        echo '<input type="text" name="signInUN" id="un" placeholder="User Name" class="form-control">
            </div>
            <div class="form-group">
             <input type="password" name="signInPW" id="pw" placeholder="Password" class="form-control"';
        if ($invalid_pw){
            echo 'autofocus';
        }
        echo '>
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>';

        // The session only contains an alert message which we no longer need
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>HoMeMatcH</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">HomeMatcH</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
           <?php
           toggle_sign_in();
           ?>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container" id="puzzle">
        <h1>HoMeMatcH</h1>
        <p>Matching the perfect tenant with the perfect home!</p>
        <p><a class="btn btn-primary btn-lg" href="html/signup.html" role="button">Sign Up &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Find the perfect home!</h2>
          <p>Our extensive preference matching system will find you the rental home of your dreams.  Choose from a number of search criteria to find the perfect match.</p>
          <p><a class="btn btn-default" href="html/tenantProfile.html" role="button">Create a Profile &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Find the ideal tenant!</h2>
          <p>Our extensive preference matching system will find you your ideal tenant.  Select the characteristics of your perfect tenant and find your match!</p>
          <p><a class="btn btn-default" href="html/tenantSelection.html" role="button">List Preferences &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Get started!</h2>
          <p>List a home to be matched to your ideal tenant based on your tenant selection preferences.  Your property will be suggested to renters who fit your profile and who's preferences fit your property.</p>
          <p><a class="btn btn-default" href="html/listProperty.html" role="button">List a Property &raquo;</a></p>
        </div>
      </div>

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
                    <li><a href ="index.php">Home</a></li>
                    <li><a href ="html/signup.html">Sign Up</a></li>
                    <li><a href="html/listProperty.html">List a Property</a></li>
                    <li><a href="html/tenantSelection.html">Tenant Selection</a></li>
                    <li><a href="html/tenantProfile.html">Tenant Profile</a></li>
                    <li><a href="html/rentalPreferences.html">Rental Preferences</a></li>
                </ul>
              </div>
              <div class="col-lg-4">
                 <p>&copy; HoMeMatcH</p>
              </div>
          </div>
      </footer>
    </div> <!-- /container -->
  </body>
</html>
