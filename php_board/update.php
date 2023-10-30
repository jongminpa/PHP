<?php
require_once("db_lib.php");
require_once("board_lib.php");


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $list_num = $_POST['list_num'];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $write_date = date('Y-m-d'); 
}

// echo $list_num."<br>";
// echo $title."<br>";
// echo $content."<br>";
// echo $write_date."<br>";

$sql = "UPDATE notice_data SET list_title = '$title', list_content = '$content', list_wirte_date ='$write_date' WHERE list_num = '$list_num'";


$result = db_update_delete($sql);


if($result){
    echo "<script>alert('수정되었습니다.'); location.href='list.php';</script>";
}else{
    echo "<script>alert('오류가 발생하였습니다.'); location.href='list.php';</script>";
}

?>