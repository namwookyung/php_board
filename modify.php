<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
    $post_no = $_GET['idx'];
    $sql = query("SELECT * FROM php_board WHERE idx='$post_no';");
    $board = $sql -> fetch_array();
?>
<!doctype html>
    <head>
        <meta charset="UTF-8">
        <title>PHP 게시판</title>
        <link rel="stylesheet" href="/php_board/css/style.css" />
    </head>
    <body>
        <div id="board_write">
            <h1>
                <a href="/">자유게시판</a>
            </h1>
            <h4>글을 수정합니다.</h4>
            <div id="write_area">
                <form action="modify_ok.php?idx=<?php echo $post_no; ?>" method="post">
                    <div id="in_title">
                        <textarea name="post_title" id="utitle" rows="1" cols="55" placeholder="제목목" maxlength="100" required><?php echo $board['post_title']; ?></textarea>
                    </div>
                    <hr />
                    <div id="in_name">
                        <textarea name="user_name" id="user_name" rows="1" cols="55" placeholder="글쓴이" maxlength="100" required><?php echo $board['user_name']; ?></textarea>
                    </div>
                    <hr />
                    <div id="in_content">
                        <textarea name="post_content" id="post_content" placeholder="내용" required><?php echo $board['post_content']; ?></textarea>
                    </div>
                    <div class="bt_se">
                        <button type="submit">수정 완료</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>