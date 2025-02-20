<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
?>
<!doctype html>
    <head>
        <meta charset="UTF-8">
        <title>PHP 게시판</title>
        <link rel="stylesheet" type="text/css" href="/php_board/css/style.css?ver=0.01" />
        <link rel="stylesheet" type="text/css" href="/php_board/css/post/read.css?ver=0.01" />
        <script type="text/javascript" src="/php_board/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="/php_board/js/read.js?ver=0.0000010010101"></script>
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
                    <div class="dap_lo" style="margin-bottom:10px;">
                        <form>
                            <div id="reply_edit" style="display: flex; align-items: center; justify-content: space-between; width:100%;">
                                <div style="width:87%;">
                                    <b><?php echo $reply['reply_name'];?></b>
                                    <input type="hidden" id="post_idx_<?php echo $reply['reply_idx']; ?>" name="post_idx" value="<?php echo $board['post_idx']; ?>" />
                                    <div class="dap_to comt_edit" id="reply_content_<?php echo $reply['reply_idx']; ?>"><?php echo nl2br("$reply[reply_content]");?></div>
                                    <input type="text" style="display:none; border: 1px solid rgba(0, 0, 0, 0.3); border-radius: 5px; width:100%; padding:10px;" name="reply_pw" id="reply_pw_<?php echo $reply['reply_idx']; ?>" placeholder="비밀번호를 입력하세요" />
                                    <div class="rep_me dap_to"><?php echo $reply['reply_date'];?></div>
                                </div>
                                <div class="rep_me rep_menu" style="width:8%; float:right;">
                                    <button type="button" data-reply-id="reply_edit_btn_<?php echo $reply['reply_idx']; ?>" class="reply_edit_btn" style="cursor:pointer; color: white; background-color:cornflowerblue; border: 1px solid cornflowerblue; border-radius: 5px; padding: 5px 8px 5px 8px;">수정</button>
                                    <button type="button" data-reply-id="reply_delete_btn_<?php echo $reply['reply_idx']; ?>" class="reply_delete_btn" style="cursor:pointer; color: white; background-color:crimson; border:1px solid crimson; border-radius: 5px; padding: 5px 8px 5px 8px;">삭제</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr />
                <?php } ?>

                <!-- 댓글 입력 -->
                <div class="dap_ins" style="margin-top:10px;">
                    <form action="/php_board/api/reply/reply_ok.php?post_idx=<?php echo $post_no; ?>" method="post">
                        <div style="display: flex; align-items: center; justify-content: space-between; width:100%;">
                            <div style="width:87%;">
                                <input type="text" name="reply_name" id="reply_name" class="reply_name" style="border: 1px solid rgba(0, 0, 0, 0.3); border-radius: 5px; width:100%; padding:10px;" size="15" placeholder="아이디" />
                                <textarea name="reply_content" class="reply_content" style="margin-top: 5px; border: 1px solid rgba(0, 0, 0, 0.3); border-radius: 5px; width:100%; padding:10px; height:10vh;" id="reply_content" placeholder="내용"></textarea>
                                <input type="password" name="reply_pw" id="reply_pw" class="reply_pw" style="border: 1px solid rgba(0, 0, 0, 0.3); border-radius: 5px; width:100%; padding:10px;" size="15" placeholder="비밀번호" />
                            </div>
                            <div style="width:8%; float:right;">
                                <button id="reply_btn" class="reply_btn" style="padding:5px 8px 5px 8px; color: #fff; background-color: orange; border-radius: 5px; border: 1px solid orange; font-size: 14px; cursor: pointer;">댓글 달기</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- 댓글 불러오기 END -->
            <div id="foot_box"></div>
        </div>
    </body>
</html>