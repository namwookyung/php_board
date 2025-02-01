<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>PHP 게시판</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>
    <div id="board_write">
        <h1>
            <a href="/">자유게시판</a>
        </h1>
        <h4>글을 작성하는 공간입니다.</h4>
        <div id="write_area">
            <form action="write_ok.php" method="post">
                <div id="in_title">
                    <textarea name="post_title" id="post_title" rows="1" cols="55" placeholder="제목" maxlength="100" required></textarea>
                </div>
                <div class="wi_line"></div>
                <div id="in_name">
                    <textarea name="user_name" id="user_name" rows="1" cols="55" placeholder="작성자" maxlength="100" required></textarea>
                </div>
                <div class="wi_line"></div>
                <div id="in_content">
                    <textarea name="post_content" id="post_content" placeholder="내용" required></textarea>
                </div>
                <div id="in_pw">
                    <input type="password" name="user_pw" id="user_pw" placeholder="비밀번호" required />
                </div>
                <div class="bt_se">
                    <button type="submit">작성 완료</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>