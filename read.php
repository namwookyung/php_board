<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
?>
<!doctype html>
    <head>
        <meta charset="UTF-8">
        <title>PHP 게시판</title>
        <link rel="stylesheet" type="text/css" href="/php_board/css/style.css" />
    </head>
    <body>
        <?php
            $post_no = $_GET['idx'];   /* post_no 함수에 idx값을 받아와 넣음 */
            $post_views = mysqli_fetch_array(query("SELECT * FROM php_board WHERE idx = '".$post_no."'"));
            $post_views = $post_views['post_views'] + 1;
            $fet = query("UPDATE php_board SET post_views = '".$post_views."' WHERE idx = '".$post_no."'");
            $sql = query("SELECT * FROM php_board WHERE idx = '".$post_no."'");    /* 받아온 idx 값을 선택 */
            $board = $sql -> fetch_array();
        ?>
        <!-- 글 조회 -->
        <div id="board_read">
            <h2><?php echo $board['post_title']; ?></h2>
            <div id="user_info">
                <?php echo $board['user_name']; ?> <?php echo $board['post_date']; ?> 조회 수 : <?php echo $board['post_views']; ?>
                <div id="board_line"></div>
            </div>
            <div id="bo_content">
                <?php echo nl2br("$board[post_content]"); ?>
            </div>
            <!-- 목록, 수정, 삭제 -->
            <div id="btn_list">
                <a href="/">
                    <button class="home_btn">목록으로</button>
                </a>
                <a href="modify.php?idx=<?php echo $board['idx']; ?>">
                    <button class="modify_btn">수정</button>
                </a>
                <a href="delete.php?idx=<?php echo $board['idx']; ?>">
                    <button class="delete_btn">삭제</button>
                </a>
            </div>
        </div>
    </body>
</html>