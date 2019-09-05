<?php
$con=mysqli_connect("localhost","root","","test");

session_start();
$adjusterId=$_SESSION['userid'];
$adjusterName=$_SESSION['username'];

$form_data = json_decode(file_get_contents("php://input"));
$option=$form_data->option;

if($option==1){

  $query="SELECT COUNT(claim_no) as green FROM claims WHERE color='green' AND adjuster = '$adjusterId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $green=$row['green'];
      }
  }
  $query="SELECT COUNT(claim_no) as red FROM claims WHERE color='red' AND adjuster = '$adjusterId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $red=$row['red'];
      }
  }
  $query="SELECT COUNT(claim_no) as yellow FROM claims WHERE color='yellow' AND adjuster = '$adjusterId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $yellow=$row['yellow'];
      }
  }

  $output='{"green": "'.$green.'", "red": "'.$red.'", "yellow": "'.$yellow.'", "name": "'.$adjusterName.'"}';
  echo($output);
}

// GET CLAIMS GREEN
if($option=="2"){
  $query="SELECT * FROM claims WHERE color='green' AND adjuster = '$adjusterId' ";
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

// GET CLAIMS YELLOW

if($option=="3"){
  $query="SELECT * FROM claims WHERE color='yellow' AND adjuster = '$adjusterId' ";
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

// GET CLAIMS RED

if($option=="4"){
  $query="SELECT * FROM claims WHERE color='red' AND adjuster = '$adjusterId' ";
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

//GETTING THE PIE CAHRT DATA

if($option==5){
  $query="SELECT COUNT(claim_no) as one FROM claims WHERE stage='1' AND adjuster = '$adjusterId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $one=$row['one'];
      }
  }
  $query="SELECT COUNT(claim_no) as two FROM claims WHERE stage='2' AND adjuster = '$adjusterId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $two=$row['two'];
      }
  }
  $query="SELECT COUNT(claim_no) as three FROM claims WHERE stage='3' AND adjuster = '$adjusterId' ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          $three=$row['three'];
      }
  }
  $output='[{"name":"Claims In Intials Stage","sliced": true,"selected": true,"y":'.$one.'},{"name":"Claims In Injury Treatment Stage","y":'.$two.'},{"name":"Claims That Are Ready To Close","y":'.$three.'}]';
  echo($output);
}


// CLAIM NO
if($option==6){
  $_SESSION['claim_no'] = $form_data->claim;
  echo '{"message": "'.$_SESSION['claim_no'].'"}';
}

?>