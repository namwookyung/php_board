<?php
    include $_SERVER['DOCUMENT_ROOT'].'/php_board/db.php';

    $post_no = $_GET['post_idx'];
    $user_name = $_POST['user_name'];
    $user_pw = password_hash($_POST['user_pw'], PASSWORD_DEFAULT);
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $sql = query("UPDATE post SET user_name = '".$user_name."', user_pw = '".$user_pw."', post_title = '".$post_title."',
        post_content = '".$post_content."' WHERE post_idx = '".$post_no."'"); ?>

    <script type="text/javascript">alert("수정 완료");</script>
    <meta http-equiv="refresh" content="0; url=/php_board/index.php">   <!-- 0초 후에 url 주소로 리다이렉션 -->