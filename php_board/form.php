<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기게시판</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function check_input(){
            // ... (함수 내용은 동일)
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
    
            var filename = fileInput.value.split('\\').pop(); // 파일 경로에서 파일 이름만 가져옴
            filenameDisplay.value = filename ? filename : '선택된 파일 없음'; // 파일 이름 표시
}        
    </script>
</head>
<body>
    <h1>등록</h1>
    <form name="board" method="post" action="insert.php" onsubmit="return check_input()" enctype="multipart/form-data">
        <table>
            <tr>
                <th>구분(필수)</th>
                <td>
                    <select class = "select1" name="division">
                    <option value="" selected disabled>선택해주세요</option> <!-- input 태그를 select 태그로 변경 -->
                    <option value="maintenance">유지보수</option> <!-- 옵션 추가 -->
                    <option value="inquiry">문의사항</option> <!-- 옵션 추가 -->
                </select>
                (유지보수, 문의사항)
                </td>
            </tr>
            <tr>
                <th>작성자(필수)</th>
                <td><input class = "input1"name="user" type="text"></td>
            </tr>
            <tr>
                <th>분류(필수)</th>
                <td>
                <input type="radio" id="option1" name="classification" value="option1">
                <label for="option1">홈페이지</label>
        
                <input type="radio" id="option2" name="classification" value="option2">
                <label for="option2">네트워크</label>
        
                <input type="radio" id="option3" name="classification" value="option3">
                <label for="option3">서버</label>
                </td>
            </tr>
            <tr>
                <th>고객 유형</th>
                <td>
                <input type="checkbox" id="user_type1" name="user_type" value="type1" onclick="singleCheckbox()">
                <label for="user_type1">호스팅</label>
        
                <input type="checkbox" id="user_type2" name="user_type" value="type2" onclick="singleCheckbox()">
                <label for="user_type2">유지보수</label>
        
                <input type="checkbox" id="user_type3" name="user_type" value="type3" onclick="singleCheckbox()">
                <label for="user_type3">서버 임대</label>

                <input type="checkbox" id="user_type4" name="user_type" value="type3" onclick="singleCheckbox()">
                <label for="user_type3">기타</label>
                </td>
            </tr>
            <tr>
                <th>제목(필수)</th>
                <td><input class = "input2"name="title" type="text"></td>
            </tr>
            <tr>
                <th>내용(필수)</th>
                <td><input class = "input3" type = "text" name = content></td>
            </tr>
            <tr>
                <th>첨부파일</th>
                <td>
                    <input type="text" id="filename" placeholder="선택된 파일 없음" readonly>
                    <input type="file" name="path" value = "찾아보기">
                </td>
            </tr>
        </table>
        <div class="submit-buttons">
            <input type="submit" value="저장">
            <input type="button" value="취소">
        </div>
    </form>
</body>
</html>
