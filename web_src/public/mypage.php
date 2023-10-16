<?php
session_start();
include "../application/core/db_connect.php";
include "../application/view/header.php";

$user_id = $_SESSION['user_id'];
$grade = $_SESSION['grade'];
// mysqli 객체를 사용 가능

if (isset($_SESSION["nickname"])) {
    $nickname = $_SESSION["nickname"];
} else {
    echo '<script>alert("login first!"); window.location.href = "index.php";</script>';
    exit();
}

// 프로필 파일 업로드 처리
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["profile_image"])) {

    //파일 이름 파싱
    $file_name = htmlspecialchars($_FILES["profile_image"]["name"]);
    $file_tmp = $_FILES["profile_image"]["tmp_name"];

    //간이 파일 업로드 감지
    $allowedExtensions = ['jpg', 'png', 'gif','jpeg']; // 허용하려는 파일 확장자 목록
    $fileExtension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('jpg, png, gif 확장자만 업로드 가능합니다.')</script>";
    }
    else{
        // 파일이 저장될 경로
        $destination = "./uploads/" . $file_name;

        // 파일을 지정된 경로로 이동
        if (move_uploaded_file($file_tmp, $destination)) {
            
            //유저 프로필 이미지 이름 변경
            $query = "UPDATE user_info SET img_name = ? WHERE user_id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ss", $file_name, $_SESSION["user_id"]);
            $stmt->execute();

            $stmt->close();
            $mysqli->close();
            
            //기존 파일 삭제
            if (isset($_SESSION["img_name"])) {
                unlink("./uploads/".$_SESSION["img_name"]);
            }

            //세션 업데이트
            $_SESSION['img_name'] = $file_name;

            echo '<script>alert("profile is updated")</script>';

        } else {
            echo '<script>alert("Failed to move uploaded file!");</script>';
        }


    }
}

// 프로필 파일 경로 가져오기
$profile_image = isset($_SESSION["img_name"]) ? "./uploads/".$_SESSION["img_name"] : "./static/img/default_profile.jpeg";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <style>
        .profile-image {
            width: 300px;
            height: 300px;
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
        <img class="profile-image" src="<?php echo htmlspecialchars($profile_image); ?>" onerror="this.src='./uploads/default_profile.jpeg';">
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
