    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
        <div class="brand-logo">
            <a href="index.php">
                <img src="./assets/images/logo-icon.png" class="logo-icon" alt="logo icon" />
                <h5 class="logo-text"> Job Pursuit
                </h5>
            </a>
        </div>
        <ul class="sidebar-menu do-nicescrol">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="index.php">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="profile.php">
                    <i class="zmdi zmdi-account"></i> <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="jobs_list.php">
                    <i class="zmdi zmdi-assignment"></i> <span>Jobs</span>
                </a>
            </li>
            <li>
                <a href="jobs_apply_list.php">
                    <i class="zmdi zmdi-assignment"></i> <span>Job Applications</span>
                </a>
            </li>
            <li>
                <a href="update_about.php">
                    <i class="zmdi zmdi-account"></i> <span>About</span>
                </a>
            </li>
            <li>
                <a href="team_list.php">
                    <i class="zmdi zmdi-accounts"></i> <span>Team List</span>
                </a>
            </li>
            <li>
                <a href="blog_list.php">
                    <i class="zmdi zmdi-accounts"></i> <span> Blog List</span>
                </a>
            </li>
            <li>
                <a href="comments_list.php">
                    <i class="zmdi zmdi-accounts"></i> <span>Comments</span>
                </a>
            </li>

            <li>
                <a href="update_contact.php">
                    <i class="zmdi zmdi-accounts"></i> <span>Contact</span>
                </a>
            </li>
            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')): ?>
            <li>
                <a href="user_list.php">
                    <i class="zmdi zmdi-accounts"></i> <span>User List</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>