<?php

    $con=mysqli_connect("localhost","root","","test");
    session_start();
    $form_data = json_decode(file_get_contents("php://input"));
    
    $option = $form_data->option;

    if($option==1){
        $query='SELECT * FROM claimants WHERE claim_no='.$_SESSION['claim_no'];
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                $output=$row;
            }
        }
        echo json_encode($output);
    }
    
    if($option==2){
        $offer = $form_data->offer;
        $details = $form_data->details;

        $query="UPDATE claimants SET offer='$offer',details='$details' WHERE claim_no=".$_SESSION['claim_no'];
        if(mysqli_query($con,$query)){
            echo'{"message": "Success"}';
        }
        else {
            echo'{"message": "Fail"}';
        }
    }
?>