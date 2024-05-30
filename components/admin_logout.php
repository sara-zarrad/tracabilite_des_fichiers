<?php

include '../components/connect_bd.php';
session_start();
session_unset();
session_destroy();
header('location:../admin/connection_admin.php');
exit();
?>
