<?php
header('Content-type:text/html;charset=utf-8');
$servername="localhost";
$username="root";
$password="";
$dbname="feather";

$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("连接失败:".$conn->connect_error);
}else{echo"连接成功"."<br>";}

$posts=$_POST;

foreach($posts as $key => $value){
    $posts=trim($value);
}

$password=md5($_POST["password"]);
$user=$_POST["user"];

$sql="INSERT INTO signin (username,pass_word) VALUES ('$user','$password')";
if ($conn->query($sql) === TRUE) {
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>