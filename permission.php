<?php  
    session_start();
    require_once __DIR__.'/vendor/autoload.php';
    ini_set(' session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
        $client = new Google_Client();
    $client->setAuthConfig('client_secret_303235166535-nfblp1roplc8ku613gsm2to01g3cafjh.apps.googleusercontent.com.json');
    $client->setAccessType("offline");        // offline access
    $client->setIncludeGrantedScopes(true);   // incremental auth
    $client->setHostedDomain("iiitdm.ac.in");
    $client->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
    
        
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);
    } else {
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }
        
    $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/index.php');
        
?>


