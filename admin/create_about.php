<?php
// Veritabanı bağlantısı için gerekli bilgileri ekleyin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobs";

try {
    // PDO kullanarak veritabanı bağlantısını oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['text'], $_FILES['image'])) {
            $text = $_POST['text'];
            $image = $_FILES['image'];
            $imageName = $image['name'];
            $imageTmpName = $image['tmp_name'];
            $imageSize = $image['size'];
            $imageError = $image['error'];
            $imageType = $image['type'];

            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowed = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($imageExt, $allowed)) {
                if ($imageError === 0) {
                    if ($imageSize < 5000000) {
                        $imageNewName = uniqid('', true) . "." . $imageExt;
                        $imageDestination = 'uploads/' . $imageNewName;

                        if (move_uploaded_file($imageTmpName, $imageDestination)) {
                            $sql = "INSERT INTO about (text, image_path) VALUES (:text, :image_path)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':text', $text);
                            $stmt->bindParam(':image_path', $imageDestination);
                            $stmt->execute();

                            echo "About section updated successfully";
                        } else {
                            echo "Failed to upload image.";
                        }
                    } else {
                        echo "Image size is too big!";
                    }
                } else {
                    echo "Error uploading image: " . $imageError;
                }
            } else {
                echo "Invalid file type!";
            }
        } else {
            echo "All form fields are required.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create About</title>
</head>

<body>
    <h1>Create About</h1>
    <form action="create_about.php" method="post" enctype="multipart/form-data">
        <label for="text">Text:</label><br>
        <textarea name="text" id="text" cols="30" rows="10"></textarea><br><br>
        <label for="image">Image:</label><br>
        <input type="file" name="image" id="image"><br><br>
        <button type="submit">Create</button>
    </form>
</body>

</html>