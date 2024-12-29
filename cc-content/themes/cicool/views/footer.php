<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer pt-1 mt-1 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row ">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-0">About Us</h4>
                <p> Students can find a large number of Courses, Model MCQ exam sets, practice sets, solutions etc. posted by different Instructors.
                </p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Quick Link</h4>
                <a class="btn btn-link" href="">Contact Us</a>
                <a class="btn btn-link" href="">Privacy Policy</a>
                <a class="btn btn-link" href="">Terms & Condition</a>
                <a class="btn btn-link" href="">FAQs & Help</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                <p class="mb-0"><i class="fa fa-map-marker-alt me-3"></i><?php echo get_company_detail()->address; ?></p>
                <p class="mb-0"><i class="fa fa-phone-alt me-3"></i><?php echo get_company_detail()->phone_no; ?></p>
                <p class="mb-0"><i class="fa fa-envelope me-3"></i><?php echo get_company_detail()->email; ?></p>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Follow us on</h4>
                <div class="d-flex pt-0">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= theme_asset() ?>vendor/wow/wow.min.js"></script>
<script src="<?= theme_asset() ?>vendor/easing/easing.min.js"></script>
<script src="<?= theme_asset() ?>vendor/waypoints/waypoints.min.js"></script>
<script src="<?= theme_asset() ?>vendor/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= theme_asset() ?>vendor/sweet-alert/sweetalert2.all.min.js"></script>

<!-- Template Javascript -->
<script src="<?= theme_asset() ?>js/main.js"></script>
</body>

</html>