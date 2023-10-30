<?php
require_once ("db_lib.php");

$list_num = isset($_GET['list_num']) ? $_GET['list_num'] : '';

//var_dump($list_num);
$sql = "Delete from notice_data where list_num='$list_num'" ;

$result = db_update_delete($sql);

header("Location:list.php");

?>