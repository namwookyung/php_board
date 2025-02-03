<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
    $idx = $_GET['idx'];
    $sql = query("SELECT * FROM php_board WHERE idx='$idx';");
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
                <form action="modify_ok.php?idx=<?php echo $idx; ?>" method="post">
                    <div id="in_title">
                        <textarea name="title" id="utitle" rows="1" cols="55" placeholder="글쓴이" maxlength="100" required>
                            <?php echo $board['name']; ?>
                        </textarea>
                    </div>