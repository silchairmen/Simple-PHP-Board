<?php include "../application/core/db_connect.php";?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 회원가입 폼이 제출된 경우

    // 연결 오류 확인
    if ($mysqli->connect_error) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    // 회원가입 폼에서 전달된 데이터 받아오기
    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $phone_num = $_POST['phone_num'];
    $grade = $_POST['grade'];
    $nickname = $_POST['nickname'];

    // 아이디 중복 체크
    $check_query = "SELECT * FROM user_info WHERE user_id = ?";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param("s", $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "이미 사용 중인 아이디입니다.";
        exit;
    }

    // 닉네임 중복 체크
    $check_query = "SELECT * FROM user_info WHERE nickname = ?";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param("s", $nickname);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "이미 사용 중인 닉네임입니다.";
        exit;
    }

    // prepare statement 생성
    $stmt = $mysqli->prepare("INSERT INTO user_info (user_id, upw, phone_num, grade, nickname) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $user_id, $user_pw, $phone_num, $grade, $nickname);

    // prepare statement 실행
    if ($stmt->execute()) {
        // 회원가입 성공
        // index.php로 리다이렉션
        header("Location: /login.php");
        exit;
    } else {
        // 회원가입 실패
        echo "회원가입 중 오류가 발생하였습니다.";
    }

    // prepare statement 및 데이터베이스 연결 종료
    $stmt->close();
    $check_stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Join Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Custom CSS -->
	<style>
		body {
			background-color: #d6eaf8;
		}
		.card {
			margin-top: 50px;
			border-radius: 10px;
			box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
			padding: 30px;
			background-color: #fff;
			max-width: 600px;
			margin-left: auto;
			margin-right: auto;
		}
		h2 {
			text-align: center;
			margin-bottom: 30px;
			color: #2c3e50;
		}
		.btn-primary {
			background-color: #3498db;
			border: none;
			font-weight: bold;
			margin-top: 20px;
		}
		.btn-primary:hover {
			background-color: #2980b9;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="card">
			<h2>OTS 회원가입</h2>
			<form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
				<div class="form-group">
					<label for="user_id">아이디</label>
					<input type="text" class="form-control" id="user_id" name="user_id" placeholder="아이디를 입력하세요">
					<button type="button" class="btn btn-primary" onclick="checkDuplicate('user_id')">중복확인</button>
				</div>
				<div class="form-group">
					<label for="nickname">닉네임</label>
					<input type="text" class="form-control" id="nickname" name="nickname" placeholder="닉네임을 입력하세요">
					<button type="button" class="btn btn-primary" onclick="checkDuplicate('nickname')">중복확인</button>
				</div>
				<div class="form-group">
					<label for="user_pw">비밀번호</label>
					<input type="password" class="form-control" id="user_pw" name="user_pw" placeholder="비밀번호를 입력하세요">
				</div>
				<div class="form-group">
					<label for="phone_num">전화번호</label>
					<input type="text" class="form-control" id="phone_num" name="phone_num" placeholder="전화번호를 입력하세요">
				</div>
				<div class="form-group">
					<label for="grade">학년</label>
					<select class="form-control" id="grade" name="grade">
						<option value="1th">1학년</option>
						<option value="2th">2학년</option>
						<option value="3th">3학년</option>
						<option value="4th">4학년</option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary btn-block">가입하기</button>
			</form>
		</div>
	</div>
    </body>
<script>
	function validateForm() {
		var user_id = document.getElementById("user_id").value;
		var user_pw = document.getElementById("user_pw").value;
		var phone_num = document.getElementById("phone_num").value;
		var grade = document.getElementById("grade").value;
		var nickname = document.getElementById("nickname").value;

		// 이메일 형식 검사
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!emailRegex.test(user_id)) {
			alert("유효한 이메일을 입력하세요.");
			return false;
		}

		// 전화번호 형식 검사 (숫자만 입력되었는지 확인)
		var phoneRegex = /^[0-9]+$/;
		if (!phoneRegex.test(phone_num)) {
			alert("전화번호는 숫자만 입력하세요.");
			return false;
		}

		// 필수 항목 검사
		if (user_id === "" || user_pw === "" || phone_num === "" || grade === "" || nickname === "") {
			alert("필수 항목을 모두 입력하세요.");
			return false;
		}
	}

	function checkDuplicate(field) {
		var value = document.getElementById(field).value;
		if (value === "") {
			alert("중복 검사할 값을 입력하세요.");
			return;
		}

		var xhr = new XMLHttpRequest();
		xhr.open("POST", "check_duplicate.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				alert(xhr.responseText);
			}
		};
		xhr.send(field + "=" + value);
	}
</script>
</html>
