<?php

// Destroys session to sign out

session_start();
session_destroy();
header('Location: http://localhost/SOEN287_assignment4/public_html/index.php');
?>
