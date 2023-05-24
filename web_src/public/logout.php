<?php
session_start();

// 모든 세션 변수 삭제
session_unset();

// 세션 파괴
session_destroy();

// 로그아웃 후 리다이렉션할 페이지로 이동
header("location: index.php");
exit;
?>