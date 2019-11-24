<?php
require '../conn.php';
session_start();
if(isset($_SESSION["admin"])&&$_SESSION["admin"]===true){
//取得用户名
$user=$_SESSION["login"];

//取得奖池
switch($_POST["choice"]){
    case "人名":
    $_SESSION["database"]="stu_name1";
    break;
    case "真心话":
    $_SESSION["database"]="real_word";
    break;
    case "大冒险":
    $_SESSION["database"]="big_adven";
    break;
}
$DB=$_SESSION["database"];

//取得奖品数
$sql="SELECT COUNT(id) AS num FROM $DB";
$awardNum=$conn->query($sql);
$row=mysqli_fetch_assoc($awardNum);
$awardNum=$row["num"];

// echo $user;
//取得已抽奖次数
$sql="SELECT lucky FROM signin WHERE username='$user'";
$lucky=$conn->query($sql);
$row=mysqli_fetch_assoc($lucky);
$lucky=$row["lucky"];

if($lucky!=0){
//取得已抽奖奖品
$sql="SELECT reality FROM signin WHERE username='$user'";
$reality=$conn->query($sql);
$row=mysqli_fetch_assoc($reality);
$reality=$row["reality"];
//存入数组
$excl=explode(",",$reality);
}
//抽奖次数
$count=$lucky+$_POST["num"];

// 随机数
for($i=$lucky;$i<$count;$i++)
{
    $num=rand(1,$awardNum);
    //抽奖
    $excl[$i]=$num;
    $y=$i;
    for($j=0;$j<=$i-1;$j++){
    if($num==$excl[$j])
        {$i--;break;}
    }
    if($j==$i && $j!=$y-1){
//  取得奖品
    $sql="SELECT name FROM $DB WHERE id=$num";
    $result=$conn->query($sql);
    $row=mysqli_fetch_assoc($result);
    echo $row["name"];
    }else{
        if($num==$excl[$j])
        continue;
    }
//  判断是否中奖
    if($num==24){
        $lucky++;
        echo "恭喜中奖！"."<br>";
        if($count==$lucky){
            $count=$i=0;
        }else{
        $count=$count-$lucky;
        $i=-1;
    }
        $lucky=0;
        $reality='0';
        unset($excl);
    }else{
        $lucky++;
        $reality=implode(",",$excl);
        echo"<br>";
    }

    //更新抽奖次数
    $sql="UPDATE signin SET lucky=$lucky WHERE username='$user'";
    $conn->query($sql);

    //将抽过的奖品放入数据库
    $sql="UPDATE signin SET reality='$reality' WHERE username='$user'";
    $conn->query($sql);  
} 
// 程序结束
}else{
    echo"请登录。";
    header("Refresh:3 url=../login/project1.html");
}
?>