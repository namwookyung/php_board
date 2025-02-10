<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";

    // 한국 시간 설정 (php.ini 적용되지 않을 경우 직접 설정)
    date_default_timezone_set('Asia/Seoul');

    // 각 변수에 write.php에서 input name 값들을 저장
    $user_name = $_POST['user_name'];
    $user_pw = password_hash($_POST['user_pw'], PASSWORD_DEFAULT);
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $post_date = date('Y-m-d H:i:s');

    if(isset($_POST['post_lock'])) {
        $post_lock = '1';
    } else {
        $post_lock = '0';
    }

    if($user_name && $user_pw && $post_title && $post_content) {
        $sql = query("INSERT INTO post(user_name, user_pw, post_title, post_content, post_date, post_lock)
        values('".$user_name."', '".$user_pw."', '".$post_title."', '".$post_content."', '".$post_date."', '".$post_lock."')");
        echo "<script>
            alert('작성 완료');
            location.href='/php_board/index.php';
        </script>";
    } else {
        echo "<script>
            alert('작성 실패');
            history.back();
        </script>";
    }
?>