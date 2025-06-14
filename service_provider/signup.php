<?php
    //session_name('nearby'); // Set session name
    session_start();
    include "config.php";

    // Handle Form Submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT);
        $username = trim($_POST["username"]);
        $role = $_POST["role"];

        // Assign levels based on role
        $level = 0;
        if ($role === "admin") {
            $level = 1;
        } elseif ($role === "provider") {
            $level = 2;
        } elseif ($role === "user") {
            $level = 3;
        }

        // Check if username exists
        $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $checkUser->bind_param("s", $username);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username already taken!');</script>";
        } else {
            // Insert data
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, username, role, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $name, $email, $phone, $password, $username, $role, $level);

            if ($stmt->execute()) {
                echo "<script>alert('Signup successful! Redirecting to login page...'); window.location.href='login.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 350px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 50px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: left;
            margin-top: -8px;
        }
        .login-link {
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form name="signupForm" method="POST" action="signup.php" onsubmit="return validateForm()">
            <input type="text" name="name" placeholder="Full Name">
            <div class="error" id="nameError"></div>

            <input type="email" name="email" placeholder="Email">
            <div class="error" id="emailError"></div>

            <input type="tel" name="phone" placeholder="Phone Number">
            <div class="error" id="phoneError"></div>

            <input type="text" name="username" placeholder="Username">
            <div class="error" id="usernameError"></div>

            <input type="password" name="password" placeholder="Password">
            <div class="error" id="passwordError"></div>

            <select name="role">
                <option value="">Select Role</option>
                <option value="user">User</option>
                <option value="provider">Provider</option>
                <!--<option value="admin">Admin</option>-->
            </select>
            <div class="error" id="roleError"></div>

            <button type="submit">Signup</button>
        </form>

        <a href="login.php" class="login-link">Already have an account? Login</a>
    </div>

    <script>
        function validateForm() {
            let valid = true;

            let name = document.signupForm.name.value.trim();
            let email = document.signupForm.email.value.trim();
            let phone = document.signupForm.phone.value.trim();
            let username = document.signupForm.username.value.trim();
            let password = document.signupForm.password.value.trim();
            let role = document.signupForm.role.value.trim();

            // Clear previous error messages
            document.getElementById("nameError").innerHTML = "";
            document.getElementById("emailError").innerHTML = "";
            document.getElementById("phoneError").innerHTML = "";
            document.getElementById("usernameError").innerHTML = "";
            document.getElementById("passwordError").innerHTML = "";
            document.getElementById("roleError").innerHTML = "";

            if (name === "") {
                document.getElementById("nameError").innerHTML = "Name is required!";
                valid = false;
            }
            if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) {
                document.getElementById("emailError").innerHTML = "Valid email is required!";
                valid = false;
            }
            if (phone === "" || !/^\d{10}$/.test(phone)) {
                document.getElementById("phoneError").innerHTML = "Valid 10-digit phone number is required!";
                valid = false;
            }
            if (username === "") {
                document.getElementById("usernameError").innerHTML = "Username is required!";
                valid = false;
            }
            if (password.length < 6) {
                document.getElementById("passwordError").innerHTML = "Password must be at least 6 characters!";
                valid = false;
            }
            if (role === "") {
                document.getElementById("roleError").innerHTML = "Please select a role!";
                valid = false;
            }

            return valid;
        }
    </script>
</body>
</html>
