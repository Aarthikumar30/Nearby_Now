<?php
session_name("nearby");
session_start();
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Please log in to register as a provider.");
}

$user_id = $_SESSION['user_id'];

// Check if provider is already registered
$query = "SELECT * FROM providers WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

if ($provider) {
    echo "<h2>Your registration status: " . ucfirst($provider['status']) . "</h2>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_name = mysqli_real_escape_string($conn, $_POST['provider_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $service_type = mysqli_real_escape_string($conn, $_POST['service_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Fetch the service_id based on the selected category
    $service_query = "SELECT service_id FROM services WHERE category = '$category' LIMIT 1";
    $service_result = mysqli_query($conn, $service_query);

    if ($service_result && mysqli_num_rows($service_result) > 0) {
        $service_row = mysqli_fetch_assoc($service_result);
        $service_id = $service_row['service_id'];

        // Insert provider details into the database
        $insert_query = "INSERT INTO providers (user_id, provider_name, category, service_type, description, experience, price, state, district, location, contact, service_id) 
                         VALUES ('$user_id', '$provider_name', '$category', '$service_type', '$description', '$experience', '$price', '$state', '$district', '$location', '$contact', '$service_id')";

        if (mysqli_query($conn, $insert_query)) {
            echo "<h2>Registration submitted. Waiting for admin approval.</h2>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Unable to fetch service ID for the selected category.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Provider Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Register as a Service Provider</h2>
    <form method="post">
        <label for="provider_name">Business Name / Provider Name:</label>
        <input type="text" name="provider_name" placeholder="Business Name" required>

        <label for="category">Select Category:</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="cleaning">Cleaning</option>
            <option value="pest_control">Pest Control</option>
            <option value="painting">Painting</option>
            <option value="gardening">Gardening</option>
            <option value="electrician">Electrician</option>
            <option value="others">Others</option>
        </select>

        <label for="service_type">Service Type:</label>
        <input type="text" name="service_type" placeholder="Service Type (e.g., House Cleaning, Wiring)" required>

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Describe your service in detail" required></textarea>

        <label for="experience">Years of Experience:</label>
        <input type="number" name="experience" placeholder="Years of Experience" required>

        <label for="price">Price (per hour):</label>
        <input type="number" name="price" placeholder="Price" required>

        <label for="state">State:</label>
        <input type="text" name="state" placeholder="State" required>

        <label for="district">District:</label>
        <input type="text" name="district" placeholder="District" required>

        <label for="location">Location:</label>
        <input type="text" name="location" placeholder="Location" required>

        <label for="contact">Contact Number:</label>
        <input type="text" name="contact" placeholder="Contact Number" required>

        <button type="submit">Submit Registration</button>
    </form>
</body>
</html>