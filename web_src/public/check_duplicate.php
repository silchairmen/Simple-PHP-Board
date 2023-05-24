<?php
include "../application/core/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 필드와 값 추출
    $field = key($_POST);
    $value = $_POST[$field];

    // 중복 체크
    $check_query = "SELECT * FROM user_info WHERE $field = ?";
    $stmt = $mysqli->prepare($check_query);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "이미 사용 중인 $field 입니다.";
    } else {
        echo "$field 사용 가능합니다.";
    }

    // prepare statement 및 데이터베이스 연결 종료
    $stmt->close();
    $mysqli->close();
}
?>