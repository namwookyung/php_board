<?php
include $_SERVER['DOCUMENT_ROOT'].'/php_board/db.php';

$reply_no = $_POST['reply_idx'];  // 댓글 번호
$sql = query("SELECT * FROM reply WHERE reply_idx='".$reply_no."'");  // reply 테이블에서 idx가 reply_no 변수에 저장된 값을 찾음
$reply = $sql -> fetch_array();

$post_no = $_POST['post_idx'];   // 게시글 번호
$sql2 = query("SELECT * FROM post WHERE post_idx='".$post_no."'");  // board 테이블에서 idx가 post_no 변수에 저장된 값을 찾음
$board = $sql2 -> fetch_array();

$pwk = $_POST['reply_pw'];
$reply_pw = $reply['reply_pw'];

if(password_verify($pwk, $reply_pw)) {
    $sql = query("UPDATE reply SET reply_content='".$_POST['reply_content']."' WHERE reply_idx = '".$reply_no."'");
    // reply 테이블의 idx가 reply_no 변수에 저장된 값의 reply_content를 선택해서 값 저장
    echo "<script>
        alert('수정되었습니다.');
        location.href='/php_board/page/post/read.php?post_idx=$post_no';
    </script>";
} else {
    echo "<script type='text/javascript'>
        alert('비밀번호가 틀립니다.');
        history.back();
    </script>";
}
?>