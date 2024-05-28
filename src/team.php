<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/_header.php'; ?>
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <?php include '../includes/_navbar.php'; ?>
    </header>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Team</h4>
                            <h2>our awesome members!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Banner Ends Here -->


    <section class="blog-posts grid-system">
        <div class="container">
            <div class="all-blog-posts">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="../assets/images/team-image-1-646x680.jpg" alt="">
                            </div>
                            <div class="down-content">
                                <span>CEO</span>
                                <h4>John Doe</h4>
                                <ul class="post-info">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-twitter"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-4">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="../assets/images/team-image-2-646x680.jpg" alt="">
                            </div>
                            <div class="down-content">
                                <span>Support</span>
                                <h4>Jane Smith</h4>
                                <ul class="post-info">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-twitter"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-4">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="../assets/images/team-image-3-646x680.jpg" alt="">
                            </div>
                            <div class="down-content">
                                <span>Support</span>
                                <h4>Samanta Green</h4>
                                <ul class="post-info">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-twitter"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-4">
                        <div class="blog-post">
                            <div class="blog-thumb">
                                <img src="../assets/images/team-image-4-646x680.jpg" alt="">
                            </div>
                            <div class="down-content">
                                <span>Support</span>
                                <h4>Mark Dawn</h4>
                                <ul class="post-info">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-twitter"></i></a> &nbsp;</li>
                                    <li>&nbsp; <a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/_footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/owl.js"></script>
    <script src="../assets/js/slick.js"></script>
    <script src="../assets/js/isotope.js"></script>
    <script src="../assets/js/accordions.js"></script>

    <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t) { //declaring the array outside of the
            if (!cleared[t.id]) { // function makes it static and global
                cleared[t.id] = 1; // you could use true and false, but that's more typing
                t.value = ''; // with more chance of typos
                t.style.color = '#fff';
            }
        }
    </script>

</body>

</html>