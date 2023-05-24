<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>게시글 보기</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container my-4">
    <br>
    <br>
    <h1 class="text-center mb-4">게시글 보기</h1>

    <?php
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM free_board WHERE id = $id";
    $result = $mysqli->query($sql);
    

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $author = $row["nickname"];
        $content = $row["content"];
        $created_at = $row["created_at"];
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo $title ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $author ?></h6>
                <p class="card-text"><?php echo $content ?></p>
                <p class="card-text"><?php echo $created_at ?></p>
                <a href="/index.php?page=board" class="btn btn-primary">목록으로</a>
            </div>
        </div>
        <?php
    } else {
        echo "게시글을 찾을 수 없습니다.";
    }

    $mysqli->close();
    ?>

</div>

</body>
</html>