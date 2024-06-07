<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="index.php">
            <img src="./assets/images/logo_ysf.png" class="logo-icon" alt="Yusuf Logo" />
            <h5 class="logo-text"> Job Pursuit
            </h5>
        </a>
    </div>
    <ul class="sidebar-menu do-nicescrol">
        <li class="sidebar-header"><?php echo $lang['main_navigation']; ?></li>
        <li>
            <a href="index.php">
                <i class="zmdi zmdi-view-dashboard"></i> <span><?php echo $lang['dashboard']; ?></span>
            </a>
        </li>
        <li>
            <a href="profile.php">
                <i class="zmdi zmdi-account-circle"></i> <span><?php echo $lang['profile']; ?></span>
            </a>
        </li>
        <li>
            <a href="jobs_list.php">
                <i class="zmdi zmdi-assignment"></i> <span><?php echo $lang['jobs']; ?></span>
            </a>
        </li>
        <li>
            <a href="jobs_apply_list.php">
                <i class="zmdi zmdi-file-text"></i> <span><?php echo $lang['job_applications']; ?></span>
            </a>
        </li>
        <li>
            <a href="update_about.php">
                <i class="zmdi zmdi-info"></i> <span><?php echo $lang['about']; ?></span>
            </a>
        </li>
        <li>
            <a href="team_list.php">
                <i class="zmdi zmdi-accounts-outline"></i> <span><?php echo $lang['team_list']; ?></span>
            </a>
        </li>
        <li>
            <a href="blog_list.php">
                <i class="zmdi zmdi-collection-text"></i> <span><?php echo $lang['blog_list']; ?></span>
            </a>
        </li>
        <li>
            <a href="comments_list.php">
                <i class="zmdi zmdi-comment-text"></i> <span><?php echo $lang['comments']; ?></span>
            </a>
        </li>
        <li>
            <a href="update_contact.php">
                <i class="zmdi zmdi-email"></i> <span><?php echo $lang['contact']; ?></span>
            </a>
        </li>
        <li>
            <a href="contact_messages.php">
                <i class="zmdi zmdi-notifications"></i> <span><?php echo $lang['contact_messages']; ?></span>
            </a>
        </li>
        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')): ?>
        <li>
            <a href="user_list.php">
                <i class="zmdi zmdi-accounts-list-alt"></i> <span><?php echo $lang['user_list']; ?></span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>