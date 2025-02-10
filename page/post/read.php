<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
?>
<!doctype html>
    <head>
        <meta charset="UTF-8">
        <title>PHP 게시판</title>
        <link rel="stylesheet" type="text/css" href="/php_board/css/style.css?after" />
        <script>
            function deleteConfirm(post_idx){
                isConfirm = confirm('삭제하시겠습니까?');
                if(isConfirm == true) {
                    var url="/php_board/api/post/delete.php?post_idx=" + post_idx;
                    location.href = url;
                }
            }

            function updateThumb(action, post_idx) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/php_board/api/post/thumb_update.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if(xhr.readyState === 4 && xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);
                        if(response.success) {
                            document.getElementById("thumb_up_count").innerText = response.up;
                            document.getElementById("thumb_down_count").innerText = response.down;
                        } else {
                            alert("오류 발생 : " + response.message);
                        }
                    }
                };
                xhr.send("action=" + action + "&post_idx=" + post_idx);
            }
        </script>
    </head>
    <body>
        <?php
            $post_no = $_GET['post_idx'];   /* post_no 함수에 post_idx값을 받아와 넣음 */
            $post_views = mysqli_fetch_array(query("SELECT * FROM post WHERE post_idx = '".$post_no."'"));
            $post_views = $post_views['post_views'] + 1;
            $fet = query("UPDATE post SET post_views = '".$post_views."' WHERE post_idx = '".$post_no."'");
            $sql = query("SELECT * FROM post WHERE post_idx = '".$post_no."'");    /* 받아온 post_idx 값을 선택 */
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
                        <button onclick="updateThumb('up', <?php echo $board['post_idx'];?>)" style="border:none; background:none; cursor:pointer;">
                            <img src="/php_board/icon/thumbs-up-regular.svg" width=24px height=24px />
                        </button>
                    </li>
                    <li style="text-align:center;">
                        <span id="thumb_up_count"><?php echo $board['post_up']; ?></span>
                    </li>
                </ul>
                <ul style="padding:0; margin:0;">
                    <li>
                        <button onclick="updateThumb('down', <?php echo $board['post_idx'];?>)" style="border:none; background:none; cursor:pointer;">
                            <img src="/php_board/icon/thumbs-down-regular.svg" width=24px height=24px />
                        </button>
                    </li>
                    <li style="text-align:center;">
                        <span id="thumb_down_count"><?php echo $board['post_down']; ?></span>
                    </li>
                </ul>
            </div>
            <hr />
            <!-- 목록, 수정, 삭제 -->
            <div id="btn_list">
                <a href="/">
                    <button class="home_btn">목록으로</button>
                </a>
                <a href="modify.php?post_idx=<?php echo $board['post_idx']; ?>">
                    <button class="modify_btn">수정</button>
                </a>
                <a href="javascript:deleteConfirm(<?php echo $board['post_idx']; ?>)">
                    <button class="delete_btn">삭제</button>
                </a>
            </div>
        </div>
        <!-- 댓글 조회 -->
        <div class="reply_view">
            <h3>댓글 목록</h3>
            <?php
                $sql3 = query("SELECT * FROM reply where reply_connect = '".$post_no."' ORDER BY reply_idx DESC");
                while($reply = $sql3 -> fetch_array()) {
                    ?>
                    <div class="dap_lo">
                        <form>
                            <div id="reply_edit">
                                <div>
                                    <b><?php echo $reply['reply_name'];?></b>
                                </div>
                                <div class="dap_to comt_edit"><?php echo nl2br("$reply[reply_content]");?></div>
                                <div class="rep_me dap_to"><?php echo $reply['reply_date'];?></div>
                                <div class="rep_me rep_menu">
                                    <button type="button" id="reply_edit_btn" class="reply_edit_btn" style="cursor:pointer; color: white; background-color:cornflowerblue; border: 1px solid cornflowerblue; border-radius: 5px; padding: 3px 6px 3px 6px;">수정</button>
                                    <button type="button" id="reply_delete_btn" class="reply_delete_btn" style="cursor:pointer; color: white; background-color:crimson; border:1px solid crimson; border-radius: 5px; padding: 3px 6px 3px 6px;">삭제</button>
                                </div>
                            </div>
                        </form>
                        <!-- 댓글 수정 -->
                        <!-- <div class="dat_edit">
                            <form method="post" action="/php_board/api/reply/reply_modify_ok.php">
                                <input type="hidden" name="reply_no" value="<?php echo $reply['reply_idx'];?>" />
                                <input type="hidden" name="post_no" value="<?php echo $post_no;?>" />
                                <input type="password" name="reply_pw" class="dap_sm" placeholder="비밀번호" />
                                <textarea name="reply_content" class="dap_edit_t"><?php echo $reply['reply_content'];?></textarea>
                                <input type="submit" value="수정" class="re_mo_bt">
                            </form>
                        </div> -->
                        <!-- 댓글 삭제 비밀번호 -->
                        <!-- <div class="dat_delete">
                            <form action="/php_board/api/reply/reply_delete.php" method="post">
                                <input type="hidden" name="reply_no" value="<?php echo $reply['reply_idx'];?>" />
                                <input type="hidden" name="post_no" value="<?php echo $post_no;?>" />
                                <p>비밀번호
                                    <input type="password" name="reply_pw" />
                                    <input type="submit" value="확인">
                                </p>
                            </form>
                        </div> -->
                    </div>
                <?php } ?>

                <!-- 댓글 입력 -->
                <div class="dap_ins">
                    <form action="/php_board/api/reply/reply_ok.php?post_idx=<?php echo $post_no; ?>" method="post">
                        <input type="text" name="reply_name" id="reply_name" class="reply_name" size="15" placeholder="아이디" />
                        <input type="password" name="reply_pw" id="reply_pw" class="reply_pw" size="15" placeholder="비밀번호" />
                        <div style="margin-top:10px;">
                            <textarea name="reply_content" class="reply_content" id="reply_content"></textarea>
                            <button id="reply_btn" class="reply_btn">댓글 달기</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- 댓글 불러오기 END -->
            <div id="foot_box"></div>
        </div>
    </body>
</html>