<?php
require_once '../libs/ayar.php';
require_once '../libs/vars.php';

session_start();

// Kullanıcı oturumu kontrolü
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Oturumdaki kullanıcı adını al
$username = $_SESSION['username'];

// Kullanıcı bilgilerini veritabanından çekme
$stmt = $connection->prepare("SELECT username, email FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Kullanıcı bulunamadı.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="tab-pane" id="edit">
            <form id="editProfileForm">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Username</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="username"
                            value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="email" name="email"
                            value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Password</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="password" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9 offset-lg-3">
                        <input type="reset" class="btn btn-secondary" value="Cancel">
                        <input type="button" class="btn btn-primary" value="Save Changes" onclick="submitForm()">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function submitForm() {
        const form = document.getElementById('editProfileForm');
        const formData = new FormData(form);

        fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors.length > 0) {
                    alert(data.errors.join('\n'));
                } else {
                    alert(data.success);
                }
            })
            .catch(error => console.error('Error:', error));
    }
    </script>
</body>

</html>