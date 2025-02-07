<?php
    include $_SERVER['DOCUMENT_ROOT'].'/php_board/db.php';

    $post_no = $_GET['idx'];
    $user_pw = password_hash($_POST['dat_pw'], PASSWORD_DEFAULT);

    if($post_no && $_POST['dat_user'] && $user_pw && $_POST['reply_content']) {
        $sql = query("INSERT INTO reply(reply_cnt, user_name, user_pw, reply_content)
        VALUES('".$post_no."', '".$_POST['dat_user']."', '".$user_pw."', '".$_POST['reply_content']."')");
        echo "<script>alert('댓글이 작성되었습니다.');
        location.href='/php_board/board/read.php?idx=$post_no';</script>";
    } else {
        echo "<script>alert('댓글 작성에 실패했습니다.');
        history.back();</script>";
    }
?>