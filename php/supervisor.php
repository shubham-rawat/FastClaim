<?php
$con=mysqli_connect("localhost","root","","test");

session_start();
$supervisorId=$_SESSION['userid'];
$supervisorName=$_SESSION['username'];

$form_data = json_decode(file_get_contents("php://input"));
$option=$form_data->option;

if($option==1){

  $query="SELECT COUNT(claim_no) as green FROM claims WHERE color='green' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $green=$row['green'];
      }
  }
  $query="SELECT COUNT(claim_no) as red FROM claims WHERE color='red' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $red=$row['red'];
      }
  }
  $query="SELECT COUNT(claim_no) as yellow FROM claims WHERE color='yellow' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $yellow=$row['yellow'];
      }
  }
  $query="SELECT COUNT(DISTINCT adjuster) as adjusters FROM claims WHERE supervisor = '$supervisorId'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
            $adjs=$row['adjusters'];
        }
    }

  $output='{"green": "'.$green.'", "red": "'.$red.'", "yellow": "'.$yellow.'", "name": "'.$supervisorName.'", "adjusters": "'.$adjs.'"}';
  echo($output);
}

// GET CLAIMS GREEN
if($option=="2"){
  $query="SELECT * FROM claims WHERE color='green' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $output[]=$row;
      }
  }
  echo json_encode($output);
}

// GET CLAIMS YELLOW

if($option=="3"){
  $query="SELECT * FROM claims WHERE color='yellow' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $output[]=$row;
      }
  }
  echo json_encode($output);
}

// GET CLAIMS RED

if($option=="4"){
  $query="SELECT * FROM claims WHERE color='red' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $output[]=$row;
      }
  }
  echo json_encode($output);
}

//GETTING THE PIE CAHRT DATA

if($option==5){
  $query="SELECT COUNT(claim_no) as one FROM claims WHERE stage='1' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $one=$row['one'];
      }
  }
  $query="SELECT COUNT(claim_no) as two FROM claims WHERE stage='2' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $two=$row['two'];
      }
  }
  $query="SELECT COUNT(claim_no) as three FROM claims WHERE stage='3' AND supervisor = '$supervisorId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $three=$row['three'];
      }
  }
  $output='[{"name":"Claims In Intials Stage","sliced": true,"selected": true,"y":'.$one.'},{"name":"Claims In Injury Treatment Stage","y":'.$two.'},{"name":"Claims That Are Ready To Close","y":'.$three.'}]';
  echo($output);
}


if($option==6){
    $output="";
    $query="SELECT username, userid FROM users WHERE role='adjuster'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {

            $query1="SELECT * FROM claims WHERE adjuster=".$row['userid']." AND supervisor='$supervisorId' ";
            $result1=mysqli_query($con,$query1);
            if(mysqli_num_rows($result1) > 0){

                $output=$output.'{"username":"'.$row['username'].'", "userid":"'.$row['userid'].'",';
                $query2="SELECT COUNT(claim_no) as green FROM claims WHERE color='green' AND supervisor = '$supervisorId' AND adjuster=".$row['userid']."";
                $result2=mysqli_query($con,$query2);
                if(mysqli_num_rows($result2)>0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $green=$row2['green'];
                    }
                }
                $query2="SELECT COUNT(claim_no) as yellow FROM claims WHERE color='yellow' AND supervisor = '$supervisorId' AND adjuster=".$row['userid']."";
                $result2=mysqli_query($con,$query2);
                if(mysqli_num_rows($result2)>0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $yellow=$row2['yellow'];
                    }
                }
                $query2="SELECT COUNT(claim_no) as red FROM claims WHERE color='red' AND supervisor = '$supervisorId' AND adjuster=".$row['userid']."";
                $result2=mysqli_query($con,$query2);
                if(mysqli_num_rows($result2)>0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $red=$row2['red'];
                    }
                }
                $output=$output.'"green":"'.$green.'","red":"'.$red.'","yellow":"'.$yellow.'"},';
                }
        }
    }
    $output=substr($output,0,(strlen($output)-1));
    $output="[".$output."]";
    echo ($output);
}


if($option==7){
    $id=$form_data->id;
    $color=$form_data->colors;
    $query="SELECT * FROM claims WHERE color='$color' AND adjuster='$id'";
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

?>