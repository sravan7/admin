<?php

    //$pdo = new PDO("mysql:host=localhost;port=3306;dbName=Misc","root","sravan7@");
    $certificatePDO = new PDO("mysql:host=localhost;port=3306;dbname=BonafideCertificatesDB","sravan","sravan7@");
    $certificatePDO ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    
    $studentsPDO = new PDO("mysql:host=localhost;port=3306;dbname=StudentsDB","sravan","sravan7@");
    //$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    $studentsPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
?>