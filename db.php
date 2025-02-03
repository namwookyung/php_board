<?php
    session_start();

    // 한글 깨짐 방지를 위한 utf-8 인코딩
    header('Content-Type: text/html; charset=utf-8');

    $db = new mysqli("localhost", "root", "rootABcd!@34", "first_php");
    $db -> set_charset("utf8");

    function query($query) {
        global $db;
        return $db -> query($query);
    }
?>