<?php
session_start();

// Redirect to the home route if no route is explicitly set or is empty
if (!isset($_GET['route']) || $_GET['route'] === '') {
    header('Location: /?route=home');
    exit();
}
?>