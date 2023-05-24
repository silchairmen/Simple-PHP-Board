<?php
// 필요한 파일을 포함합니다.
include "../application/core/db_connect.php";

// 삭제할 항목의 ID를 가져옵니다.
$id = $_GET['id'];

// 삭제 쿼리를 준비합니다.
$stmt = $mysqli->prepare("DELETE FROM free_board WHERE id = ?");
$stmt->bind_param("i", $id);

// 쿼리를 실행하고 결과를 확인합니다.
if ($stmt->execute()) {
    // 삭제가 성공한 경우
    $script = "<script>alert('글 삭제를 성공하였습니다.'); location.href='/index.php?page=board'</script>";
    echo $script;
} else {
    // 삭제가 실패한 경우
    $script = "<script>alert('글 삭제를 실패하였습니다');location.href='/index.php?page=board'=</script>";
    echo $script;
}

// 문장과 데이터베이스 연결을 닫습니다.
$stmt->close();
$mysqli->close();
?>
