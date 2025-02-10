<?php
    include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";

    $post_no = $_GET['post_idx'];
    $sql = query("DELETE FROM post WHERE post_idx = '$post_no';");
?>
<script type="text/javascript">alert("삭제 완료");</script>
<meta http-equiv="refresh" content="0; url = /php_board/index.php" />   <!-- 0초 후에 url 주소로 리다이렉션 -->