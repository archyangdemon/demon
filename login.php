<?php
session_start();
$conn = new mysqli("localhost", "root", "", "loan_grants_portal");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    echo "Login successful. Redirecting...";
    header("refresh:2;url=../dashboard.php");
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$conn->close();
?>