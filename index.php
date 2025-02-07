<?php include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php"; ?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>PHP 게시판</title>
    <link rel="stylesheet" type="text/css" href="/php_board/css/style.css" />
</head>
<body>
    <div id="board_area">
        <h1>자유게시판</h1>
        <h4>PHP로 만든 간단한 게시판입니다.</h4>
        <table class="list-table">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>글쓴이</th>
                    <th>작성일</th>
                    <th>조회수</th>
                    <th>좋아요</th>
                    <th>싫어요</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // php_board 테이블에서 idx를 기준으로 내림차순해서 10개까지 표시
                    $sql = query("SELECT * FROM php_board ORDER BY idx DESC LIMIT 0, 10");

                    if (!$sql) {
                        die("쿼리 실행 오류: " . $db->error);
                    }

                    // 게시글이 있는지 확인
                    if ($sql->num_rows == 0) {
                        echo "<tr><td colspan='7' style='text-align: center;'>게시글이 없습니다.</td></tr>";
                    } else {
                        while($board = $sql -> fetch_array()) {
                            // post_title 변수에 DB에서 가져온 title을 선택
                            $post_title = $board["post_title"];
                            if(strlen($post_title) > 30) {
                                // title이 30을 넘어서면 ... 표시
                                $post_title = str_replace($board["post_title"], mb_substr($board["post_title"], 0, 30, "utf-8")."...", $board["post_title"]);
                            }
                ?>
                <tr>
                    <td>
                        <?php echo $board['idx']; ?>
                    </td>
                    <td>
                        <?php $lockimg = "<img src='icon/lock-solid.svg' alt='lock' title='lock' width='16' height='16' />";
                        if($board['post_lock'] == "1") {
                            ?><a href="/php_board/api/board/ck_read.php?idx=<?php echo $board['idx'];?>"><?php echo $post_title, $lockimg;
                        } else {
                            ?>
                            <a href="/php_board/page/board/read.php?idx=<?php echo $board["idx"];?>"><?php echo $post_title;}?></a>
                    </td>
                    <td>
                        <?php echo $board['user_name']; ?>
                    </td>
                    <td>
                        <?php echo $board['post_date']; ?>
                    </td>
                    <td>
                        <?php echo $board['post_views']; ?>
                    </td>
                    <td>
                        <?php echo $board['post_up']; ?>
                    </td>
                    <td>
                        <?php echo $board['post_down']; ?>
                    </td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
        <div id="write_btn">
            <a href="/php_board/page/board/write.php">
                <button class="write_btn">글쓰기</button>
            </a>
        </div>
    </div>
</body>
</html>