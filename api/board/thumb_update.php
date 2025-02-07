<?php
include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idx = $_POST['idx'];
    $action = $_POST['action'];

    // 현재 추천수/비추천수 가져오기
    $sql = query("SELECT post_up, post_down FROM php_board WHERE idx = '$idx'");
    $row = mysqli_fetch_array($sql);

    if($action === "up") {
        $new_up = $row['post_up'] + 1;
        query("UPDATE php_board SET post_up = '$new_up' WHERE idx = '$idx'");
    } else if($action === "down") {
        $new_down = $row['post_down'] + 1;
        query("UPDATE php_board SET post_down = '$new_down' WHERE idx = '$idx'");
    }

    // 업데이트된 추천/비추천 수 다시 가져오기
    $updated_sql = query("SELECT post_up, post_down FROM php_board WHERE idx = '$idx'");
    $updated_row = mysqli_fetch_array($updated_sql);

    echo json_encode([
        "success" => true,
        "up" => $updated_row['post_up'],
        "down" => $updated_row['post_down']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "잘못된 요청입니다."]);
}
?>