<?php
include '../libs/ayar.php';
// Bildirimleri çekme
$query = "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($connection, $query);
$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <form class="search-bar">
                    <input type="text" class="form-control" placeholder="Enter keywords" />
                    <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                </form>
            </li>
        </ul>

        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item dropdown-lg">
                <a class="nav-link waves-effect btn btn-primary" target="_blank" href="../src/index.php">
                    <i class="fa fa-home"></i><?php echo $lang['go_page']; ?>
                </a>
            </li>
            <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                    href="javascript:void();">
                    <i class="fa fa-bell-o"></i>
                    <span class="badge badge-pill badge-danger"><?php echo count($notifications); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <?php if (count($notifications) > 0): ?>
                    <?php foreach ($notifications as $notification): ?>
                    <a class="dropdown-item mark-as-read" href="#" data-id="<?php echo $notification['id']; ?>">
                        <i class="fa fa-check"></i>
                        <?php echo $notification['message']; ?>
                    </a>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <a class="dropdown-item" href="#"><?php echo $lang['no_new_notification']; ?></a>
                    <?php endif; ?>
                </div>
            </li>
            <li class="nav-item language">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                    href="javascript:void();"><i class="fa fa-flag"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item" onclick="changeLanguage('en')">
                        <i class="flag-icon flag-icon-gb mr-2"></i> <?php echo $lang['english']; ?>
                    </li>
                    <li class="dropdown-item" onclick="changeLanguage('tr')">
                        <i class="flag-icon flag-icon-tr mr-2"></i> <?php echo $lang['turkish']; ?>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="../admin/assets/images/admin-logo.jpg" class="img-circle"
                            alt="user avatar" /></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <?php if (in_array($_COOKIE["auth"]["role"], ['admin', 'IK'])) : ?> <li
                        class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">
                                <div class="avatar">
                                    <img class="align-self-start mr-3" src="../admin/assets/images/admin-logo.jpg"
                                        alt="user avatar" />
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title"><?php echo $_COOKIE["auth"]["username"]; ?></h6>
                                    <p class="user-subtitle">
                                        <?php echo isset($_COOKIE["auth"]["email"]) ? $_COOKIE["auth"]["email"] : ''; ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a href="profile.php"><i class="zmdi zmdi-account mr-2"></i> <?php echo $lang['profile']; ?></a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a href="logout.php"><i class="icon-power mr-2"></i> <?php echo $lang['logout']; ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<script>
function changeLanguage(language) {
    fetch('change_language.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'language=' + language
    }).then(function() {
        location.reload();
    });
}
</script>