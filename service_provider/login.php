<?php
session_name('nearby');
session_start();
include "config.php";

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password, role, level FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
           
            $_SESSION['user_login'] = true;   
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["level"] = $row["level"];

            // Redirect based on role
            if ($row["role"] === "admin") {
                header("Location: admin_dashboard.php");
            } elseif ($row["role"] === "provider") {
                header("Location: provider_dashboard.php?user_id=".$row["id"]);
            } else {
                //header("Location: user_dashboard.php");
                header("Location: user_dashboard.php?user_id=".$row["id"]);
            }
            exit();
            
            // Redirect to dashboard
            //header("Location: dashboard.php");
            //exit(); 
           
           /* // Store session data
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];

            // Redirect based on role
            if ($row["role"] === "admin") {
                header("Location: admin_dashboard.php");
            } elseif ($row["role"] === "provider") {
                header("Location: provider_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();*/
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { width: 350px; margin: auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1); margin-top: 50px; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { background-color: #28a745; color: white; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #218838; }
        .error { color: red; font-size: 14px; margin-top: -8px; }
        .signup-link { display: block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="signup.php" class="signup-link">Don't have an account? Signup</a>
    </div>
</body>
</html>
