<?php
include $_SERVER['DOCUMENT_ROOT'].'/php_board/db.php';

$reply_no = $_POST['reply_idx'];
$sql = query("SELECT * FROM reply WHERE reply_idx='".$reply_no."'");
$reply = $sql -> fetch_array();

$post_no = $_POST['post_idx'];
$sql2 = query("SELECT * FROM post WHERE post_idx='".$post_no."'");
$board = $sql2 -> fetch_array();

$pwk = $_POST['reply_pw'];
$reply_pw = $reply['reply_pw'];

if(password_verify($pwk, $reply_pw)) {
    $sql = query("DELETE FROM reply WHERE reply_idx='".$reply_no."'");
    echo "<script type='text/javascript'>
        alert('댓글이 삭제되었습니다.');
        location.href='/php_board/page/post/read.php?post_idx=".$post_no."';
    </script>";
} else {
    echo "<script type='text/javascript'>
        alert('비밀번호가 틀립니다.');
        history.back();
    </script>";
}
?>