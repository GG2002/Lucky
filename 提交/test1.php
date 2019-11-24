<?php
require '../conn.php';

if($_FILES["file"]["error"]>0){
    echo "错误：".$_FILES["file"]["error"];
}else{
    echo "文件名：".$_FILES["file"]["name"]."已提交";
}


if(file_exists("upload/".$_FILES["file"]["name"])){
    //比对文件是否相同，不同则更新，相同则返回主页
    $oldhash=hash_file('md5',"upload/".$_FILES["file"]["name"]);
    $newhash=hash_file('md5',$_FILES["file"]["tmp_name"]);
    $oldfile=filesize("upload/".$_FILES["file"]["name"]);
    $newfile=filesize($_FILES["file"]["tmp_name"]);
    
    
    
    if($oldhash!==$newhash||$oldfile!==$newfile){
        copy($_FILES["file"]["tmp_name"],"upload/".$_FILES["file"]["name"]);
        echo "文件更新成功。";
        $submit=true;
    }else{
    echo $_FILES["file"]["name"]."已经存在";
    $submit=false;
}
}else{
    //不存在则创建新文件
    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
    echo "文件储存在：upload/".$_FILES["file"]["name"];
    $submit=true;
}



//创建新文件或更新则插入数据库
if($submit){
    session_start();
    $_SESSION["name"]="upload/".$_FILES["file"]["name"];
    header("Refresh:1;url=test2.php");
}else{
    header("Refresh:1;url=../");
}
?>