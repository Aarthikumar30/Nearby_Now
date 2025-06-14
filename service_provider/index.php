<?php
    session_name('nearby');
    session_start();
    include "config.php";
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Now</title>

    <!--    bootstrap css file link    -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <!--swiper css file-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!--    font awesome cdn link   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!--    custom css file link    -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <!--    header section start    -->
        <section id="header">
            <nav class="sidemenu">
                <img src="images/logo.png" class="logo">
                <ul id="sidemenu">
                    <li><a href="#header">Home</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#why">Why Us</a></li>
                    
                    <li><button onclick="window.location.href='login.php'">Login / Sign Up</button></li>
                </ul>
            </nav>
            <div class="header-text">
                <h1>Nearby Now</h1>
                <p>Connecting Users & Service Providers Seamlessly...!</p>
            </div>
        </section>

    <!--    header section end    -->




    <!--    about section start    -->
        <section class="home-about">
            <div class="image">
                <img src="images/about-img.webp" alt="">
            </div>

            <div class="content">
                <h3>about us</h3>
                <p> Welcome to Nearby Now, your trusted platform for effortlessly connecting service seekers with skilled local professionals. Whether you're a user searching for reliable home services or a service provider looking to expand your reach, we simplify the process with a seamless and efficient system.</p>
                <p>At Nearby Now, we bridge the gap between service seekers and providers, ensuring quality, trust, and convenience for all.</p>
            </div>
        </section>

    <!--    about section end    -->




    <!--    why us section start    -->

        <section class="why-us" id="why">
            <h3>Why Us</h3>
            <div class="why-us-content">
                <div class="why-us-box">
                    <!--<img src="images/why-us.webp" alt="">-->
                    <h4>Efficient</h4>
                    <p>Our platform is designed to make the process of finding and hiring service providers quick and easy.</p>
                </div>
                <div class="why-us-box">
                    <h4>Reliable</h4>
                    <p>Our service providers are vetted and verified to ensure quality and trustworthiness.</p>
                </div>
                <div class="why-us-box">
                    <h4>Convenient</h4>
                    <p>With Nearby Now, you can find and book services with just a few clicks, saving you time and effort.</p>
                </div>
            </div>
        </section>

    <!--    why us section end    -->




    <!--    footer section start    -->

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

    <!--    footer section end    -->


                            


    <!--    bootstrap js file link    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!--swiper js file-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!--    custom js file link    -->
    <script src="js/script.js"></script>

</body>
</html>