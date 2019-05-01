<?php  
    session_start();
    require_once __DIR__.'/vendor/autoload.php';
    ini_set(' session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
    $client = new Google_Client();
    $client->setAuthConfigFile('client_secret_737091014820-6vtpr3l3jrtfjp434n0u5ntqhcvei9ir.apps.googleusercontent.com.json');
    $client->setApplicationName("IIITDM Bonafide");
    $client->setRedirectUri("http://".$_SERVER["HTTP_HOST"]."/index.php");
    $client->setHostedDomain("iiitdm.ac.in");
    $client->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
