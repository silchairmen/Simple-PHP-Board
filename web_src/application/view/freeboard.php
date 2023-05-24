<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
    <br>
    <br>
    <h1 class="text-center mb-4">게시판</h1>
    <!-- 검색 폼 추가 -->
    <form action="/index.php" method="GET" class="mb-4">
        <div class="input-group">
            <input type="hidden" name="page" value="board">
            <input type="text" name="search" class="form-control" placeholder="검색어를 입력하세요">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">검색</button>
            </div>
        </div>
    </form>
    <?php
    if ($mysqli->mysqliect_error) {
        die("mysqliection failed: " . $mysqli->mysqliect_error);
    }

    // 검색어 처리
    $search = '';
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        // 검색어가 전달된 경우, 해당 검색어로 게시글 조회 쿼리
        $sql = "SELECT * FROM free_board WHERE title LIKE '%$search%' ORDER BY id DESC";
    } else {
        // 검색어가 전달되지 않은 경우, 모든 게시글 조회 쿼리
        $sql = "SELECT * FROM free_board ORDER BY id DESC";
    }

    $result = $mysqli->query($sql);

    // 게시글 목록 출력
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $title = $row["title"];
            $author = $row["nickname"];
            $created_at = $row["created_at"];
            ?>
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h5 class="card-title"><?php echo $title ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $author ?></h6>
                        <p class="card-text"><?php echo $created_at ?></p>
                    </div>
                    <div>
                        <?php
                        // 세션에서 nickname 가져오기
                        $session_nickname = $_SESSION["nickname"];

                        if ($author == $session_nickname) {
                            // 글의 author와 세션의 nickname이 일치하는 경우
                            ?>
                            <a href="/index.php?page=board&id=<?php echo $id ?>" class="btn btn-primary">상세 보기</a>
                            <a href="/index.php?page=board&model=edit&id=<?php echo $id ?>"
                               class="btn btn-warning">수정</a>
                            <a href="/index.php?page=board&model=delete&id=<?php echo $id ?>"
                               class="btn btn-danger">삭제</a>
                            <?php
                        } else {
                            // 글의 author와 세션의 nickname이 일치하지 않는 경우
                            ?>
                            <a href="/index.php?page=board&id=<?php echo $id ?>" class="btn btn-primary">상세 보기</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "게시글이 없습니다.";
    }

    $mysqli->close();
    ?>

    <a href="/index.php?page=board&model=write" class="btn btn-success mb-4">새 글 쓰기</a>
</div>
</body>
</html>
