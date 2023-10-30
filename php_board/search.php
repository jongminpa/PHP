<?php
require_once("db_lib.php");
require_once("board_lib.php");

$title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
$author = isset($_GET['search_author']) ? $_GET['search_author'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';


$posts_per_page = 10; // 여기에 원하는 값으로 설정
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;


$sql = $sql = "SELECT * FROM notice_data where 1=1";
$params = [];
if (!empty($title)) {
    $sql .= " AND list_title LIKE ?";
    $params[] = "%$title%";
}

if (!empty($author)) {
    $sql .= " AND list_user LIKE ?";
    $params[] = "%$author%";
}

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND list_wirte_date BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
}

$sql .= " ORDER BY list_num DESC LIMIT $posts_per_page OFFSET $offset";

$results = db_select($sql, $params);

?>