<?php
include '../core.php';
$_SESSION = [];
session_destroy();
header("location: /login.php");
die();
