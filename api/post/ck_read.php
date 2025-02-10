<?php
include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";
?>
<script type="text/javascript">
    $(function() {
        $("#writepass").dialog({
            modal: true,
            title: '비밀글입니다.',
            width: 400,
        });
    });
    </script>
    <?php
    $post_no = $_GET['post_idx'];
    $sql = query("SELECT * FROM post WHERE post_idx = '".$post_no."'");
    $board = $sql -> fetch_array();

    ?>
    <div id='writepass'>
        <form action="" method="post">
            <p>비밀번호 <input type="password" name="pw_chk" /> <input type="submit" value="확인"/></p>
        </form>
    </div>
<?php
$user_pw = $board['user_pw'];

if(isset($_POST['pw_chk'])) {   // 만약 pw_chk POST 값이 있다면
    $pwk = $_POST['pw_chk'];    // $pwk 변수에 POST값으로 받은 pw_chk를 넣음

    if(password_verify($pwk, $user_pw)) {   // 다시 if문으로 DB의 pw와 입력하여 받아온 user_pw와 값이 같은지 비교를 하고
        $pwk == $user_pw;
        ?>
        <script type="text/javascript">
            location.replace("/php_board/page/post/read.php?post_idx=<?php echo $board['post_idx']; ?>");
        </script>   <!-- pwk와 user_pw 값이 같으면 read.php로 보냄 -->
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert('비밀번호가 틀립니다.');
        </script>   <!-- 아니면 비밀번호가 틀리다는 메시지를 보여줌 -->
        <?php
    }
}
?>