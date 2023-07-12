<?php
session_start();
include "../application/core/db_connect.php";
$uid = $upw = "";
$uid_err = $upw_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["uid"]))){
        $uid_err = "Please enter username.";
    } else{
        $uid = trim($_POST["uid"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['upw']))){
        $upw_err = "Please enter your password.";
    } else{
        $upw = trim($_POST['upw']);
    }

    // Validate credentials
    if (empty($uid_err) && empty($upw_err)) {
		// Prepare a select statement
		$stmt = $mysqli->prepare("SELECT * FROM user_info WHERE user_id=? AND upw=?");
	
		$stmt->bind_param("ss", $uid, $upw);
	
		$stmt->execute();
	
		$stmt->store_result();
	
		// Check if username exists
		if ($stmt->num_rows == 1) {
			// Bind result variables
			$stmt->bind_result($id, $user_id, $upw, $phone_num, $grade, $nickname);
			if ($stmt->fetch()) {
				// Store data in session variables
				$_SESSION["id"] = $id;
				$_SESSION["user_id"] = $user_id;
                $_SESSION["phone_num"] = $phone_num;
                $_SESSION["grade"] = $grade;
                $_SESSION["nickname"] = $nickname;

	
				// Redirect user to home page
				header("location: ../index.php");
				exit;
			} else {
				// Display an error message if password is not valid
				$upw_err = "비밀번호가 올바르지 않습니다.";
				echo "<script>alert('$upw_err');</script>";
			}
		} else {
			// Display an error message if username doesn't exist
			$uid_err = "아이디 혹은 비밀번호가 올바르지 않습니다.";
			echo "<script>alert('$uid_err');</script>";
		}
	
		// Close statement
		$stmt->close();
	
		// Close connection
		$mysqli->close();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #d6eaf8;
        }
        .card {
            margin-top: 100px;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: #fff;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>OTS Member Login</h2>
            <form method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="uid" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="upw" id="password" placeholder="Enter password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <button type="button" onclick="window.location.href='./join.php'" class="btn btn-primary btn-block">Join</button>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
