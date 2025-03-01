<?php
include $_SERVER['DOCUMENT_ROOT']."/php_board/db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_idx = $_POST['post_idx'];
    $action = $_POST['action'];

    // 현재 추천수/비추천수 가져오기
    $sql = query("SELECT post_up, post_down FROM post WHERE post_idx = '$post_idx'");
    $row = mysqli_fetch_array($sql);

    if($action === "up") {
        $new_up = $row['post_up'] + 1;
        query("UPDATE post SET post_up = '$new_up' WHERE post_idx = '$post_idx'");
    } else if($action === "down") {
        $new_down = $row['post_down'] + 1;
        query("UPDATE post SET post_down = '$new_down' WHERE post_idx = '$post_idx'");
    }

    // 업데이트된 추천/비추천 수 다시 가져오기
    $updated_sql = query("SELECT post_up, post_down FROM post WHERE post_idx = '$post_idx'");
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