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
<header>
        <a class="logo" href="../templates/home.php">PROGRAMM</a>
        <nav>
            <div></i></div>
            <ul class="head">
                <li><a class="header" href="../templates/home.php">Home</a></li>
                <li><a class="header" href="../templates/courses">Courses &blacktriangledown;</a>
                    <ul>
                        <li><a href="../templates/backend.php">Backend</a></li>
                        <li><a href="../templates/data_science.php">Data science</a></li>
                        <li><a href="../templates/UI.php">UI design</a></li>
                        <li><a href="../templates/UX.php">UX design</a></li>
                        <li><a href="../templates/frontend.php">Frontend</a></li>
                        <li><a href="../templates/gamedev.php">Gamedev</a></li>
                        <li><a href="../templates/python.php">Python</a></li>
                    </ul>
                </li>
                <li><a class="header" href="../templates/kontakt.php">Contact</a></li>
                <li><a class="header" href="../templates/qna.php">Q&A</a></li>
            </ul>
            <div class="hamburger">
             <span class="bar"></span>
             <span class="bar"></span>
             <span class="bar"></span>
            </div>
        </nav>
</header>


</body>