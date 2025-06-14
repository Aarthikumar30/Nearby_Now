<?php
session_start();
include "../config.php";

// Check if the user is logged in and is a provider
/*if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}*/

$provider_id = $_SESSION['provider_id'] ?? null;
$message = "";

// Check if provider_id is set
if (!$provider_id) {
    die("Provider ID is not set. Please log in again.");
}

// Fetch provider details
$query = "SELECT * FROM providers WHERE provider_id = '$provider_id'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $provider = mysqli_fetch_assoc($result);
} else {
    die("Provider details not found. Please ensure your account is registered.");
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_name = $_POST['provider_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $description = $_POST['description'];
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update_query = "UPDATE providers SET provider_name='$provider_name', email='$email', contact='$contact', description='$description', password='$password' WHERE provider_id='$provider_id'";
    } else {
        $update_query = "UPDATE providers SET provider_name='$provider_name', email='$email', contact='$contact', description='$description' WHERE provider_id='$provider_id'";
    }

    if (mysqli_query($conn, $update_query)) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { width: 400px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: green; color: white; padding: 10px; border: none; cursor: pointer; border-radius: 5px; }
        button:hover { background-color: darkgreen; }
        .message { color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <form method="post">
        <label>Business Name</label>
        <input type="text" name="provider_name" value="<?php echo htmlspecialchars($provider['provider_name']); ?>" required>
        
        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($provider['email']); ?>" required>

        <label>Phone</label>
        <input type="text" name="contact" value="<?php echo htmlspecialchars($provider['contact']); ?>" required>

        <label>Description</label>
        <textarea name="description" required><?php echo htmlspecialchars($provider['description']); ?></textarea>

        <label>New Password (Leave blank if not changing)</label>
        <input type="password" name="password">

        <button type="submit">Update Profile</button>
    </form>
    <p class="message"><?php echo $message; ?></p>
    <button onclick="window.location.href='../provider_dashboard.php?section=profile'">View Profile</button>
</div>

</body>
</html>