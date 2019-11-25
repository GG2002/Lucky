<?php
header('Content-type:text/html;charset=utf-8');

$servername="localhost";
$username="root";
$password="";
$dname="feather";
$conn=new mysqli($servername,$username,$password,$dname);
if($conn->connect_error){
    die("连接失败".$conn->connect_error);
}