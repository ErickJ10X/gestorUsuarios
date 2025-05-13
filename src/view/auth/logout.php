<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');
global $authController;
$authController->logout();

header("Location: login.php");
