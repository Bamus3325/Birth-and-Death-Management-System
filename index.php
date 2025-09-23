<?php
session_start();
error_reporting(E_ALL);
if (!isset($_SESSION['user'])) {
    header("location: login");
}
else {
    header("location: dashboard");
}
?>