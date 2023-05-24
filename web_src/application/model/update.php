<?php
    $id = $_POST['id'];
    $nickname = $_POST['author'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "UPDATE free_board SET title='".$title."', content='".$content."' WHERE id=".$id." and nickname="."'".$nickname."'";
    $result = $mysqli->query($query);

    if ($result === false) {
        echo "<script>alert('Fail to update')</script>";
        echo "<script>location.href='/index.php?page=board&model=edit&id=".$id."'</script>";
    }
    else{
        echo "<script>alert('edit success')</script>";
        echo "<script>location.href='/index.php?page=board'</script>";
    }
?>