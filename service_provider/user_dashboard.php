<?php
session_name('nearby');
session_start();
include "config.php"; // Database connection

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    //echo "User ID from URL: " . $user_id;
} else {
    echo "User ID not found in the URL.";
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    echo "User is not logged in. Please log in.";
    header("Location: login.php");
    exit();
}

// Determine the active section
$section = isset($_GET['section']) ? $_GET['section'] : 'home';

$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!--swiper css file-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/user_dashboard_style.css">
</head>
<body>
    <!-- Header Section -->
    <section class="header">
        <a href="home.php" class="logo"><img src="images/logo.png"></a>

        <nav class="navbar">
            <a href="user_dashboard.php?section=home&user_id=<?php echo $user_id?>">Home</a>
            <a href="user_dashboard.php?section=user_profile&user_id=<?php echo $user_id?>">Profile</a>
            <a href="user_dashboard.php?section=view_services&user_id=<?php echo $user_id?>">Services</a>
            <a href="user_dashboard.php?section=your_bookings&user_id=<?php echo $user_id?>">Bookings</a>
        </nav>

        <div id="menu-btn" class="fas fa-bars"></div>
    </section>

    <!-- Main Content -->
    <div class="content">
        <?php
        // Load content based on the active section
        if ($section === 'home') {
            ?>
             <section id="home" class="user" >

                <div class="slide">
                    <div class="content">
                        <h3>nearby now</h3>
                        <p>"Find Trusted Services, Book with Ease, Get the Job Done!"</p>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search">

                    <?php
                    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
                    $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";
        
                    $query = "SELECT * FROM providers WHERE status = 'approved'";
                    if (!empty($search)) {
                        $query .= " AND (category LIKE '%$search%' OR state LIKE '%$search%' OR district LIKE '%$search%' OR provider_name LIKE '%$search%')";
                    }
                    if (!empty($category)) {
                        $query .= " AND category = '$category'";
                    }
        
                    $result = mysqli_query($conn, $query);
                    ?>
                    
                        <form action="user_dashboard.php" method="GET" class="search-bar">
                            <input type="hidden" name="section" value="view_services">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="text" name="search" placeholder="Search for services..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit">Search</button>
                        </form>
                    
                </div>


                <!-- Home About Section -->

                <section id="home-about" class="home-abt">

                <div class="home-about">
                    <div class="image">
                        <img src="images/about-img-2.webp" alt="">
                    </div>

                    <div class="content">
                        <h3>about us</h3>
                        <p>Nearby Now makes booking local services effortless. Use the dashboard to browse professionals, manage bookings, and track requests—all with verified experts and transparent pricing. Whether you need plumbing, cleaning, or electrical work, we connect you with trusted local professionals for a seamless and reliable experience. </p>
                        <p>Enjoy convenience, quality, and hassle-free service at your fingertips!</p>
                    </div>
                </div>
                </section>

                <!-- Category Filter -->

                <section id="category" class="category">

                    <h1 class="heading-title"> categories </h1>


                    <div class="box-container">

                        <div class="box">
                            <div class="image">
                                <img src="images/cleaning.webp" alt="">
                            </div>
                            <div class="content">
                                <h3>cleaning</h3>
                                <p>Experience top-notch cleaning services tailored to your needs. From deep cleaning to regular maintenance, our experts ensure a sparkling clean space. Book now for hassle-free, affordable, and efficient cleaning!</p>
                                <a href="user_dashboard.php?section=view_services&category=cleaning&user_id=<?php echo $user_id?>" class="btn">book now</a>
   
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <img src="images/plumbing.webp" alt="">
                            </div>
                            <div class="content">
                                <h3>plumbing</h3>
                                <p>From pipe repairs to installations, our expert plumbers provide quick and efficient solutions for all your plumbing needs. Book now for hassle-free and affordable service!</p>
                                
                                <a href="user_dashboard.php?section=view_services&category=plumbing&user_id=<?php echo $user_id?>" class="btn">book now</a>

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <img src="images/painting.webp" alt="">
                            </div>
                            <div class="content">
                                <h3>painting</h3>
                                <p>Give your home or office a fresh new look with our professional painting services. From vibrant colors to smooth finishes, our skilled painters deliver quality results. Book now for a flawless makeover!</p>

                                <a href="user_dashboard.php?section=view_services&category=painting&user_id=<?php echo $user_id?>" class="btn">book now</a>

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <img src="images/gardening.webp" alt="">
                            </div>
                            <div class="content">
                                <h3>gardening</h3>
                                <p>Enhance your home or office with professional gardening services. From lawn care to plant maintenance, our experts create and maintain lush, vibrant gardens. Book now for a greener tomorrow!</p>
                                
                                <a href="user_dashboard.php?section=view_services&category=gardening&user_id=<?php echo $user_id?>" class="btn">book now</a>

                                
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <img src="images/pest_control.webp" alt="">
                            </div>
                            <div class="content">
                                <h3>pest control</h3>
                                <p>Keep your home or office safe with our eco-friendly pest control solutions. We eliminate termites, rodents, cockroaches, and more with advanced treatments. Book now for a hassle-free service!</p>
                            
                                <a href="user_dashboard.php?section=view_services&category=pest_control&user_id=<?php echo $user_id?>" class="btn">book now</a>
                                
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <img src="images/electrician.webp" alt="">
                            </div>
                            <div class="content">
                                <h3>electrician</h3>
                                <p>From wiring and installations to repairs and maintenance, our expert electricians ensure safety and reliability. Get fast, affordable, and professional electrical services. Book now!</p>
                                
                                <a href="user_dashboard.php?section=view_services&category=electrician&user_id=<?php echo $user_id?>" class="btn">book now</a>
                                
                            </div>
                        </div>

                    </div> 

                    <div class="load-more"> <a href="user_dashboard.php?section=view_services&user_id=<?php echo $user_id?>" class="btn btn-light"> Show All </a> </div>

                </section>

            </section>
            <?php
        } elseif ($section === 'user_profile') {
            // User Profile Section
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE id = '$user_id'";
            $result = mysqli_query($conn, $query);
            $user = mysqli_fetch_assoc($result);
            ?>
            <section id="user_profile" class="user">

                <h1 class="heading-title"> your profile </h1>

                <div class="profile-info">
                    <p><label>User Name:</label> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><label>Email: </label> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><label>Contact:</label> <?php echo htmlspecialchars($user['phone']); ?></p>
                    
                    <a href="user_dashboard.php?section=edit_profile&user_id=<?php echo $user_id; ?>" class="btn">Edit Profile</a>
                
                    <a href="logout.php" class="btn">Logout</a>
                </div>
                 

            </section>
            <?php
        } elseif ($section === 'view_services') {
            // View Services Section
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
            $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";

            $query = "SELECT * FROM providers WHERE status = 'approved'";
            if (!empty($search)) {
                $query .= " AND (category LIKE '%$search%' OR state LIKE '%$search%' OR district LIKE '%$search%' OR provider_name LIKE '%$search%')";
            }
            if (!empty($category)) {
                $query .= " AND category = '$category'";
            }

            $result = mysqli_query($conn, $query);
            ?>
            <section id="view_services" class="user">
                <h1 class="heading-title">View Services</h1>
                <form action="user_dashboard.php" method="GET" class="search-form">
                    <input type="hidden" name="section" value="view_services">
                    <input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden>
                    <input type="text" name="search" placeholder="Search by category, state, district or provider name" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Search</button>
                </form>
                <div class="service-container">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='service-card'>";
                            echo "<h3> <strong></strong> " . htmlspecialchars($row['service_type']) . "</h3>";
                            echo "<h6> <strong>Category : </strong> " . htmlspecialchars($row['category']) . "</h6>";
                            echo "<p> <strong>Provider Name : </strong>" . htmlspecialchars($row['provider_name']) . "</p>";
                            echo "<p> <strong>Description : </strong>" . htmlspecialchars($row['description']) . "</p>";
                            echo "<p> <strong>Experience : </strong>" . htmlspecialchars($row['experience']) . "</p>";
                            echo "<p><strong>Price(per hour) : </strong> ₹" . htmlspecialchars($row['price']) . "</p>";
                            echo "<p><strong>State : </strong> " . htmlspecialchars($row['state']) . "</p>";
                            echo "<p><strong>District : </strong> " . htmlspecialchars($row['district']) . "</p>";
                            echo "<p><strong>Location : </strong> " . htmlspecialchars($row['location']) . "</p>";
                            echo "<a href='user_dashboard.php?section=book_service&service_id=" . $row['service_id'] . "&user_id=" . $user_id . "' class='btn'>Book Now</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No services available.</p>";
                    }
                    ?>
                </div>
            </section>
            <?php
        } elseif ($section === 'your_bookings') {
            // Your Bookings Section
            ?>
            <section id="your_bookings" class="user">

                <h1 class='heading-title'>Your Bookings</h1>
                <div class="bookings-container">
                    <!--<form action="user_dashboard.php" method="GET" class="search-form">
                        <input type="hidden" name="section" value="your_bookings">
                        <input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden>
                        <input type="text" name="search" placeholder="Search by booking ID or service name" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit">Search</button>
                    </form>-->
                    <div class="bookings-list">
                        <?php
                        // Fetch bookings for the logged-in user
                        $user_id = $_SESSION['user_id'];
                        $query = "SELECT b.booking_id, b.booking_date, b.status, 
                                     p.category, p.service_type AS service_name, p.provider_name 
                              FROM bookings b
                              JOIN providers p ON b.provider_id = p.provider_id
                              JOIN services s ON b.service_id = s.service_id
                              WHERE b.user_id = '$user_id'
                              ORDER BY b.booking_date DESC";
                        
                        $result = mysqli_query($conn, $query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='booking-card'>";
                                echo "<h3>Booking ID: " . htmlspecialchars($row['booking_id']) . "</h3>";
                                echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
                                echo "<p><strong>Service:</strong> " . htmlspecialchars($row['service_name']) . "</p>";
                                echo "<p><strong>Provider:</strong> " . htmlspecialchars($row['provider_name']) . "</p>";
                                echo "<p><strong>Date:</strong> " . htmlspecialchars($row['booking_date']) . "</p>";
                                echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No bookings found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <?php
        } elseif ($section === 'book_service') {
            if (isset($_GET['service_id'])) {
                $user_id = $_SESSION['user_id'];
                $service_id = mysqli_real_escape_string($conn, $_GET['service_id']);
                echo $service_id;

                // Fetch the service details from the services table
                $service_query = "SELECT s.service_id, s.category, p.service_type, p.description, p.price, 
                                         p.provider_id, p.provider_name, p.status 
                                  FROM services s
                                  JOIN providers p ON s.service_id = p.service_id
                                  WHERE s.service_id = '$service_id' AND p.status = 'approved'";
                $service_result = mysqli_query($conn, $service_query);

                // Debugging output
                if (!$service_result) {
                    die("Query Failed: " . mysqli_error($conn));
                }

                if ($service_result && mysqli_num_rows($service_result) > 0) {
                    $service = mysqli_fetch_assoc($service_result);

                    // Handle booking submission
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
                        $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
                        $booking_time = mysqli_real_escape_string($conn, $_POST['booking_time']);
                        $address = mysqli_real_escape_string($conn, $_POST['address']);
                        $contact = mysqli_real_escape_string($conn, $_POST['contact']);

                        $insert_query = "INSERT INTO bookings (user_id, service_id, provider_id, user_name, booking_date, booking_time, address, contact, status) 
                                        VALUES ('$user_id', '$service_id', '{$service['provider_id']}', '$user_name', '$booking_date', '$booking_time', '$address', '$contact', 'pending')";

                        if (mysqli_query($conn, $insert_query)) {
                            echo "<script>alert('Booking successful!'); window.location='user_dashboard.php?section=your_bookings&user_id=' +$user_id;</script>";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                    ?>
                    <section id="book_service" class="user">
                        <h1 class="heading-title">Book Service</h1>
                        <div class="service-details">
                            <h2>Booking: <?php echo htmlspecialchars($service['service_type']); ?></h2>
                            <h2>Category: <?php echo htmlspecialchars($service['category']); ?></h2>
                            <p><strong>Provider:</strong> <?php echo htmlspecialchars($service['provider_name']); ?></p>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                            <p>Price: ₹<?php echo number_format($service['price'], 2); ?></p>
                            
                            <form method="POST">
                                <label for="user_name">Your Name:</label>
                                <input type="text" name="user_name" placeholder="Your Name" required><br>
                                
                                <label for="booking_date">Select Date:</label>
                                <input type="date" name="booking_date" required><br>

                                <label for="booking_time">Select Time:</label>
                                <input type="time" name="booking_time" required><br>

                                <label for="address">Your Address:</label>
                                <textarea name="address" placeholder="Address" required></textarea><br>

                                <label for="contact">Contact Number:</label>
                                <input type="text" name="contact" placeholder="Contact Number" required><br>

                                <button type="submit">Confirm Booking</button>
                            </form>
                        </div>
                    </section>
                    <?php
                } else {
                    echo "<p>Service not found or not approved.</p>";
                }
            } else {
                echo "<p>No service selected.</p>";
                echo "<p><a href='user_dashboard.php?section=view_services&user_id=$user_id'>Go back to services</a></p>";
            }
        } elseif ($section === 'change_password'){
            //change password section
            if (isset($_POST['change_password'])) {
                $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
                $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
                $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

                // Fetch the current password from the database
                $query = "SELECT password FROM users WHERE id = '$user_id'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);

                if (password_verify($current_password, $row['password'])) {
                    if ($new_password === $confirm_password) {
                        // Hash the new password and update it in the database
                        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                        $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
                        if (mysqli_query($conn, $update_query)) {
                            echo "<p>Password changed successfully.</p>";
                        } else {
                            echo "<p>Error updating password: " . mysqli_error($conn) . "</p>";
                        }
                    } else {
                        echo "<p>New passwords do not match.</p>";
                    }
                } else {
                    echo "<p>Current password is incorrect.</p>";
                }
            }
            

        } elseif ($section === 'delete_account'){
            //delete account section
            if (isset($_POST['delete_account'])) {
                $query = "DELETE FROM users WHERE id = '$user_id'";
                if (mysqli_query($conn, $query)) {
                    session_destroy();
                    header("Location: login.php?message=Account deleted successfully.");
                    exit();
                } else {
                    echo "<p>Error deleting account: " . mysqli_error($conn) . "</p>";
                }
            }
        
        } elseif ($scetion === 'edit_profile'){
            //edit profile section

        }else {
            echo "<p>Invalid section selected.</p>";
        }
        ?>
    </div>

    <!-- ======================================================
                    FOOTER SECTION
    ========================================================= -->
    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h1 class="logo-text">Nearby Now</h1>
                <p>Connecting Users & Service Providers Seamlessly...!</p>
                <div class="contact">
                    <span><i class="fas fa-phone"></i> &nbsp; +91 1234567890</span>
                    <span><i class="fas fa-envelope"></i> &nbsp; nearbynow@gmail.com </span>
                </div>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; Nearby Now - 2025 | All rights reserved
        </div>
    </footer>

    <!-- JavaScript -->
    
</body>
</html>