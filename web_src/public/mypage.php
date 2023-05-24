<?php
session_start();
include "../application/core/db_connect.php";
include "../application/view/header.php";
// mysqli 객체를 사용 가능

if (isset($_SESSION["nickname"])) {
    $nickname = $_SESSION["nickname"];
} else {
    echo '<script>alert("login first!"); window.location.href = "index.php";</script>';
    exit();
}

// 프로필 파일 업로드 처리
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["profile_image"])) {
    $file_name = $_FILES["profile_image"]["name"];
    $file_tmp = $_FILES["profile_image"]["tmp_name"];

    // 파일이 저장될 경로
    $destination = "/var/www/html/uploads/" . $nickname . "_" . $file_name;

    // 이전 프로필 이미지 삭제
    if (isset($_SESSION["profile_image"])) {
        unlink("/var/www/html/".$_SESSION["profile_image"]);
        unset($_SESSION["profile_image"]);
    }

    // 파일을 지정된 경로로 이동
    if (move_uploaded_file($file_tmp, $destination)) {
        // 업로드한 파일 경로를 세션에 저장
        $destination = str_replace("/var/www/html", "", $destination);
        $_SESSION["profile_image"] = $destination;
    } else {
        echo '<script>alert("Failed to move uploaded file!");</script>';
    }
}

// 프로필 파일 경로 가져오기
$profile_image = isset($_SESSION["profile_image"]) ? $_SESSION["profile_image"] : "default_profile_image.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .profile-image {
            width: 500px;
            height: 500px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<br>
<br>

<div class="container my-4">
    <h1 class="text-center mb-4">My Page</h1>

    <div class="text-center">
        <img class="profile-image" src="<?php echo htmlspecialchars($profile_image . '?' . time()); ?>" alt="Profile Image">
    </div>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_image">프로필 사진 업로드</label>
            <input type="file" class="form-control-file" id="profile_image" name="profile_image">
        </div>
        <div class="form-group">
            <label for="user_id">아이디</label>
            <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nickname">닉네임</label>
            <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo htmlspecialchars($nickname); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="grade">학년</label>
            <input type="text" class="form-control" id="grade" name="grade" value="<?php echo htmlspecialchars($grade); ?>">
        </div>
        <button type="submit" class="btn btn-primary">저장</button>
    </form>
</div>

</body>
</html>
