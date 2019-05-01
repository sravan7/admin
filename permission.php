<?php  
    session_start();
    require_once __DIR__.'/vendor/autoload.php';
    ini_set(' session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT'])));
    $client = new Google_Client();
    $client->setAuthConfigFile('client_secret_303235166535-nfblp1roplc8ku613gsm2to01g3cafjh.apps.googleusercontent.com.json');
    $client->setApplicationName("IIITDM Bonafide");
    $client->setRedirectUri("https://".$_SERVER["HTTP_HOST"]."/index.php");
    $client->setHostedDomain("iiitdm.ac.in");
    $client->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
