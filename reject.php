<?php 
 require_once "connection.php";

$update="UPDATE Certificates  SET state= :state
WHERE certificate_count= :num";

$stmtUpdate = $certificatePDO->prepare($update);
$stmtUpdate->execute(array(":state"=>2, ":num"=>$_GET["num"]));
$mailSubject = "%20Bonafide%20Certifcate%20Request";
$mailBody = "%0A%0Ayour application rejected for the%20__%20reason";
$mailUrl = 'http://mail.google.com/a/iiitdm.ac.in/mail?view=cm&fs=1&tf=1&to='.$_GET["user_id"].'@iiitdm.ac.in&su=Rejected:%20'.$_GET["purpose"].''.$mailSubject.'&body=Dear%20'.$_GET["name"].''.$mailBody.'';

header('Location:'.$mailUrl.'');
?>