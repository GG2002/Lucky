<?php 
require '../conn.php';
session_start();
$file=fopen($_SESSION["name"],"r+");
while(!feof($file))
{
  $reward=fgets($file);
 
  $sql="INSERT INTO award (award) VALUES ('$reward')";
  if($conn->query($sql)===TRUE){
    echo "成功。";
  }else{
    echo "失败。";
  }
}
fclose($file);
header("Refresh:3;url=../");
?>