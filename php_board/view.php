<?php
require_once ("db_lib.php");
require_once ("board_lib.php");

$list_num = isset($_GET['list_num']) ? $_GET['list_num'] : '';

$pdo = db_connects();

$sql_2="UPDATE notice_data SET list_click = list_click + 1 WHERE list_num = '$list_num'";
db_update_delete($sql_2);

$sql = "SELECT * FROM notice_data WHERE list_num = $list_num";
$result = db_select($sql);

$division = $name = $classification = $user_type = $title = $content = $path = "";

if ($result && count($result) > 0) {
    $division = $result[0]["list_division"];
    $name = $result[0]["list_user"];
    $classification = $result[0]["list_classification"];
    $user_type = $result[0]["list_user_type"];
    $title = $result[0]["list_title"];
    $content = $result[0]["list_content"];
    $path = $result[0]["list_path"];
} else {
    alert ("데이터를 찾을 수 없습니다.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_view.css">
    <title>조회</title>
</head>
<body>
    <h1>조회</h1>
    <table border="1">
        <tr>
            <th>구분</th>
            <td><?= htmlspecialchars($division) ?></td>
        </tr>
        <tr>
            <th>작성자</th>
            <td><?= htmlspecialchars($name) ?></td>
        </tr>
        <tr>
            <th>분류</th>
            <td><?= htmlspecialchars($classification) ?></td>
        </tr>
        <tr>
            <th>고객 유형</th>
            <td><?= htmlspecialchars($user_type) ?></td>
        </tr>
        <tr>
            <th>제목</th>
            <td><?= htmlspecialchars($title) ?></td>
        </tr>
        <tr>
            <th class = "content1">내용</th>
            <td><?= nl2br(htmlspecialchars($content)) ?></td> 
        </tr>
        <tr>
            <th>첨부파일</th>
            <td><a href="<?= $path?>" target="_blank">다운로드</a></td>
        </tr>
    </table>
    <div class="button-group">
    <button onclick="location.href='data_input.php?list_num=<?php echo $list_num; ?>&viewmode=edit'">수정</button>
    <button onclick="location.href='delete.php?list_num=<?php echo $list_num;?>'">삭제</button>
    <button onclick="location.href='list.php'">목록보기</button>
</div>
</body>
</html>
