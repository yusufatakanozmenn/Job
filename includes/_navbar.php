<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <h2>Job Agency<em>.</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jobs.html">Jobs</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="about.php">About Us</a>
                        <a class="dropdown-item" href="team.php">Team</a>
                        <a class="dropdown-item" href="blog.html">Blog</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_COOKIE["auth"])) : ?>

                        <li class="nav-item">
                            <a href="../admin/logout.php" class="nav-link">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Welcome,
                                <?php echo htmlspecialchars($_COOKIE["auth"]["username"]); ?></a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="../admin/login.php" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="../admin/register.php" class="nav-link">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </ul>
        </div>
    </div>
</nav>