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
                            <h4>Post Details</h4>
                            <h2>Single blog post</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Banner Ends Here -->
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-post">
                                    <div class="blog-thumb">
                                        <img src="../assets/images/blog-fullscreen-1-1920x700.jpg" alt="">
                                    </div>
                                    <div class="down-content">
                                        <a href="blog-details.html">
                                            <h4>Aenean pulvinar gravida sem nec</h4>
                                        </a>
                                        <ul class="post-info">
                                            <li><a href="#">John Doe</a></li>
                                            <li><a href="#">10.07.2020 10:20</a></li>
                                            <li><a href="#"><i class="fa fa-comments" title="Comments"></i> 12</a></li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a
                                                href="#">Praesentium doloribus</a>, corporis repellat sequi, voluptatem
                                            facere, aliquam in consectetur odit debitis id maiores. Rem nobis incidunt
                                            quod veniam, sapiente voluptas omnis ut consequuntur animi laborum ipsam
                                            debitis corporis suscipit aperiam quo dolorum voluptates, culpa consectetur,
                                            id accusamus explicabo laboriosam aut. Aut omnis dolorum, tempore culpa, cum
                                            dignissimos? Voluptatem accusamus obcaecati ad. <br><br> Lorem ipsum dolor
                                            sit amet, consectetur adipisicing elit. Deleniti eaque vitae at. Modi
                                            beatae, dignissimos neque sequi incidunt, voluptatum iure eligendi totam,
                                            quibusdam, nesciunt obcaecati architecto tenetur voluptatem distinctio
                                            magni.</p>
                                        <div class="post-options">
                                            <div class="row">
                                                <div class="col-6">

                                                </div>
                                                <div class="col-6">
                                                    <ul class="post-share">
                                                        <li><i class="fa fa-share-alt"></i></li>
                                                        <li><a href="#">Facebook</a>,</li>
                                                        <li><a href="#"> Twitter</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebar-item comments">
                                    <div class="sidebar-heading">
                                        <h2>4 comments</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li>
                                                <div class="author-thumb">
                                                    <img src="../assets/images/comment-author-01.jpg" alt="">
                                                </div>
                                                <div class="right-content">
                                                    <h4>Charles Kate<span>May 16, 2020</span></h4>
                                                    <p>Fusce ornare mollis eros. Duis et diam vitae justo fringilla
                                                        condimentum eu quis leo. Vestibulum id turpis porttitor sapien
                                                        facilisis scelerisque. Curabitur a nisl eu lacus convallis
                                                        eleifend posuere id tellus.</p>
                                                </div>
                                            </li>
                                            <li class="replied">
                                                <div class="author-thumb">
                                                    <img src="../assets/images/comment-author-02.jpg" alt="">
                                                </div>
                                                <div class="right-content">
                                                    <h4>Thirteen Man<span>May 20, 2020</span></h4>
                                                    <p>In porta urna sed venenatis sollicitudin. Praesent urna sem,
                                                        pulvinar vel mattis eget.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="author-thumb">
                                                    <img src="../assets/images/comment-author-03.jpg" alt="">
                                                </div>
                                                <div class="right-content">
                                                    <h4>Belisimo Mama<span>May 16, 2020</span></h4>
                                                    <p>Nullam nec pharetra nibh. Cras tortor nulla, faucibus id
                                                        tincidunt in, ultrices eget ligula. Sed vitae suscipit ligula.
                                                        Vestibulum id turpis volutpat, lobortis turpis ac, molestie
                                                        nibh.</p>
                                                </div>
                                            </li>
                                            <li class="replied">
                                                <div class="author-thumb">
                                                    <img src="../assets/images/comment-author-02.jpg" alt="">
                                                </div>
                                                <div class="right-content">
                                                    <h4>Thirteen Man<span>May 22, 2020</span></h4>
                                                    <p>Mauris sit amet justo vulputate, cursus massa congue, vestibulum
                                                        odio. Aenean elit nunc, gravida in erat sit amet, feugiat
                                                        viverra leo.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebar-item submit-comment">
                                    <div class="sidebar-heading">
                                        <h2>Your comment</h2>
                                    </div>
                                    <div class="content">
                                        <form id="comment" action="#" method="post">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <fieldset>
                                                        <input name="name" type="text" id="name" placeholder="Your name"
                                                            required="">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <fieldset>
                                                        <input name="email" type="text" id="email"
                                                            placeholder="Your email" required="">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input name="subject" type="text" id="subject"
                                                            placeholder="Subject">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <textarea name="message" rows="6" id="message"
                                                            placeholder="Type your comment" required=""></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <button type="submit" id="form-submit"
                                                            class="main-button">Submit</button>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sidebar-item search">
                                    <form id="search_form" name="gs" method="GET" action="#">
                                        <input type="text" name="q" class="searchText" placeholder="type to search..."
                                            autocomplete="on">
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="sidebar-item recent-posts">
                                    <div class="sidebar-heading">
                                        <h2>Recent Posts</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li><a href="blog-details.html">
                                                    <h5>Vestibulum id turpis porttitor sapien facilisis scelerisque</h5>
                                                    <span>May 31, 2020</span>
                                                </a></li>
                                            <li><a href="blog-details.html">
                                                    <h5>Suspendisse et metus nec libero ultrices varius eget in risus
                                                    </h5>
                                                    <span>May 28, 2020</span>
                                                </a></li>
                                            <li><a href="blog-details.html">
                                                    <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit,
                                                        numquam.</h5>
                                                    <span>May 14, 2020</span>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
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