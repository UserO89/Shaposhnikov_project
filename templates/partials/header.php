<?php
  require('../_inc/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 'Moj web | '. (basename($_SERVER["SCRIPT_NAME"], '.php'));?></title>
    <?php
        add_stylesheet();
    ?>
</head>
<body>
<nav>
            <div><a href="home.php"><img src="../assests/img/logo.png"></a></div>
            <div class="openMenu"><i class="fa fa-bars"></i></div>
            <ul class="mainMenu">
                <li><a class="menu-item" href="../templates/home.php">Home</a></li>
                <li><a class="menu-item" href="../templates/kontakt.php">Contact</a></li>
                <li><a class="menu-item" href="../templates/qna.php">Q&A</a></li>
                <div class="closeMenu"><i class="fa fa-times"></i></div>
                <span class="icons">
                    <a href="https://www.facebook.com/profile.php?id=100024376782304"><i  class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/v_l_a_d089/"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com/U_s_e_r089" ><i class="fab fa-twitter"></i></a>
                    <a href="https://github.com/"><i class="fab fa-github"></i></a>
                </span>
            </ul>
        </nav>


</body>