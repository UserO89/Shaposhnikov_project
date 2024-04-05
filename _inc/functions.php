<?php
require_once('config.php');

function add_stylesheet() {
    echo '<link rel="stylesheet" href="../assests/css/style.css">';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous">';
}


function add_scripts(){
    echo('<script src="../assests/js/acordeon.js"></script>');
    echo('<script src="../assests/js/burger.js"></script>');
    echo('<script src="../assests/js/slider.js"></script>');

}

function redirect_homepage(){
    header("Location: templates/home.php");
    die("Nepodarilo sa nájsť Domovskú stránku");
}

function setTimeout($url){
    sleep(2);    
    header("Location: $url");
    exit();
}

    ?>