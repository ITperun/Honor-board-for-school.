<?php
session_start();

$correct_username = "admin";
$correct_password = "12345";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION["logged_in"] = true;
        header("Location: admin.php");
        exit();
    } else {
        echo "You Shall Not Pass!";
    }
}
?>
