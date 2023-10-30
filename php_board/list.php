<?php
require_once("db_lib.php");
require_once("board_lib.php");

$title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
$author = isset($_GET['search_author']) ? $_GET['search_author'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 목록</title>
    <link rel="stylesheet" href="style_list.css">
</head>
<body>
    <h1>목록</h1>
    <form method="GET" action = "">
    <div class="search">
        <span>제목
        <input type="text" id="search_title" name="search_title" value = "<?php echo sacarXss($title)?>">
        </span>
        <span>작성자
        <input type="text" id="search_author" name="search_author" value = "<?php echo sacarXss($author)?>">
        </span>
        <span>작성일자
        <input type="date" id="start_date" name="start_date" value = "<?php echo sacarXss($start_date)?>">
        <input type="date" id="end_date" name="end_date" value = "<?php echo sacarXss($end_date)?>">
        </span>
        <input type="submit" value="검색" id="search-button">
    </div>   
    </form>

    <table class="board-list">
    <thead>
        <tr>
            <th class="col1">번호</th>
            <th class="col2">구분</th>
            <th class="col3">제목</th>
            <th class="col4">첨부</th>
            <th class="col5">작성일</th>
            <th class="col6">작성자</th>
            <th class="col7">조회수</th>
        </tr>
    </thead>
    <tbody>
        <?php
                $pdo = db_connects();
            
                $posts_per_page = 10;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $posts_per_page;
            
                $sql = "SELECT * FROM notice_data WHERE 1=1 ";
                $params = [];
            
                if (!empty($title)) {
                    $sql .= "AND list_title LIKE ? ";
                    $params[] = "%$title%";
                }
            
                if (!empty($author)) {
                    $sql .= "AND list_user LIKE ? ";
                    $params[] = "%$author%";
                }
            
                if (!empty($start_date) && !empty($end_date)) {
                    $sql .= "AND list_wirte_date BETWEEN ? AND ? ";
                    $params[] = $start_date;
                    $params[] = $end_date;
                }
            
                $sql .= "ORDER BY list_num DESC LIMIT $posts_per_page OFFSET $offset";
            
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td class='col1'>" . htmlspecialchars($row['list_num']) . "</td>";
                    echo "<td class='col2'>" . htmlspecialchars($row['list_division']) . "</td>";
                    echo "<td class='col3'><a href='view.php?list_num=" . htmlspecialchars($row['list_num']) . "'>" . htmlspecialchars($row['list_title']) . "</a></td>";
                    echo "<td class='col4'>" . htmlspecialchars($row['list_path']) . "</td>";
                
                    if (isset($row['list_wirte_date'])) {
                        echo "<td class='col5'>" . htmlspecialchars($row['list_wirte_date']) . "</td>";
                    } else {
                        echo "<td class='col5'>N/A</td>";
                    }
                
                    if (isset($row['list_user'])) {
                        echo "<td class='col6'>" . htmlspecialchars($row['list_user']) . "</td>";
                    } else {
                        echo "<td class='col6'>N/A</td>";
                    }
                
                    echo "<td class='col7'>" . htmlspecialchars($row['list_click']) . "</td>";
                    echo "</tr>";
                }
            
        
            
            $sql_total_posts = "SELECT COUNT(*) as total_posts FROM notice_data";
            $stmt_total = $pdo->query($sql_total_posts);
            $total_posts = $stmt_total->fetch(PDO::FETCH_ASSOC)['total_posts'];
            $total_pages = ceil($total_posts / $posts_per_page);
        ?>
    </tbody>
</table>
<div class="pagination">
<div class="add-post-button">
    <a href="data_input.php?viewmode=write">글 등록</a>
</div>
    <ul>
        <li><a href="?page=1">&#60;&#60;</a></li>
        <li><a href="?page=<?= max(1, $page-1) ?>">&#60;</a></li>
        <?php for($i=1; $i<=$total_pages; $i++): ?>
            <li><a href="?page=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>
        <li><a href="?page=<?= min($total_pages, $page+1) ?>">&#62;</a></li>
        <li><a href="?page=<?= $total_pages ?>">&#62;&#62;</a></li>
    </ul>
</div>
</body>
</html>


