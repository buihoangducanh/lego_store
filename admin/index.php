<?php
session_start();
$role_id = $_SESSION['user_role'];
if ($role_id == 1) {
    header("Location:productlist.php");
} else {
    header("Location:../index.php");
}
