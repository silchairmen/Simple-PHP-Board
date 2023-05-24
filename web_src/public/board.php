<?php
    include "../application/core/db_connect.php";
    $id = $_GET['id'];
    $model = $_GET['model'];
    if($_SESSION['nickname']){

        if (isset($id)){
            if(isset($model)){
                if ($model=="edit"){
                    include "../application/model/edit.php";
                }
                elseif($model="delete"){
                    include "../application/model/delete.php";
                }
                elseif($model="update"){
                    include "../application/model/update.php";
                }
            }
            else{
                include "../application/view/view_board.php";
            }
        }
        elseif (isset($model)){
            include "../application/model/".$model.".php";
        }
        else{
            include "../application/view/freeboard.php";
        }
    }
    else{
        $script = "<script>alert('Login First.'); location.href='/login.php'</script>";
        echo $script;
    }
?>
    