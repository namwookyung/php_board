<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>PHP 게시판</title>
    <link rel="stylesheet" type="text/css" href="/php_board/css/style.css" />
    <script>
        function isConfirm() {
            return confirm('작성하시겠습니까?');    // 확인(true)이면 제출, 취소(false)면 제출 안 됨
        }
    </script>
</head>
<body>
    <div id="board_write">
        <h1>
            <a href="/">자유게시판</a>
        </h1>
        <h4>글을 작성하는 공간입니다.</h4>
        <div id="write_area">
            <form action="write_ok.php" method="post" onsubmit="return isConfirm();">
                <div id="in_title">
                    <textarea name="post_title" id="post_title" rows="1" cols="55" placeholder="제목" maxlength="100" required
                        style="border:1px solid lightgray; padding:10px; border-radius:5px; width:100%;"></textarea>
                </div>
                <hr />
                <div id="in_name">
                    <textarea name="user_name" id="user_name" rows="1" cols="55" placeholder="작성자" maxlength="100" required
                        style="border:1px solid lightgray; padding:10px; border-radius:5px; width:100%;"></textarea>
                </div>
                <hr />
                <div id="in_content">
                    <textarea name="post_content" id="post_content" placeholder="내용" required
                        style="border:1px solid lightgray; padding:10px; border-radius:5px; width:100%; height:50vh;"></textarea>
                </div>
                <div id="in_pw">
                    <input type="password" name="user_pw" id="user_pw" placeholder="비밀번호" required
                        style="border:1px solid lightgray; padding:10px; border-radius:5px; width:100%;"/>
                </div>
                <div id="in_lock" style="font-size: 14px;">
                    <input type="checkbox" value="1" name="post_lock" />해당 글을 잠급니다.
                </div>
                <hr />
                <div class="bt_se" style="text-align:right;">
                    <button style="padding:8px 20px 8px 20px; color: #fff; background-color: skyblue;
                    border-radius: 5px; border: 1px solid skyblue; font-size: 16px;" type="submit">작성 완료</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>