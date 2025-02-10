<?php
    include $_SERVER['DOCUMENT_ROOT'].'/php_board/db.php';

    date_default_timezone_set('Asia/Seoul');

    echo 'POST_IDX: ' . $_GET['post_idx'];  // 디버깅: GET 값 확인
    echo 'REPLY_NAME: ' . $_POST['reply_name'];  // 디버깅: POST 값 확인

    $post_no = $_GET['post_idx'];
    $reply_pw = password_hash($_POST['reply_pw'], PASSWORD_DEFAULT);
    $reply_date = date('Y-m-d H:i:s');

    if($post_no && $_POST['reply_name'] && $reply_pw && $_POST['reply_content']) {
        $sql = query("INSERT INTO reply(reply_connect, reply_name, reply_pw, reply_content, reply_date)
        VALUES('".$post_no."', '".$_POST['reply_name']."', '".$reply_pw."', '".$_POST['reply_content']."', '".$reply_date."')");
        echo "<script>alert('댓글이 작성되었습니다.');
        location.href='/php_board/page/post/read.php?post_idx=$post_no';</script>";
    } else {
        echo "<script>
            alert('댓글 작성에 실패했습니다.');
        </script>";
    }
?>
<!-- history.back(); -->