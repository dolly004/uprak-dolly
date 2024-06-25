<?php
session_start();
include_once 'database.php';

$db = new Database();
$conn = $db->koneksi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error_message = "Username or password must be filled.";
    } else {
        $query = "SELECT * FROM kasir WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "Username not registered.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <form method="POST" action="login.php">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>

</html>