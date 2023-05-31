<?php session_start();?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
          <div class="container">
            <a class="navbar-brand" href="/index.php">OTS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="/introduce.php?username=test">intruduce</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=board">Board</a>
                </li>
              </ul>
              <ul class="navbar-nav ms-auto">
                <?php
                if(isset($_SESSION['nickname'])) {
                  echo "
                  <li class='nav-item'>
                    <a class='nav-link' href='/mypage.php'>Mypage</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='/logout.php'>Logout</a>
                  </li>";
                } else {
                  echo "
                  <li class='nav-item'>
                    <a class='nav-link' href='/login.php'>Login</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='/join.php'>Join</a>
                  </li>";
                }
                ?>
              </ul>
            </div>
          </div>
        </nav>