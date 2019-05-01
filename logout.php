<?php
// Include configuration file
require_once 'permission.php';

// Remove token and user data from the session
unset($_SESSION['token']);
//unset($_SESSION['userData']);

// Reset OAuth access token
$client->revokeToken();

// Destroy entire session data
session_destroy();

// Redirect to homepage
header("Location: index.php");
?>