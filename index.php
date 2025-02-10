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
            <?php
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $sql = query("SELECT * FROM post");
            $row_num = mysqli_num_rows($sql);   // 게시판 총 레코드 수
            $list = 10; // 한 페이지에 보여줄 개수
            $block_ct = 5;  // 블록당 보여줄 페이지 개수

            $block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기
            $block_start = (($block_num - 1) * $block_ct) + 1;   // 블록의 시작 번호
            $block_end = $block_start + $block_ct - 1;  // 블록 마지막 번호

            $total_page = ceil($row_num / $list);   // 페이징한 페이지 수 구하기
            if($block_end > $total_page) $block_end = $total_page;  // 만약 블록의 마지막 번호가 페이지 수보다 많다면 마지막 번호는 페이지 수
            $total_block = ceil($total_page/$block_ct); // 블럭 총 개수
            $start_num = ($page - 1) * $list;   // 시작 번호(page - 1)에서 $list를 곱한다.

            $sql2 = query("SELECT * FROM post ORDER BY post_idx DESC LIMIT $start_num, $list");
            while($post = $sql2 -> fetch_array()) {
                $title = $post["post_title"];
                if(strlen($title) > 30) {
                    $title = str_replace($post["post_title"], mb_substr($post["post_title"], 0, 30, "utf-8")."...", $post["post_title"]);
                }
                $reply_idx = $post["post_idx"];
                $reply_connect = query("SELECT COUNT(*) AS reply_connect FROM reply WHERE reply_connect=$reply_idx");
                $reply_count = $reply_connect -> fetch_array();
            }
            ?>
            <tbody>
                <?php
                    // post 테이블에서 post_idx를 기준으로 내림차순해서 10개까지 표시
                    $sql = query("SELECT * FROM post ORDER BY post_idx DESC LIMIT 0, 10");

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

                            // 댓글 수 불러오기
                            $con_idx = $board['post_idx'];
                            $reply_connect = query("SELECT COUNT(*) AS reply_connect FROM reply WHERE reply_connect = $con_idx");
                            $con_reply_count = $reply_connect -> fetch_array();

                            if(strlen($post_title) > 30) {
                                // title이 30을 넘어서면 ... 표시
                                $post_title = str_replace($board["post_title"], mb_substr($board["post_title"], 0, 30, "utf-8")."...", $board["post_title"]);
                            }
                ?>
                <tr>
                    <td>
                        <?php echo $board['post_idx']; ?>
                    </td>
                    <td>
                        <?php $lockimg = "<img src='icon/lock-solid.svg' alt='lock' title='lock' width='16' height='16' />";
                        if($board['post_lock'] == "1") {
                            ?><a href="/php_board/api/post/ck_read.php?post_idx=<?php echo $board['post_idx'];?>"><?php echo $post_title,"[".$con_reply_count["reply_connect"]."]", $lockimg;
                        } else {
                            ?>
                            <a href="/php_board/page/post/read.php?post_idx=<?php echo $board["post_idx"];?>"><?php echo $post_title."[".$con_reply_count["reply_connect"]."]";}?></a>
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
        <div id="page_num">
            <ul>
                <?php
                if($page <= 1){ // 만약 page가 1보다 작거나 같다면
                    echo "<li class='fo_re'>처음</li>"; // 처음이라는 글자에 빨간색 표시
                } else {
                    echo "<li><a href='?page=1'>처음</a></li>"; // 아니라면 처음 글자에 1번 페이지로 갈 수 있게 링크
                }
                if($page <= 1){ // 만약 page가 1보다 작거나 같다면 빈값

                } else {
                    $pre = $page - 1;   // pre 변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전 버튼을 누르면 2번 페이지로 갈 수 있게 함
                    echo "<li><a href='?page=$pre'>이전</a></li>";  // 이전 글자에 pre 변수를 링크한다. 이러면 이전 버튼을 누를 때마다 현재 페이지에서 -1하게 됨
                }
                for($i = $block_start; $i <= $block_end; $i++) {    // for문 반복문을 사용하여, 초기값을 블록의 시작 번호를 조건으로 블록 시작 번호가 마지막 블록보다 작거나 같을 때까지 $i를 반복
                    if($page == $i) {   // 만약 page가 $i와 같다면
                        echo "<li class='fo_re'>[$i]</li>"; // 현재 페이지에 해당하는 번호에 굵은 빨간색을 적용
                    } else {
                        echo "<li><a href='?page=$i'>[$i]</a></li>";    // 아니라면 $i
                    }
                }
                if($block_num >= $total_block) {    // 만약 현재 블록이 블록 총 개수보다 크거나 같다면 빈 값

                } else {
                    $next = $page + 1;  // next 변수에 page + 1을 해줌
                    echo "<li><a href='?page=$next'>다음</a></li>"; // 다음 글자에 next 변수를 링크, 현재 4페이지라면 +1 하여 5페이지로 이동
                }
                if($page >= $total_page) {
                    echo "<li class='fo_re'>마지막</li>";   // 마지막 글자에 굵은 빨간색을 적용
                } else {
                    echo "<li><a href='?page=$total_page'>마지막</a></li>"; // 아니라면 마지막 글자에 total_page를 링크
                }
            ?>
            </ul>
        </div>
        <div id="write_btn">
            <a href="/php_board/page/post/write.php">
                <button class="write_btn">글쓰기</button>
            </a>
        </div>
    </div>
</body>
</html>