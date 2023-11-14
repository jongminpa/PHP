<?php

require_once("db_lib.php");
require_once("board_lib.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["division"])) {
        alert("구분선택");
    }else{
        $division = $_POST["division"];
    }
    if (empty($_POST["user"])) {
        alert("작성자누락");
    }else{
        $user = $_POST["user"];
    }
    if (!isset($_POST["classification"])) {
        alert("분류선택");
    }else{
        $classification = $_POST["classification"];
    }
    if (!isset($_POST["user_type"])) {
        alert("고객유형선택");
    }else{
        $user_type = $_POST['user_type'];
        $user_type_str = implode(", ", $user_type);
    }
    if (empty($_POST["title"])) {
        alert("제목누락");
    }else{
        $title = $_POST["title"];
    }
    if (empty($_POST["content"])) {
        alert("내용누락");
    }else{
        $content = $_POST["content"];
    }


    $write_date = date('Y-m-d'); 

    $path = null;

    
    if (isset($_FILES['path']) && $_FILES['path']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['path'];

        $fileName = basename($file['name']);
        $fileTmpName = $file['tmp_name'];

        $uploadDir = 'uploads/';
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpName, $filePath))
        {
            $path = $filePath; // 파일 경로를 변수에 저장
        } else {
            alert ("파일 업로드에 실패했습니다.");
        }
    
    }

    $pdb = db_connects();
    if (!$pdb) {
        alert ("데이터베이스 연결에 실패하였습니다.");
    }
        
    $sql = "INSERT INTO notice_data (list_division, list_user, list_classification, list_user_type, list_title, list_content, list_path, list_wirte_date) VALUES (:division, :user, :classification, :user_type, :title, :content, :path, :write_date)";
    
    $param = array(':division'=>$division, ':user'=>$user, ':classification'=>$classification, ':user_type'=>$user_type_str, ':title'=>$title, ':content'=>$content, ':path'=>$path, ':write_date'=>$write_date);

    $result = db_insert($sql, $param);

    var_dump($result);

    if ($result) {
        echo "<script>alert('저장되었습니다.'); location.href='list.php';</script>";
    } else {
        echo "<script>alert('저장에 실패했습니다.'); history.back();</script>";
    }
}
    header("Location:list.php");
?>