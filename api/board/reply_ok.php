<?php
    include $_SERVER['DOCUMENT_ROOT'].'/php_board/db.php';

    $post_no = $_GET['idx'];
    $reply_pw = password_hash($_POST['reply_pw'], PASSWORD_DEFAULT);

    if($post_no && $_POST['reply_name'] && $reply_pw && $_POST['reply_content']) {
        $sql = query("INSERT INTO reply(reply_cnt, reply_name, reply_pw, reply_content)
        VALUES('".$post_no."', '".$_POST['reply_name']."', '".$reply_pw."', '".$_POST['reply_content']."')");
        echo "<script>alert('댓글이 작성되었습니다.');
        location.href='/php_board/page/board/read.php?idx=$post_no';</script>";
    } else {
        echo "<script>alert('댓글 작성에 실패했습니다.');
        <div>
            오류 발생?
        </div>
        </script>";
    }
?>
<!-- history.back(); -->