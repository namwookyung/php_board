<?php include $_SERVER['DOCUMENT_ROOT']."/PHP_BOARD/db.php"; ?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>PHP 게시판</title>
    <link rel="stylesheet" type="text/css" href="/PHP_BOARD/css/style.css" />
</head>
<body>
    <div id="board_area">
        <h1>자유게시판</h1>
        <h4>자유롭게 글을 쓸 수 있는 게시판입니다.</h4>
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
                            $title = $board["post_title"];
                            if(strlen($title) > 30) {
                                // title이 30을 넘어서면 ... 표시
                                $title = str_replace($board["post_title"], mb_substr($board["post_title"], 0, 30, "utf-8")."...", $board["post_title"]);
                            }
                ?>
                <tr>
                    <td>
                        <?php echo $board['idx']; ?>
                    </td>
                    <td>
                        <a href = "">
                            <?php echo $title; ?>
                        </a>
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
                        <?php echo $board['post_good']; ?>
                    </td>
                    <td>
                        <?php echo $board['post_bad']; ?>
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