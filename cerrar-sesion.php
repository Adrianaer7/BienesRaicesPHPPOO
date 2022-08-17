<?php 
    session_start();
    $_SESSION = []; //vacio el array que tiene login true
    header("Location: /")
?>