<?php
include '../components/connect_bd.php';
session_start();
session_unset();
session_destroy();

header('location:../user/connection_utilisateur.php');
exit();
?>
