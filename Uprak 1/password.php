<?php
session_start();
include_once 'database.php';

$db = new Database();
$conn = $db->koneksi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current password
    $query = "SELECT password FROM admin WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($old_password, $user['password'])) {
        if ($new_password == $confirm_password) {
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE admin SET password = :new_password WHERE username = :username";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bindParam(':new_password', $new_password_hashed);
            $update_stmt->bindParam(':username', $username);
            if ($update_stmt->execute()) {
                session_destroy();
                header("Location: login.php");
                exit;
            } else {
                $error_message = "Failed to update password.";
            }
        } else {
            $error_message = "New password and confirmation do not match.";
        }
    } else {
        $error_message = "Old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
</head>

<body>
    <form method="POST" action="change_password.php">
        Old Password: <input type="password" name="old_password"><br>
        New Password: <input type="password" name="new_password"><br>
        Confirm New Password: <input type="password" name="confirm_password"><br>
        <button type="submit">Save</button>
    </form>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>

</html>