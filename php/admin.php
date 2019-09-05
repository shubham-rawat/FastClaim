<?php

    $con=mysqli_connect("localhost","root","","test");
    session_start();
    $form_data = json_decode(file_get_contents("php://input"));

    if($_SESSION['role']=="admin"){
        $option = $form_data->option;
        
        if($option=="1"){
            $query="SELECT COUNT(claim_no) as green FROM claims WHERE color='green' ";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $green=$row['green'];
                }
            }
            $query="SELECT COUNT(claim_no) as red FROM claims WHERE color='red' ";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $red=$row['red'];
                }
            }
            $query="SELECT COUNT(claim_no) as yellow FROM claims WHERE color='yellow' ";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $yellow=$row['yellow'];
                }
            }
            $query="SELECT COUNT(userid) as supervisor FROM users where role='supervisor'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $sup=$row['supervisor'];
                }
            }
            $output='{"green": "'.$green.'", "red": "'.$red.'", "yellow": "'.$yellow.'", "supervisors": "'.$sup.'"}';
            echo($output);
        }

        if($option=="2"){
            $query="SELECT * FROM claims WHERE color='green'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $output[]=$row;
                }
            }
            echo json_encode($output);
        }

        if($option=="3"){
            $query="SELECT * FROM claims WHERE color='yellow'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $output[]=$row;
                }
            }
            echo json_encode($output);
        }

        if($option=="4"){
            $query="SELECT * FROM claims WHERE color='red'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $output[]=$row;
                }
            }
            echo json_encode($output);
        }

        if($option=="5"){
            $output="";
            $query="SELECT username, userid FROM users WHERE role='supervisor'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $output=$output.'{"username":"'.$row['username'].'", "userid":"'.$row['userid'].'",';
                    $query2="SELECT COUNT(claim_no) as green FROM claims WHERE color='green' AND supervisor=".$row['userid']."";
                    $result2=mysqli_query($con,$query2);
                    if(mysqli_num_rows($result2)>0){
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $green=$row2['green'];
                        }
                    }
                    $query2="SELECT COUNT(claim_no) as yellow FROM claims WHERE color='yellow' AND supervisor=".$row['userid']."";
                    $result2=mysqli_query($con,$query2);
                    if(mysqli_num_rows($result2)>0){
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $yellow=$row2['yellow'];
                        }
                    }
                    $query2="SELECT COUNT(claim_no) as red FROM claims WHERE color='red' AND supervisor=".$row['userid']."";
                    $result2=mysqli_query($con,$query2);
                    if(mysqli_num_rows($result2)>0){
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $red=$row2['red'];
                        }
                    }
                    $output=$output.'"green":"'.$green.'","red":"'.$red.'","yellow":"'.$yellow.'"},';
                }
            }
            $output=substr($output,0,(strlen($output)-1));
            $output="[".$output."]";
            echo ($output);
        }

        if($option==6){
            $id=$form_data->id;
            $color=$form_data->colors;
            $query="SELECT * FROM claims WHERE color='$color' AND supervisor='$id'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $output[]=$row;
                }
                echo json_encode($output);
            }
            else{
                echo '[{"claim_no":"","type":"","details":""}]';
            }
        }

        // GETTING THE PIE DATA
        if($option==7){
            $query="SELECT COUNT(claim_no) as one FROM claims WHERE stage='1' ";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $one=$row['one'];
                }
            }
            $query="SELECT COUNT(claim_no) as two FROM claims WHERE stage='2' ";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $two=$row['two'];
                }
            }
            $query="SELECT COUNT(claim_no) as three FROM claims WHERE stage='3' ";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $three=$row['three'];
                }
            }
            $output='[{"name":"Claims In Intials Stage","sliced": true,"selected": true,"y":'.$one.'},{"name":"Claims In Injury Treatment Stage","y":'.$two.'},{"name":"Claims That Are Ready To Close","y":'.$three.'}]';
            echo($output);
        }

        if($option==8){
            $role=$form_data->role;
            $userid=$form_data->userid;
            $username=$form_data->username;
            $query="INSERT INTO users ( userid, username, password, role) VALUES ('$userid','$username','123456','$role')";
            if(mysqli_query($con,$query)){
                if($role=='adjuster'){
                    echo '{"message": "Adjuster Added"}';
                }
                else{
                    echo '{"message": "Supervisor Added"}';
                }
            }
            else{
                echo '{"message": "User Id already exists!"}';
            }
        }
        if($option==9){
            $_SESSION['claim_no'] = $form_data->claim;
            echo '{"message": "'.$_SESSION['claim_no'].'"}';
        }
    }
?>