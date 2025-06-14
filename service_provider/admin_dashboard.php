<?php
session_name('nearby');
session_start();
include "config.php";
/*if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <a class="btn btn-danger" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h2>Welcome, Admin <?php echo $_SESSION["username"]; ?>!</h2>
            <p>Manage users and services from this panel.</p>

            <a href="dashboard.php" class="btn btn-success">Verify Providers</a>
        </div>
    </div>
</body>
</html>
