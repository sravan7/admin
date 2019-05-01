<?php
    require_once "connection.php";

//     if(isset($_GET["user_id"])){
        
//         $get = "SELECT * FROM Students WHERE rollno=:rollNo";
//         $getStmt =  $studentsPDO->prepare($get);
//         $getStmt->execute(array(
//         "rollNo"=>$_GET["user_id"]
//         ));
//         $getData = $getStmt->fetch(PDO::FETCH_ASSOC);
//         //echo($_GET["user_id"]);
        
//         $getSingle = "SELECT * FROM Certificates WHERE certificate_count= :num";
//         $stmtGetSingle= $certificatePDO ->prepare($getSingle);
//         $stmtGetSingle->execute(array(":num"=>$_GET["user_id"]));
//         $RequestsSingle = $stmtGetSingle->fetch(PDO::FETCH_ASSOC);
        
//         $updateStatus = "UPDATE Certificates SET state=:status WHERE rollNo=:rollno ";
//         $stmtUpdate = $certificatePDO ->prepare($updateStatus);


//         # Create a connection
//         $url = 'https://script.google.com/a/iiitdm.ac.in/macros/s/AKfycbzKEJOJ0LLkG8rDgismTQ54JGdwsPZ7UGejcfbJXhnbwv51YoI/exec';
//         //$url = 'https://script.google.com/macros/s/AKfycbwp_V2Ng2X9gB_cCQWIWyNtzdZ2bUz2tJCP7RnOd8pGp5P0VQU/exec';
//         //$url = 'https://script.google.com/macros/s/AKfycbwp_V2Ng2X9gB_cCQWIWyNtzdZ2bUz2tJCP7RnOd8pGp5P0VQU/exec';
//         //$url = 'https://script.google.com/macros/s/AKfycbxJxK7Q7ZiqAIk6vkDKcJLCHHHz3OmETMF37yuXCzfUU6rByl0/exec';
//         //https://script.google.com/macros/s/AKfycbxJxK7Q7ZiqAIk6vkDKcJLCHHHz3OmETMF37yuXCzfUU6rByl0/exec
// # Get response
//         //$response = http_post_data($url, $RequestsSingle);
//         //echo($getData["name"]);
//         $ch = curl_init('https://script.google.com/a/iiitdm.ac.in/macros/s/AKfycbzKEJOJ0LLkG8rDgismTQ54JGdwsPZ7UGejcfbJXhnbwv51YoI/exec');
//         # Form data string
//         $postString = http_build_query($getData,"","&");
//         # Setting our options
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         # Get the response
//         $response = curl_exec($ch);
//         curl_close($ch);
//         if(!empty($response)){
//             echo("successful");
//             //header()
//             //$stmtUpdate.execute(array(":status"=>1 , ":rollno"=>$_GET["user_id"]));
//             header("refresh:1; url=index.php");
//         }
//         //echo($response);
//     }

    $getData = "SELECT * FROM Certificates WHERE date_time< :dateTime AND state=:state ORDER BY date_time ASC ";;
    $stmtGetData= $certificatePDO ->prepare($getData);
    $stmtGetData->execute(array(":dateTime"=> date("Y-m-d H:i:s"), ":state"=>0));
    // echo(date("Y-m-d H:i:s"));
    //$RequestsData = $stmtGetData->fetch(PDO::FETCH_ASSOC);
    echo '<div class="jumbotron justify-content-center table-responsive-sm">';
    echo '<div class="col-auto">';
    echo '<table class="table table-bordered table-hover" id="acceptTable">'."\n";
    echo("<thead class='thead-light'>
        <th>#</th>
        <th>RollNo</th>
        <th>Name</th>
        <th>Type</th>
        <th>Purpose</th>
        <th>Application DateTime</th>
        <th>Action</th>
        </thead>
        <tbody>
        ");
        //$row=$RequestsData;
        $mailSubject = "%20Bonafide%20Certifcate%20Request";
        $mailBody = "%0A%0Ayour application rejected for the%20__%20reason";
while($row=$stmtGetData->fetch(PDO::FETCH_ASSOC)) {
    //print_r($row);
    echo "<tr><td>";
    echo($row["certificate_count"]);
    echo"</td><td>";
    echo($row["rollNo"]);
    echo"</td><td>";
    echo($row["name"]);
    echo"</td><td>";
    echo($row["certificateType"]);
    echo"</td><td>";
    echo($row["purpose"]);
    echo"</td><td>";
    echo($row["date_time"]);
    echo("</td><td>");
    echo("<a class='btn btn-primary mt-1 mr-2' target='_blank' href='certificate.php?user_id=".$row["rollNo"]."&type=".$row["certificateType"]."&purpose=".$row["purpose"]."&num=".$row["certificate_count"]."'>Accept</a>");
    echo("<a class='btn btn-danger mt-1' target='_blank'  href='reject.php?user_id=".$row["rollNo"]."&name=".$row["name"]."&type=".$row["certificateType"]."&purpose=".$row["purpose"]."&num=".$row["certificate_count"]."'>Reject</a>");
    echo"</td></tr>\n";
}
echo "</tbody> </table></div> </div>";
    
?>
   
  