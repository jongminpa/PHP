<?php
require_once("db_lib.php");

$viewmode = isset($_GET['viewmode']) ? $_GET['viewmode'] :'';
$list_num = isset($_GET['list_num']) ? $_GET['list_num'] : '';
if($viewmode == "edit" && $list_num){
    $sql = "SELECT * FROM notice_data where list_num = $list_num";

    $pdo = db_connects();
    $result = db_select($sql);

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
    

    $user_type_array=explode(",",$user_type);
    $user_type_array = array_map('trim', $user_type_array);
    //var_dump ($user_type_array);
}


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기게시판</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function check_input(){
            return true;
        }

        function singleCheckbox(checkbox) {
            var checkboxes = document.getElementsByName('user_type[]');
            checkboxes.forEach(function(item) {
            if (item !== checkbox) item.checked = false;
            });
        }

        function updateFilename() {
            var fileInput = document.querySelector('input[type=file]');
            var filenameDisplay = document.getElementById('filename');
    
            var filename = fileInput.value.split('\\').pop(); 
            filenameDisplay.value = filename ? filename : '선택된 파일 없음'; 
        }
        document.addEventListener('DOMContentLoaded', function () {
            var fileInput = document.querySelector('input[name="path"]');
            var filenameField = document.getElementById('filename');

            fileInput.addEventListener('change', function () {
            var files = fileInput.files;
            if (files.length > 0) {
                filenameField.value = files[0].name;
            } else {
                filenameField.value = "선택된 파일 없음";
            }
            });
        });        
    </script>
</head>
<body>
    <h1>등록</h1>
    <form name="board" method="post" action="<?php echo ($viewmode == 'edit') ? 'update.php' : 'insert.php'; ?>" enctype="multipart/form-data">
        <table>
            <tr><?php if($viewmode == "write") {?>
                <th>구분(필수)</th>
                <td>
                    <select class = "select1" name="division">
                    <option value="" selected disabled>선택해주세요</option> 
                    <option value="유지보수">유지보수</option> 
                    <option value="문의사항">문의사항</option> 
                </select>
                (유지보수, 문의사항)
                </td>
                <?php } else {?>
                <th>구분</th>
                <td>
                    <select class = "select1" name="division">
                    <option value="<?php echo $division?>" disabled selected ><?php echo $division?></option>
                </select>
                </td>
                <?php }?>
            </tr>
            <tr><?php if($viewmode == "write") {?>
                <th>작성자(필수)</th>
                <td><input class = "input1"name="user" type="text"></td>
                <?php } else{ ?>
                <th>작성자</th>
                <td><input class="input1" name="user" type="text" value="<?php echo $name; ?>" disabled></td>
                <?php } ?>
            </tr>
            <tr><?php if($viewmode == "write") {?>
                <th>분류(필수)</th>
                <td>
                <input type="radio" id="option1" name="classification" value="홈페이지">
                <label for="option1">홈페이지</label>
        
                <input type="radio" id="option2" name="classification" value="네트워크">
                <label for="option2">네트워크</label>
        
                <input type="radio" id="option3" name="classification" value="서버">
                <label for="option3">서버</label>
                </td>    <?php }else{ ?>
                <th>분류</th>
                    <td> 
                    <input type="radio" id="option1" name="classification" value="홈페이지" 
                    <?php if($classification == "홈페이지") echo 'checked'; ?> 
                    <?php if($viewmode != "write") echo 'disabled'; ?>
                    <label for="option1">홈페이지</label>
            
                    <input type="radio" id="option2" name="classification" value="네트워크" 
                    <?php if($classification == "네트워크") echo 'checked';?>;
                    <?php if($viewmode != "write") echo 'disabled'; ?>>
                    <label for="option2">네트워크</label>
            
                    <input type="radio" id="option3" name="classification" value="서버" 
                    <?php if($classification == "서버") echo 'checked';?>
                    <?php if($viewmode != "write") echo 'disabled'; ?>>
                    <label for="option3">서버</label>
                    </td>
                    <?php  }?>
            </tr>
            <tr><?php if($viewmode == "write") {?>
                <th>고객 유형</th>
                <td>
                <input type="checkbox" id="user_type1" name="user_type[]" value="호스팅" >
                <label for="user_type1">호스팅</label>
        
                <input type="checkbox" id="user_type2" name="user_type[]" value="유지보수" >
                <label for="user_type2">유지보수</label>
        
                <input type="checkbox" id="user_type3" name="user_type[]" value="서버임대" >
                <label for="user_type3">서버 임대</label>

                <input type="checkbox" id="user_type4" name="user_type[]" value="기타">
                <label for="user_type3">기타</label>
                </td>
                <?php }  else {?>
                <th>고객 유형</th>
                <td>
                <input type="checkbox" id="user_type1" name="user_type[]" value="호스팅"
                <?php if(in_array("호스팅", $user_type_array)) echo "checked"; ?>
                <?php if($viewmode != "write") echo 'disabled'; ?>
                <label for="user_type1">호스팅</label>
        
                <input type="checkbox" id="user_type2" name="user_type[]" value="유지보수" 
                <?php if(in_array("유지보수", $user_type_array)) echo "checked"; ?>
                <?php if($viewmode != "write") echo 'disabled'; ?>                
                <label for="user_type2">유지보수</label>
        
                <input type="checkbox" id="user_type3" name="user_type[]" value="서버임대"  
                <?php if(in_array("서버임대", $user_type_array)) echo "checked"; ?>
                <?php if($viewmode != "write") echo 'disabled'; ?>
                <label for="user_type3">서버 임대</label>

                <input type="checkbox" id="user_type4" name="user_type[]" value="기타" 
                <?php if(in_array("기타", $user_type_array)) echo "checked"; ?>
                <?php if($viewmode != "write") echo 'disabled'; ?>
                <label for="user_type3">기타</label>
                </td><?php }?>
            </tr>
            <tr><?php if ($viewmode == "write") { ?>
                <th>제목(필수)</th>
                <td><input class = "input2"name="title" type="text"></td>
                <?php }else{?>
                <th>제목</th>
                <td><input class = "input2"name="title" type="text" value = "<?php echo $title ?>"></td>
                <?php }?>    
            </tr>
            <tr><?php if ($viewmode == "write") { ?>
                <th>내용(필수)</th>
                <td><input class = "input3" type = "text" name = content></td>
                <?php } else{?>
                <th>내용</th>
                <td><input class = "input3" type = "text" name = content value = "<?php echo $content ?>"></td>
                <?php }?>    
            </tr>
            <tr>
                <th>첨부파일</th>
                <td>
                    <input type="text" id="filename" placeholder="선택된 파일 없음" readonly>
                    <input type="file" name="path" value = "찾아보기">
                </td>
            </tr>
        </table>

        <input type="hidden" name="list_num" value="<?php echo $list_num; ?>">
        
        <div class="submit-buttons">
            <input type="submit" value="저장">
            <input type="button" value="취소" onclick="location.href='list.php';">
        </div>
    </form>
</body>
</html>