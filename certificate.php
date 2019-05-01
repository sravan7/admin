<?php
    require_once "connection.php";

    if(isset($_GET["user_id"]) && isset($_GET["type"])&& isset($_GET["num"])){

        $certificateType = array("type"=>$_GET["type"],"purpose"=>$_GET["purpose"]);


        // $url = 'https://script.google.com/macros/s/AKfycbxqF_KXKDhDgBiQnmVVBA7ufxkVC7mxcFHX8uu3UpaQ0_l0lY4/exec';
        // $url = 'https://script.google.com/macros/s/AKfycbxqF_KXKDhDgBiQnmVVBA7ufxkVC7mxcFHX8uu3UpaQ0_l0lY4/exec';
        $url = 'https://script.google.com/macros/s/AKfycbxqF_KXKDhDgBiQnmVVBA7ufxkVC7mxcFHX8uu3UpaQ0_l0lY4/exec';
        $coh = curl_init($url);
     
        $deleteFiles = http_build_query(array("type"=>"delete"),"","&");
        curl_setopt($coh, CURLOPT_POST, true);
        curl_setopt($coh, CURLOPT_POSTFIELDS, $deleteFiles);
        curl_setopt($coh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($coh, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($coh, CURLOPT_FOLLOWLOCATION, true);
        # Get the response
        $delResponse = curl_exec($coh);
        curl_close($coh);
        $delDecodeResponse = json_decode($delResponse, true);

        if($_GET["type"]=="passport"){
            $get = "SELECT * FROM Students WHERE rollno=:rollNo";
            $getStmt =  $studentsPDO->prepare($get);
            $getStmt->execute(array(
            ":rollNo"=>$_GET["user_id"]
            ));
            $getData = $getStmt->fetch(PDO::FETCH_ASSOC);

           $getData = array_merge($getData, $certificateType);
            //echo($_GET["user_id"]);
            
            // $getSingle = "SELECT * FROM Certificates WHERE rollNo= :number";
            // $stmtGetSingle= $certificatePDO ->prepare($getSingle);
            // $stmtGetSingle->execute(array(":num"=>$_GET["user_id"]));
            // $RequestsSingle = $stmtGetSingle->fetch(PDO::FETCH_ASSOC);
            
            // $updateStatus = "UPDATE Certificates SET state=:status WHERE certificate_count=:number";
            // $stmtUpdate = $certificatePDO->prepare($updateStatus);
    
            $update="UPDATE Certificates  SET state= :state
            WHERE certificate_count= :num";
    
            $stmtUpdate = $certificatePDO->prepare($update);
            // $stmtUpdate->execute(array(
            //     ":sate"=>1,
            //     ":num"=>$_GET["num"]
            // ));
            $requestHeaders = array();
            $requestHeaders[] ='Authorization: Bearer'.$_SESSION["token"];
           
         
            // $url = 'https://script.google.com/macros/s/AKfycbxqF_KXKDhDgBiQnmVVBA7ufxkVC7mxcFHX8uu3UpaQ0_l0lY4/exec';
            # Get response
            //$response = http_post_data($url, $RequestsSingle);
            //echo($getData["name"]);
            $ch = curl_init($url);
            # Form data string
            $postString = http_build_query($getData,"","&");
            # Setting our options
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            # Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            $decodeResponse = json_decode($response, true);
            if($decodeResponse["type"]==200){
            
                $fileDownloadUrl = 'https://docs.google.com/feeds/download/documents/export/Export?id='.$decodeResponse["id"].'&exportFormat=docx';
                // echo($decodeResponse["id"]);
                // echo('<script type="text/javascript">location.href='.$fileDownloadUrl.';</script>');
                // header('Location:fake.php');
                // header('Location:'.$fileDownloadUrl.'');
                echo('<a href="'.$fileDownloadUrl.'" target="_blank">"'.$_GET["user_id"].''.$_GET["type"].'"Download</a>');
                
                $stmtUpdate->execute(array(":state"=>1 , ":num"=>$_GET["num"]));
                //header()
                // $stmtUpdate.execute(array(":status"=>1 , ":rollno"=>$_GET["user_id"]));
                // header("refresh:1; url=index.php");
            }
            
            //     echo("successful");
            //     //header()
            //     // $stmtUpdate->execute(array(":state"=>1 , ":num"=>$_GET["num"]));
            //     // header("refresh:2; url=index.php");
            // }
            // echo($response);

        }
        elseif($_GET["type"]=="project" || $_GET["type"]=="internship" ){
                
                $get = "SELECT * FROM Students WHERE rollno=:rollNo";
                $getStmt =  $studentsPDO->prepare($get);
                $getStmt->execute(array(
                ":rollNo"=>$_GET["user_id"]
                ));
                $getData = $getStmt->fetch(PDO::FETCH_ASSOC);
    
               $getData = array_merge($getData, $certificateType);  

                $update="UPDATE Certificates  SET state= :state
                WHERE certificate_count= :num";
        
                $stmtUpdate = $certificatePDO->prepare($update);
               
                $requestHeaders = array();
                $requestHeaders[] ='Authorization: Bearer'.$_SESSION["token"];
               
             
                $ch = curl_init($url);
                # Form data string
                $postString = http_build_query($getData,"","&");
                # Setting our options
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                # Get the response
                $response = curl_exec($ch);
                curl_close($ch);
                $decodeResponse = json_decode($response, true);
                if($decodeResponse["type"]==200){
                
                    $fileDownloadUrl = 'https://docs.google.com/feeds/download/documents/export/Export?id='.$decodeResponse["id"].'&exportFormat=docx';
                    // echo($decodeResponse["id"]);
                    // echo('<script type="text/javascript">location.href='.$fileDownloadUrl.';</script>');
                    // header('Location:fake.php');
                    // header('Location:'.$fileDownloadUrl.'');
                    echo('<a href="'.$fileDownloadUrl.'" target="_blank">"'.$_GET["user_id"].''.$_GET["type"].'"Download</a>');
                    $stmtUpdate->execute(array(":state"=>1 , ":num"=>$_GET["num"]));
                //     //header()
                //     // $stmtUpdate->execute(array(":state"=>1 , ":num"=>$_GET["num"]));
                //     // header("refresh:2; url=index.php");
                   
                }
        
        }
        elseif($_GET["type"]=="scholarship" ){
                
            $get = "SELECT * FROM Students WHERE rollno=:rollNo";
            $getStmt =  $studentsPDO->prepare($get);
            $getStmt->execute(array(
            ":rollNo"=>$_GET["user_id"]
            ));
            $getData = $getStmt->fetch(PDO::FETCH_ASSOC);

           $getData = array_merge($getData, $certificateType);  

            $update="UPDATE Certificates  SET state= :state
            WHERE certificate_count= :num";
    
            $stmtUpdate = $certificatePDO->prepare($update);
           
            $requestHeaders = array();
            $requestHeaders[] ='Authorization: Bearer'.$_SESSION["token"];
           
         
            $ch = curl_init($url);
            # Form data string
            $postString = http_build_query($getData,"","&");
            # Setting our options
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            # Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            $decodeResponse = json_decode($response, true);
            if($decodeResponse["type"]==200){
            
                $fileDownloadUrl = 'https://docs.google.com/feeds/download/documents/export/Export?id='.$decodeResponse["id"].'&exportFormat=docx';
                // echo($decodeResponse["id"]);
                // echo('<script type="text/javascript">location.href='.$fileDownloadUrl.';</script>');
                // header('Location:fake.php');
                // header('Location:'.$fileDownloadUrl.'');
                echo('<a href="'.$fileDownloadUrl.'" target="_blank">"'.$_GET["user_id"].''.$_GET["type"].'"Download</a>');
                $stmtUpdate->execute(array(":state"=>1 , ":num"=>$_GET["num"]));
            //     //header()
            //     // header("refresh:2; url=index.php");
               
            }
    
    }
        else{
            echo("die here");
        }
    }
?>