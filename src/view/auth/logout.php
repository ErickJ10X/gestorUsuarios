<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');

$authController->logout();
