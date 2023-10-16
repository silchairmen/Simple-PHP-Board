<?php session_start();
  ini_set('display_errors', 1);
  include '../application/core/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Soti</title>
        <link rel="icon" type="image/x-icon" href="/static/assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="static/css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <?php
          include "../application/view/header.php";
          $page = $_GET['page'];

          if (isset($page)){
            try {
                
                include $page.".php";
                include "../application/view/footer.php";
            } catch (Exception $e) {
                include "../application/view/404.php";
                echo $e;
            }
        }
          else{
            include "../application/view/main.php";
            include "../application/view/footer.php";
          }
        ?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/static/js/scripts.js"></script>
    </body>
</html>
