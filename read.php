<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
?>
<!doctype html>
    <head>
        <meta charset="UTF-8">
        <title>PHP 게시판</title>
        <link rel="stylesheet" type="text/css" href="/php_board/css/style.css" />
        <script>
            function deleteConfirm(idx){
                isConfirm = confirm('삭제하시겠습니까?');
                if(isConfirm == true) {
                    var url="delete.php?idx=" + idx;
                    location.href = url;
                }
            }

            function updateThumb(action, idx) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "thumb_update.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if(xhr.readyState === 4 && xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);
                        if(response.success) {
                            document.getElementById("thumb_up_count").innerText = response.up;
                            document.getElenentById("thumb_down_count").innerText = response.down;
                        } else {
                            alert("오류 발생 : " + response.message);
                        }
                    }
                };
                xhr.send("action = " + action + "&idx=" + idx);
            }
        </script>
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
            <div id="user_info" style="display:flex;">
                <div style="width:30%;"><?php echo $board['user_name']; ?></div>
                <div style="text-align:right; width:70%;"><?php echo $board['post_date']; ?> &nbsp;조회 수 : <?php echo $board['post_views']; ?></div>
            </div>
            <hr />
            <div id="bo_content" style="height:50vh;">
                <?php echo nl2br("$board[post_content]"); ?>
            </div>
            <!-- up, down 버튼 -->
            <div style="justify-content:space-around; display:flex;">
                <ul style="padding:0; margin:0;">
                    <li>
                        <button onclick="updateThumb('up', <?php echo $board['idx'];?>" style="border:none; background:none; cursor:pointer;">
                            <img src="icon/thumbs-up-regular.svg" width=24px height=24px />
                        </button>
                    </li>
                    <li style="text-align:center;">
                        <span><?php echo $board['post_up']; ?></span>
                    </li>
                </ul>
                <ul style="padding:0; margin:0;">
                    <li>
                        <button onclick="updateThumb('down', <?php echo $board['idx'];?>" style="border:none; background:none; cursor:pointer;">
                            <img src="icon/thumbs-down-regular.svg" width=24px height=24px />
                        </button>
                    </li>
                    <li style="text-align:center;">
                        <span><?php echo $board['post_down']; ?></span>
                    </li>
                </ul>
            </div>
            <hr />
            <!-- 목록, 수정, 삭제 -->
            <div id="btn_list">
                <a href="/">
                    <button class="home_btn">목록으로</button>
                </a>
                <a href="modify.php?idx=<?php echo $board['idx']; ?>">
                    <button class="modify_btn">수정</button>
                </a>
                <a href="javascript:deleteConfirm(<?php echo $board['idx']; ?>)">
                    <button class="delete_btn">삭제</button>
                </a>
            </div>
        </div>
    </body>
</html>