<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h1>Welcome to the Dashboard</h1>
    <p>Hello, <?php echo $_SESSION['username']; ?>!</p>
    <a href="change_password.php">Change Password</a>
    <a href="logout.php">Logout</a>
</body>

</html>