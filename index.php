<?php
// Include configuration file
require_once __DIR__.'/vendor/autoload.php';

require_once 'permission.php';

// if(isset($_GET['code'])){
//     //$client->authenticate($_GET['code']);
//     //$_SESSION['token'] = $client->getAccessToken();
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $client->setAccessToken($token);
//     $_SESSION['token'] = $token;
//     header('Location: index.php');
// }

if(!empty($_SESSION['token'])){
    $client->setAccessToken($_SESSION['token']);
    if ($client->isAccessTokenExpired()) {
        unset($_SESSION['token']);
        $client->revokeToken();

    // Destroy entire session data
        session_destroy();
      }
}

if(isset($_GET['code'])){
    // Get user profile data from google
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
    $_SESSION['token'] = $token;
    $Oauth = new Google_Service_Oauth2($client);
    $gpUserProfile = $Oauth->userinfo_v2_me->get();
    //$gpUserProfile = $google_oauthV2->userinfo->get();
    
   
    // Getting user profile info
    $gpUserData = array();
    $gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
    $gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
    $gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
    $gpUserData['email']      = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
    $gpUserData['gender']     = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
    $gpUserData['locale']     = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
    $gpUserData['picture']    = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
    $gpUserData['link']       = !empty($gpUserProfile['link'])?$gpUserProfile['link']:'';
    
    // Insert or update user data to the database
    $gpUserData['oauth_provider'] = 'google';
    
    
    // Storing user data in the session
    $_SESSION['userData'] = $gpUserData;
    // Render user profile data
    // echo($client->getAccessToken());
    if($_SESSION["userData"]){
        $_SESSION["loggedIn"]=1;
        /*
        $output .= '<center>';
        $output  .= '<h2>Google Account Details</h2>';
        $output .= '<img src="'.$gpUserData['picture'].'">';
        $output .= '<p><b>Google ID:</b> '.$gpUserData['oauth_uid'].'</p>';
        $output .= '<p><b>Name:</b> '.$gpUserData['first_name'].' '.$gpUserData['last_name'].'</p>';
        $output .= '<p><b>Email:</b> '.$gpUserData['email'].'</p>';
        $output .= '<p><b>Logged in with:</b> Google</p>';
        $output .= '<p><a href="'.$gpUserData['link'].'" target="_blank">Click to visit Google+</a></p>';
        $output .= '<p>Logout from <a href="logout.php">Google</a></p>';
        $output .= '</center>';
        */
    }else{
        $_SESSION["loggedIn"]=-1;
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
}else{
    // Get login url
    $authUrl = $client->createAuthUrl();
    $_SESSION["loggedIn"]=0;
    // Render google login button
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'" class="login-bt">login</a>';
}

?>

<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"  crossorigin="anonymous">
    
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

   
</head>
<body>
   <!-- <h1> <?= $_SESSION["loggedIn"]===0; ?></h1>
    <h1> <?= $_SESSION["loggedIn"]===1; ?></h1>
    -->
   
    <?php if ($_SESSION["loggedIn"]===1) { ?>
   
      <?php
        require("header.php"); 
      ?>  
     <?php require("Requests.php"); ?> 
      <?php 
      require("footer.php");
      ?>
<script src="js/script.js"></script>

    <?php } elseif($_SESSION["loggedIn"]===0){ ?>
        <?= $output ?>
    <?php } else { ?>
        <h2>something has gone wrong</h2>
    <?php } ?>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src=" https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"> </script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>

$(document).ready(function(){
    $('#acceptTable').dataTable(
        
    );
});

function showmenu() {
      var x = document.getElementById('navUL');
      if (x.style.display == 'none') {
        x.style.display = 'block';
      } else {
        x.style.display = 'none';
      }
    }
</script>
</html>