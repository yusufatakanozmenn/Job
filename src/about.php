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
                            <h4>about us</h4>
                            <h2>more about us!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Banner Ends Here -->


    <section class="about-us">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <img src="../assets/images/about-fullscreen-1-1920x700.jpg" alt="">
                    <p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipisicing elit</a>. Eveniet earum totam,
                        maiores tenetur reprehenderit eius et deserunt sequi veniam commodi! Asperiores laborum facere
                        ratione numquam minima odio aut ut autem placeat illo, sint! Quia aut alias ipsam, velit esse
                        ullam iusto facere! <a href="#">Maxime</a> autem similique, sit voluptatum culpa deserunt cumque
                        harum ab amet esse sequi suscipit facere, maiores error veritatis nihil facilis laborum
                        distinctio quidem deleniti, aperiam iusto? Dicta dolorem cum labore sint obcaecati illo saepe
                        ratione modi nostrum natus.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, provident fugit veniam culpa
                        soluta cumque assumenda rerum modi ut accusantium dolorem omnis sapiente et minima maiores vitae
                        inventore aperiam facilis doloremque esse officiis nobis aut ex velit? Repellat sequi
                        voluptatem, hic aspernatur assumenda quam animi mollitia culpa vel alias laudantium architecto,
                        incidunt voluptatum doloremque sit tempore explicabo recusandae perferendis quia et nisi rerum,
                        quod accusantium. Excepturi reprehenderit itaque temporibus iste possimus numquam unde enim
                        ratione distinctio, facilis, culpa, consectetur dolores.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur alias sunt sapiente quidem
                        repudiandae temporibus consequuntur, molestiae laborum. Hic alias et, deserunt provident
                        voluptatibus voluptatem molestias repudiandae odit distinctio dolore officiis esse nulla
                        aspernatur iste odio quidem sint corrupti impedit at quam obcaecati quas, eaque libero! Totam
                        repudiandae, culpa animi.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
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