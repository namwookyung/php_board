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
                    <th width="50">번호</th>
                    <th width="500">제목</th>
                    <th width="150">글쓴이</th>
                    <th width="100">작성일</th>
                    <th width="75">조회수</th>
                    <th width="75">좋아요</th>
                    <th width="75">싫어요</th>
                </tr>
            </thead>
            <?php
            // php_board 테이블에서 idx를 기준으로 내림차순해서 10개까지 표시
            $sql = query("select * from php_board order by idx desc limit 0, 10");
            while($board = $sql -> fetch_array()) {
                // post_title 변수에 DB에서 가져온 title을 선택
                $title = $board["post_title"];
                if(strlen($title) > 30) {
                    // title이 30을 넘어서면 ... 표시
                    $title = str_replace($board["post_title"], mb_substr($board["post_title"], 0, 30, "utf-8")."...", $board["post_title"]);
                }
            }
            ?>
            <tbody>
                <tr>
                    <td width="50">
                        <?php echo $board['idx']; ?>
                    </td>
                    <td width="500">
                        <a href = "">
                            <?php echo $title; ?>
                        </a>
                    </td>
                    <td width="150">
                        <?php echo $board['user_name']; ?>
                    </td>
                    <td width="100">
                        <?php echo $board['post_date']; ?>
                    </td>
                    <td width="75">
                        <?php echo $board['post_views']; ?>
                    </td>
                    <td width="75">
                        <?php echo $board['post_good']; ?>
                    </td>
                    <td width="75">
                        <?php echo $board['post_bad']; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="write_btn">
            <a href="/page/board/write.php">
                <button>글쓰기</button>
            </a>
        </div>
    </div>
</body>
</html>