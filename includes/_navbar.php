<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="display: flex; align-items: center;">
            <img style="margin-top: 10px; margin-right:5px;" src="../assets/images/logo.png" alt="Logo" height="50"
                width="50"">
            <h2>Job Pursuit<em>.</em></h2>
        </a>
        <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><?php echo $lang['home']; ?>
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jobs.php"><?php echo $lang['jobs']; ?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false"><?php echo $lang['about']; ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="about.php"><?php echo $lang['about_us']; ?></a>
                            <a class="dropdown-item" href="team.php"><?php echo $lang['team']; ?></a>
                            <a class="dropdown-item" href="blog.php"><?php echo $lang['blog']; ?></a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php"><?php echo $lang['contact_us']; ?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false"><?php echo $lang['language']; ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="?lang=en"><?php echo $lang['english']; ?></a>
                            <a class="dropdown-item" href="?lang=tr"><?php echo $lang['turkish']; ?></a>
                        </div>
                    </li>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <?php if (isset($_COOKIE["auth"])) : ?>

                        <li class="nav-item">
                            <a href="../admin/logout.php" class="nav-link"><?php echo $lang['logout']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><?php echo $lang['welcome']; ?>,
                                <?php echo htmlspecialchars($_COOKIE["auth"]["username"]); ?></a>
                        </li>
                        <?php else : ?>
                        <li class="nav-item">
                            <a href="../admin/login.php" class="nav-link"><?php echo $lang['login']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="../admin/register.php" class="nav-link"><?php echo $lang['register']; ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </ul>
            </div>
    </div>
</nav>