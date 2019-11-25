<?php
require "../conn.php";

$posts=$_POST;

foreach($posts as $key => $value){
    $posts=trim($value);
}

$password=md5($_POST["password"]);
$user=$_POST["user"];


$query = "SELECT username FROM signin WHERE pass_word = '$password' AND username = '$username'";
//  取得查询结果
$userInfo = $conn->query($query); 

if (!empty($userInfo)) {
    //  当验证通过后，启动 Session
    session_start();
    //  注册登陆成功的 admin 变量，并赋值 true
    $_SESSION["admin"] = true;
    //  将用户名赋值给Session
    $_SESSION["login"]=$user;
    echo $_SESSION["login"];
    echo "登陆成功！";
    header('Location:../抽奖/project2.html');
} else {
    die("用户名密码错误");
    header('Location:project1.html');
}
?>