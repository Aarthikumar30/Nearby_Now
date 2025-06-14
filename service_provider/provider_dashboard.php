<?php
session_name("nearby");
session_start();
include 'config.php';
//$user_id = $_SESSION['user_id'];

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    //echo "User ID from URL: " . $user_id;
} else {
    echo "User ID not found in the URL.";
}


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT provider_id, status, description FROM providers WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);
$status = $provider ? ucfirst($provider['status']) : 'Not Registered';

// Determine the active section
$section = isset($_GET['section']) ? $_GET['section'] : 'home';


//Profile Section
if ($section === 'profile') {
    $query = "SELECT * FROM providers WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);
    $provider = mysqli_fetch_assoc($result);
    if (!$provider) {
        die("Profile not found.");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--swiper css file-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard_style.css">
</head>
<body>
    <div class="dashboard">
        <!-- Left Column : Sidebar -->
        <div class="sidebar">
            <div><h2 class="fas fa-user"> Provider <?php echo $_SESSION["username"]; ?>!</h2></div>
            <h3>My Dashboard</h3>
            <a href="provider_dashboard.php?section=home&user_id=<?php echo $user_id; ?>">Home</a>
            <a href="provider_dashboard.php?section=profile&user_id=<?php echo $user_id; ?>">Profile</a>
            <!--<a href="provider_dashboard.php?section=add_service&user_id=< echo $user_id;?>">Add Service</a>
            <a href="provider_dashboard.php?section=manage_service&user_id=< echo $user_id;?>">Manage Bookings</a>-->
            <a href="provider_dashboard.php?section=view_bookings&user_id=<?echo $user_id;?>">View Bookings</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Right Column : Page Content -->
        <div class="content">
            <?php
            // Include content based on the active section
            if ($section === 'home') {?>
                
                <div class="head">
                    <p>Manage your services and appointments here.</p>
                    <?php // Fetch the count of new (pending) bookings for the logged-in provider
                        $new_bookings_query = "SELECT COUNT(*) AS new_bookings_count 
                        FROM bookings 
                        WHERE provider_id = '{$provider['provider_id']}' AND status = 'pending'";
                        $new_bookings_result = mysqli_query($conn, $new_bookings_query);
                        $new_bookings = mysqli_fetch_assoc($new_bookings_result);
                        $new_bookings_count = $new_bookings['new_bookings_count'];
                    ?>

                    <?php if ($new_bookings_count > 0) { ?>
                        <div class="new-bookings-alert">
                            <h3>New Bookings</h3>
                            <p>You have <strong><?php echo $new_bookings_count; ?></strong> new booking(s) pending action. 
                            <a href="provider_dashboard.php?section=view_bookings&user_id=<?php echo $user_id;?>">View Bookings</a></p>
                        </div>
                    <?php } ?>
                </div>

                <div class="about">
                    <div class="image">
                        <img src="images/about-img-1.webp" alt="">
                    </div>

                    <div class="about-content">
                        <h3>About Us</h3>
                        <p>Welcome to Nearby Now, your platform for connecting with local customers and growing your business. Manage bookings, receive service requests, and build your reputation with verified reviews—all in one place!</p>

                        <h3>What We Do</h3>
                        <p>At Nearby Now, we connect local service providers with customers in their area. Our platform allows you to list your services, set your availability, and receive bookings from customers looking for your expertise.</p>
                        <p>Whether you're a plumber, electrician, or any other service provider, Nearby Now is the place to grow your business and build your reputation.</p>
                    </div>
                </div>

                <div class="register">
                    <h3>Register Your Services</h3>
                    <p>Expand your reach by listing your services on Nearby Now. Showcase your skills, set your availability, and start receiving bookings from customers in your area.</p>

                    <div class="registration-status">
                        <p>Registration Status: <strong><?php echo $status; ?></strong></p>

                        <?php if ($provider && $provider['status'] == 'approved') { ?>
                            <p><strong>Provider ID:</strong> <?php echo $provider['provider_id']; ?></p>
                            <p><strong>Description:</strong> <?php echo $provider['description']; ?></p>
                        <?php } else if (!$provider) { ?>
                            <a href="provider/register.php" class="btn">Register</a>
                        <?php } else { ?>
                            <p>Your account is awaiting admin approval.</p>
                        <?php } ?>
                    </div>
                </div>

                <?php
            } elseif ($section === 'profile') {
                // Profile Section
                ?>
                <h1>Profile</h1>
                <div class="profile-info">
                    <p><label>Provider Name:</label> <?php echo htmlspecialchars($provider['provider_name']); ?></p>
                    <p><label>Email:</label> <?php echo htmlspecialchars($provider['email']); ?></p>
                    <p><label>Contact:</label> <?php echo htmlspecialchars($provider['contact']); ?></p>
                    <p><label>Description:</label> <?php echo htmlspecialchars($provider['description']); ?></p>
                </div>
                <a href="provider_dashboard.php?section=edit_profile&user_id=<?php echo $user_id?>" class="btn">Edit Profile</a>
                <?php
            } elseif ($section === 'add_service') {
                // Add Service Section
                ?>
                <h1>Add Service</h1>
                <form method="POST" action="">
                    <label for="service_name">Service Name:</label>
                    <input type="text" id="service_name" name="service_name" required>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required>
                    <button type="submit">Add Service</button>
                </form>
                <?php
            } elseif ($section === 'manage_service') {
                // Manage Services Section
                ?>
                <h1>Manage Services</h1>
                <p>Display a list of services added by the provider here.</p>
                <?php
            } elseif ($section === 'view_bookings') {
                // Fetch bookings for the logged-in provider where status is 'confirmed'
                $query = "SELECT b.b_id, b.booking_date, b.booking_time, b.status, b.address, b.contact, 
                             p.category, p.service_type as service_name, b.user_name AS customer_name 
                          FROM bookings b
                          JOIN services s ON b.service_id = s.service_id
                          JOIN providers p ON b.provider_id = p.provider_id
                          JOIN users u ON b.user_id = u.id
                          WHERE b.provider_id = '{$provider['provider_id']}' AND b.status IN ('confirmed', 'pending', 'cancelled', 'completed')
                          ORDER BY b.booking_date DESC";
                $result = mysqli_query($conn, $query);

                // Handle Actions (Pending, Cancel, Completed)
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['b_id'])) {
                    $action = $_POST['action'];
                    $b_id = $_POST['b_id'];

                    if($action === 'confirmed'){
                        //Generate a unique booking ID
                        $booking_id =  'BOOK-' . time() . '-' .rand(1000, 9999);
                        // Check if the booking ID already exists in the database
                        $check_query = "SELECT * FROM bookings WHERE booking_id = '$booking_id'";
                        $check_result = mysqli_query($conn, $check_query);
                        while (mysqli_num_rows($check_result) > 0) {
                            // If it exists, generate a new one
                            $booking_id = 'BOOK-' . time() . '-' . rand(1000, 9999);
                            $check_result = mysqli_query($conn, $check_query);
                        }
                        // If it doesn't exist, proceed with the update
                        
                        // Update the booking status to 'confirmed'
                        $update_query = "UPDATE bookings 
                                         SET status = 'confirmed', booking_id = '$booking_id' 
                                         WHERE b_id = '$b_id'";
                        mysqli_query($conn, $update_query);
                    }

                    if ($action === 'pending') {
                        // Update the booking status to 'pending'
                        $update_query = "UPDATE bookings 
                                         SET status = 'pending' 
                                         WHERE b_id = '$b_id'";
                        mysqli_query($conn, $update_query);
                    } elseif ($action === 'cancel') {
                        // Update the booking status to 'cancelled'
                        $update_query = "UPDATE bookings 
                                         SET status = 'cancelled' 
                                         WHERE b_id = '$b_id'";
                        mysqli_query($conn, $update_query);
                    } elseif ($action === 'completed') {
                        // Update the booking status to 'completed'
                        $update_query = "UPDATE bookings 
                                         SET status = 'completed' 
                                         WHERE b_id = '$b_id'";
                        mysqli_query($conn, $update_query);
                    }

                    // Refresh the page to reflect changes
                    header("Location: provider_dashboard.php?section=view_bookings&user_id=".$user_id);
                    exit();
                }
                ?>
                <h1>View Bookings</h1>
                <div class="bookings-container">
                    <?php if (mysqli_num_rows($result) > 0) { ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Category</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['booking_time']); ?></td>
                                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                                        <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'confirmed') { ?>
                                                <form method="POST" action="provider_dashboard.php?section=view_bookings">
                                                    <input type="hidden" name="b_id" value="<?php echo $row['b_id']; ?>">
                                                    <button type="submit" name="action" value="completed" class="btn btn-warning btn-sm">Completed</button>
                                                    <button type="submit" name="action" value="cancel" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            <?php } elseif ($row['status'] === 'pending') { ?>
                                                <form method="POST" action="provider_dashboard.php?section=view_bookings">
                                                    <input type="hidden" name="b_id" value="<?php echo $row['b_id']; ?>">
                                                    <button type="submit" name="action" value="confirmed" class="btn btn-success btn-sm">Conifrm</button>
                                                    <button type="submit" name="action" value="cancel" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            <?php } else { ?>
                                                <span><?php echo ucfirst($row['status']); ?></span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>No bookings found.</p>
                    <?php } ?>
                </div>
                <?php
            } else if ($section === 'edit_profile') {
                // Fetch provider details
                $query = "SELECT provider_name, email, contact, description FROM providers WHERE user_id='$user_id'";
                $result = mysqli_query($conn, $query);
                $provider = mysqli_fetch_assoc($result);

                // Handle missing provider data
                $provider_name = isset($provider['provider_name']) ? htmlspecialchars($provider['provider_name']) : '';
                $email = isset($provider['email']) ? htmlspecialchars($provider['email']) : '';
                $contact = isset($provider['contact']) ? htmlspecialchars($provider['contact']) : '';
                $description = isset($provider['description']) ? htmlspecialchars($provider['description']) : '';

                // Handle profile update
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $provider_name = $_POST['provider_name'];
                    $email = $_POST['email'];
                    $contact = $_POST['contact'];
                    $description = $_POST['description'];
                }
                ?>
                <h1>Edit Profile</h1>
                <form method="POST" action="provider_dashboard.php?section=edit_profile">
                    <label for="provider_name">Provider Name:</label>
                    <input type="text" id="provider_name" name="provider_name" value="<?php echo $provider_name; ?>" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                    
                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required>
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"><?php echo $description; ?></textarea>
                    
                    <button type="submit">Update Profile</button>
                </form>

                
                <button onclick="window.location.href='provider_dashboard.php?section=profile&user_id=<?php echo $user_id?>'">View Profile</button>
                
                <?php
            } 
            else {
                echo "<p>Invalid section selected.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>