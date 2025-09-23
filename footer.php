 <?php
include "./config/database.php";

    $conn = (new Database())->connect();

    // check connection
    if (!$conn || $conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // fetch all site configurations into an array
    $configs = [];
    $result = $conn->query("SELECT config_key, config_value FROM site_configurations");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $configs[$row['config_key']] = $row['config_value'];
        }
    }
    ?>
 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
     <div class="container py-5">
         <div class="row g-5">

             <!-- Quick Links -->
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-3">Quick Link</h4>
                 <a class="btn btn-link" href="./about.php">About Us</a>
                 <a class="btn btn-link" href="./contact.php">Contact Us</a>
                 <a class="btn btn-link" href="./privacypolicy.php">Privacy Policy</a>
                 <a class="btn btn-link" href="./terms.php">Terms & Condition</a>
                 <a class="btn btn-link" href="./faq.php">FAQs & Help</a>
             </div>

             <!-- Contact -->
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-3">Contact</h4>
                 <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>
                     <?php echo $configs['address'] ?? 'Default Address'; ?>
                 </p>
                 <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>
                     <?php echo $configs['landline'] ?? 'Default Phone'; ?>
                 </p>
                 <p class="mb-2"><i class="fa fa-envelope me-3"></i>
                     <?php echo $configs['email'] ?? 'Default Email'; ?>
                 </p>
                 <div class="d-flex pt-2">
                     <a class="btn btn-outline-light btn-social" href="<?php echo $configs['twitter'] ?? '#'; ?>"><i class="fab fa-twitter"></i></a>
                     <a class="btn btn-outline-light btn-social" href="<?php echo $configs['facebook'] ?? '#'; ?>"><i class="fab fa-facebook-f"></i></a>
                     <a class="btn btn-outline-light btn-social" href="<?php echo $configs['youtube'] ?? '#'; ?>"><i class="fab fa-youtube"></i></a>
                     <a class="btn btn-outline-light btn-social" href="<?php echo $configs['linkedin'] ?? '#'; ?>"><i class="fab fa-linkedin-in"></i></a>
                 </div>
             </div>

             <!-- Gallery -->
             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-3">Gallery</h4>
                 <div class="row g-2 pt-2">
                     <div class="col-4"><a href="img/major1.jpg"><img class="img-fluid bg-light p-1" src="img/major1.jpg" alt=""></a></div>
                     <div class="col-4"><a href="img/mini1.jpg"><img class="img-fluid bg-light p-1" src="img/mini1.jpg" alt=""></a></div>
                     <div class="col-4"><a href="img/internship.jpg"><img class="img-fluid bg-light p-1" src="img/internship.jpg" alt=""></a></div>
                     <div class="col-4"><a href="img/cyber.jpg"><img class="img-fluid bg-light p-1" src="img/cyber.jpg" alt=""></a></div>
                     <div class="col-4"><a href="img/structural.jpg"><img class="img-fluid bg-light p-1" src="img/structural.jpg" alt=""></a></div>
                     <div class="col-4"><a href="img/mini1.jpg"><img class="img-fluid bg-light p-1" src="img/mini1.jpg" alt=""></a></div>
                 </div>
             </div>

             <!-- Newsletter -->

             <div class="col-lg-3 col-md-6">
                 <h4 class="text-white mb-3">Subscribe to our Newsletter</h4>
                 <form action="subscribe.php" method="POST">
                     <div class="position-relative mx-auto" style="max-width: 400px;">
                         <input name="email" class="form-control border-0 w-100 py-3 ps-4 pe-5"
                             type="email" placeholder="Your email" required>
                         <button type="submit" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                             Subscribe
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>

     <!-- <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Subscribe to our Newsletter</h4>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Subscribe</button>
                </div>
            </div> -->

 </div>
 </div>

 <!-- Copyright -->
 <div class="container">
     <div class="copyright">
         <div class="row">
             <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                 &copy; <a class="border-bottom" href="#">Vsofts Solutions</a>, All Right Reserved.
                 Designed By <a class="border-bottom" href="./">westechnologies.in</a>
             </div>
             <div class="col-md-6 text-center text-md-end">
                 <div class="footer-menu">
                     <a href="./index.php">Home</a>
                     <a href="./contact.php">Help</a>
                     <a href="./faq.php">FAQs</a>
                 </div>
             </div>
         </div>
     </div>
 </div>
 </div>
 <!-- Footer End -->
 <?php $conn->close(); ?>