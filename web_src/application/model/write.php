<?php
session_start();
// 연결 오류 확인
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// 폼 제출이 발생했을 때 실행
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // 입력값 받기
    //author은 고정값이라 개발자가 그냥 넘어간다고 가정
    //vlun point
    $author = $_POST['author']

    $title = str_replace("script", "nohack", $_POST['title']);
    $content = str_replace("script", "nohack", $_POST['content']);
    $title = str_replace("img", "nohack", $_POST['title']);
    $content = str_replace("img", "nohack", $_POST['content']);

    

    // SQL 쿼리 작성
    $query = "INSERT INTO free_board (title, nickname, content) VALUES ('$title', '$author', '$content')";

    // 쿼리 실행
    if ($mysqli->query($query)) {
        // 글 작성 성공한 경우
        echo "<script>alert('글 작성을 성공하였습니다.'); location.href = '/index.php?page=board';</script>";
        exit;
    } else {
        // 글 작성 실패한 경우
        echo "<script>alert('글 작성을 실패하였습니다.'); location.href = '/index.php?page=board';</script>";
        exit;
    }
}

// 데이터베이스 연결 종료
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>새 글 쓰기</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container my-4">
    <br><br>
    <h1 class="text-center mb-4">새 글 쓰기</h1>

    <form method="POST" action="/index.php?&page=board&model=write">
        <div class="form-group">
            <label for="title">제목</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="author">작성자: <?php echo $_SESSION["nickname"]; ?></label>
            <input type="hidden" name="author" value="<?php echo $_SESSION["nickname"]; ?>">
        </div>
        <div class="form-group">
            <label for="content">내용</label>
            <textarea class="form-control" id="content" name="content" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">글 작성</button>
    </form>
</div>
</body>
</html>
