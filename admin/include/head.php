<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<!-- loader-->
<link href="./assets/css/pace.min.css" rel="stylesheet" />
<script src="./assets/js/pace.min.js"></script>
<!--favicon-->
<link rel="icon" href="./assets/images/favicon.ico" type="image/x-icon" />
<!-- Vector CSS -->
<link href="./assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
<!-- simplebar CSS-->
<link href="./assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
<!-- Bootstrap core CSS-->
<link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
<!-- animate CSS-->
<link href="./assets/css/animate.css" rel="stylesheet" type="text/css" />
<!-- Icons CSS-->
<link href="./assets/css/icons.css" rel="stylesheet" type="text/css" />
<!-- Sidebar CSS-->
<link href="./assets/css/sidebar-menu.css" rel="stylesheet" />
<!-- Custom Style-->
<link href="./assets/css/app-style.css" rel="stylesheet" />
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