<?php

require_once("data.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $division = $_POST["division"];
    $user = $_POST["user"];
    $classification = $_POST["classification"];
    $user_type = $_POST["user_type"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $write_date = date('Y-m-d H:i:s'); // 현재 시간을 가져옵니다.

    // 파일 업로드 처리
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["path"]["name"]);

    if (move_uploaded_file($_FILES["path"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["path"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $path = $target_file; // 데이터베이스에 저장할 파일 경로

    $pdb = db_connects();

    $sql = "INSERT INTO notice_data (list_division, list_user, list_classification, list_user_type, list_title, list_content, list_path, list_write_date) VALUES (:division, :user, :classification, :user_type, :title, :content, :path, :write_date)";
    
    $param = array(':division'=>$division, ':user'=>$user, ':classification'=>$classification, ':user_type'=>$user_type, ':title'=>$title, ':content'=>$content, ':path'=>$path, ':write_date'=>$write_date);

    $result = db_insert($sql, $param);

    if ($result) {
        echo "Data inserted successfully!";
    } else {
        echo "Failed to insert data.";
    }
}
header("Location:list.php");
?>
