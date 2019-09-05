<?php

    $con=mysqli_connect("localhost","root","","test");
    session_start();
    $form_data = json_decode(file_get_contents("php://input"));

    $user = $form_data->userid;
    $pass = $form_data->password;
    $query="SELECT * FROM users WHERE userid ='$user' AND password = '$pass'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result) > 0){
        $msg="Present";
        while($row = mysqli_fetch_assoc($result)) {
            $_SESSION['userid']=$row['userid'];
            $_SESSION['username']=$row['username'];
            $_SESSION['role']=$row['role'];
        }
    }
    else{
        $msg="Absent";
    }
    $output='{"message": "'.$msg.'", "role": "'.$_SESSION['role'].'"}';
    echo($output);
?>