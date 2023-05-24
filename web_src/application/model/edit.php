<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>글 수정</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container my-4">
    <br>
    <br>
    <h1 class="text-center mb-4">글 수정</h1>

    <?php
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // 게시글 ID 가져오기
    $id = $_GET['id'];

    // 게시글 조회 쿼리
    $sql = "SELECT * FROM free_board WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $author = $row["nickname"];
        $content = $row["content"];
        ?>
        <form action="/index.php?&page=board&model=update" method="POST">
            <div class="form-group">
                <label for="author">작성자</label>
                <p><?php echo $author ?></p>
                <input type="hidden" name="author" value=<?php echo $author?>>
                <input type="hidden" name="id" value=<?php echo $id;?>>
            </div>
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title ?>">
            </div>
            <div class="form-group">
                <label for="content">내용</label>
                <textarea class="form-control" id="content" name="content" rows="4"><?php echo $content ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">수정 완료</button>
        </form>
        <?php
    } else {
        echo "게시글을 찾을 수 없습니다.";
    }

    $mysqli->close();
    ?>

</div>

</body>
</html>