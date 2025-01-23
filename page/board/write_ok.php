<?php
    include $_SERVER['DOCUMENT_ROOT']."/PHP_BOARD/db.php";

    // 각 변수에 write.php에서 input name 값들을 저장
    $user_name = $_POST['user_name'];
    $user_pw = password_hash($_POST['user_pw'], PASSWORD_DEFAULT);
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $post_date = date('Y-m-d');
    if($user_name && $user_pw && $post_title && $post_content) {
        $sql = query("INSERT INTO php_board(user_name, user_pw, post_title, post_content, post_date) values('".$user_name."', '".$user_pw."', '".$post_title."', '".$post_content."', '".$post_date."')");
        echo "<script>
        alert('작성 완료');
        location.href='/PHP_BOARD/index.php';
        </script>";
    } else {
        echo "<script>
        alert('작성 실패');
        history.back();
        </script>";
    }
?>