<?php
include '../application/view/header.php';

try {
    $username = $_GET['username'];

    if (isset($username)){
        
    }
    else{
        $username="test";
    }
  }
  
  //catch exception
  catch(Exception $e) {
    $username = 'test';
  }
?>

<html>
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>soti</title>
        <link rel="icon" type="image/x-icon" href="/static/assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="static/css/styles.css" rel="stylesheet" />
    </head>
<body>
<div class="container px-4 px-lg-5">
    <br><Br>
                    <!-- Heading Row-->
                    <div class="row gx-4 gx-lg-5 align-items-center my-5">
                        <div class="col-lg-5">
                            <h1 class="font-weight-light">Hi. <?php echo $username;?> <br>Welcome to SOTI</h1>
                            <p>Welcome to Ots Thank you for your hard work. Ots is a security research club. We basically master security. But it's not limited to security. Studying overall IT knowledge, the goal of the club is to gather good people and keep them by their side.</p>
                        </div>
                    </div>
                    <!-- Call to Action-->
                </div>
</body>
    </html>
